<?php
include '../koneksi/koneksi.php';
include 'header.php';

// Ambil data produk dari database
$produk = mysqli_query($conn, "SELECT * FROM produk");

// Fungsi cek role untuk hak akses tambah produk (Admin & Staf Gudang)
function canAddProduk() {
    return isset($_SESSION['role']) && ($_SESSION['role'] === 'Admin' || $_SESSION['role'] === 'Staf Gudang');
}

// Fungsi cek role untuk hak akses edit dan hapus produk (Admin saja)
function canEditDeleteProduk() {
    return isset($_SESSION['role']) && ($_SESSION['role'] === 'Admin'|| $_SESSION['role'] === 'Staf Gudang');
}
?>

<div class="container mt-5">
    <div class="card">
        <div class="card-header" style="border-bottom: 3px solid red; display: flex; justify-content: space-between; align-items: center;">
            <h3>Kelola Produk</h3>

            <?php if (canAddProduk()): ?>
                <a href="tambah_produk.php" class="btn btn-primary">
                    <i class="fas fa-plus" style="margin-right: 8px;"></i> Tambah Produk
                </a>
            <?php endif; ?>

        </div>
        <div class="card-body">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Produk</th>
                        <th>Deskripsi</th>
                        <th>Cover</th>
                        <?php if (canEditDeleteProduk()): ?>
                            <th>Aksi</th>
                        <?php endif; ?>
                    </tr>
                </thead>
                <tbody>
                    <?php $no = 1;
                    while ($row = mysqli_fetch_assoc($produk)) { ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td><?= htmlspecialchars($row['nama']) ?></td>
                            <td><?= htmlspecialchars($row['deskripsi']) ?></td>
                            <td>
                                <img src="../gambar/<?= htmlspecialchars($row['cover']) ?>" width="150" class="img-fluid" alt="<?= htmlspecialchars($row['nama']) ?>">
                            </td>

                            <?php if (canEditDeleteProduk()): ?>
                                <td>
                                    <a href="edit_produk.php?id=<?= $row['id'] ?>" class="btn btn-warning btn-sm">
                                        <i class="fas fa-edit"></i> Edit
                                    </a>
                                    <a href="hapus_produk.php?id=<?= $row['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Hapus produk ini?')">
                                        <i class="fas fa-trash"></i> Hapus
                                    </a>
                                </td>
                            <?php endif; ?>

                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>
