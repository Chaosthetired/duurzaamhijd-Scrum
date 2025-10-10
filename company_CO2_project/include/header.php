<?php

$logged_in = !empty($_SESSION['logged_in']);
$role      = $_SESSION['role'] ?? null;   // 'admin', 'superuser', etc.
$username  = $_SESSION['username'] ?? null;
?>
<!DOCTYPE html>
<html lang="nl">
<head>
  <meta charset="UTF-8">
  <link rel="stylesheet" href="CSS/css_header.css">
  <link rel="stylesheet" href="CSS/forms.css">
  <link rel="stylesheet" href="CSS/login.css">
  <link rel="stylesheet" href="CSS/overzicht.css">
  <title>Overzicht bedrijven</title>
</head>
<body>
  <header>
    <h1>🌍 Bedrijven &amp; hun duurzaamheid</h1>

    <?php if ($logged_in): ?>
      <a href="get_company.php" class="btn">➕ Bedrijf toevoegen</a>

      <?php if ($role == 'admin' || $role == 'superuser'): ?>
        <a href="get_type.php" class="btn">➕ Type toevoegen</a>
      <?php endif; ?>

      <?php if ($role == 'superuser'): ?>
        <a href="get_admin.php" class="btn">➕ Admin toevoegen</a>
      <?php endif; ?>

      <a href="get_reviews_company.php" class="btn">🔎 Review submissions</a>

      <a href="log_out.php" class="btn">➖ Log uit</a>

    <?php else: ?>
      <a href="Home_Login.php" class="btn">🔐 Inloggen</a>
      <a href="register.php" class="btn">📝 Registreren</a>
    <?php endif; ?>
  </header>
