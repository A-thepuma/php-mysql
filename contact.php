<?php

$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $email = isset($_POST['email']) ? trim($_POST['email']) : '';
  $message = isset($_POST['message']) ? trim($_POST['message']) : '';

  if ($email === '' || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errors[] = "Veuillez saisir un email valide.";
  }
  if ($message === '') {
    $errors[] = "Veuillez écrire un message.";
  }

  if (empty($errors)) {
    
  }
}
?>
<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="UTF-8">
  <title>Site de recettes — Contact</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="d-flex flex-column min-vh-100">
  <div class="container py-3">

    <?php include 'header.php'; ?>

    <h1>Contactez-nous</h1>

    <?php if (!empty($errors)): ?>
      <div class="alert alert-danger">
        <?php echo implode('<br>', array_map('htmlspecialchars', $errors)); ?>
      </div>
    <?php endif; ?>

    <form method="post" action="submit_contact.php" class="mt-3" novalidate>
      <div class="mb-3">
        <label for="email" class="form-label">Email</label>
        <input type="email" class="form-control" id="email" name="email" placeholder="vous@exemple.com"
          value="<?php echo isset($email) ? htmlspecialchars($email) : ''; ?>" required>
      </div>

      <div class="mb-3">
        <label for="message" class="form-label">Votre message</label>
        <textarea class="form-control" id="message" name="message" rows="5" placeholder="Exprimez-vous"
          required><?php echo isset($message) ? htmlspecialchars($message) : ''; ?></textarea>
      </div>

      <button type="submit" class="btn btn-primary">Envoyer</button>
    </form>

    <?php include 'footer.php'; ?>
  </div>
</body>

</html>