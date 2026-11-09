<?php
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}
if (!isset($_SESSION['id'])) { header("Location: login.php"); exit; }
require_once __DIR__ . "/koneksi.php";
$halaman = basename($_SERVER['PHP_SELF']);
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?= htmlspecialchars($judul ?? 'Data Kendaraan', ENT_QUOTES, 'UTF-8') ?> | Rental Kendaraan</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
  <style>
    body { background-color: #f5f7fb; }
    .navbar-brand { letter-spacing: .2px; }
    .page-heading { color: #172b4d; }
    .card { border: 0; border-radius: .85rem; }
    .table > :not(caption) > * > * { padding: .9rem 1rem; }
  </style>
</head>
<body class="d-flex flex-column min-vh-100 bg-light">

<nav class="navbar navbar-expand-lg navbar-dark bg-primary shadow-sm">
  <div class="container">
    <a class="navbar-brand" href="dashboard.php">
      <i class="bi bi-car-front-fill me-2"></i>Rental Kendaraan
    </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#menu"
            aria-controls="menu" aria-expanded="false" aria-label="Buka navigasi">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="menu">
      <ul class="navbar-nav me-auto">
        <li class="nav-item">
          <a class="nav-link <?= $halaman == 'dashboard.php' ? 'active' : '' ?>" href="dashboard.php">
            <i class="bi bi-speedometer2 me-1"></i>Dashboard
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link <?= $halaman == 'kendaraan.php' ? 'active' : '' ?>" href="kendaraan.php">
            <i class="bi bi-grid me-1"></i>Data Kendaraan
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link <?= $halaman == 'tambah.php' ? 'active' : '' ?>" href="tambah.php">
            <i class="bi bi-plus-circle me-1"></i>Tambah Data
          </a>
        </li>
      </ul>
      <span class="navbar-text text-white me-lg-3">
        <i class="bi bi-person-circle"></i>
        <?= htmlspecialchars($_SESSION['nama'], ENT_QUOTES, 'UTF-8') ?>
        <span class="d-lg-none"> &middot; <?= htmlspecialchars($_SESSION['email'], ENT_QUOTES, 'UTF-8') ?></span>
      </span>
      <a href="logout.php" class="btn btn-sm btn-outline-light mt-2 mt-lg-0">
        <i class="bi bi-box-arrow-right me-1"></i>Keluar
      </a>
    </div>
  </div>
</nav>

<main class="container py-4 py-lg-5 flex-grow-1">