<?php

include '../koneksi/koneksi.php';
include 'header.php';

// Fungsi untuk mengecek apakah user bisa mengelola admin
function canManageAdmin() {
    return isset($_SESSION['role']) && $_SESSION['role'] === 'Admin';
}

// Cek apakah user sudah login dan berperan sebagai Admin
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'Admin') {
    echo "<script>alert('Akses ditolak! Hanya Admin yang dapat mengakses halaman ini.'); window.location.href='dashboard.php';</script>";
    exit;
}

// Ambil semua data admin dari database
$query = "SELECT * FROM admin ORDER BY username ASC";
$result = mysqli_query($conn, $query);
?>

<div class="container mt-5">
    <h2>Kelola Admin</h2>

    <?php if (canManageAdmin()): ?>
        <a href="tambah_admin.php" class="btn btn-success mb-3">+ Tambah Admin</a>
    <?php endif; ?>

    <?php if (mysqli_num_rows($result) > 0): ?>
        <table class="table table-bordered table-striped">
            <thead class="thead-dark">
                <tr>
                    <th>ID</th>
                    <th>Username</th>
                    <th>Nama Lengkap</th>
                    <th>Email</th>
                    <th>Role</th>
                    <?php if (canManageAdmin()): ?>
                        <th>Aksi</th>
                    <?php endif; ?>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = mysqli_fetch_assoc($result)): ?>
                    <tr>
                        <td><?= htmlspecialchars($row['id']) ?></td>
                        <td><?= htmlspecialchars($row['username']) ?></td>
                        <td><?= htmlspecialchars($row['nama_lengkap']) ?></td>
                        <td><?= htmlspecialchars($row['email']) ?></td>
                        <td><?= htmlspecialchars($row['role']) ?></td>
                        <?php if (canManageAdmin()): ?>
                            <td>
                                <a href="edit_admin.php?id=<?= $row['id'] ?>" class="btn btn-warning btn-sm">Edit</a>
                                <a href="hapus_admin.php?id=<?= $row['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin hapus admin ini?')">Hapus</a>
                            </td>
                        <?php endif; ?>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p class="text-muted">Belum ada data admin.</p>
    <?php endif; ?>
</div>

<?php
include 'footer.php';
?>
