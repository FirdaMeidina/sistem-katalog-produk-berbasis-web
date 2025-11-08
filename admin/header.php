<?php

session_start();
include '../koneksi/koneksi.php';

// Cek apakah user sudah login
if (!isset($_SESSION['username']) || !isset($_SESSION['role'])) {
    header("Location: ../login_form.php");
    exit;
}

// Dapatkan nama file halaman sekarang, misal 'dashboard.php'
$current_page = basename($_SERVER['PHP_SELF']);

// Fungsi pengecekan role
function is_admin() {
    return isset($_SESSION['role']) && $_SESSION['role'] === 'Admin';
}

function is_staf_gudang() {
    return isset($_SESSION['role']) && $_SESSION['role'] === 'Staf Gudang';
}

function is_pemimpin() {
    return isset($_SESSION['role']) && $_SESSION['role'] === 'Pemimpin';
}

function is_marketing() {
    return isset($_SESSION['role']) && $_SESSION['role'] === 'Manager Pemasaran';
}

// Fungsi untuk pengecekan izin CRUD produk
function can_manage_produk() {
    return is_admin() || is_staf_gudang();
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Admin Panel - Batik Bali Lestari</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<!-- Bootstrap -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
<!-- FontAwesome CDN -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
<link rel="stylesheet" href="../css/style.css">
<style>
.navbar-admin {
    background-color: rgb(231, 2, 2);
    border: none;
    border-radius: 0;
    margin-bottom: 0;
    position: relative;
    z-index: 10;
}
.navbar-admin .navbar-brand,
.navbar-admin .nav > li > a {
    color: white !important;
    font-weight: 600;
    transition: background-color 0.3s ease, color 0.3s ease;
}
.navbar-admin .nav > li > a:hover,
.navbar-admin .nav > li > a:focus {
    background-color: rgb(145, 20, 20);
    color: white !important;
    outline: none;
}
.navbar-admin .nav > li.active > a {
    background-color: rgb(216, 143, 143);
    color: white !important;
}
.navbar-admin .navbar-toggle {
    border-color: white;
}
.navbar-admin .navbar-toggle .icon-bar {
    background-color: white;
}
.navbar-admin .navbar-collapse.collapse.in {
    background-color: rgb(231, 2, 2);
    padding: 10px 15px;
    border-radius: 0 0 5px 5px;
    box-shadow: 0 4px 6px rgba(0,0,0,0.1);
}
</style>
</head>
<body>

<nav class="navbar navbar-admin navbar-inverse">
  <div class="container">
    <div class="navbar-header">
      <!-- Hamburger button untuk mobile -->
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#admin-navbar-collapse" aria-expanded="false">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="dashboard.php"><strong>Admin Batik Bali Lestari</strong></a>
    </div>

    <div class="collapse navbar-collapse" id="admin-navbar-collapse">
      <ul class="nav navbar-nav navbar-right">
        <li class="<?= ($current_page == 'dashboard.php') ? 'active' : '' ?>"><a href="dashboard.php">Dashboard</a></li>

        <?php if (can_manage_produk()): ?>
            <li class="<?= ($current_page == 'kelola_produk.php') ? 'active' : '' ?>"><a href="kelola_produk.php">Produk</a></li>
        <?php endif; ?>

        <li class="<?= ($current_page == 'kelola_profil.php') ? 'active' : '' ?>"><a href="kelola_profil.php">Profil</a></li>
        <li class="<?= ($current_page == 'kelola_kontak.php') ? 'active' : '' ?>"><a href="kelola_kontak.php">Kontak</a></li>
        <li><a href="logout.php" onclick="return confirm('Keluar dari Admin?')">Logout</a></li>
      </ul>
    </div>
  </div>
</nav>

<!-- Script jQuery & Bootstrap JS -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</body>
</html>
