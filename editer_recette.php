<?php

session_start();
require_once __DIR__ . '/mysql.php';

// Vérification d'accès
if (!isset($_SESSION['LOGGED_USER'])) {
  http_response_code(403);
  exit('Accès refusé : connectez-vous.');
}

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
if ($id <= 0) { http_response_code(400); exit('ID invalide.'); }

// Changer la recette
$st = $db->prepare('SELECT recipe_id, title, recipe, author, is_enabled FROM recipes WHERE recipe_id = :id');
$st->execute(array('id' => $id));
$rec = $st->fetch(PDO::FETCH_ASSOC);
if (!$rec) { http_response_code(404); exit('Recette introuvable.'); }

// Vérifier que l'utilisateur connecté est le propriétaire
if (strcasecmp($rec['author'], $_SESSION['LOGGED_USER']['email']) !== 0) {
  http_response_code(403);
  exit('Accès refusé : vous n’êtes pas l’auteur de cette recette.');
}

// Préparer valeurs et erreurs
$errors = array();
$title   = isset($_POST['title'])  ? $_POST['title']  : $rec['title'];
$body    = isset($_POST['recipe']) ? $_POST['recipe'] : $rec['recipe'];
$enabled = isset($_POST['is_enabled']) ? 1 : (int)$rec['is_enabled'];

// Soumission -> validation -> UPDATE
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  if (trim($title) === '') { $errors[] = "Le titre est requis."; }
  if (trim($body)  === '') { $errors[] = "La recette est requise."; }

  if (!$errors) {
    $sql = 'UPDATE recipes
            SET title = :title, recipe = :recipe, is_enabled = :is_enabled
            WHERE recipe_id = :id AND author = :author';
    $upd = $db->prepare($sql);
    $upd->execute(array(
      'title'      => $title,
      'recipe'     => $body,
      'is_enabled' => $enabled,
      'id'         => $id,
      'author'     => $_SESSION['LOGGED_USER']['email'],
    ));
    header('Location: index.php?edited=1');
    exit;
  }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="utf-8">
  <title>Modifier une recette</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="d-flex flex-column min-vh-100">
  <div class="container py-4">
    <?php include 'header.php'; ?>

    <h1 class="mb-4">Modifier la recette</h1>

    <?php if ($errors): ?>
      <div class="alert alert-danger">
        <ul class="mb-0">
          <?php foreach ($errors as $e): ?><li><?= htmlspecialchars($e) ?></li><?php endforeach; ?>
        </ul>
      </div>
    <?php endif; ?>

    <form method="post" class="card p-3 shadow-sm">
      <div class="mb-3">
        <label class="form-label">Titre *</label>
        <input type="text" name="title" class="form-control"
               value="<?= htmlspecialchars($title) ?>" required>
      </div>

      <div class="mb-3">
        <label class="form-label">Recette *</label>
        <textarea name="recipe" rows="6" class="form-control" required><?= htmlspecialchars($body) ?></textarea>
      </div>

      <div class="form-check mb-3">
        <input class="form-check-input" type="checkbox" id="is_enabled" name="is_enabled" <?= $enabled ? 'checked' : '' ?>>
        <label class="form-check-label" for="is_enabled">Publier</label>
      </div>

      <div class="d-flex gap-2">
        <button type="submit" class="btn btn-primary">Enregistrer</button>
        <a href="index.php" class="btn btn-outline-secondary">Annuler</a>
      </div>
    </form>

    <?php include 'footer.php'; ?>
  </div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
