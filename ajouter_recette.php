<?php
// ajouter_recette.php
session_start();
require_once __DIR__ . '/mysql.php';

// Accès réservé : utilisateur connecté
if (!isset($_SESSION['LOGGED_USER'])) {
    http_response_code(403);
    exit('Accès refusé. Veuillez vous connecter.');
}

// valeurs par défaut
$errors = [];
$title = isset($_POST['title']) ? $_POST['title'] : '';
$body  = isset($_POST['recipe']) ? $_POST['recipe'] : '';

// soumission du formulaire
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // 1) validations minimales
    if (trim($title) === '')  { $errors[] = "Le titre est requis."; }
    if (trim($body)  === '')  { $errors[] = "La description est requise."; }

    // 2) insertion en BDD si OK
    if (!$errors) {
        $sql = 'INSERT INTO recipes (title, recipe, author, is_enabled)
                VALUES (:title, :recipe, :author, :is_enabled)';
        $st  = $db->prepare($sql);
        $st->execute([
            'title'      => $title,
            'recipe'     => $body,
            'author'     => $_SESSION['LOGGED_USER']['email'], // auteur = email connecté
            'is_enabled' => 1, // publier directement (0 = brouillon)
        ]);

        // redirection (évite la double soumission au F5)
        header('Location: index.php?created=1');
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="utf-8">
  <title>Ajouter une recette</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="d-flex flex-column min-vh-100">
  <div class="container py-4">
    <?php include 'header.php'; ?>

    <h1 class="mb-4">Ajouter une recette</h1>

    <?php if ($errors): ?>
      <div class="alert alert-danger">
        <ul class="mb-0">
          <?php foreach ($errors as $e): ?>
            <li><?= htmlspecialchars($e) ?></li>
          <?php endforeach; ?>
        </ul>
      </div>
    <?php endif; ?>

    <form method="post" class="card p-3 shadow-sm">
      <div class="mb-3">
        <label class="form-label">Titre de la recette *</label>
        <input type="text" name="title" class="form-control"
               value="<?= htmlspecialchars($title) ?>" placeholder="Choisissez un titre percutant !" required>
      </div>

      <div class="mb-3">
        <label class="form-label">Description de la recette *</label>
        <textarea name="recipe" rows="6" class="form-control"
                  placeholder="Seulement du contenu vous appartenant ou libre de droits." required><?= htmlspecialchars($body) ?></textarea>
      </div>

      <button type="submit" class="btn btn-primary">Envoyer</button>
      <a href="index.php" class="btn btn-outline-secondary ms-2">Annuler</a>
    </form>

    <?php include 'footer.php'; ?>
  </div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
