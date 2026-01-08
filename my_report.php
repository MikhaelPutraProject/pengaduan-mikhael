<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];
$apiBase = "http://localhost/pengaduan/api.php";

$complaintsJson = file_get_contents(
    $apiBase . "?table=complaints&filter=user_id,eq,$user_id&order=created_at,desc"
);

$complaints = json_decode($complaintsJson, true);

if (!is_array($complaints)) {
    $complaints = [];
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Laporan Saya | Pengaduan Kota Madiun By Mikhael</title>
<meta name="viewport" content="width=device-width, initial-scale=1">

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
body {
    background: linear-gradient(135deg, #eef2ff, #f8f9fa);
    min-height: 100vh;
}

.report-card {
    border-radius: 18px;
}

.badge-status {
    font-size: .85rem;
    padding: 6px 12px;
    border-radius: 20px;
}

.report-title {
    font-weight: 600;
}

.report-isi {
    white-space: normal;
    line-height: 1.6;
}

.log-item {
    border-left: 4px solid #0d6efd;
    padding-left: 15px;
    margin-bottom: 12px;
}

.navbar-brand:hover {
    opacity: 0.85;
}

@media (max-width: 576px) {
    .badge-status {
        font-size: .75rem;
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
                    <a class="nav-link" href="report.php">Buat Laporan</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-danger" href="logout.php">Keluar</a>
                </li>
            </ul>
        </div>
    </div>
</nav>


<!-- CONTENT -->
<div class="container py-5">
<div class="col-lg-9 mx-auto">

<h3 class="fw-bold text-center mb-4">📋 Laporan Saya</h3>

<?php if (empty($complaints)): ?>
    <div class="alert alert-info text-center rounded-pill">
        Anda belum memiliki pengaduan
    </div>
<?php else: ?>
    <?php foreach ($complaints as $c): ?>
        <?php
        $logsJson = file_get_contents(
            $apiBase . "?table=complaint_logs&filter=complaint_id,eq," . $c['id']
        );
        
        $logs = json_decode($logsJson, true);
        
        // Pastikan logs array
        if (!is_array($logs)) {
            $logs = [];
        }

        $statusColor = match ($c['status']) {
            'baru' => 'secondary',
            'diproses' => 'warning',
            'selesai' => 'success',
            default => 'dark'
        };
        ?>

        <div class="card shadow-sm mb-4 report-card">
            <div class="card-body">

                <div class="d-flex justify-content-between align-items-start flex-wrap">
                    <div>
                        <div class="report-title fs-5">
                            <?= htmlspecialchars($c['judul']) ?>
                        </div>
                        <small class="text-muted">
                            ID Laporan: #<?= $c['id'] ?>
                        </small>
                    </div>
                    <span class="badge bg-<?= $statusColor ?> badge-status mt-2">
                        <?= strtoupper($c['status']) ?>
                    </span>
                </div>

                <hr>

                <p class="fw-semibold mb-1">Isi Pengaduan</p>
                <div class="report-isi text-muted mb-3">
                    <?= nl2br(htmlspecialchars($c['isi'])) ?>
                </div>

                <p class="fw-semibold mb-2">Catatan Admin</p>

                <?php if (empty($logs)): ?>
                    <div class="text-muted fst-italic">
                        Belum ada tanggapan dari admin
                    </div>
                <?php else: ?>
                    <?php foreach ($logs as $log): ?>
                        <div class="log-item">
                            <?= htmlspecialchars($log['catatan']) ?><br>
                            <small class="text-muted">
                                <?= $log['tanggal'] ?>
                            </small>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>

            </div>
        </div>

    <?php endforeach; ?>
<?php endif; ?>

</div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
