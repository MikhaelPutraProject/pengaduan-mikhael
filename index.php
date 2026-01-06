<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Pengaduan By Mikhael</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #eef2ff, #e0e7ff);
            min-height: 100vh;
        }

        .main-card {
            border: none;
            border-radius: 24px;
            background: rgba(255,255,255,0.95);
            box-shadow: 0 20px 40px rgba(0,0,0,0.1);
        }

        .title {
            font-weight: 600;
            font-size: 1.9rem;
            color: #1f2937;
        }

        .subtitle {
            color: #6b7280;
            font-size: 1rem;
            line-height: 1.6;
        }

        .btn-report {
            background: linear-gradient(135deg, #4f46e5, #6366f1);
            border: none;
            padding: 14px 36px;
            font-size: 1rem;
            font-weight: 500;
            border-radius: 999px;
            transition: all 0.25s ease;
        }

        .btn-report:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(79,70,229,.4);
        }

        .navbar-brand:hover {
            opacity: 0.85;
        }

        /* Mobile */
        @media (max-width: 576px) {
            .main-card {
                margin: 0 10px;
                padding: 2rem 1.5rem !important;
            }

            .title {
                font-size: 1.5rem;
            }

            .btn-report {
                width: 100%;
                padding: 14px;
            }
        }
    </style>
</head>
<body>

<!-- NAVBAR -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow-sm">
    <div class="container">
        <a class="navbar-brand fw-semibold" href="index.php">
            Pengaduan
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
<div class="container d-flex align-items-center justify-content-center" style="min-height:85vh;">
    <div class="card main-card text-center p-5 col-lg-6 col-md-8">
        <h1 class="title mb-3">Laporkan Masalah Anda</h1>

        <p class="subtitle mb-4">
            Sampaikan keluhan mengenai fasilitas umum atau pelayanan masyarakat
            dengan cepat dan mudah.
        </p>

        <a href="report.php" class="btn btn-report text-white shadow-sm">
            Buat Laporan
        </a>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
