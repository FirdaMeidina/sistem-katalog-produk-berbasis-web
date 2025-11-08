<?php
include 'header.php';

$id = $_GET['id'] ?? null;
if (!$id) {
    header('Location: kelola_admin.php');
    exit;
}

$query = mysqli_query($conn, "SELECT * FROM admin WHERE id='$id'");
$admin = mysqli_fetch_assoc($query);

if (!$admin) {
    header('Location: kelola_admin.php');
    exit;
}

$error = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username     = mysqli_real_escape_string($conn, $_POST['username'] ?? '');
    $nama_lengkap = mysqli_real_escape_string($conn, $_POST['nama_lengkap'] ?? '');
    $email        = mysqli_real_escape_string($conn, $_POST['email'] ?? '');

    if (empty($username) || empty($nama_lengkap) || empty($email)) {
        $error = "Semua field wajib diisi.";
    } else {
        if (!empty($_POST['password'])) {
            $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
            $update = mysqli_query($conn, "UPDATE admin SET username='$username', nama_lengkap='$nama_lengkap', email='$email', password='$password' WHERE id='$id'");
        } else {
            $update = mysqli_query($conn, "UPDATE admin SET username='$username', nama_lengkap='$nama_lengkap', email='$email' WHERE id='$id'");
        }

        if ($update) {
            header('Location: kelola_admin.php?success=Admin berhasil diupdate');
            exit;
        } else {
            $error = "Gagal mengupdate data admin: " . mysqli_error($conn);
        }
    }
}
?>

<div class="container mt-5">
    <h2>Edit Admin</h2>
    <?php if ($error): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>
    <form method="POST" action="">
        <div class="mb-3">
            <label for="username" class="form-label">Username</label>
            <input
                type="text"
                class="form-control"
                id="username"
                name="username"
                value="<?= htmlspecialchars($admin['username'] ?? '') ?>"
                required>
        </div>
        <div class="mb-3">
            <label for="nama_lengkap" class="form-label">Nama Lengkap</label>
            <input
                type="text"
                class="form-control"
                id="nama_lengkap"
                name="nama_lengkap"
                value="<?= htmlspecialchars($admin['nama_lengkap'] ?? '') ?>"
                required>
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input
                type="email"
                class="form-control"
                id="email"
                name="email"
                value="<?= htmlspecialchars($admin['email'] ?? '') ?>"
                required>
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Password (kosongkan jika tidak ingin diubah)</label>
            <input
                type="password"
                class="form-control"
                id="password"
                name="password"
                placeholder="Isi jika ingin ganti password">
        </div>
        <button type="submit" class="btn btn-primary">Update</button>
        <a href="kelola_admin.php" class="btn btn-secondary">Batal</a>
    </form>
</div>

<?php
include 'footer.php';
?>
