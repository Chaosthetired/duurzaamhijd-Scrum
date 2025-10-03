<?php
$companies = [
    [
        "company_id"             => 1,
        "company_name"           => "Example Corp",
        "company_type"           => 2,
        "company_emissions"      => 1500,
        "logo_id"                => "uploads/example.png",
        "company_source"         => "self-reported",
        "company_electricity_use"=> 32000,
        "company_active"         => true
    ],
    [
        "company_id"             => 2,
        "company_name"           => "Shell",
        "company_type"           => 1,
        "company_emissions"      => 1000000,
        "logo_id"                => "uploads/shell.png",
        "company_source"         => "jaarverslag 2023",
        "company_electricity_use"=> 500000000,
        "company_active"         => true
    ],
    [
        "company_id"             => 3,
        "company_name"           => "Tesla",
        "company_type"           => 3,
        "company_emissions"      => 200000,
        "logo_id"                => "uploads/tesla.png",
        "company_source"         => "milieurapport",
        "company_electricity_use"=> 70000000,
        "company_active"         => true
    ]
];
?>

<!DOCTYPE html>
<html lang="nl">
<head>
  <meta charset="UTF-8">
  <title>Overzicht bedrijven</title>
  <style>
    body { font-family: Arial, sans-serif; padding: 20px; background: #f9f9f9; }
    header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 20px;
    }
    h1 { color: #333; }
    table { width: 100%; border-collapse: collapse; background: white; box-shadow: 0 2px 6px rgba(0,0,0,0.1); border-radius: 10px; overflow: hidden; }
    th, td { border: 1px solid #ddd; padding: 12px; text-align: left; }
    th { background-color: #f2f2f2; }
    td img { max-height: 50px; border-radius: 5px; }
    .btn {
      padding: 10px 15px;
      background: green;
      color: white;
      text-decoration: none;
      border-radius: 6px;
      font-weight: bold;
    }
    .btn:hover { background: darkgreen; }
  </style>
</head>
<body>
  <header>
    <h1>🌍 Bedrijven & hun duurzaamheid</h1>
    <a href="opslaan.php" class="btn">➕ Bedrijf toevoegen</a>
  </header>

  <!-- Overzichtstabel -->
  <table>
    <tr>
      <th>Logo</th>
      <th>Bedrijf</th>
      <th>CO₂-uitstoot (ton/jaar)</th>
      <th>Elektriciteitsgebruik (kWh/jaar)</th>
      <th>Bron</th>
    </tr>

    <?php foreach ($companies as $company): ?>
      <tr>
        <td><img src="<?php echo $company['logo_id']; ?>" alt="Logo van <?php echo $company['company_name']; ?>"></td>
        <td><?php echo $company['company_name']; ?></td>
        <td><?php echo $company['company_emissions']; ?></td>
        <td><?php echo $company['company_electricity_use']; ?></td>
        <td><?php echo $company['company_source']; ?></td>
      </tr>
    <?php endforeach; ?>
  </table>
</body>
</html>
