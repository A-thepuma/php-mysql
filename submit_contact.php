<?php
$email   = isset($_POST['email']) ? trim($_POST['email']) : '';
$message = isset($_POST['message']) ? trim($_POST['message']) : '';

$invalid = ($email === '' || !filter_var($email, FILTER_VALIDATE_EMAIL) || $message === '');
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
