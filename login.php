<?php


if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Si déjà connecté, on ne traite pas le POST
if (!isset($_SESSION['LOGGED_USER'])) {

    if (isset($_POST['email']) && isset($_POST['password'])) {
        $email = trim($_POST['email']);
        $password = (string) $_POST['password'];
        $found = false;

        foreach ($users as $user) {
            if (
                isset($user['email'], $user['password']) &&
                $user['email'] === $email &&
                $user['password'] === $password
            ) {
                $_SESSION['LOGGED_USER'] = $user['email'];
                $found = true;

                // Cookie qui expire dans un an
                setcookie(
                    'LOGGED_USER',
                    $user['email'],
                    time() + 365 * 24 * 3600,
                    "",
                    "",
                    false,
                    true
                );

                header('Location: index.php');
                exit;

            } 
            
        }

        if (!$found) {
            $errorMessage = sprintf(
                'Les informations envoyées ne permettent pas de vous identifier : (%s/%s)',
                htmlspecialchars($email, ENT_QUOTES),
                htmlspecialchars($password, ENT_QUOTES)
            );
        }
    }
}
?>

<!-- Si utilisateur/trice est non identifié(e), on affiche le formulaire -->
<?php if (!isset($loggedUser)): ?>
    <form action="index.php" method="post">
        <!-- si message d'erreur on l'affiche -->
        <?php if (isset($errorMessage)): ?>
            <div class="alert alert-danger" role="alert">
                <?php echo $errorMessage; ?>
            </div>
        <?php endif; ?>

        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" id="email" name="email" aria-describedby="email-help"
                placeholder="you@exemple.com" required>
            <div id="email-help" class="form-text">
                L'email utilisé lors de la création de compte.
            </div>
        </div>

        <div class="mb-3">
            <label for="password" class="form-label">Mot de passe</label>
            <input type="password" class="form-control" id="password" name="password" required>
        </div>

        <button type="submit" class="btn btn-primary">Envoyer</button>
    </form>

    <!-- Si utilisateur/trice bien connecté(e), on affiche un message de succès -->
<?php else: ?>
    <div class="alert alert-success" role="alert">
        Bonjour <?php echo htmlspecialchars($loggedUser['email']); ?> et bienvenue sur le site !
    </div>
<?php endif; ?>