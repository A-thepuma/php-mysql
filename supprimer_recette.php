<?php
session_start();
require_once __DIR__ . '/mysql.php';

// Accès réservé
if (!isset($_SESSION['LOGGED_USER'])) {
  http_response_code(403);
  exit('Accès refusé : connectez-vous.');
}

// Les méthode et paramètres
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
  http_response_code(405);
  exit('Méthode non autorisée.');
}

$id = isset($_POST['id']) ? (int)$_POST['id'] : 0;
if ($id <= 0) {
  header('Location: index.php?deleted=0'); exit;
}

// Suppression réservée au propriétaire
try {
  $sql = 'DELETE FROM recipes WHERE recipe_id = :id AND author = :author LIMIT 1';
  $st  = $db->prepare($sql);
  $st->execute(array(
    'id'     => $id,
    'author' => $_SESSION['LOGGED_USER']['email'],
  ));

  // Si aucune ligne touchée = pas propriétaire ou id invalide
  if ($st->rowCount() === 0) {
    header('Location: index.php?deleted=0'); exit;
  }

  header('Location: index.php?deleted=1'); exit;
} catch (Exception $e) {
  header('Location: index.php?deleted=0'); exit;
}
