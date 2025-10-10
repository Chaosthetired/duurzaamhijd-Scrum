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
      <th>CO₂-uitstoot (ton/jaar)</th>
      <th>Elektriciteitsgebruik (kWh/jaar)</th>
      <th>typen</th>
      <th>Bron</th>
    </tr>
<?php foreach ($companyRows as $company): ?>
    <?php 
      $company_show = $company['company_active'];

      if ($company_show) {  // only show if it's 1
          $logo_id = $company['logo_id'];
          $logorow = $fotoopj->selectlogo($logo_id);

          $type_id = $company['company_type'];
          $typerow = $fctopj->getTypeById($type_id);
    ?>
        <tr>
          <td><img src="<?php echo $logorow['logo_path']; ?>" alt="Logo van <?php echo $company['company_name']; ?>"></td>
          <td><?php echo $company['company_name']; ?></td>
          <td><?php echo $company['company_emissions']; ?></td>
          <td><?php echo $company['company_electricity_use']; ?></td>
          <td><?php echo $typerow['type_name']; ?></td>
          <td><?php echo $company['company_source']; ?></td>
        </tr>
    <?php } ?>
<?php endforeach; ?>

  </table>
</body>
</html>
