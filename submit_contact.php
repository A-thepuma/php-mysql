<?php
$email = isset($_POST['email']) ? trim($_POST['email']) : '';
$message = isset($_POST['message']) ? trim($_POST['message']) : '';

$invalid = ($email === '' || !filter_var($email, FILTER_VALIDATE_EMAIL) || $message === '');

$uploadMsg = 'Aucun fichier envoyé.';
?>


<?php
// Testons si le fichier a bien été envoyé et s'il n'y a pas d'erreur
if (isset($_FILES['screenshot']) && $_FILES['screenshot']['error'] == 0) {
    // Testons si le fichier n'est pas trop gros
    if ($_FILES['screenshot']['size'] <= 1000000) {

        // Testons si l'extension est autorisée
        $fileInfo = pathinfo($_FILES['screenshot']['name']);
        $extension = $fileInfo['extension'];
        $allowedExtensions = ['jpg', 'jpeg', 'gif', 'png'];
        if (in_array($extension, $allowedExtensions)) {

            // On peut valider le fichier et le stocker définitivement
            move_uploaded_file(
                $_FILES['screenshot']['tmp_name'],
                'uploads/' . basename($_FILES['screenshot']['name'])
            );
            echo "L'envoi a bien été effectué !";
        }

    }
}
?>


<!doctype html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <title>Site de recettes — Confirmation</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="styles.css">
</head>

<body class="d-flex flex-column min-vh-100">
    <div class="container py-3">
        <?php include 'header.php'; ?>

        <?php if ($invalid): ?>
            <h2>Il faut un email et un message pour soumettre le formulaire.</h2>
            <a href="contact.php" class="btn btn-link mt-3">← Retour au formulaire</a>
        <?php else: ?>
            <h1>Message bien reçu !</h1>
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Rappel de vos informations</h5>
                    <p><b>Email</b> : <?= htmlspecialchars($email, ENT_QUOTES, 'UTF-8') ?></p>
                    <p><b>Message</b> : <?= nl2br(htmlspecialchars($message, ENT_QUOTES, 'UTF-8')) ?></p>
                </div>
            </div>
        <?php endif; ?>

        <?php include 'footer.php'; ?>

    </div>
</body>

</html>