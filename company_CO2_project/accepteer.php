<?php
 require_once("include/db.inc.php");
 require_once("classes/functions.php");
 require_once("include/auth_check.php");
 $pdo = connect();
 $fctopj = new functions($pdo);

 $typeRows = $fctopj->getAllTypes();
 include "include/header.php";




foreach ($companies as $i => $company) {
    if ($company['company_id'] == $company_id) {
        if ($actie == 'accepteren') {
            $companies[$i]['company_active'] = true;
        } elseif ($actie == 'afwijzen') {
            array_splice($companies, $i, 1); // bedrijf verwijderen
        }
        break;
    }
}

file_put_contents($file, json_encode($companies, JSON_PRETTY_PRINT));
exit;
?>
