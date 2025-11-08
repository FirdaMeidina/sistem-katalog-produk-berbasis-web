<?php
include 'header.php';

// Fungsi akses
function canManageKategori() {
    return isset($_SESSION['role']) && ($_SESSION['role'] === 'Admin' || $_SESSION['role'] === 'Staf Gudang');
}

// Ambil data kategori
$query = "SELECT * FROM kategori ORDER BY nama_kategori ASC";
$result = mysqli_query($conn, $query);
?>

<div class="container mt-5">
    <h2>Kelola Kategori</h2>

    <?php if (canManageKategori()): ?>
        <a href="tambah_kategori.php" class="btn btn-success mb-3">+ Tambah Kategori</a>
    <?php endif; ?>

    <?php if (mysqli_num_rows($result) > 0): ?>
        <table class="table table-bordered table-striped">
            <thead class="thead-dark">
                <tr>
                    <th>ID</th>
                    <th>Nama Kategori</th>
                    <?php if (canManageKategori()): ?>
                        <th>Aksi</th>
                    <?php endif; ?>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = mysqli_fetch_assoc($result)): ?>
                    <tr>
                        <td><?= htmlspecialchars($row['id']) ?></td>
                        <td><?= htmlspecialchars($row['nama_kategori']) ?></td>
                        <?php if (canManageKategori()): ?>
                        <td>
                            <a href="edit_kategori.php?id=<?= $row['id'] ?>" class="btn btn-warning btn-sm">Edit</a>
                            <a href="hapus_kategori.php?id=<?= $row['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin hapus kategori ini?')">Hapus</a>
                        </td>
                        <?php endif; ?>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p class="text-muted">Belum ada data kategori.</p>
    <?php endif; ?>
</div>

<?php include 'footer.php'; ?>
