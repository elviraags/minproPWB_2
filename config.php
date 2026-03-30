<?php
// ============================================
// config.php — Koneksi ke Database MySQL
// ============================================

$host     = 'localhost';
$dbname   = 'portfolioelvira';
$username = 'root';   // sesuaikan
$password = '';       // sesuaikan (kosong di XAMPP)

try {
    $pdo = new PDO(
        "mysql:host=$host;dbname=$dbname;charset=utf8mb4",
        $username,
        $password,
        [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        ]
    );
} catch (PDOException $e) {
    die("Koneksi gagal: " . $e->getMessage());
}
?>
