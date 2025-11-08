<?php
include '../koneksi/koneksi.php';

$id = intval($_GET['id']); // hindari SQL injection

// Ambil data produk berdasarkan ID
$produk = mysqli_fetch_assoc(mysqli_query($conn, "SELECT cover, image_1, image_2, image_3, image_4 FROM produk WHERE id = $id"));

$folder = "../gambar/";

// Hapus semua gambar jika ada
if ($produk) {
    $gambarFields = ['cover', 'image_1', 'image_2', 'image_3', 'image_4'];

    foreach ($gambarFields as $field) {
        if (!empty($produk[$field])) {
            $filePath = $folder . $produk[$field];
            if (file_exists($filePath)) {
                unlink($filePath); // hapus file dari folder
            }
        }
    }

    // Hapus data dari database
    $deleted = mysqli_query($conn, "DELETE FROM produk WHERE id = $id");

    if ($deleted) {
        echo "<script>
            alert('Produk berhasil dihapus!');
            window.location.href = 'kelola_produk.php';
        </script>";
        exit;
    } else {
        echo "<script>
            alert('Gagal menghapus produk dari database.');
            window.location.href = 'kelola_produk.php';
        </script>";
        exit;
    }
} else {
    echo "<script>
        alert('Produk tidak ditemukan.');
        window.location.href = 'kelola_produk.php';
    </script>";
    exit;
}
