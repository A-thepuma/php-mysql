<?php

// Déclaration du tableau des recettes
$recipes = [
    [
        'title' => 'Cassoulet',
        'recipe' => 'Etape 1 : Des flageolets',
        'author' => 'mickael.andrieu@exemple.com',
        'enabled' => true,
    ],
    [
        'title' => 'Couscous',
        'recipe' => 'Etape 1 : semoule, Etape 2 : légumes...',
        'author' => 'mickael.andrieu@exemple.com',
        'enabled' => false,
    ],
    [
        'title' => 'Escalope milanaise',
        'recipe' => 'Etape 1 : prenez une belle escalope',
        'author' => 'mathieu.nebra@exemple.com',
        'enabled' => true,
    ],
];


?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Affichage des recettes</title>
    <style>
        body {
            font-family: system-ui, -apple-system, Segoe UI, Arial, sans-serif;
            line-height: 2;
            margin: 40px;
        }

        h1 {
            font-size: 32px;
            margin-bottom: 24px;
        }

        article {
            margin: 0 0 20px 0;
        }

        article h3 {
            font-size: 24px;
            margin: 0 0 6px 0;
        }

        article .steps {
            color: #444;
            margin: 0 0 4px 0;
        }

        article .author {
            font-style: italic;
            color: #666;
        }
    </style>
</head>

<body>
    <h1>Affichage des recettes</h1>
    <?php foreach ($recipes as $recipe): ?>
        <?php if (!empty($recipe['enabled'])): ?>
            <article>
                <h3><?php echo htmlspecialchars($recipe['title']); ?></h3>
                <div class="steps"><?php echo htmlspecialchars($recipe['recipe']); ?></div>
                <div class="author"><?php echo htmlspecialchars($recipe['author']); ?></div>
            </article>
        <?php endif; ?>
    <?php endforeach; ?>
</body>

</html>