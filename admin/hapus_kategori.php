<?php
session_start();
include '../koneksi/koneksi.php';

// Cek apakah user sudah login dan memiliki role yang sesuai
if (!isset($_SESSION['role']) || !in_array($_SESSION['role'], ['Admin', 'Staf Gudang'])) {
    echo "<script>alert('Akses ditolak!'); window.location.href='kelola_kategori.php';</script>";
    exit;
}

// Pastikan ada ID kategori yang dikirim
if (isset($_GET['id'])) {
    $id = intval($_GET['id']);

    // Query untuk hapus
    $query = "DELETE FROM kategori WHERE id = $id";
    if (mysqli_query($conn, $query)) {
        echo "<script>alert('Kategori berhasil dihapus'); window.location.href='kelola_kategori.php';</script>";
    } else {
        echo "<script>alert('Gagal menghapus kategori'); window.location.href='kelola_kategori.php';</script>";
    }
} else {
    echo "<script>alert('ID kategori tidak ditemukan'); window.location.href='kelola_kategori.php';</script>";
}
?>
