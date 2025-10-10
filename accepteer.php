<?php
$file = 'bedrijven.json';
$companies = file_exists($file) ? json_decode(file_get_contents($file), true) : [];

$company_id = $_GET['company_id'];
$actie = $_GET['actie']; // "accepteren" of "afwijzen"

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
header('Location: admin.php');
exit;
?>
