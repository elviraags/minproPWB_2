<?php
// ============================================
// foto_sertifikat.php
// Menampilkan foto sertifikat (BLOB) dari database
// Cara pakai: <img src="foto_sertifikat.php?id=1">
// ============================================
require_once 'config.php';

$id = (int)($_GET['id'] ?? 0);

if ($id <= 0) {
    http_response_code(400);
    exit('ID tidak valid.');
}

$stmt = $pdo->prepare("SELECT foto, foto_mime FROM sertifikat WHERE id = ?");
$stmt->execute([$id]);
$row = $stmt->fetch();

if (!$row || empty($row['foto'])) {
    http_response_code(404);
    exit('Foto belum diupload.');
}

header("Content-Type: " . $row['foto_mime']);
header("Cache-Control: max-age=86400");
echo $row['foto'];
?>
