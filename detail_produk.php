<?php
include 'header.php';
include 'koneksi/koneksi.php';
?>

<style>
    /* CARD UTAMA */
    .detail-card {
        background-color: white;
        border-radius: 12px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        transition: box-shadow 0.3s ease, transform 0.3s ease;
        padding: 20px;
        margin-top: 30px;
        margin-bottom: 60px;
        /* Tambahan jarak dari footer */
    }

    .detail-card:hover {
        box-shadow: 0 0 20px rgba(231, 2, 2, 0.4);
        transform: scale(1.01);
    }

    /* GAMBAR PRODUK */
    .thumbnail {
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        transition: transform 0.3s ease;
    }

    .thumbnail:hover {
        transform: scale(1.03);
    }

    .thumbnail img {
        width: 100%;
        height: auto;
    }

    /* TOMBOL MARKETPLACE */
    .btn-custom {
        transition: all 0.2s ease;
        margin-right: 5px;
        margin-bottom: 5px;
    }

    .btn-custom:hover {
        transform: translateY(-2px) scale(1.05);
    }

    .btn-shopee {
        background-color: #ff5722;
        color: white;
    }

    .btn-shopee:hover {
        background-color: #e64a19;
        color: white;
    }

    .btn-tokopedia {
        background-color: #03ac0e;
        color: white;
    }

    .btn-tokopedia:hover {
        background-color: #028f0c;
        color: white;
    }

    .btn-lazada {
        background-color: #ff0000;
        color: white;
    }

    .btn-lazada:hover {
        background-color: #cc0000;
        color: white;
    }

    .btn-warning:hover {
        transform: translateY(-1px) scale(1.03);
    }

    /* JUDUL */
    .section-title {
        border-bottom: 4px solid rgb(231, 2, 2);
        padding-bottom: 8px;
        margin-bottom: 20px;
        font-weight: bold;
    }

    .swiper-product {
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 6px 20px rgba(0, 0, 0, 0.1);
        position: relative;
    }

    .swiper-slide img {
        width: 100%;
        height: auto;
        object-fit: cover;
        border-radius: 12px;
        transition: transform 0.3s ease;
    }

    .swiper-slide img:hover {
        transform: scale(1.02);
    }

    .swiper-pagination {
        text-align: center;
    }

    .swiper-button-prev,
    .swiper-button-next {
        color: #e60023;
        background-color: rgba(255, 255, 255, 0.9);
        border-radius: 50%;
        width: 36px;
        height: 36px;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.15);
        top: 45%;
    }

    .swiper-button-prev:hover,
    .swiper-button-next:hover {
        background-color: #fff;
        transform: scale(1.1);
    }

    .swiper-button-prev::after,
    .swiper-button-next::after {
        font-size: 18px;
        font-weight: bold;
    }
</style>

<?php
$produkParam = $_GET['produk'] ?? '';

if (empty($produkParam)) {
    echo "<div class='container'><div class='alert alert-danger mt-4'>Produk tidak ditemukan.</div></div>";
    include 'footer.php';
    exit;
}

if (ctype_digit($produkParam)) {
    $id = intval($produkParam);
    $stmt = mysqli_prepare($conn, "SELECT * FROM produk WHERE id = ?");
    mysqli_stmt_bind_param($stmt, 'i', $id);
} else {
    $kode = mysqli_real_escape_string($conn, $produkParam);
    $stmt = mysqli_prepare($conn, "SELECT * FROM produk WHERE kode_produk = ?");
    mysqli_stmt_bind_param($stmt, 's', $kode);
}

mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

if (!$result || mysqli_num_rows($result) === 0) {
    echo "<div class='container'><div class='alert alert-danger mt-4'>Produk tidak ditemukan.</div></div>";
    include 'footer.php';
    exit;
}

$row = mysqli_fetch_assoc($result);
?>

<div class="container" style="padding: 50px 0;">
    <div style="display: flex; justify-content: space-between; align-items: center;">
        <h2 class="section-title">Detail Produk</h2>
        <a href="produk.php" class="btn btn-warning mt-3">← Kembali ke Katalog</a>
    </div>

    <div class="detail-card row">
        <div class="col-md-5">
            <div class="swiper swiper-product position-relative">
                <div class="swiper-wrapper">
                    <?php
                    $gambarUtama = (!empty($row['cover']) && file_exists("gambar/" . $row['cover']))
                        ? "gambar/" . $row['cover']
                        : "gambar/default.jpg";

                    echo '<div class="swiper-slide"><img src="' . $gambarUtama . '" class="img-fluid rounded w-100" /></div>';

                    for ($i = 1; $i <= 4; $i++) {
                        $kolom = 'image_' . $i;
                        if (!empty($row[$kolom]) && file_exists("gambar/" . $row[$kolom])) {
                            echo '<div class="swiper-slide"><img src="gambar/' . htmlspecialchars($row[$kolom]) . '" class="img-fluid rounded w-100" /></div>';
                        }
                    }
                    ?>
                </div>
                <div class="swiper-button-next"></div>
                <div class="swiper-button-prev"></div>
                <div class="swiper-pagination mt-2"></div>
            </div>
        </div>

        <div class="col-md-7">
            <table class="table table-borderless">
                <tr>
                    <td><strong>Nama</strong></td>
                    <td><?= htmlspecialchars($row['nama']); ?></td>
                </tr>
                <tr>
                    <td><strong>Harga</strong></td>
                    <td>
                        <?= !empty($row['harga']) && $row['harga'] > 0
                            ? 'Rp.' . number_format($row['harga'], 3, ',', '.')
                            : '<span class="text-muted">Harga belum tersedia</span>'; ?>
                    </td>
                </tr>
                <tr>
                    <td><strong>Deskripsi</strong></td>
                    <td><?= nl2br(htmlspecialchars($row['deskripsi'])); ?></td>
                </tr>
                <tr>
                    <td><strong>Beli di</strong></td>
                    <td>
                        <?php
                        $id = $row['id'];
                        $hasLinks = false;
                        if (!empty($row['link_shopee'])) {
                            $hasLinks = true;
                            echo '<a href="redirect_marketplace.php?produk_id=' . $id . '&marketplace=shopee&url=' . urlencode($row['link_shopee']) . '" class="btn btn-sm btn-shopee btn-custom" target="_blank">Shopee</a>';
                        }
                        if (!empty($row['link_tokopedia'])) {
                            $hasLinks = true;
                            echo '<a href="redirect_marketplace.php?produk_id=' . $id . '&marketplace=tokopedia&url=' . urlencode($row['link_tokopedia']) . '" class="btn btn-sm btn-tokopedia btn-custom" target="_blank">Tokopedia</a>';
                        }
                        if (!empty($row['link_lazada'])) {
                            $hasLinks = true;
                            echo '<a href="redirect_marketplace.php?produk_id=' . $id . '&marketplace=lazada&url=' . urlencode($row['link_lazada']) . '" class="btn btn-sm btn-lazada btn-custom" target="_blank">Lazada</a>';
                        }
                        if (!$hasLinks) {
                            echo '<span class="text-muted">Tautan marketplace belum tersedia.</span>';
                        }
                        ?>
                    </td>
                </tr>
            </table>
        </div>
    </div>
</div>

<!-- Swiper JS -->
<script src="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.js"></script>

<script>
    var swiper = new Swiper(".swiper-product", {
        loop: true,
        spaceBetween: 10,
        slidesPerView: 1,
        pagination: {
            el: ".swiper-pagination",
            clickable: true,
        },
    });
</script>

<?php include 'footer.php'; ?>