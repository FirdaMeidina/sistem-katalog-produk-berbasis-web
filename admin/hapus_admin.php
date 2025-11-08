<?php
include 'header.php';

$id = $_GET['id'] ?? null;
if ($id) {
    // Pastikan tidak menghapus admin utama jika ada logika khusus
    mysqli_query($conn, "DELETE FROM admin WHERE id='$id'");
}

header('Location: kelola_admin.php?success=Admin berhasil dihapus');
exit;
