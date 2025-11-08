<?php

include '../koneksi/koneksi.php';
include 'header.php';

// Cek apakah user sudah login dan memiliki role Admin
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'Admin') {
    echo "<script>alert('Akses ditolak! Hanya Admin yang dapat mengakses halaman ini.'); window.location.href='dashboard.php';</script>";
    exit;
}


$uploadDir = __DIR__ . '/uploads/';  
$uploadDirRelative = 'uploads/'; 

if (!is_dir($uploadDir)) {
    mkdir($uploadDir, 0755, true);
}

$gambarBaru = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email      = mysqli_real_escape_string($conn, $_POST['email']);
    $telepon    = mysqli_real_escape_string($conn, $_POST['telepon']);
    $alamat     = mysqli_real_escape_string($conn, $_POST['alamat']);
    $maps_embed = mysqli_real_escape_string($conn, $_POST['maps_embed']);

    if (!empty($_FILES['gambar']['name']) && $_FILES['gambar']['error'] === UPLOAD_ERR_OK) {
    
        $allowedExt = ['jpg', 'jpeg', 'png', 'gif'];
        $ext = strtolower(pathinfo($_FILES['gambar']['name'], PATHINFO_EXTENSION));

        if (!in_array($ext, $allowedExt)) {
            die("Format gambar tidak didukung. Hanya jpg, jpeg, png, gif yang diperbolehkan.");
        }

        
        $maxSize = 2 * 1024 * 1024; 
        if ($_FILES['gambar']['size'] > $maxSize) {
            die("Ukuran gambar terlalu besar. Maksimal 2MB.");
        }

        $gambarBaru = uniqid('img_') . '-' . preg_replace('/\s+/', '_', basename($_FILES['gambar']['name']));
        $targetPath = $uploadDir . $gambarBaru;

        if (!move_uploaded_file($_FILES['gambar']['tmp_name'], $targetPath)) {
            die("Upload gambar gagal.");
        }
    }

    $cek = mysqli_query($conn, "SELECT * FROM kontak WHERE id = 1");
    if (mysqli_num_rows($cek) > 0) {
        $row = mysqli_fetch_assoc($cek);
        $gambarLama = $row['gambar'];

        if ($gambarBaru && $gambarLama && file_exists($uploadDir . $gambarLama)) {
            unlink($uploadDir . $gambarLama);
        }

        $gambarFinal = $gambarBaru ?: $gambarLama;

        $sql = "UPDATE kontak SET 
            email = '$email',
            telepon = '$telepon',
            alamat = '$alamat',
            maps_embed = '$maps_embed',
            gambar = '$gambarFinal'
            WHERE id = 1";
        mysqli_query($conn, $sql);

    } else {
    
        $gambarFinal = $gambarBaru ?: '';
        $sql = "INSERT INTO kontak (id, email, telepon, alamat, maps_embed, gambar) 
                VALUES (1, '$email', '$telepon', '$alamat', '$maps_embed', '$gambarFinal')";
        mysqli_query($conn, $sql);
    }

    header("Location: kelola_kontak.php?status=sukses");
    exit;
}

$result = mysqli_query($conn, "SELECT * FROM kontak WHERE id = 1");
$data   = mysqli_fetch_assoc($result);

if (!$data) {
    $data = [
        'email'      => '',
        'telepon'    => '',
        'alamat'     => '',
        'maps_embed' => '',
        'gambar'     => ''
    ];
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Kelola Kontak</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background: #f4f4f4;
            margin: 0;
            padding-top: 100px;
        }

        .kontak-wrapper {
            max-width: 960px;
            margin: 0 auto;  /* center horizontally */
            padding: 30px 20px;
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
        }

        h3 {
            margin-bottom: 10px;
            color: #333;
            position: relative;
            padding-bottom: 10px;
        }

        h3::after {
            content: "";
            display: block;
            width: 100%;
            height: 4px;
            background-color: #dc3545;
            margin-top: 8px;
            border-radius: 2px;
        }

        label {
            font-weight: bold;
            margin-top: 15px;
            display: block;
        }

        input[type="email"],
        input[type="text"],
        textarea,
        input[type="file"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 6px;
            margin-top: 5px;
            box-sizing: border-box;
        }

        button {
            margin-top: 20px;
            background: #dc3545;
            color: white;
            border: none;
            padding: 10px 25px;
            border-radius: 6px;
            cursor: pointer;
            font-size: 15px;
        }

        button:hover {
            background: #bb2d3b;
        }

        .success {
            background: #d1e7dd;
            color: #0f5132;
            padding: 10px;
            margin-bottom: 18px;
            border-radius: 6px;
            text-align: center;
        }

        .gambar-preview {
            text-align: center;
            margin-bottom: 20px;
        }

        .gambar-preview img {
            max-width: 100%;
            height: auto;
            border-radius: 8px;
            box-shadow: 0 2px 6px rgba(0,0,0,0.15);
        }
    </style>
</head>
<body>

    <div class="kontak-wrapper">
        <h3>Kelola Kontak</h3>

        <?php if (isset($_GET['status']) && $_GET['status'] === 'sukses'): ?>
            <div class="success">Data kontak berhasil disimpan.</div>
        <?php endif; ?>

        <?php if (!empty($data['gambar'])): ?>
            <div class="gambar-preview">
                <strong>Gambar Perusahaan Saat Ini:</strong><br>
                <img src="<?= $uploadDirRelative . htmlspecialchars($data['gambar']) ?>" alt="Gambar Perusahaan">
            </div>
        <?php endif; ?>

        <form method="POST" enctype="multipart/form-data">
            <label for="email">Email</label>
            <input type="email" id="email" name="email"
                   value="<?= htmlspecialchars($data['email']) ?>" required>

            <label for="telepon">Telepon</label>
            <input type="text" id="telepon" name="telepon"
                   value="<?= htmlspecialchars($data['telepon']) ?>" required>

            <label for="alamat">Alamat</label>
            <textarea id="alamat" name="alamat" rows="3"><?= htmlspecialchars($data['alamat']) ?></textarea>

            <label for="maps_embed">Google Maps Embed</label>
            <textarea id="maps_embed" name="maps_embed" rows="3"><?= htmlspecialchars($data['maps_embed']) ?></textarea>

            <label for="gambar">Gambar Perusahaan (opsional)</label>
            <input type="file" id="gambar" name="gambar" accept="image/*">

            <button type="submit">Simpan</button>
        </form>
    </div>

</body>
<?php include 'footer.php'; ?>
</html>
