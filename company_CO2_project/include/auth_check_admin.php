<?php
session_start();

// Require login
if (empty($_SESSION['logged_in'])) {
    header("Location: home_login.php");
    exit;
}

// Require role: admin OR superuser
if (!isset($_SESSION['role']) || !in_array($_SESSION['role'], ['admin', 'superuser'], true)) {
    // Optional: set a flash message before redirecting
    // $_SESSION['flash'] = 'Access denied: admin or superuser required.';
    header("Location: home_login.php");
    exit;
}
