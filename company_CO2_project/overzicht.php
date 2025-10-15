<?php
require_once("include/db.inc.php");
require_once("classes/company_class.php");
require_once("classes/foto_class.php");
require_once("classes/functions.php");
$pdo = connect();
$fotoopj = new foto($pdo);
$comobj = new company_class($pdo);
$fctopj = new functions($pdo);

$companyRows = $comobj->getAllCompanies();

include "include/header.php";
?>
<body>


  <!-- Overzichtstabel -->
  <table>
    <tr>
      <th>Logo</th>
      <th>Bedrijf</th>
      <th>CO₂-uitstoot (miljoen ton/jaar)</th>
      <th>Elektriciteitsgebruik (kWh/jaar)</th>
      <th>typen</th>
      <th>Bron</th>
    </tr>
<?php foreach ($companyRows as $company): ?>
  <?php
    if (($company['company_status'] ?? null) === 'accepted') {
        $logo_id  = $company['logo_id']        ?? null;
        $type_id  = $company['company_type']    ?? null;

        $logorow  = $logo_id ? $fotoopj->selectlogo($logo_id) : null;

        $typerow  = $type_id ? $fctopj->getTypeById($type_id) : null;

        $logoPath = $logorow['logo_path'] ?? 'uploads/logos/default.png';
        $typeName = $typerow['type_name'] ?? '—';
  ?>
      <tr>
        <td>
          <img src="<?= htmlspecialchars($logoPath) ?>" 
               alt="Logo van <?= htmlspecialchars($company['company_name'] ?? 'Onbekend') ?>">
        </td>
        <td><?= htmlspecialchars($company['company_name'] ?? '') ?></td>
        <td><?= htmlspecialchars((string)($company['company_emissions'] ?? '')) ?></td>
        <td><?= htmlspecialchars((string)($company['company_electricity_use'] ?? '')) ?></td>
        <td><?= htmlspecialchars($typeName) ?></td>
        <td><?= htmlspecialchars($company['company_source'] ?? '') ?></td>
      </tr>
  <?php } ?>
<?php endforeach; ?>

  </table>
</body>
</html>
