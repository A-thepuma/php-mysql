<?php
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

        <?php include 'header.php'; ?>

        <h1 class="mb-4">Site de recettes</h1>

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

        <?php include 'footer.php'; ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>