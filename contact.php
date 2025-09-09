<?php

$sent = isset($_GET['sent']) && $_GET['sent'] == 1;
$errors = array();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email   = isset($_POST['email']) ? trim($_POST['email']) : '';
    $message = isset($_POST['message']) ? trim($_POST['message']) : '';

    if ($email === '' || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Veuillez saisir un email valide.";
    }
    if ($message === '') {
        $errors[] = "Veuillez écrire un message.";
    }

    if (empty($errors)) {
    
       header('Location: contact.php?sent=1&email=' . urlencode($email) . '&message=' . urlencode($message));
       exit;
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Site de recettes — Contact</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="styles.css">
</head>
<body class="d-flex flex-column min-vh-100">
  <div class="container py-3">

    <?php include 'header.php'; ?>
  
    <h1>Contactez-nous</h1>

    <?php
     if ($sent): ?>
      <?php 
      include 'submit_contact.php'; ?>
      
    <?php else: ?>

      <?php if (!empty($errors)): ?>
        <div class="alert alert-danger">
          <?php echo implode('<br>', array_map('htmlspecialchars', $errors)); ?>
        </div>
      <?php endif; ?>

      <form method="post" class="mt-3" novalidate>
        <div class="mb-3">
          <label for="email" class="form-label">Email</label>
          <input
            type="email"
            class="form-control"
            id="email"
            name="email"
            placeholder="vous@exemple.com"
            value="<?php echo isset($email) ? htmlspecialchars($email) : ''; ?>"
            required
          >
          <div class="form-text">Nous ne revendrons pas votre email.</div>
        </div>

        <div class="mb-3">
          <label for="message" class="form-label">Votre message</label>
          <textarea
            class="form-control"
            id="message"
            name="message"
            rows="5"
            placeholder="Exprimez-vous"
            required
          ><?php echo isset($message) ? htmlspecialchars($message) : ''; ?></textarea>
        </div>

        <button type="submit" class="btn btn-primary">Envoyer</button>
      </form>

    <?php endif; ?>

    <?php include 'footer.php'; ?>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
