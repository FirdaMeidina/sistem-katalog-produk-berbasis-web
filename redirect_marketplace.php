<?php
include 'koneksi/koneksi.php';

$produk_id   = intval($_GET['produk_id'] ?? 0);
$marketplace = $_GET['marketplace'] ?? '';
$url         = $_GET['url'] ?? '';

$allowed = ['shopee', 'tokopedia', 'lazada'];

if ($produk_id > 0 && in_array($marketplace, $allowed) && !empty($url)) {
    $stmt = mysqli_prepare($conn, "INSERT INTO produk_clicks (produk_id, marketplace) VALUES (?, ?)");
    mysqli_stmt_bind_param($stmt, 'is', $produk_id, $marketplace);
    mysqli_stmt_execute($stmt);
}

header("Location: " . $url);
exit;
