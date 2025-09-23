<?php session_start(); // $_SESSION 
require_once __DIR__ . '/mysql.php';      
require_once __DIR__ . '/variables.php';  
require_once __DIR__ . '/functions.php';

// Récupération des recettes 
$sqlQuery = 'SELECT * FROM recipes WHERE is_enabled = 1';
$recipesStatement = $db->prepare($sqlQuery);
$recipesStatement->execute();
$recipes = $recipesStatement->fetchAll();
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Site de Recettes - Page d'accueil</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="d-flex flex-column min-vh-100">
    <div class="container">

        <!-- Navigation -->
        <?php include_once('header.php'); ?>

        <!-- Inclusion du formulaire de connexion -->
        <?php include_once('login.php'); ?>

        <h1>Site de Recettes !</h1>

        <!-- Si l'utilisateur existe, on affiche les recettes -->
        <?php if (isset($_SESSION['LOGGED_USER'])): ?>
            <?php foreach (getRecipes($recipes, 5) as $recipe): ?>
                <article>
                    <h3><?= htmlspecialchars($recipe['title']) ?></h3>
                    <div><?= nl2br(htmlspecialchars($recipe['recipe'])) ?></div>
                    <i>
                        <?= displayAuthor(
                            $recipe['author'],
                            isset($users) ? $users : []
                        ) ?>
                    </i>
                </article>
            <?php endforeach ?>
        <?php endif; ?>
    </div>

    <?php include_once('footer.php'); ?>
</body>

</html>