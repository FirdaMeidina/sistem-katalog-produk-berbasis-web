<?php
session_start();
include '../koneksi/koneksi.php';

// Cek role
if (!isset($_SESSION['role']) || ($_SESSION['role'] !== 'Admin' && $_SESSION['role'] !== 'Staf Gudang')) {
    echo "<script>alert('Akses ditolak! Halaman ini hanya untuk Admin dan Staf Gudang.'); window.location.href='dashboard.php';</script>";
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Tambah Kategori</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>

<body>
    <div class="container mt-5">
        <h3>Tambah Kategori Batik</h3>
        <form method="POST" action="proses_tambah_kategori.php" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="nama_kategori" class="form-label">Nama Kategori</label>
                <input type="text" name="nama_kategori" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="deskripsi" class="form-label">Deskripsi</label>
                <textarea name="deskripsi" class="form-control"></textarea>
            </div>
            <div class="mb-3">
                <label for="gambar" class="form-label">Upload Gambar</label>
                <input type="file" name="gambar" class="form-control" accept="image/*">
            </div>
            <button type="submit" class="btn btn-primary">Simpan</button>
            <a href="kelola_kategori.php" class="btn btn-secondary">Kembali</a>
        </form>
    </div>
</body>
</html>
