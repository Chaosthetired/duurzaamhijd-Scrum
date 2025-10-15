<?php
declare(strict_types=1);
header('Content-Type: application/json; charset=utf-8');
session_start();

echo __DIR__ . '/../include/db.inc.php';
require_once(__DIR__ . '/../include/db.inc.php');
require_once(__DIR__ . '/../classes/company_class.php');



// JSON-only auth guard (no redirects)
if (empty($_SESSION['logged_in'])) {
  http_response_code(401);
  echo json_encode(['ok'=>false,'error'=>'Niet ingelogd']); exit;
}
$role = $_SESSION['role'] ?? '';
if ($role !== 'admin' && $role !== 'superuser') {
  http_response_code(403);
  echo json_encode(['ok'=>false,'error'=>'Geen rechten']); exit;
}

ini_set('display_errors', '0');

$raw = file_get_contents('php://input') ?: '';
$in  = json_decode($raw, true);
if (!is_array($in)) {
  http_response_code(400);
  echo json_encode(['ok'=>false,'error'=>'Ongeldige JSON body']); exit;
}

$company_id = (int)($in['company_id'] ?? 0);
$action     = strtolower(trim((string)($in['action'] ?? '')));

if (!$company_id || !in_array($action, ['accepteren','afwijzen'], true)) {
  http_response_code(400);
  echo json_encode(['ok'=>false,'error'=>'Ongeldige invoer']); exit;
}

$status_map = ['accepteren'=>'accepted','afwijzen'=>'rejected'];
$new_status = $status_map[$action];

try {
  $pdo = connect();
  $admin_id = $_SESSION['user_id'] ?? null;

  $sql = "
    UPDATE company_table
       SET company_status = :status,
           company_admin_reviewed_by_id = :admin_id,
           company_reviewed_at = NOW()
     WHERE company_id = :id
  ";
  $pdo->query($sql);
  $pdo->bind(':status',   $new_status);
  $pdo->bind(':admin_id', $admin_id);
  $pdo->bind(':id',       $company_id);
  $pdo->execute();

  $rows = method_exists($pdo,'rowCount') ? (int)$pdo->rowCount() : 1;
  if ($rows < 1) {
    http_response_code(404);
    echo json_encode(['ok'=>false,'error'=>'Bedrijf niet gevonden']); exit;
  }

  echo json_encode(['ok'=>true,'id'=>$company_id,'new_status'=>$new_status,'reviewed_at'=>date('c')]);
} catch (Throwable $e) {
  http_response_code(500);
  echo json_encode(['ok'=>false,'error'=>'DB fout: '.$e->getMessage()]);
}
