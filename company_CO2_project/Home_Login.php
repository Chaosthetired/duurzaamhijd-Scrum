<?php
session_start();

require_once("include/db.inc.php");
require_once("classes/login_class.php");

$pdo = connect();
$loginopj = new login($pdo);

// If the user is already logged in, redirect to welcome page
if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) {
    header("Location: get_page.php");
    exit;
}

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    $user = $loginopj->getUserByUsername($username); // secure method using prepared statements

    if ($user && password_verify($password, $user['password'])) {
        session_regenerate_id(true);
        $_SESSION['logged_in'] = true;
        $_SESSION['username'] = $username;
        $_SESSION['role'] = $user['Role'];
        header("Location: get_company.php");
        exit;
    } else {
        $error = "Invalid username or password.";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Login Page</title>
</head>
<body>
    <h2>Login</h2>
    <?php 
    if (isset($error)) {
        echo "<p style='color:red;'>$error</p>";
    }
    ?>
    <form method="post" action="">
        <label for="username">Username:</label>
        <input type="text" name="username" id="username" required>
        <br/><br/>
        <label for="password">Password:</label>
        <input type="password" name="password" id="password" required>
        <br/><br/>
        <input type="submit" value="Login">
    </form>
</body>
</html>