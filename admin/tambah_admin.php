<?php
include 'header.php';

$error = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username     = mysqli_real_escape_string($conn, $_POST['username'] ?? '');
    $nama_lengkap = mysqli_real_escape_string($conn, $_POST['nama_lengkap'] ?? '');
    $email        = mysqli_real_escape_string($conn, $_POST['email'] ?? '');
    $password_raw = $_POST['password'] ?? '';
    $role         = mysqli_real_escape_string($conn, $_POST['role'] ?? '');

    // Validasi input wajib diisi
    if (empty($username) || empty($nama_lengkap) || empty($email) || empty($password_raw) || empty($role)) {
        $error = "Semua field wajib diisi.";
    } else {
        // Cek username sudah ada atau belum
        $cek = mysqli_query($conn, "SELECT * FROM admin WHERE username='$username'");
        if (mysqli_num_rows($cek) > 0) {
            $error = "Username sudah digunakan!";
        } else {
            // Hash password
            $password = password_hash($password_raw, PASSWORD_DEFAULT);

            // Insert ke database
            $insert = mysqli_query($conn, "INSERT INTO admin (username, nama_lengkap, email, password, role) VALUES ('$username', '$nama_lengkap', '$email', '$password', '$role')");

            if ($insert) {
                header('Location: kelola_admin.php?success=Admin berhasil ditambahkan');
                exit;
            } else {
                $error = "Gagal menambahkan admin: " . mysqli_error($conn);
            }
        }
    }
}
?>

<div class="container mt-5">
    <h2>Tambah Admin Baru</h2>
    <?php if ($error): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>
    <form method="POST" action="">
        <div class="mb-3">
            <label for="username" class="form-label">Username</label>
            <input type="text" class="form-control" id="username" name="username" value="<?= isset($_POST['username']) ? htmlspecialchars($_POST['username']) : '' ?>" required>
        </div>
        <div class="mb-3">
            <label for="nama_lengkap" class="form-label">Nama Lengkap</label>
            <input type="text" class="form-control" id="nama_lengkap" name="nama_lengkap" value="<?= isset($_POST['nama_lengkap']) ? htmlspecialchars($_POST['nama_lengkap']) : '' ?>" required>
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" id="email" name="email" value="<?= isset($_POST['email']) ? htmlspecialchars($_POST['email']) : '' ?>" required>
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input type="password" class="form-control" id="password" name="password" required>
        </div>
        <div class="mb-3">
            <label for="role" class="form-label">Role</label>
            <select class="form-control" id="role" name="role" required>
                <option value="">-- Pilih Role --</option>
                <option value="Admin" <?= (isset($_POST['role']) && $_POST['role'] == 'Admin') ? 'selected' : '' ?>>Admin (Full Akses)</option>
                <option value="Pemimpin Perusahaan" <?= (isset($_POST['role']) && $_POST['role'] == 'Pemimpin Perusahaan') ? 'selected' : '' ?>>Pemimpin Perusahaan</option>
                <option value="Staf Gudang" <?= (isset($_POST['role']) && $_POST['role'] == 'Staf Gudang') ? 'selected' : '' ?>>Staf Gudang</option>
                <option value="Manager Pemasaran" <?= (isset($_POST['role']) && $_POST['role'] == 'Manager Pemasaran') ? 'selected' : '' ?>>Manager Pemasaran</option>
                <option value="Viewer" <?= (isset($_POST['role']) && $_POST['role'] == 'Viewer') ? 'selected' : '' ?>>Viewer (Hanya Lihat)</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Simpan</button>
        <a href="kelola_admin.php" class="btn btn-secondary">Batal</a>
    </form>
</div>

<?php
include 'footer.php';
?>
