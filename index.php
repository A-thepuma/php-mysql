<?php
// index.php
session_start();
require_once __DIR__ . '/mysql.php'; // $db = PDO

// Déconnexion
if (isset($_GET['action']) && $_GET['action'] === 'logout') {
    $_SESSION = [];
    session_destroy();
    setcookie('LOGGED_USER', '', time() - 3600, "", "", false, true);
    header('Location: index.php');
    exit;
}

// Session depuis le cookie (sans variables.php)
if (!isset($_SESSION['LOGGED_USER']) && isset($_COOKIE['LOGGED_USER'])) {
    $_SESSION['LOGGED_USER'] = [
        'email' => (string) $_COOKIE['LOGGED_USER'],
        'full_name' => '',
        'age' => null,
    ];
}

$loggedUser = $_SESSION['LOGGED_USER'] ?? null;

// --- Charger les recettes publiées (BDD) ---
$sqlQuery = 'SELECT recipe_id, title, recipe, author
             FROM recipes
             WHERE is_enabled = 1
             ORDER BY recipe_id DESC';
$recipesStatement = $db->prepare($sqlQuery);
$recipesStatement->execute();
$recipes = $recipesStatement->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Site de recettes - Page d'accueil</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="d-flex flex-column min-vh-100">
    <div class="container py-3">
        <?php include 'header.php'; ?>

        <!-- Formulaire de connexion -->
        <?php include_once 'login.php'; ?>

        <h1 class="mb-4">Site de recettes</h1>

        <?php if ($loggedUser): ?>
            <div class="row g-3">
                <?php foreach ($recipes as $recipe): ?>
                    <div class="col-12 col-md-6">
                        <article class="card recipe-card shadow-sm h-100">
                            <div class="card-body">
                                <h3 class="h4 card-title mb-2">
                                    <?= htmlspecialchars($recipe['title']) ?>
                                </h3>

                                <?php if (!empty($recipe['recipe'])): ?>
                                    <p class="card-text mb-2">
                                        <?= htmlspecialchars($recipe['recipe']) ?>
                                    </p>
                                <?php endif; ?>

                                <div class="author">
                                    <?= htmlspecialchars($recipe['author'] ?: 'Anonyme') ?>
                                </div>
                            </div>
                        </article>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <div class="alert alert-info">Connectez-vous pour voir les recettes.</div>
        <?php endif; ?>

        <?php include 'footer.php'; ?>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>