<?php
session_start();
include '../koneksi/koneksi.php';

// Cek apakah user sudah login dan memiliki hak akses yang sesuai
if (!isset($_SESSION['role']) || 
    ($_SESSION['role'] !== 'Admin' && $_SESSION['role'] !== 'Staf Gudang')) {
    echo "<script>alert('Anda tidak memiliki akses!'); window.location='kelola_kategori.php';</script>";
    exit;
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nama_kategori = mysqli_real_escape_string($conn, $_POST['nama_kategori']);
    $deskripsi = mysqli_real_escape_string($conn, $_POST['deskripsi']);

    // Proses upload gambar
    $gambar = '';
    if (isset($_FILES['gambar']) && $_FILES['gambar']['error'] === UPLOAD_ERR_OK) {
        $nama_file = $_FILES['gambar']['name'];
        $tmp_file = $_FILES['gambar']['tmp_name'];
        $folder = '../gambar/';
        $gambar = time() . '_' . basename($nama_file);
        move_uploaded_file($tmp_file, $folder . $gambar);
    }

    // Simpan ke database
    $query = "INSERT INTO kategori (nama_kategori, deskripsi, gambar) 
              VALUES ('$nama_kategori', '$deskripsi', '$gambar')";
    
    if (mysqli_query($conn, $query)) {
        echo "<script>alert('Kategori berhasil ditambahkan!'); window.location='kelola_kategori.php';</script>";
    } else {
        echo "<script>alert('Gagal menyimpan kategori: " . mysqli_error($conn) . "'); window.history.back();</script>";
    }
} else {
    header("Location: tambah_kategori.php");
    exit;
}
?>
