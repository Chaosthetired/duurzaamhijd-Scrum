<?php
session_start();
session_unset(); // Unset all session variables
session_destroy(); // Destroy the session
header("Location: overzicht.php"); // Redirect back to login page
exit;
