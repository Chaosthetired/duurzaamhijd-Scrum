<?php
// Standalone demo data (no DB, no includes).
$companyRows = [
  [
    'company_active' => 1,
    'logo_path' => 'images/acme.png',
    'company_name' => 'ACME Energie BV',
    'company_emissions' => '125,000',
    'company_electricity_use' => '48,500,000',
    'type_name' => 'Energieproducent',
    'company_source' => 'Klimaatrapport 2024'
  ],
  [
    'company_active' => 1,
    'logo_path' => 'images/greensteel.png',
    'company_name' => 'GreenSteel NL',
    'company_emissions' => '310,000',
    'company_electricity_use' => '92,100,000',
    'type_name' => 'Staal',
    'company_source' => 'Jaarverslag 2024'
  ],
  [
    'company_active' => 0, // niet getoond
    'logo_path' => 'images/hiddenco.png',
    'company_name' => 'HiddenCo',
    'company_emissions' => '50,000',
    'company_electricity_use' => '10,000,000',
    'type_name' => 'Overig',
    'company_source' => '—'
  ],
];
?>
<!doctype html>
<html lang="nl">
<head>
  <meta charset="utf-8">
  <title>Overzicht – CO₂ & Elektriciteit</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="preload" href="CSS/css_header.css" as="style">
  <link rel="stylesheet" href="css/css_header.css">
</head>
<body>

<h1>Overzichtstabel</h1>

<table>
  <tr>
    <th>Logo</th>
    <th>Bedrijf</th>
    <th>CO₂-uitstoot (ton/jaar)</th>
    <th>Elektriciteitsgebruik (kWh/jaar)</th>
    <th>Type</th>
    <th>Bron</th>
  </tr>

  <?php foreach ($companyRows as $company): ?>
    <?php if (!empty($company['company_active'])): ?>
      <tr>
        <td>
          <?php if (!empty($company['logo_path'])): ?>
            <img class="logo"
                 src="<?php echo htmlspecialchars($company['logo_path']); ?>"
                 alt="Logo van <?php echo htmlspecialchars($company['company_name']); ?>">
          <?php else: ?>
            <span class="muted">—</span>
          <?php endif; ?>
        </td>
        <td><?php echo htmlspecialchars($company['company_name']); ?></td>
        <td><?php echo htmlspecialchars($company['company_emissions']); ?></td>
        <td><?php echo htmlspecialchars($company['company_electricity_use']); ?></td>
        <td><?php echo htmlspecialchars($company['type_name']); ?></td>
        <td><?php echo htmlspecialchars($company['company_source']); ?></td>
      </tr>
    <?php endif; ?>
  <?php endforeach; ?>

</table>

</body>
</html>
 