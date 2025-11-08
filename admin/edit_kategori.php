<?php
session_start();
include '../koneksi/koneksi.php';

// Cek role
if (!isset($_SESSION['role']) || ($_SESSION['role'] !== 'Admin' && $_SESSION['role'] !== 'Staf Gudang')) {
    echo "<script>alert('Anda tidak memiliki akses!'); window.location='kelola_kategori.php';</script>";
    exit;
}

// Ambil ID kategori dari URL
if (!isset($_GET['id'])) {
    echo "<script>alert('ID tidak ditemukan'); window.location='kelola_kategori.php';</script>";
    exit;
}

$id = intval($_GET['id']);
$query = "SELECT * FROM kategori WHERE id = $id";
$result = mysqli_query($conn, $query);

if (!$result || mysqli_num_rows($result) === 0) {
    echo "<script>alert('Data tidak ditemukan'); window.location='kelola_kategori.php';</script>";
    exit;
}

$data = mysqli_fetch_assoc($result);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Kategori</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-5">
    <h3>Edit Kategori</h3>
    <form method="POST" action="proses_edit_kategori.php" enctype="multipart/form-data">
        <input type="hidden" name="id" value="<?= $data['id'] ?>">

        <div class="mb-3">
            <label for="nama_kategori" class="form-label">Nama Kategori</label>
            <input type="text" name="nama_kategori" class="form-control" value="<?= htmlspecialchars($data['nama_kategori']) ?>" required>
        </div>

        <div class="mb-3">
            <label for="deskripsi" class="form-label">Deskripsi</label>
            <textarea name="deskripsi" class="form-control"><?= htmlspecialchars($data['deskripsi']) ?></textarea>
        </div>

        <div class="mb-3">
            <label>Gambar Saat Ini</label><br>
            <?php if (!empty($data['gambar'])): ?>
                <img src="../gambar/<?= htmlspecialchars($data['gambar']) ?>" width="150"><br><br>
            <?php endif; ?>
            <label for="gambar" class="form-label">Ganti Gambar (opsional)</label>
            <input type="file" name="gambar" class="form-control" accept="image/*">
        </div>

        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
        <a href="kelola_kategori.php" class="btn btn-secondary">Kembali</a>
    </form>
</div>
</body>
</html>
