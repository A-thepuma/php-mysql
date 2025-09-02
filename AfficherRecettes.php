<?php
// Users
$users = [
    [
        'full_name' => 'Mickaël Andrieu',
        'email' => 'mickael.andrieu@exemple.com',
        'age' => 34,
    ],
    [
        'full_name' => 'Mathieu Nebra',
        'email' => 'mathieu.nebra@exemple.com',
        'age' => 34,
    ],
    [
        'full_name' => 'Laurène Castor',
        'email' => 'laurene.castor@exemple.com',
        'age' => 28,
    ],
];

// Déclaration du tableau des recettes
$recipes = [
    [
        'title' => 'Cassoulet',
        'recipe' => '',
        'author' => 'mickael.andrieu@exemple.com',
        'is_enabled' => true,
    ],
    [
        'title' => 'Couscous',
        'recipe' => '',
        'author' => 'mickael.andrieu@exemple.com',
        'is_enabled' => false,
    ],
    [
        'title' => 'Escalope milanaise',
        'recipe' => '',
        'author' => 'mathieu.nebra@exemple.com',
        'is_enabled' => true,
    ],
    [
        'title' => 'Salade Romaine',
        'recipe' => '',
        'author' => 'laurene.castor@exemple.com',
        'is_enabled' => false,
    ],
];

// Fonctions
function isValidRecipe($recipe)
{
    return is_array($recipe) && !empty($recipe['is_enabled']);
}

function getRecipes($recipes)
{
    $valid = array();
    foreach ($recipes as $r) {
        if (isValidRecipe($r)) {
            $valid[] = $r;
        }
    }
    return $valid;
}

function displayAuthor($authorEmail, $users)
{
    for ($i = 0; $i < count($users); $i++) {
        $u = $users[$i];
        if (isset($u['email']) && $authorEmail === $u['email']) {
            $name = isset($u['full_name']) ? $u['full_name'] : 'Auteur';
            $age = isset($u['age']) ? $u['age'] : '?';
            return $name . ' (' . $age . ' ans)';
        }
    }
    return $authorEmail;
}

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
    <?php foreach (getRecipes($recipes) as $recipe): ?>
        <article>
            <h3><?php echo htmlspecialchars($recipe['title']); ?></h3>
            <div class="steps"><?php echo htmlspecialchars($recipe['recipe']); ?></div>
            <div class="author">
                <?php echo htmlspecialchars(displayAuthor($recipe['author'], $users)); ?>
            </div>
        </article>
    <?php endforeach; ?>
</body>

</html>