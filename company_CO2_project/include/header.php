 <!DOCTYPE html>
<html lang="nl">
<head>
  <meta charset="UTF-8">
    <link rel="stylesheet" href="CSS/css_header.css">
  <title>Overzicht bedrijven</title>
</head>
  <header>
    <h1>🌍 Bedrijven & hun duurzaamheid</h1>
    <a href="get_company.php" class="btn">➕ Bedrijf toevoegen</a>
        <?php if ($_SESSION['role'] !== 'admin') {
    echo ' <a href="get_type.php" class="btn">➕ type toevoegen</a>';
    } ?>
    <?php if ($_SESSION['role'] !== 'superuser') {
    echo '<a href="get_admin.php" class="btn">➕ admin toevoegen</a>';
    } ?>
    
    <a href="reviewCheck.php" class="btn">➕ Review submitions</a>
            <?php if ($_SESSION) {
    echo '<a href="log_out.php" class="btn">➖  log out</a>';
    } ?>
    <a href="log_out.php" class="btn">➖  log out</a>
  </header>
