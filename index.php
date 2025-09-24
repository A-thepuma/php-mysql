<?php
session_start();

if (isset($_GET['action']) && $_GET['action'] === 'logout') {
    $_SESSION = [];
    session_destroy();
    setcookie('LOGGED_USER', '', time() - 3600, "", "", false, true);
    header('Location: index.php'); // retour sur la page avec le formulaire
    exit;
}

if (!isset($_SESSION['LOGGED_USER']) && isset($_COOKIE['LOGGED_USER'])) {
    require_once __DIR__ . '/variables.php'; 

    $cookieEmail = (string) $_COOKIE['LOGGED_USER'];
    $matched = null;
    foreach ($users as $u) {
        if (isset($u['email']) && strcasecmp($u['email'], $cookieEmail) === 0) {
            $matched = $u; break;
        }
    }
    if ($matched) {
        $_SESSION['LOGGED_USER'] = [
            'email' => $matched['email'],
            'full_name' => isset($matched['full_name']) ? $matched['full_name'] : '',
            'age' => isset($matched['age']) ? $matched['age'] : null,
        ];
    }
}

$loggedUser = isset($_SESSION['LOGGED_USER']) ? $_SESSION['LOGGED_USER'] : null;

// includes utilitaires et header
include_once 'variables.php';
include_once 'functions.php'; 
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Site de recettes - Page d'accueil</title>

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">

</head>

<body class="d-flex flex-column min-vh-100">
    <div class="container py-3">

        <!-- Navigation -->

        <?php include 'header.php'; ?>

        <!-- Inclusion des fichiers utilitaires -->

        <?php
        include_once('variables.php');
        include_once('functions.php');
        ?>

        <!-- Inclusion du formulaire de connexion -->

        <?php include_once 'login.php'; ?>

        <h1 class="mb-4">Site de recettes</h1>

        <!-- Si l'utilisateur existe, on affiche les recettes -->

        <?php if (isset($loggedUser)): ?>
            <div class="row g-3">
                <?php foreach (getRecipes($recipes) as $recipe): ?>
                    <div class="col-12 col-md-6">
                        <article class="card recipe-card shadow-sm h-100">
                            <div class="card-body">
                                <h3 class="h4 card-title mb-2">
                                    <?php echo htmlspecialchars($recipe['title']); ?>
                                </h3>

                                <?php if (!empty($recipe['recipe'])): ?>
                                    <p class="card-text mb-2">
                                        <?php echo htmlspecialchars($recipe['recipe']); ?>
                                    </p>
                                <?php endif; ?>

                                <div class="author">
                                    <?php echo htmlspecialchars(displayAuthor($recipe['author'], $users)); ?>
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