<?php
// ============================================
// upload.php — Upload Foto Sertifikat ke Database
// ============================================
require_once 'config.php';

$pesan = '';
$error = '';

$sertifikat_list = $pdo->query(
    "SELECT id, judul FROM sertifikat WHERE profil_id = 1 ORDER BY urutan"
)->fetchAll();

// ============================================
// PROSES UPLOAD
// ============================================
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id   = (int)($_POST['id'] ?? 0);
    $file = $_FILES['foto'] ?? null;

    $allowed_mime = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];

    if ($id <= 0) {
        $error = 'Pilih sertifikat terlebih dahulu.';
    } elseif (!$file || $file['error'] !== UPLOAD_ERR_OK) {
        $error = 'Gagal upload file. Coba lagi.';
    } elseif (!in_array($file['type'], $allowed_mime)) {
        $error = 'Format tidak didukung. Gunakan JPG, PNG, GIF, atau WEBP.';
    } elseif ($file['size'] > 5 * 1024 * 1024) {
        $error = 'Ukuran file maksimal 5MB.';
    } else {
        $blob = file_get_contents($file['tmp_name']);
        $mime = $file['type'];

        $stmt = $pdo->prepare("UPDATE sertifikat SET foto = ?, foto_mime = ? WHERE id = ?");
        $stmt->bindParam(1, $blob, PDO::PARAM_LOB);
        $stmt->bindParam(2, $mime);
        $stmt->bindParam(3, $id, PDO::PARAM_INT);
        $stmt->execute();

        $pesan = 'Foto sertifikat berhasil disimpan ke database!';
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload Foto Sertifikat</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background: #f0f2f5; }
        .preview-img { max-height: 220px; object-fit: contain; border-radius: 8px; display: none; border: 1px solid #dee2e6; padding: 6px; background: #fff; }
    </style>
</head>
<body>
<div class="container py-5" style="max-width: 560px;">
    <h4 class="fw-bold mb-1">Upload Foto Sertifikat</h4>
    <p class="text-muted mb-4">Foto disimpan sebagai BLOB langsung di database</p>

    <?php if ($pesan): ?>
        <div class="alert alert-success"><?= htmlspecialchars($pesan) ?></div>
    <?php endif; ?>
    <?php if ($error): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <div class="card shadow-sm p-4">
        <form method="POST" enctype="multipart/form-data">

            <div class="mb-3">
                <label class="form-label fw-semibold">Pilih Sertifikat</label>
                <select name="id" class="form-select" required>
                    <option value="">-- Pilih sertifikat --</option>
                    <?php foreach ($sertifikat_list as $s): ?>
                        <option value="<?= $s['id'] ?>"
                            <?= (isset($_POST['id']) && $_POST['id'] == $s['id']) ? 'selected' : '' ?>>
                            <?= htmlspecialchars($s['judul']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label fw-semibold">File Foto Sertifikat</label>
                <input type="file" name="foto" class="form-control" accept="image/*" required
                       onchange="preview(this)">
                <div class="form-text">Format: JPG, PNG, GIF, WEBP &bull; Maks 5MB</div>
            </div>

            <div class="mb-3 text-center">
                <img id="prev" class="preview-img w-100" src="#" alt="Preview">
            </div>

            <button type="submit" class="btn btn-primary w-100">Simpan ke Database</button>
        </form>
    </div>

    <!-- Daftar status foto -->
    <div class="card shadow-sm mt-4 p-4">
        <h6 class="fw-semibold mb-3">Status Foto Sertifikat</h6>
        <table class="table table-sm mb-0">
            <thead><tr><th>Sertifikat</th><th class="text-center">Status</th></tr></thead>
            <tbody>
                <?php
                $all = $pdo->query("SELECT id, judul, foto FROM sertifikat WHERE profil_id = 1 ORDER BY urutan")->fetchAll();
                foreach ($all as $s):
                    $ada = !empty($s['foto']);
                ?>
                <tr>
                    <td><?= htmlspecialchars($s['judul']) ?></td>
                    <td class="text-center">
                        <?php if ($ada): ?>
                            <span class="badge bg-success">✓ Ada</span>
                        <?php else: ?>
                            <span class="badge bg-secondary">Belum diupload</span>
                        <?php endif; ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <div class="text-center mt-3">
        <a href="index.php" class="text-decoration-none">← Kembali ke Portfolio</a>
    </div>
</div>

<script>
function preview(input) {
    const img = document.getElementById('prev');
    if (input.files && input.files[0]) {
        img.src = URL.createObjectURL(input.files[0]);
        img.style.display = 'block';
    }
}
</script>
</body>
</html>
