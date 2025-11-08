<?php

include 'header.php';
include '../koneksi/koneksi.php';


if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'Admin') {
    echo "<script>alert('Akses ditolak! Hanya Admin yang dapat mengakses halaman ini.'); window.location.href='dashboard.php';</script>";
    exit;
}


$id = 1;
$upload_dir = realpath(__DIR__ . '/../image') . '/';
$upload_url = '/BatikBaliLestari/image/';

// Ambil data profil perusahaan
$stmt = $conn->prepare("SELECT * FROM profil_perusahaan WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$data = $result->fetch_assoc();
$stmt->close();

if (!$data) {
    $data = ['judul' => '', 'isi' => '', 'gambar' => '', 'visi' => '', 'misi' => '', 'sejarah' => ''];
}

// Proses penyimpanan
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $judul   = trim($_POST['judul']);
    $isi     = trim($_POST['isi']);
    $visi    = trim($_POST['visi']);
    $misi    = trim($_POST['misi']);
    $sejarah = trim($_POST['sejarah']);
    $gambar_lama = $data['gambar'];
    $gambar = $gambar_lama;

    // Upload gambar profil utama
    if (isset($_FILES['gambar']) && $_FILES['gambar']['error'] === UPLOAD_ERR_OK) {
        $tmp = $_FILES['gambar']['tmp_name'];
        $ext = strtolower(pathinfo($_FILES['gambar']['name'], PATHINFO_EXTENSION));
        $allowed = ['jpg', 'jpeg', 'png', 'gif'];

        if (in_array($ext, $allowed) && $_FILES['gambar']['size'] <= 2 * 1024 * 1024) {
            $filename = 'profil_' . time() . '.' . $ext;
            $destination = $upload_dir . $filename;
            if (move_uploaded_file($tmp, $destination)) {
                if (!empty($gambar_lama) && file_exists($upload_dir . $gambar_lama)) {
                    unlink($upload_dir . $gambar_lama);
                }
                $gambar = $filename;
            }
        }
    }

    // Upload galeri (multi)
    if (isset($_FILES['galeri']['name'])) {
        foreach ($_FILES['galeri']['name'] as $key => $val) {
            $tmp_name = $_FILES['galeri']['tmp_name'][$key];
            $ext = strtolower(pathinfo($val, PATHINFO_EXTENSION));
            if (in_array($ext, ['jpg', 'jpeg', 'png']) && $_FILES['galeri']['size'][$key] <= 2 * 1024 * 1024) {
                $newname = 'galeri_' . time() . '_' . rand(100, 999) . '.' . $ext;
                if (move_uploaded_file($tmp_name, $upload_dir . $newname)) {
                    $conn->query("INSERT INTO galeri_profil (nama_file) VALUES ('$newname')");
                }
            }
        }
    }

    // Simpan ke database
    $stmt = $conn->prepare("UPDATE profil_perusahaan SET judul = ?, isi = ?, gambar = ?, visi = ?, misi = ?, sejarah = ? WHERE id = ?");
    $stmt->bind_param("ssssssi", $judul, $isi, $gambar, $visi, $misi, $sejarah, $id);

    if ($stmt->execute()) {
        $stmt->close();
        header("Location: kelola_profil.php?status=sukses");
        exit;
    } else {
        echo "<div class='alert alert-danger'>Gagal menyimpan: " . htmlspecialchars($stmt->error) . "</div>";
        $stmt->close();
    }
}

// Ambil galeri
$galeri = $conn->query("SELECT * FROM galeri_profil ORDER BY uploaded_at DESC");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Kelola Profil Perusahaan</title>
    <style>
        body {
            font-family: sans-serif;
            background: #f4f4f4;
            padding: 20px;
            margin: 0;
        }

        .profil-wrapper {
            background: #fff;
            padding: 30px;
            margin: 20px;
            border-radius: 12px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
        }

        h2 {
            margin-bottom: 10px;
            color: #333;
            position: relative;
            padding-bottom: 10px;
        }

        h2::after {
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

        textarea,
        input[type="text"],
        input[type="file"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 6px;
            margin-top: 5px;
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

        .preview-image {
            margin: 10px 5px;
            max-height: 120px;
            border: 1px solid #ddd;
            border-radius: 6px;
        }

        .status-msg {
            color: green;
            margin-bottom: 15px;
        }
    </style>
</head>
<body>
<div class="profil-wrapper">
    <h2>Kelola Profil Perusahaan</h2>

    <?php if (isset($_GET['status']) && $_GET['status'] === 'sukses'): ?>
        <p class="status-msg">✔ Data berhasil disimpan!</p>
    <?php endif; ?>

    <form method="POST" enctype="multipart/form-data">
        <label>Judul Profil</label>
        <input type="text" name="judul" value="<?= htmlspecialchars($data['judul']) ?>" required>

        <label>Deskripsi Singkat</label>
        <textarea name="isi" rows="4"><?= htmlspecialchars($data['isi']) ?></textarea>

        <label>Visi</label>
        <textarea name="visi" rows="3"><?= htmlspecialchars($data['visi']) ?></textarea>

        <label>Misi</label>
        <textarea name="misi" rows="3"><?= htmlspecialchars($data['misi']) ?></textarea>

        <label>Sejarah Perusahaan</label>
        <textarea name="sejarah" rows="5"><?= htmlspecialchars($data['sejarah']) ?></textarea>

        <label>Gambar Profil Utama</label>
        <?php if (!empty($data['gambar']) && file_exists($upload_dir . $data['gambar'])): ?>
            <img class="preview-image" src="<?= $upload_url . $data['gambar'] ?>" alt="Gambar">
        <?php endif; ?>
        <input type="file" name="gambar" accept="image/*">

        <label>Galeri (bisa lebih dari 1)</label>
        <input type="file" name="galeri[]" multiple accept="image/*">

        <button type="submit">Simpan</button>
    </form>

    <?php if ($galeri && $galeri->num_rows > 0): ?>
        <h4 style="margin-top: 30px;">Galeri Terunggah:</h4>
        <?php while ($row = $galeri->fetch_assoc()): ?>
            <img src="<?= $upload_url . $row['nama_file'] ?>" class="preview-image" alt="Galeri">
        <?php endwhile; ?>
    <?php endif; ?>
</div>
</body>
<?php include 'footer.php'; ?>
</html>
