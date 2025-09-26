<?php 
require_once("include/db.inc.php");
require_once("classes/functions.php");
$pdo = connect();
 $fctopj = new functions($pdo);

$page_id = isset($_GET['id']) ? intval($_GET['id']) : null;
if ($page_id === null) {
    $page_id = isset($_POST['Dropdown_type']) ? intval($_POST['Dropdown_type']) : null;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $page_name = trim(htmlspecialchars($_POST['input_page_name']));

    $pageobj->updatepage($image_to_text_id, $branch, $page_name, $page_id);

    header('Location: getchange_page.php?id=' . $page_id);
    exit();
}