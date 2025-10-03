<?php
 require_once("include/db.inc.php");
 require_once("classes/functions.php");
 $pdo = connect();
 $fctopj = new functions($pdo);

$type_id = isset($_GET['id']) ? intval($_GET['id']) : null;

 if ($_SERVER['REQUEST_METHOD'] === 'POST') {
     $type_name = trim(htmlspecialchars($_POST['input_type_name']));
 
     $fctopj->updateType($type_id,$type_name);
 
     $nextPageUrl = 'getchange_type.php?id=' . $type_id;
     header('Location: ' . $nextPageUrl);
     exit();
}