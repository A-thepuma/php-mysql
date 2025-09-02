<?php
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