<?php
include '../koneksi/koneksi.php';

if (!isset($_GET['id'])) {
    echo "ID produk tidak ditemukan.";
    exit;
}

$id = intval($_GET['id']);
$query = mysqli_query($conn, "SELECT * FROM produk WHERE id = $id");

if (!$query) {
    echo "Query gagal: " . mysqli_error($conn);
    exit;
}

$produk = mysqli_fetch_assoc($query);

include 'header.php';
?>

<div class="container mt-5">
    <div class="card shadow">
        <div class="card-header bg-primary text-white">
            <h4 class="mb-0">Edit Produk</h4>
        </div>
        <div class="card-body">
            <form method="POST" action="proses_edit_produk.php" enctype="multipart/form-data">
                <input type="hidden" name="id" value="<?= $produk['id'] ?>">

                <div class="mb-3">
                    <label class="form-label">Nama Produk:</label>
                    <input type="text" class="form-control" name="nama" value="<?= $produk['nama'] ?>" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Kategori ID:</label>
                    <input type="text" class="form-control" name="kategori_id" value="<?= $produk['kategori_id'] ?>" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Deskripsi:</label>
                    <textarea class="form-control" name="deskripsi" rows="3" required><?= $produk['deskripsi'] ?></textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label">Cover Saat Ini:</label><br>
                    <img src="../gambar/<?= $produk['cover'] ?>" width="120" class="img-thumbnail mb-2">
                </div>

                <div class="mb-3">
                    <label class="form-label">Cover Baru (Kosongkan jika tidak diubah):</label>
                    <input type="file" class="form-control" name="cover">
                </div>

                <div class="mb-3">
                    <label class="form-label">Image Ke-1 Baru (Kosongkan jika tidak diubah):</label>
                    <input type="file" class="form-control" name="image_1">
                </div>

                <div class="mb-3">
                    <label class="form-label">Image Ke-2 Baru (Kosongkan jika tidak diubah):</label>
                    <input type="file" class="form-control" name="image_2">
                </div>

                <div class="mb-3">
                    <label class="form-label">Image Ke-3 Baru (Kosongkan jika tidak diubah):</label>
                    <input type="file" class="form-control" name="image_3">
                </div>

                <div class="mb-3">
                    <label class="form-label">Image Ke-4 Baru (Kosongkan jika tidak diubah):</label>
                    <input type="file" class="form-control" name="image_4">
                </div>

                <!-- Tambahan input Link Shopee -->
<div class="mb-3">
    <label class="form-label">Link Shopee:</label>
    <input type="text" class="form-control" name="link_shopee" value="<?= htmlspecialchars($produk['link_shopee']) ?>">
</div>

<!-- Tambahan input Link Tokopedia -->
<div class="mb-3">
    <label class="form-label">Link Tokopedia:</label>
    <input type="text" class="form-control" name="link_tokopedia" value="<?= htmlspecialchars($produk['link_tokopedia']) ?>">
</div>

<!-- Tambahan input Link Lazada -->
<div class="mb-3">
    <label class="form-label">Link Lazada:</label>
    <input type="text" class="form-control" name="link_lazada" value="<?= htmlspecialchars($produk['link_lazada']) ?>">
</div>


                <button type="submit" class="btn btn-success">
                    <i class="fas fa-save"></i> Update
                </button>

                <a href="kelola_produk.php" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Kembali
                </a>
            </form>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>