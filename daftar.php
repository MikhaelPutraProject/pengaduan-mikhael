<?php
session_start();

// Jika sudah login, langsung ke index
if (isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit;
}

$error = "";
$sukses = "";

if (isset($_POST['nama'], $_POST['email'], $_POST['password'])) {
    $nama = $_POST['nama'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Cek email sudah ada
    $cekUrl = "http://localhost/pengaduan/api.php/records/users?filter=email,eq,$email";
    $cekRes = json_decode(file_get_contents($cekUrl), true);

    if (!empty($cekRes['records'])) {
        $error = "Email sudah terdaftar";
    } else {
        // Simpan user baru
        $postData = json_encode([
            "nama" => $nama,
            "email" => $email,
            "password" => $password
        ]);

        $opts = [
            "http" => [
                "method"  => "POST",
                "header"  => "Content-Type: application/json",
                "content" => $postData
            ]
        ];

        $context = stream_context_create($opts);
        file_get_contents("http://localhost/pengaduan/api.php/records/users", false, $context);

        $sukses = "Pendaftaran berhasil, silakan login";
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Daftar User | Pengaduan Kota Madiun By Mikhael</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background: linear-gradient(135deg, #198754, #20c997);
            min-height: 100vh;
        }
        .card {
            border-radius: 20px;
        }
    </style>
</head>
<body>

<div class="container d-flex justify-content-center align-items-center" style="min-height:100vh;">
    <div class="card shadow-lg p-4 col-md-5">
        <h3 class="text-center fw-bold mb-4">Daftar Akun</h3>

        <?php if ($error): ?>
            <div class="alert alert-danger text-center"><?= $error ?></div>
        <?php endif; ?>

        <?php if ($sukses): ?>
            <div class="alert alert-success text-center">
                <?= $sukses ?><br>
                <a href="login.php">Login sekarang</a>
            </div>
        <?php endif; ?>

        <form method="post">
            <div class="mb-3">
                <label class="form-label">Nama</label>
                <input type="text" name="nama" class="form-control" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Email</label>
                <input type="email" name="email" class="form-control" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Password</label>
                <input type="password" name="password" class="form-control" required>
            </div>

            <button class="btn btn-success w-100">
                Daftar
            </button>
        </form>

        <p class="text-center mt-3">
            Sudah punya akun?
            <a href="login.php">Login</a>
        </p>
    </div>
</div>

</body>
</html>
