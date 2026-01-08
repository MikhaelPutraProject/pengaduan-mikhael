<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];
$message = "";

$apiBase = "http://localhost/pengaduan/api.php";

$categoriesJson = file_get_contents(
    $apiBase . "?table=categories"
);

$categories = json_decode($categoriesJson, true);

if (!is_array($categories)) {
    $categories = [];
}

if (isset($_POST['judul'])) {
    $data = [
        "user_id"     => $user_id,
        "category_id" => $_POST['category_id'],
        "judul"       => $_POST['judul'],
        "isi"         => $_POST['isi'],
        "status"      => "baru"
    ];

    $ch = curl_init($apiBase . "?table=complaints");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        "Content-Type: application/json"
    ]);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
    curl_exec($ch);
    curl_close($ch);

    $message = "Pengaduan berhasil dikirim!";
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Buat Pengaduan | Pengaduan Kota Madiun By Mikhael</title>
<meta name="viewport" content="width=device-width, initial-scale=1">

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
body {
    background: linear-gradient(135deg, #eef2ff, #f8f9fa);
    min-height: 100vh;
}

/* Card utama */
.report-card {
    border-radius: 20px;
    padding: 30px;
}

/* Judul */
.report-title {
    font-weight: 700;
    font-size: 1.8rem;
}

/* Input */
.form-control,
.form-select {
    border-radius: 12px;
    padding: 12px;
}

/* Fokus input */
.form-control:focus,
.form-select:focus {
    box-shadow: 0 0 0 0.2rem rgba(13,110,253,.25);
}

/* Tombol */
.btn {
    border-radius: 30px;
    padding: 10px 25px;
}

.navbar-brand:hover {
    opacity: 0.85;
}

/* HP */
@media (max-width: 576px) {
    .report-card {
        padding: 20px;
    }

    .report-title {
        font-size: 1.4rem;
    }

    .btn {
        width: 100%;
    }
}
</style>
</head>

<body>

<!-- NAVBAR -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow-sm">
    <div class="container">
        <a class="navbar-brand fw-semibold" href="index.php">
            Pengaduan Kota Madiun
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#nav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="nav">
            <ul class="navbar-nav ms-auto text-center">
                <li class="nav-item">
                    <a class="nav-link" href="my_report.php">Laporan Saya</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-danger" href="logout.php">Keluar</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<!-- CONTENT -->
<div class="container d-flex align-items-center justify-content-center" style="min-height: 90vh;">
<div class="col-lg-7 col-md-9 col-12">
<div class="card shadow-lg report-card">

    <div class="text-center mb-4">
        <div class="fs-1">📝</div>
        <div class="report-title">Pengaduan Masyarakat Kota Madiun</div>
        <p class="text-muted mb-0">
            Laporkan permasalahan fasilitas umum dan pelayanan publik di wilayah Kota Madiun
        </p>
    </div>

    <?php if ($message): ?>
        <div class="alert alert-success text-center rounded-pill">
            <?= $message ?>
        </div>
    <?php endif; ?>

    <form method="post">
        <div class="mb-3">
            <label class="form-label fw-semibold">Kategori</label>
            <select name="category_id" class="form-select" required>
                <option value="">-- Pilih Kategori --</option>
                <?php foreach ($categories as $cat): ?>
                    <option value="<?= $cat['id'] ?>">
                        <?= $cat['nama_kategori'] ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label fw-semibold">Judul Pengaduan</label>
            <input type="text" name="judul" class="form-control" placeholder="Contoh: Lampu jalan mati di Jalan Pahlawan" required>
        </div>

        <div class="mb-4">
            <label class="form-label fw-semibold">Isi Pengaduan</label>
            <textarea name="isi" rows="5" class="form-control" placeholder="Jelaskan lokasi dan permasalahan yang terjadi di Kota Madiun secara detail..." required></textarea>
        </div>

        <div class="d-flex gap-2 flex-column flex-md-row">
            <a href="index.php" class="btn btn-secondary">
                ⬅ Kembali
            </a>
            <button type="submit" class="btn btn-primary flex-fill">
                🚀 Kirim Pengaduan
            </button>
        </div>
    </form>

</div>
</div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
