<?php
session_start();
include '../koneksi/koneksi.php';

// Cek role: hanya Admin & Staf Gudang yang boleh
if (!isset($_SESSION['role']) || ($_SESSION['role'] !== 'Admin' && $_SESSION['role'] !== 'Staf Gudang')) {
    echo "<script>alert('Akses ditolak!'); window.location='kelola_kategori.php';</script>";
    exit;
}

// Proses jika form dikirim via POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id             = intval($_POST['id']);
    $nama_kategori  = mysqli_real_escape_string($conn, $_POST['nama_kategori']);
    $deskripsi      = mysqli_real_escape_string($conn, $_POST['deskripsi']);

    // Ambil data lama
    $query = mysqli_query($conn, "SELECT * FROM kategori WHERE id = $id");
    $data_lama = mysqli_fetch_assoc($query);
    $gambar_lama = $data_lama['gambar'];

    // Cek jika ada upload gambar baru
    if (isset($_FILES['gambar']) && $_FILES['gambar']['error'] === UPLOAD_ERR_OK) {
        $nama_file = $_FILES['gambar']['name'];
        $tmp_file  = $_FILES['gambar']['tmp_name'];
        $ext       = pathinfo($nama_file, PATHINFO_EXTENSION);
        $nama_baru = time() . '_' . uniqid() . '.' . $ext;

        $tujuan_upload = "../gambar/" . $nama_baru;

        if (move_uploaded_file($tmp_file, $tujuan_upload)) {
            // Hapus gambar lama jika ada
            if (!empty($gambar_lama) && file_exists("../gambar/" . $gambar_lama)) {
                unlink("../gambar/" . $gambar_lama);
            }

            $gambar_disimpan = $nama_baru;
        } else {
            echo "<script>alert('Gagal upload gambar!'); window.history.back();</script>";
            exit;
        }
    } else {
        // Jika tidak upload gambar baru
        $gambar_disimpan = $gambar_lama;
    }

    // Update ke database
    $update = "UPDATE kategori SET 
                nama_kategori = '$nama_kategori', 
                deskripsi = '$deskripsi', 
                gambar = '$gambar_disimpan' 
               WHERE id = $id";

    if (mysqli_query($conn, $update)) {
        echo "<script>alert('Kategori berhasil diperbarui!'); window.location='kelola_kategori.php';</script>";
    } else {
        echo "<script>alert('Gagal memperbarui kategori!'); window.history.back();</script>";
    }
} else {
    // Akses langsung dilarang
    echo "<script>window.location='kelola_kategori.php';</script>";
    exit;
}
?>
