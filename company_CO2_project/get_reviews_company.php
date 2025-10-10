<?php
require_once("include/db.inc.php"); 
require_once("classes/company_class.php"); 
require_once("classes/foto_class.php"); 
require_once("include/auth_check_admin.php");
$pdo = connect();
$fotoopj = new foto($pdo); 
$comobj = new company_class($pdo);

$allCompanies = $comobj->getAllCompanies();


// Define “pending”
$pending = array_values(array_filter($allCompanies, function ($c) {
    // treat NULL/'' or explicit 'pending' as pending
    $status = isset($c['company_status']) ? strtolower((string)$c['company_status']) : '';
    if ($status === '' || $status === '0' || $status === 'pending' || $status === 'null') {
        return true;
    }
    // legacy fallback: if you still use company_active, show inactive
    if (array_key_exists('company_active', $c) && (int)$c['company_active'] === 0) {
        return true;
    }
    return false;
}));

// CSRF token (tiny & worth it)
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(16));
}
$csrf = $_SESSION['csrf_token'];

function h($v){ return htmlspecialchars((string)$v, ENT_QUOTES, 'UTF-8'); }

 include "include/header.php";
?>

  <?php if (empty($pending)): ?>
    <p>Er zijn momenteel geen bedrijven in afwachting.</p>
  <?php else: ?>
    <table>
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
        <tr>
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
            <!-- Accept -->
            <form method="post" action="api/company_moderation.php">
              <input type="hidden" name="company_id" value="<?= h($c['company_id']) ?>">
              <input type="hidden" name="action" value="accepteren">
              <input type="hidden" name="csrf" value="<?= h($csrf) ?>">
              <button class="btn btn-success" type="submit">Accepteren</button>
            </form>
            <!-- Reject -->
            <form method="post" action="api/company_moderation.php" onsubmit="return confirm('Weet je zeker dat je dit bedrijf wil afwijzen?');">
              <input type="hidden" name="company_id" value="<?= h($c['company_id']) ?>">
              <input type="hidden" name="action" value="afwijzen">
              <input type="hidden" name="csrf" value="<?= h($csrf) ?>">
              <button class="btn btn-danger" type="submit">Afwijzen</button>
            </form>
          </td>
        </tr>
      <?php endforeach; ?>
      </tbody>
    </table>
  <?php endif; ?>

  <?php if (!empty($_GET['ok'])): ?>
    <div class="alert success" style="margin-top:1rem;">Actie uitgevoerd.</div>
  <?php endif; ?>
</body>
</html>