<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    // Redirect to login page
    header("Location: home_login.php");
    exit;
}
if ($_SESSION['role'] !== 'superuser') {
    echo "Access denied not superuser";
    sleep(5);
    header("Location: home_login.php");
    exit;
}