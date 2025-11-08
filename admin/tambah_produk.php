<?php
include '../koneksi/koneksi.php';

$kategori_result = mysqli_query($conn, "SELECT * FROM kategori ORDER BY nama_kategori ASC");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama        = mysqli_real_escape_string($conn, $_POST['nama']);
    $deskripsi   = mysqli_real_escape_string($conn, $_POST['deskripsi']);
    $harga       = intval($_POST['harga']);
    $kategori_id = intval($_POST['kategori']);
    $tanggal     = date('Y-m-d');
    $link_shopee = $_POST['link_shopee'];
    $link_tokopedia = $_POST['link_tokopedia'];
    $link_lazada = $_POST['link_lazada'];

    $folder = "../gambar/";
    if (!is_dir($folder)) {
        mkdir($folder, 0777, true);
    }

    $allowed_ext = ['jpg', 'jpeg', 'png', 'gif'];

    // Fungsi untuk upload file
    function uploadFile($fieldName, $folder, $allowed_ext)
    {
        if (!empty($_FILES[$fieldName]['name'])) {
            $fileName = $_FILES[$fieldName]['name'];
            $tmpName = $_FILES[$fieldName]['tmp_name'];
            $ext = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

            if (in_array($ext, $allowed_ext)) {
                $safeName = time() . '_' . preg_replace('/[^a-zA-Z0-9\._]/', '_', $fileName);
                $targetPath = $folder . $safeName;
                if (move_uploaded_file($tmpName, $targetPath)) {
                    return $safeName;
                }
            }
        }
        return null;
    }

    // Upload cover utama
    $cover = uploadFile('cover', $folder, $allowed_ext);
    if (!$cover) {
        echo "<script>alert('Cover wajib diunggah dan harus berformat gambar.');</script>";
        include 'header.php';
        exit;
    }

    // Upload gambar tambahan jika ada
    $images = [];
    for ($i = 1; $i <= 4; $i++) {
        $images["image_$i"] = uploadFile("image_$i", $folder, $allowed_ext);
    }

    // Simpan ke DB
    $query = "INSERT INTO produk 
    (nama, deskripsi, harga, cover, image_1, image_2, image_3, image_4, kategori_id, tanggal_dibuat, link_shopee,link_tokopedia, link_lazada ) 
    VALUES (
        '$nama',
        '$deskripsi',
        '$harga',
        '$cover'," .
        (!empty($images['image_1']) ? "'{$images['image_1']}'" : "NULL") . "," .
        (!empty($images['image_2']) ? "'{$images['image_2']}'" : "NULL") . "," .
        (!empty($images['image_3']) ? "'{$images['image_3']}'" : "NULL") . "," .
        (!empty($images['image_4']) ? "'{$images['image_4']}'" : "NULL") . "," .
        "'$kategori_id',
        '$tanggal',
        '$link_shopee',
        '$link_tokopedia',
        '$link_lazada'
    )";

    if (mysqli_query($conn, $query)) {
        echo "<script>alert('Produk berhasil ditambahkan!'); window.location.href='kelola_produk.php';</script>";
        exit;
    } else {
        echo "<script>alert('Gagal menyimpan produk: " . mysqli_error($conn) . "');</script>";
    }
}

include 'header.php';
?>


<div class="container mt-5">
    <div class="card">
        <div class="card-header" style="border-bottom: 3px solid red; padding-bottom: 5px;margin-bottom: 15px;">
            <h3>Tambah Produk</h3>
        </div>
        <div class="card-body">
            <form method="POST" enctype="multipart/form-data">
                <div class="form-group mb-3">
                    <label for="nama">Nama Produk</label>
                    <input type="text" name="nama" id="nama" class="form-control" required>
                </div>

                <div class="form-group mb-3">
                    <label for="deskripsi">Deskripsi Produk</label>
                    <textarea name="deskripsi" id="deskripsi" class="form-control" rows="4" required></textarea>
                </div>

                <div class="form-group mb-3">
                    <label for="harga">Harga Produk (Rp)</label>
                    <input type="number" name="harga" id="harga" class="form-control" min="0" step="1000" required>
                </div>

                <div class="form-group mb-3">
                    <label for="kategori">Kategori Produk</label>
                    <select name="kategori" id="kategori" class="form-control" required>
                        <option value="">-- Pilih Kategori --</option>
                        <?php while ($row = mysqli_fetch_assoc($kategori_result)) : ?>
                            <option value="<?= $row['id']; ?>"><?= htmlspecialchars($row['nama_kategori']); ?></option>
                        <?php endwhile; ?>
                    </select>
                </div>

                <div class="form-group mb-4">
                    <label for="cover">Cover Produk</label>
                    <input type="file" name="cover" id="cover" class="form-control-file" accept="image/*" required>
                </div>

                <div class="form-group mb-4">
                    <label for="image_1">Image Ke-1</label>
                    <input type="file" name="image_1" id="image_1" class="form-control-file" accept="image/*">
                </div>

                <div class="form-group mb-4">
                    <label for="image_2">Image Ke-2</label>
                    <input type="file" name="image_2" id="image_2" class="form-control-file" accept="image/*">
                </div>

                <div class="form-group mb-4">
                    <label for="image_3">Image Ke-3</label>
                    <input type="file" name="image_3" id="image_3" class="form-control-file" accept="image/*">
                </div>

                <div class="form-group mb-4">
                    <label for="image_4">Image Ke-4</label>
                    <input type="file" name="image_4" id="image_4" class="form-control-file" accept="image/*">
                </div>

                <div class="form-group mb-3">
                    <label for="link_shopee">Link Shopee</label>
                    <input type="text" name="link_shopee" id="link_shopee" class="form-control" required>
                </div>

                <div class="form-group mb-3">
                    <label for="link_tokopedia">Link Tokopedia</label>
                    <input type="text" name="link_tokopedia" id="link_tokopedia" class="form-control" required>
                </div>

                <div class="form-group mb-3">
                    <label for="link_lazada">Link Lazada</label>
                    <input type="text" name="link_lazada" id="link_lazada" class="form-control" required>
                </div>

                <button type="submit" class="btn btn-success">Tambah Produk</button>
                <a href="kelola_produk.php" class="btn btn-secondary">Kembali</a>
            </form>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>