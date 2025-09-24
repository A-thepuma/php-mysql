<?php
// DÉMARRER LA SESSION AVANT TOUT
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/variables.php';

// Si pas connecté et qu'on reçoit le POST, on traite ici
if (!isset($_SESSION['LOGGED_USER']) && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = isset($_POST['email']) ? trim($_POST['email']) : '';
    $password = isset($_POST['password']) ? (string)$_POST['password'] : '';
    $foundUser = null;

    

    foreach ($users as $user) {
        if (
            isset($user['email'], $user['password']) &&
            strcasecmp($user['email'], $email) === 0 &&
            $user['password'] === $password
        ) {
            $foundUser = $user;
            break;
        }
    }

    if ($foundUser) {
        $_SESSION['LOGGED_USER'] = [
            'email' => $foundUser['email'],
            'full_name' => isset($foundUser['full_name']) ? $foundUser['full_name'] : '',
            'age' => isset($foundUser['age']) ? $foundUser['age'] : null,
        ];

        setcookie('LOGGED_USER', $foundUser['email'], time() + 365*24*3600, "", "", false, true);

        header('Location: index.php');
        exit;
    } else {
        $errorMessage = sprintf(
            'Les informations envoyées ne permettent pas de vous identifier : (%s/%s)',
            htmlspecialchars($email, ENT_QUOTES),
            htmlspecialchars($password, ENT_QUOTES)
        );
    }
}

if (!isset($_SESSION['LOGGED_USER']) && isset($_COOKIE['LOGGED_USER'])) {
    $_SESSION['LOGGED_USER'] = ['email' => $_COOKIE['LOGGED_USER']];
}

?>

<!-- Formulaire si NON connecté -->
<?php if (!isset($_SESSION['LOGGED_USER'])): ?>
    <form action="index.php" method="post">
        <?php if (isset($errorMessage)): ?>
            <div class="alert alert-danger" role="alert">
                <?= $errorMessage ?>
            </div>
        <?php endif; ?>

        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" id="email" name="email" aria-describedby="email-help"
                placeholder="you@exemple.com" required>
            <div id="email-help" class="form-text">L'email utilisé lors de la création de compte.</div>
        </div>

        <div class="mb-3">
            <label for="password" class="form-label">Mot de passe</label>
            <input type="password" class="form-control" id="password" name="password" required>
        </div>

        <button type="submit" class="btn btn-primary">Envoyer</button>
    </form>
<?php else: ?>
    <div class="alert alert-success" role="alert">
        Bonjour <?= htmlspecialchars($_SESSION['LOGGED_USER']['email']) ?> et bienvenue sur le site !
        <a class="btn btn-sm btn-outline-secondary ms-2" href="index.php?action=logout">Se déconnecter</a>

    </div>
<?php endif; ?>