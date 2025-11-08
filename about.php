<?php 
include 'header.php';
include 'koneksi/koneksi.php';

// Ambil data profil perusahaan
$id = 1;
$stmt = $conn->prepare("SELECT * FROM profil_perusahaan WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$data = $result->fetch_assoc();
$stmt->close();

// Cek gambar
$upload_url = '/BatikBaliLestari/image/';
$upload_dir = realpath(__DIR__ . '/image') . '/';
$gambar_exists = !empty($data['gambar']) && file_exists($upload_dir . $data['gambar']);

// Galeri
$galeri = $conn->query("SELECT * FROM galeri_profil ORDER BY uploaded_at ASC");
?>

<style>
    @keyframes fadeIn {
        0% { opacity: 0; transform: translateY(20px); }
        100% { opacity: 1; transform: translateY(0); }
    }

    @keyframes zoomIn {
        0% { opacity: 0; transform: scale(0.9); }
        100% { opacity: 1; transform: scale(1); }
    }

    @keyframes slideUp {
        0% { opacity: 0; transform: translateY(40px); }
        100% { opacity: 1; transform: translateY(0); }
    }

    .section-title {
        font-size: 30px;
        border-left: 6px solid #b30000;
        padding-left: 15px;
        margin-bottom: 20px;
        font-weight: bold;
        color: #b30000;
        animation: slideUp 0.6s ease-in-out;
    }

    .container-about {
        padding-bottom: 100px;
        font-size: 18px;
        line-height: 1.8;
        color: #333;
        animation: fadeIn 0.8s ease-in-out;
    }

    .info-section {
        background-color: #fff9f9;
        border-radius: 10px;
        padding: 25px;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.05);
        margin-bottom: 30px;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        animation: fadeIn 0.8s ease forwards;
    }

    .info-section:hover {
        transform: scale(1.015);
        box-shadow: 0 6px 16px rgba(231, 2, 2, 0.15);
    }

    .info-section h4 {
        font-size: 24px;
        margin-top: 20px;
        color: #d84e6f;
        font-weight: bold;
    }

    .info-section p {
        font-size: 17px;
        color: #444;
    }

    .galeri-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 15px;
        margin-top: 10px;
    }

    @media (max-width: 768px) {
        .galeri-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    .galeri-grid img {
        width: 100%;
        border-radius: 8px;
        border: 1px solid #ddd;
        box-shadow: 0 2px 6px rgba(241, 95, 127, 0.2);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        cursor: pointer;
        animation: zoomIn 0.6s ease-in-out;
    }

    .galeri-grid img:hover {
        transform: scale(1.05);
        box-shadow: 0 4px 12px rgba(241, 95, 127, 0.6);
    }

    .btn-produk {
        background-color: #d84e6f;
        border: none;
        font-size: 20px;
        padding: 14px 36px;
        font-weight: 600;
        border-radius: 10px;
        transition: 0.3s ease;
        color: #fff;
        animation: fadeIn 0.7s ease-in-out;
    }

    .btn-produk:hover {
        background-color: #b30000;
        transform: scale(1.05);
    }

    .img-fluid.rounded {
        border: 3px solid #d84e6f;
        max-width: 100%;
        max-height: 300px;
        animation: zoomIn 0.6s ease-in-out;
    }

    @media (max-width: 768px) {
        .section-title {
            font-size: 24px;
        }

        .info-section h4 {
            font-size: 20px;
        }

        .container-about {
            font-size: 16px;
        }
    }
</style>


<div class="container container-about">
    <h2 class="section-title"> <?= htmlspecialchars($data['judul'] ?? 'Profil Perusahaan') ?></h2>

    <?php if ($gambar_exists): ?>
        <div class="text-center mb-4">
            <img src="<?= $upload_url . htmlspecialchars($data['gambar']) ?>" class="img-fluid rounded" alt="Foto Perusahaan">
        </div>
    <?php endif; ?>

    <div class="info-section">
        <p><?= nl2br(htmlspecialchars($data['isi'] ?? '')) ?></p>
    </div>

    <div class="info-section">
        <h4><i class="fas fa-bullseye"></i> Visi</h4>
        <p><?= nl2br(htmlspecialchars($data['visi'] ?? '')) ?></p>
    </div>

    <div class="info-section">
        <h4><i class="fas fa-flag-checkered"></i> Misi</h4>
        <p><?= nl2br(htmlspecialchars($data['misi'] ?? '')) ?></p>
    </div>

    <div class="info-section">
        <h4><i class="fas fa-history"></i> Sejarah Perusahaan</h4>
        <p><?= nl2br(htmlspecialchars($data['sejarah'] ?? '')) ?></p>
    </div>

    <?php if ($galeri->num_rows > 0): ?>
        <h4 class="section-title"><i class="fas fa-images"></i> Galeri Profil</h4>
        <div class="galeri-grid">
            <?php while ($row = $galeri->fetch_assoc()): ?>
                <img src="<?= $upload_url . htmlspecialchars($row['nama_file']) ?>" alt="Galeri" loading="lazy" />
            <?php endwhile; ?>
        </div>
    <?php endif; ?>

   <div class="text-center" style="margin-top: 60px; margin-bottom: 80px;">
    <a href="produk.php" class="btn btn-danger btn-lg btn-produk"><i class="fas fa-shopping-bag"></i> Lihat Produk Kami</a>
</div>

</div>

<?php include 'footer.php'; ?>
