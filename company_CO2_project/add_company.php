<?php 
require_once("include/db.inc.php"); 
require_once("classes/company_class.php"); 
require_once("classes/foto_class.php"); 
$pdo = connect();
$fotoopj = new foto($pdo); 
$comobj = new company_class($pdo);

$target_dir       = "fotos/";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // 1) inputs
    $name        = trim(htmlspecialchars($_POST['input_company_name'] ?? '', ENT_QUOTES, 'UTF-8'));
    $emissions   = (float)str_replace(',', '.', ($_POST['input_emissions_text']   ?? '0'));
    $electricity = (float)str_replace(',', '.', ($_POST['input_electricity_text'] ?? '0'));
    $source      = trim(htmlspecialchars($_POST['input_source_text'] ?? '', ENT_QUOTES, 'UTF-8'));
    $type_id     = (int)($_POST['type_dropdown'] ?? 0);

    // 2) guest user default (0)
    $user_id = isset($_SESSION['user_id']) ? (int)$_SESSION['user_id'] : 0;

    // 3) logo default -> try replace if upload ok
    $logo_id = 1; // (fix: make sure this is defined even without upload)

    if (isset($_FILES['image_input']) && $_FILES['image_input']['error'] === UPLOAD_ERR_OK) {
        $image_path     = $target_dir . basename($_FILES['image_input']['name']);
        $imageFileType  = strtolower(pathinfo($image_path, PATHINFO_EXTENSION));
        $upload_ok      = 1;
        $upload_ok      = $foto->allowedimage($imageFileType, $upload_ok);
        $maybe_logo_id  = $foto->addimage($upload_ok, $image_path, $_FILES);
        if ($maybe_logo_id) {
            $logo_id = (int)$maybe_logo_id;
        }
    }

    // 4) build one payload array
    $payload = [
        'company_name'                 => $name,
        'company_type'                 => $type_id,
        'company_emissions'            => $emissions,
        'logo_id'                      => $logo_id,
        'company_source'               => $source,
        'company_electricity_use'      => $electricity,
        'company_version'              => 1,           // set what you want as default
        'company_status'               => 'pending',   // or whatever your flow needs
        'company_user_submit_id'       => $user_id,    // 0 = guest
        'company_admin_reviewed_by_id' => null,
        'company_reviewed_at'          => null
        // NOTE: submitted_at handled as NOW() in SQL below
    ];

    // 5) insert using one function that accepts the array
    $company_id = $comobj->addCompany($payload);

    // 6) redirect (fix: $page_id was undefined)
    header('Location: getchange_page.php?id=' . $company_id);
    exit;
}
