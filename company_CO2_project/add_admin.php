<?php
 require_once("include/db.inc.php");
 require_once("classes/login_class.php");
 $pdo = connect();
 $loginobj = new login($pdo);

 if ($_SERVER['REQUEST_METHOD'] === 'POST') {
     $username = trim(htmlspecialchars($_POST['Admin_username']));
     $password = trim(htmlspecialchars($_POST['Admin_password']));

     $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
 
     $Role = "admin";

     $loginobj->addAdmin($username, $password, $hashedPassword, $Role);
 
     exit();
}