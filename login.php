<?php
session_start();

// Jika sudah login, langsung ke index
if (isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit;
}

$error = "";

if (isset($_POST['email'], $_POST['password'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Panggil API
    $apiUrl = "https://pengaduanbymikhael.ct.ws/api.php/records/users?filter=email,eq,$email";
    $response = file_get_contents($apiUrl);
    $data = json_decode($response, true);

    if (!empty($data['records'])) {
        $user = $data['records'][0];

        // CEK PASSWORD (plaintext)
        if ($password === $user['password']) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['nama'];

            header("Location: index.php");
            exit;
        } else {
            $error = "Password salah";
        }
    } else {
        $error = "Email tidak terdaftar";
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Login User | Pengaduan By Mikhael</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background: linear-gradient(135deg, #0d6efd, #6610f2);
            min-height: 100vh;
        }
        .login-card {
            border-radius: 20px;
        }
    </style>
</head>
<body>

<div class="container d-flex justify-content-center align-items-center" style="min-height:100vh;">
    <div class="card login-card shadow-lg p-4 col-md-5">
        <h3 class="text-center fw-bold mb-4">Login User</h3>

        <?php if ($error): ?>
            <div class="alert alert-danger text-center">
                <?= $error ?>
            </div>
        <?php endif; ?>

        <form method="post">
            <div class="mb-3">
                <label class="form-label">Email</label>
                <input type="email" name="email" class="form-control" placeholder="email@example.com" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Password</label>
                <input type="password" name="password" class="form-control" placeholder="Password" required>
            </div>

            <button type="submit" class="btn btn-primary w-100">
                Login
            </button>

            <p class="text-center mt-3">
                Belum punya akun? <a href="daftar.php">Daftar di sini</a>
            </p>
        </form>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
