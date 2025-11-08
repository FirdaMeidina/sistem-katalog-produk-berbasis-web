<?php 
include 'header.php';
include 'koneksi/koneksi.php';

// Ambil data kontak
$query = mysqli_query($conn, "SELECT * FROM kontak WHERE id = 1 LIMIT 1");
if (!$query) {
    die('Query error: ' . mysqli_error($conn));
}
$kontak = mysqli_fetch_assoc($query);

// Nilai default jika kosong
if (!$kontak) {
    $kontak = [
        'alamat' => 'Alamat belum tersedia.',
        'email' => 'Email belum tersedia.',
        'telepon' => 'Telepon belum tersedia.',
        'maps_embed' => '',
        'gambar' => ''
    ];
}

// Fungsi untuk filter iframe
function sanitize_maps_embed($html) {
    return strip_tags($html, '<iframe><src><width><height><style><allowfullscreen><frameborder><loading><referrerpolicy>');
}
?>

<style>
    .kontak-title {
        font-size: 30px;
        font-weight: bold;
        color: #b30000;
        border-left: 6px solid #b30000;
        padding-left: 15px;
        margin-bottom: 25px;
        animation: fadeInDown 0.8s ease;
    }

    .kontak-wrapper {
        padding-bottom: 100px;
        font-size: 18px;
        line-height: 1.7;
        color: #333;
        animation: fadeIn 1s ease-in;
    }

    .kontak-card {
        background-color: #fff;
        border: 2px solid #f15f7f;
        border-radius: 10px;
        padding: 20px;
        margin-bottom: 25px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .kontak-card:hover {
        transform: scale(1.02);
        box-shadow: 0 6px 16px rgba(0, 0, 0, 0.1);
    }

    .kontak-icon {
        color: #d84e6f;
        margin-right: 10px;
    }

    .kontak-image {
        max-width: 100%;
        height: auto;
        border-radius: 10px;
        border: 3px solid #f15f7f;
        margin-top: 15px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        transition: transform 0.3s ease;
    }

    .kontak-image:hover {
        transform: scale(1.03);
    }

    .maps-embed {
        border-radius: 10px;
        overflow: hidden;
        box-shadow: 0 2px 10px rgba(0,0,0,0.15);
        margin-top: 10px;
    }

    @media (max-width: 768px) {
        .kontak-title {
            font-size: 24px;
        }

        .kontak-wrapper {
            font-size: 16px;
        }
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }

    @keyframes fadeInDown {
        from { opacity: 0; transform: translateY(-30px); }
        to { opacity: 1; transform: translateY(0); }
    }
</style>

<div class="container kontak-wrapper">
    <h2 class="kontak-title"><i class="fas fa-address-book"></i> Kontak Kami</h2>

    <div class="row">
        <div class="col-md-6">
            <div class="kontak-card">
                <p><i class="fas fa-map-marker-alt kontak-icon"></i><strong>Alamat:</strong><br><?= nl2br(htmlspecialchars($kontak['alamat'])); ?></p>
                <p><i class="fas fa-envelope kontak-icon"></i><strong>Email:</strong><br><?= htmlspecialchars($kontak['email']); ?></p>
                <p><i class="fas fa-phone kontak-icon"></i><strong>Telepon:</strong><br><?= htmlspecialchars($kontak['telepon']); ?></p>

                <?php if (!empty($kontak['gambar'])): ?>
                    <img src="admin/uploads/<?= htmlspecialchars($kontak['gambar']); ?>" alt="Gambar Perusahaan" class="kontak-image">
                <?php endif; ?>
            </div>
        </div>

        <div class="col-md-6">
            <div class="kontak-card">
                <p><i class="fas fa-map kontak-icon"></i><strong>Lokasi Kami:</strong></p>
                <div class="maps-embed">
                    <?= $kontak['maps_embed'] ? sanitize_maps_embed($kontak['maps_embed']) : '<em>Embed Google Maps belum tersedia.</em>'; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>
