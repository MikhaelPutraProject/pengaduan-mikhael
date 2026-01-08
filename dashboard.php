<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header("Location: login_admin.php");
    exit;
}

$admin_id = $_SESSION['admin_id'];
$apiBase  = "http://localhost/pengaduan/api.php";
$message  = "";

/* ================== UPDATE STATUS ================== */
if (isset($_POST['update_status'])) {
    $complaint_id = (int)$_POST['complaint_id'];
    $status       = $_POST['status'];

    $ch = curl_init($apiBase . "?table=complaints/$complaint_id");
    curl_setopt_array($ch, [
        CURLOPT_CUSTOMREQUEST => "PUT",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_HTTPHEADER => ["Content-Type: application/json"],
        CURLOPT_POSTFIELDS => json_encode([
            "status" => $status
        ])
    ]);
    curl_exec($ch);
    curl_close($ch);

    $message = "Status pengaduan berhasil diperbarui";
}

/* ================== TAMBAH LOG ================== */
if (isset($_POST['add_log'])) {
    $complaint_id = (int)$_POST['complaint_id'];
    $catatan      = trim($_POST['catatan']);

    $ch = curl_init($apiBase . "?table=complaint_logs");
    curl_setopt_array($ch, [
        CURLOPT_POST => true,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_HTTPHEADER => ["Content-Type: application/json"],
        CURLOPT_POSTFIELDS => json_encode([
            "complaint_id" => $complaint_id,
            "admin_id"     => $admin_id,
            "catatan"      => $catatan
        ])
    ]);
    curl_exec($ch);
    curl_close($ch);

    $message = "Catatan admin berhasil ditambahkan";
}

/* ================== AMBIL DATA COMPLAINTS ================== */
$complaintsJson = @file_get_contents(
    $apiBase . "?table=complaints&order=created_at,desc"
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
<title>Dashboard Admin | Pengaduan Kota Madiun</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
body { background:#f5f7fa; }
.isi-laporan { white-space: normal; }
</style>
</head>

<body>

<nav class="navbar navbar-dark bg-dark shadow">
    <div class="container">
        <span class="navbar-brand fw-bold">Dashboard Admin</span>
        <a href="logout_admin.php" class="btn btn-outline-danger btn-sm">Logout</a>
    </div>
</nav>

<div class="container mt-4">

<?php if ($message): ?>
<div class="alert alert-success text-center">
    <?= htmlspecialchars($message) ?>
</div>
<?php endif; ?>

<?php if (empty($complaints)): ?>
<div class="alert alert-info text-center">
    Belum ada pengaduan
</div>
<?php endif; ?>

<?php foreach ($complaints as $c): ?>

<?php
/* ===== USER ===== */
$userJson = @file_get_contents(
    $apiBase . "?table=users/{$c['user_id']}"
);
$user = json_decode($userJson, true);

/* ===== LOG ===== */
$logsJson = @file_get_contents(
    $apiBase . "?table=complaint_logs&filter=complaint_id,eq,{$c['id']}"
);
$logs = json_decode($logsJson, true);
if (!is_array($logs)) $logs = [];

$statusColor = match ($c['status']) {
    'baru'     => 'secondary',
    'diproses' => 'warning',
    'selesai'  => 'success',
    default    => 'dark'
};
?>

<div class="card shadow mb-4">
    <div class="card-header d-flex justify-content-between align-items-center">
        <strong>#<?= $c['id'] ?> - <?= htmlspecialchars($c['judul']) ?></strong>
        <span class="badge bg-<?= $statusColor ?>">
            <?= strtoupper($c['status']) ?>
        </span>
    </div>

    <div class="card-body">
        <p><b>Email Pengirim:</b> <?= htmlspecialchars($user['email'] ?? '-') ?></p>

        <p class="fw-bold mb-1">Isi Laporan</p>
        <div class="border rounded p-2 mb-3 isi-laporan">
            <?= nl2br(htmlspecialchars($c['isi'])) ?>
        </div>

        <!-- UPDATE STATUS -->
        <form method="post" class="row g-2 mb-3">
            <input type="hidden" name="complaint_id" value="<?= $c['id'] ?>">
            <div class="col-md-4">
                <select name="status" class="form-select form-select-sm">
                    <option value="baru"     <?= $c['status']=='baru'?'selected':'' ?>>Baru</option>
                    <option value="diproses" <?= $c['status']=='diproses'?'selected':'' ?>>Diproses</option>
                    <option value="selesai"  <?= $c['status']=='selesai'?'selected':'' ?>>Selesai</option>
                </select>
            </div>
            <div class="col-md-2">
                <button name="update_status" class="btn btn-primary btn-sm w-100">
                    Update
                </button>
            </div>
        </form>

        <!-- LOG ADMIN -->
        <h6 class="fw-bold">Log Admin</h6>

        <?php if (empty($logs)): ?>
            <p class="text-muted">Belum ada catatan</p>
        <?php else: ?>
            <ul class="list-group mb-3">
                <?php foreach ($logs as $l): 
                    $adminJson = @file_get_contents(
                        $apiBase . "?table=admins/{$l['admin_id']}"
                    );
                    $admin = json_decode($adminJson, true);
                ?>
                <li class="list-group-item">
                    <b><?= htmlspecialchars($admin['username'] ?? 'Admin') ?></b>
                    <small class="text-muted">(<?= $l['tanggal'] ?>)</small><br>
                    <?= htmlspecialchars($l['catatan']) ?>
                </li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>

        <!-- TAMBAH LOG -->
        <form method="post">
            <input type="hidden" name="complaint_id" value="<?= $c['id'] ?>">
            <div class="input-group input-group-sm">
                <input type="text" name="catatan" class="form-control"
                       placeholder="Tambah catatan admin" required>
                <button name="add_log" class="btn btn-success">Kirim</button>
            </div>
        </form>
    </div>
</div>

<?php endforeach; ?>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
