<?php
require_once 'config.php';

// ambil data dari database
$dokumentasi = $pdo->query("SELECT * FROM dokumentasi")->fetchAll();
$sertifikat  = $pdo->query("SELECT * FROM sertifikat")->fetchAll();
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portfolio - Elvira</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- CSS -->
    <link rel="stylesheet" href="style.css">
</head>
<body>

<!-- NAVBAR -->
<nav class="navbar navbar-expand-lg navbar-dark custom-navbar fixed-top shadow">
    <div class="container">
        <a class="navbar-brand fw-bold" href="#">MyPortfolio</a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item"><a class="nav-link" href="#home">Home</a></li>
                <li class="nav-item"><a class="nav-link" href="#about">About</a></li>
                <li class="nav-item"><a class="nav-link" href="#documentation">Dokumentasi</a></li>
                <li class="nav-item"><a class="nav-link" href="#certificates">Certificates</a></li>
            </ul>
        </div>
    </div>
</nav>

<!-- HOME -->
<section id="home" class="hero d-flex align-items-center text-center text-white">
    <div class="container">
        <img src="images/me.jpeg" class="profile-img mb-4" alt="Profile">

        <h1 class="fw-bold">Elvira Agustin</h1>
        <p class="lead">Mahasiswa</p>
        <a href="#about" class="btn btn-light mt-3">Scroll Down</a>
    </div>
</section>

<!-- ABOUT -->
<section id="about" class="py-5">
    <div class="container">
        <h2 class="text-center mb-5 fw-bold">About Me</h2>

        <div class="row">
            <div class="col-md-6">
                <p>
                    Saya adalah pribadi yang mampu memanajemen waktu dengan baik antara akademik dan kegiatan organisasi.
                    Saya terbiasa bekerja dalam tim, aktif berkomunikasi, serta menghargai pendapat orang lain untuk mencapai tujuan bersama.
                </p>

                <h5 class="mt-4">Pengalaman</h5>
                <ul>
                    <li>Kepanitiaan Aplikasi</li>
                    <li>Panitia Insevent</li>
                    <li>Pengurus Organisasi Kampus</li>
                </ul>
            </div>

            <div class="col-md-6">
                <h5>Skill Level</h5>

                <div class="mb-3">
                    <label>Memanajemen Waktu</label>
                    <div class="progress">
                        <div class="progress-bar bg-primary" style="width: 90%">90%</div>
                    </div>
                </div>

                <div class="mb-3">
                    <label>Kerjasama Tim</label>
                    <div class="progress">
                        <div class="progress-bar bg-primary" style="width: 85%">85%</div>
                    </div>
                </div>

                <div class="mb-3">
                    <label>Berkomunikasi</label>
                    <div class="progress">
                        <div class="progress-bar bg-primary" style="width: 75%">75%</div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</section>


<section id="documentation" class="py-5 bg-light">
    <div class="container">
        <h2 class="text-center mb-5 fw-bold">Dokumentasi Kegiatan</h2>

        <div class="row text-center">
            <?php foreach ($dokumentasi as $dok): ?>
                <div class="col-md-4 mb-4">
                    <div class="card shadow h-100">

                        <img src="images/<?= htmlspecialchars($dok['nama_foto']) ?>"
                             class="card-img-top"
                             alt="<?= htmlspecialchars($dok['keterangan']) ?>">

                        <div class="card-body">
                            <p class="card-text"><?= htmlspecialchars($dok['keterangan']) ?></p>
                        </div>

                    </div>
                </div>
            <?php endforeach; ?>
        </div>

    </div>
</section>


<section id="certificates" class="py-5">
    <div class="container">
        <h2 class="text-center mb-5 fw-bold">Certificates</h2>

        <div class="row">
            <?php foreach ($sertifikat as $cert): ?>
                <div class="col-md-3 mb-4">
                    <div class="card shadow-sm h-100">

                        <img src="images/<?= htmlspecialchars($cert['nama_foto']) ?>"
                             class="card-img-top"
                             alt="<?= htmlspecialchars($cert['judul']) ?>">

                        <div class="card-body">
                            <h6><?= htmlspecialchars($cert['judul']) ?></h6>
                            <p class="small"><?= htmlspecialchars($cert['deskripsi']) ?></p>
                        </div>

                    </div>
                </div>
            <?php endforeach; ?>
        </div>

    </div>
</section>


<footer class="custom-footer text-center">
    <div class="container">
        <p>© 2026 - Elvira Agustin | Portfolio Website</p>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>