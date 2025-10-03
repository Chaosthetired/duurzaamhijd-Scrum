<?php
 require_once("include/db.inc.php");
 require_once("classes/company_class.php");
 require_once("classes/foto_class.php");
 $pdo = connect();
 $fotoopj = new foto($pdo);
 $comobj = new company_class($pdo);
 $default_image_id = 1;
 $uploadok = 1;
 $target_dir = "fotos/";

 if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $company_name = trim(htmlspecialchars($_POST['input_company_name'] ?? '', ENT_QUOTES, 'UTF-8'));
    $emissions = (float)str_replace(',', '.', ($_POST['input_emissions_text'] ?? '0'));
    $electricity = (float)str_replace(',', '.', ($_POST['input_electricity_text'] ?? '0'));
    $source = trim(htmlspecialchars($_POST['input_source_text'] ?? '', ENT_QUOTES, 'UTF-8'));
     $selected_type_id = (int)($_POST['type_dropdown'] ?? 0);
 
     if (!isset($_FILES["image_input"]) || $_FILES["image_input"]["error"] !== UPLOAD_ERR_OK) {
         // No image uploaded, use default image ID
         $image_id = $default_image_id;
     } else {
         // Image uploaded, proceed with processing
         $image_path = $target_dir . basename($_FILES["image_input"]["name"]);
         $imageFileType = strtolower(pathinfo($image_path, PATHINFO_EXTENSION));
         $uploadok = $fotoopj->allowedimage($imageFileType, $uploadok);
         $logo_id = $fotoopj->addimage($uploadok, $image_path, $_FILES);
     }


     $company_id = $comobj->addCompany($company_name, $emissions, $electricity, $source, $selected_type_id, $logo_id);
 
     $nextPageUrl = 'getchange_page.php?id=' . $page_id;
     header('Location: ' . $nextPageUrl);
     exit();
}