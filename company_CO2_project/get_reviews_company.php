<?php
require_once("include/db.inc.php"); 
require_once("classes/company_class.php"); 
require_once("classes/foto_class.php"); 
require_once("include/auth_check_admin.php");

$pdo     = connect();
$fotoopj = new foto($pdo); 
$comobj  = new company_class($pdo);

$allCompanies = $comobj->getAllCompanies();

// Define “pending”
$pending = array_values(array_filter($allCompanies, function ($c) {
    $status = isset($c['company_status']) ? strtolower((string)$c['company_status']) : '';
    if ($status === '' || $status === '0' || $status === 'pending' || $status === 'null') return true;
    if (array_key_exists('company_active', $c) && (int)$c['company_active'] === 0) return true;
    return false;
}));

function h($v){ return htmlspecialchars((string)$v, ENT_QUOTES, 'UTF-8'); }

include "include/header.php";
?>

<?php if (empty($pending)): ?>
  <p class="pending-empty">Er zijn momenteel geen bedrijven in afwachting.</p>
<?php else: ?>
  <table id="pending-table">
    <thead>
      <tr>
        <th>ID</th>
        <th>Naam</th>
        <th>Type</th>
        <th>CO₂ (ton/jaar)</th>
        <th>Elektriciteit (kWh/jaar)</th>
        <th>Bron</th>
        <th>Ingediend door</th>
        <th>Acties</th>
      </tr>
    </thead>
    <tbody>
    <?php foreach ($pending as $c): ?>
      <tr data-company-id="<?= h($c['company_id']) ?>">
        <td><?= h($c['company_id']) ?></td>
        <td><?= h($c['company_name']) ?></td>
        <td><?= h($c['company_type']) ?></td>
        <td><?= h($c['company_emissions']) ?></td>
        <td><?= h($c['company_electricity_use']) ?></td>
        <td>
          <?php if (!empty($c['company_source'])): ?>
            <a href="<?= h($c['company_source']) ?>" target="_blank" rel="noopener">link</a>
          <?php endif; ?>
        </td>
        <td><?= h($c['company_user_submit_id'] ?? '') ?></td>
        <td style="display:flex; gap:.5rem;">
          <button type="button" class="btn btn-success act" data-action="accepteren">Accepteren</button>
          <button type="button" class="btn btn-danger act" data-action="afwijzen">Afwijzen</button>
        </td>
      </tr>
    <?php endforeach; ?>
    </tbody>
  </table>
<?php endif; ?>

<?php if (!empty($_GET['ok'])): ?>
  <div class="alert success" style="margin-top:1rem;">Actie uitgevoerd.</div>
<?php endif; ?>

<!-- Load your external JS (adjust the path to wherever you store JS) -->
<script src="JS/review_company.js" defer></script>
</body>
</html>
