<?php 
if (session_status() == PHP_SESSION_NONE) { session_start(); }
include 'koneksi.php';
if(!isset($_SESSION['status']) && basename($_SERVER['PHP_SELF']) != 'login.php'){
    header("location:login.php");
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PIKUCEK! Laundry</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;800&display=swap" rel="stylesheet">
    
  <style>
        body { font-family: 'Poppins', sans-serif; background-color: #f8f9fa; }
        
        /* TEMA BARU: Professional Midnight Blue */
        .navbar {
            /* Gradasi Gelap Elegan */
            background: linear-gradient(90deg, #000428 0%, #004e92 100%); 
            border-bottom-left-radius: 20px;
            border-bottom-right-radius: 20px;
        }
        
        /* Logo Putih agar kontras dengan background gelap */
        .navbar-brand { font-weight: 800; font-size: 24px; font-style: italic; color: #fff !important; }
        
        /* Menu Link Putih Transparan */
        .nav-link { font-weight: 500; color: rgba(255,255,255,0.8) !important; }
        .nav-link:hover { color: #fff !important; }

        .card-dashboard { border: none; border-radius: 15px; transition: transform 0.3s; }
        .card-dashboard:hover { transform: translateY(-5px); }
    </style>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body class="bg-light">

<nav class="navbar navbar-expand-lg navbar-light shadow mb-4 p-3">
  <div class="container">
    <a class="navbar-brand fw-bold fst-italic" href="index.php" style="font-weight: 800; font-size: 24px;">
        <i class="fas fa-soap"></i> PIKUCEK!
    </a>
    
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav ms-auto">
        <li class="nav-item"><a class="nav-link" href="index.php">Dashboard</a></li>
        
        <?php if(isset($_SESSION['role']) && $_SESSION['role'] == 'admin'){ ?>
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">Data Master</a>
            <ul class="dropdown-menu border-0 shadow">
                <li><a class="dropdown-item" href="paket.php">Paket Laundry</a></li>
                <li><a class="dropdown-item" href="outlet.php">Outlet</a></li>
                <li><a class="dropdown-item" href="pelanggan.php">Pelanggan</a></li>
                <li><hr class="dropdown-divider"></li>
                <li><a class="dropdown-item" href="pengguna.php">Pegawai</a></li>
            </ul>
        </li>
        <?php } ?>

        <li class="nav-item"><a class="nav-link" href="transaksi.php">Transaksi</a></li>
        <li class="nav-item"><a class="nav-link" href="laporan.php">Laporan</a></li>
        
        <li class="nav-item ms-3">
            <a class="btn btn-light text-primary fw-bold btn-sm mt-1" href="logout.php">Keluar <i class="fas fa-arrow-right"></i></a>
        </li>
      </ul>
    </div>
  </div>
</nav>
<div class="container pb-5">