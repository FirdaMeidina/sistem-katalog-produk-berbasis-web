<?php
include 'koneksi.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Validasi koneksi
    if (!$conn) {
        die("Koneksi database gagal: " . mysqli_connect_error());
    }

    // Ambil data dari form
    $kode_produk = mysqli_real_escape_string($conn, $_POST['kode_produk']);
    $nama        = mysqli_real_escape_string($conn, $_POST['nama']);
    $harga       = mysqli_real_escape_string($conn, $_POST['harga']);
    $deskripsi   = mysqli_real_escape_string($conn, $_POST['deskripsi']);
    $kategori    = mysqli_real_escape_string($conn, $_POST['kategori']); // <-- Pastikan ada input kategori
    $tanggal     = date('Y-m-d');

    // Upload Gambar
    $gambar = '';
    if (isset($_FILES['gambar']) && $_FILES['gambar']['error'] == 0) {
        $target_dir = "gambar/";
        if (!file_exists($target_dir)) {
            mkdir($target_dir, 0777, true);
        }

        $gambar = time() . "_" . basename($_FILES["gambar"]["name"]);
        $target_file = $target_dir . $gambar;

        if (!move_uploaded_file($_FILES["gambar"]["tmp_name"], $target_file)) {
            die("Gagal mengunggah gambar.");
        }
    }

    // Query simpan produk
    $query = "INSERT INTO produk (kode_produk, nama, harga, deskripsi, kategori, gambar, tanggal_dibuat) 
              VALUES ('$kode_produk', '$nama', '$harga', '$deskripsi', '$kategori', '$gambar', '$tanggal')";

    if (mysqli_query($conn, $query)) {
        header("Location: produk.php?status=sukses");
        exit;
    } else {
        echo "Gagal menyimpan produk: " . mysqli_error($conn);
    }
} else {
    header("Location: tambah_produk.php");
    exit;
}
?>
