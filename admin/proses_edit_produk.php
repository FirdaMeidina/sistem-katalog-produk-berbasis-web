<?php
include '../koneksi/koneksi.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id           = intval($_POST['id']);
    $nama         = mysqli_real_escape_string($conn, $_POST['nama']);
    $kategori_id  = intval($_POST['kategori_id']);
    $deskripsi    = mysqli_real_escape_string($conn, $_POST['deskripsi']);
    $link_shopee  = mysqli_real_escape_string($conn, $_POST['link_shopee']);
    $link_tokopedia = mysqli_real_escape_string($conn, $_POST['link_tokopedia']);
    $link_lazada  = mysqli_real_escape_string($conn, $_POST['link_lazada']);

    // Awal SET query
    $setClause = "
        nama = '$nama',
        kategori_id = '$kategori_id',
        deskripsi = '$deskripsi',
        link_shopee = '$link_shopee',
        link_tokopedia = '$link_tokopedia',
        link_lazada = '$link_lazada'
    ";

    // Fungsi upload gambar
    function uploadGambar($fieldName, $targetFolder = "../gambar/")
    {
        if (!empty($_FILES[$fieldName]['name'])) {
            $safeName = time() . '_' . preg_replace('/[^a-zA-Z0-9\._]/', '_', $_FILES[$fieldName]['name']);
            $tmpName = $_FILES[$fieldName]['tmp_name'];
            if (move_uploaded_file($tmpName, $targetFolder . $safeName)) {
                return $safeName;
            }
        }
        return null;
    }

    // Upload cover baru jika diunggah
    $cover = uploadGambar('cover');
    if ($cover) {
        $setClause .= ", cover = '$cover'";
    }

    // Upload image_1 - image_4
    for ($i = 1; $i <= 4; $i++) {
        $field = "image_$i";
        $gambar = uploadGambar($field);
        if ($gambar) {
            $setClause .= ", $field = '$gambar'";
        }
    }

    // Eksekusi update
    $sql = "UPDATE produk SET $setClause WHERE id = $id";
    if (mysqli_query($conn, $sql)) {
        echo "<script>alert('Produk berhasil diupdate!'); window.location='kelola_produk.php';</script>";
    } else {
        echo "Gagal update: " . mysqli_error($conn);
    }
}
?>
