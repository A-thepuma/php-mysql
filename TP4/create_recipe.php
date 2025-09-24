<?php
session_start();
require_once __DIR__ . '/mysql.php';

$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
   
    $title  = isset($_POST['title'])  ? trim($_POST['title'])  : '';
    $recipe = isset($_POST['recipe']) ? trim($_POST['recipe']) : '';
    $author = isset($_POST['author']) ? trim($_POST['author']) : '';
    $is_enabled = isset($_POST['is_enabled']) ? 1 : 0;

    if ($title !== '' && $recipe !== '' && $author !== '') {
        $sql = "INSERT INTO recipes (title, recipe, author, is_enabled)
                VALUES (:title, :recipe, :author, :is_enabled)";
        $stmt = $db->prepare($sql);
        $stmt->execute(array(
            ':title'      => $title,
            ':recipe'     => $recipe,
            ':author'     => $author,
            ':is_enabled' => $is_enabled,
        ));
        $message = "Recette ajoutée avec succès !";
    } else {
        $message = "Veuillez remplir tous les champs.";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Ajouter une recette</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container py-4">
  <h1>Nouvelle recette</h1>

  <?php if ($message !== ''): ?>
    <div class="alert alert-info"><?php echo htmlspecialchars($message); ?></div>
  <?php endif; ?>

  <form method="post">
    <div class="mb-3">
      <label for="title" class="form-label">Titre</label>
      <input type="text" name="title" id="title" class="form-control" required>
    </div>

    <div class="mb-3">
      <label for="recipe" class="form-label">Recette</label>
      <textarea name="recipe" id="recipe" class="form-control" rows="5" required></textarea>
    </div>

    <div class="mb-3">
      <label for="author" class="form-label">Auteur</label>
      <input type="text" name="author" id="author" class="form-control" required>
    </div>

    <div class="form-check mb-3">
      <input type="checkbox" name="is_enabled" id="is_enabled" class="form-check-input" checked>
      <label for="is_enabled" class="form-check-label">Activer la recette</label>
    </div>

    <button type="submit" class="btn btn-primary">Enregistrer</button>
    <a href="index.php" class="btn btn-secondary">Retour</a>
  </form>
</body>
</html>
