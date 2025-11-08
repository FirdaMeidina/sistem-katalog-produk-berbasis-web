<?php
include 'header.php';
include 'koneksi/koneksi.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Batik Bali Lestari</title>

    <!-- jQuery, Bootstrap, Font Awesome, AOS -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>

    <style>
        body {
            margin: 0;
            font-family: 'Segoe UI', sans-serif;
            background-color: #fefefe;
        }

        .slider {
            width: 100%;
            overflow: hidden;
        }

        .slides {
            display: flex;
            width: 200%;
            animation: slide 10s infinite ease-in-out;
        }

        .slide {
            width: 50%;
        }

        .slide img {
            width: 100%;
            height: 500px;
            object-fit: cover;
            object-position: center;
        }

        @media (max-width: 991px) {
            .slide img {
                height: 400px;
            }
        }

        @media (max-width: 768px) {
            .slide img {
                height: 300px;
            }
        }

        @media (max-width: 480px) {
            .slide img {
                height: 200px;
            }
        }

        @keyframes slide {

            0%,
            20% {
                transform: translateX(0);
            }

            30%,
            50% {
                transform: translateX(-50%);
            }

            60%,
            100% {
                transform: translateX(0);
            }
        }

        .sambutan {
            font-style: italic;
            text-align: center;
            line-height: 29px;
            padding: 15px;
            margin-top: 20px;
            border-top: 5px solid rgb(231, 2, 2);
            border-bottom: 5px solid rgb(231, 2, 2);
            background-color: #fff5f5;
        }

        /* Katalog */
        .catalog-header h2 {
            font-size: 32px;
            font-weight: bold;
            font-family: 'Georgia', serif;
            color: #333;
            border-bottom: 4px solid rgb(231, 2, 2);
            padding-bottom: 10px;
            margin-top: 40px;
            margin-bottom: 30px;
        }

        .product-grid {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 20px;
            padding-bottom: 20px;
        }

        .product-card {
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 2px 12px rgba(0, 0, 0, 0.1);
            text-align: center;
            cursor: pointer;
            transition: transform 0.3s ease;
        }

        .product-card:hover {
            transform: scale(1.03);
            box-shadow: 0 8px 20px #d84e6f;
        }

        .product-card img {
            width: 100%;
            height: 300px;
            object-fit: contain;
            background-color: #f8f8f8;
            border-top-left-radius: 10px;
            border-top-right-radius: 10px;
        }

        .card-body {
            padding: 15px;
        }

        .card-title {
            font-size: 18px;
            font-weight: 600;
            color: #333;
            margin-bottom: 10px;
        }

        .price {
            color: #b30000;
            font-weight: bold;
            font-size: 1.2rem;
        }

        @media (max-width: 991px) {
            .product-grid {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }

            .product-card img {
                height: 250px;
            }

            .card-title {
                font-size: 16px;
            }

            .price {
                font-size: 1rem;
            }
        }

        @media (max-width: 575px) {
            .product-grid {
                grid-template-columns: repeat(2, minmax(0, 1fr));
                gap: 15px;
            }

            .product-card img {
                height: 200px;
            }

            .card-title {
                font-size: 14px;
            }

            .price {
                font-size: 0.9rem;
            }
        }

        /* Ringkasan */
        .summary-section {
            background: #fdf2f2;
            padding: 40px 20px;
            text-align: center;
            margin-top: 40px;
            border-top: 3px solid #d94c4c;
        }

        .summary-section h3 {
            font-size: 24px;
            color: #b30000;
            margin-bottom: 15px;
        }

        .summary-section p {
            max-width: 700px;
            margin: auto;
            font-size: 16px;
            color: #555;
        }

        .summary-section a.btn {
            margin-top: 20px;
            background: #b30000;
            color: white;
            border-radius: 25px;
            padding: 10px 25px;
            transition: background 0.3s;
            display: inline-block;
        }

        .summary-section a.btn:hover {
            background: #920000;
        }

        .text-danger {
            color: #b30000;
            font-weight: bold;
            font-size: 1.2rem;
        }

        .summary-wrapper {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 30px;
            align-items: center;
            max-width: 1000px;
            margin: auto;
            text-align: left;
        }

        .summary-text {
            padding-right: 10px;
        }

        .image-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 10px;
        }

        .image-grid img {
            width: 100%;
            border-radius: 10px;
            object-fit: cover;
            height: 120px;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .image-grid img:hover {
            transform: scale(1.05);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
        }

        @media (max-width: 768px) {
            .summary-wrapper {
                grid-template-columns: 1fr;
                text-align: center;
            }

            .summary-text {
                padding-right: 0;
            }

            .image-grid img {
                height: 100px;
            }
        }
    </style>
</head>

<body>

    <!-- Slider -->
    <div class="slider">
        <div class="slides">
            <div class="slide"><img src="image/home/1.jpg" alt="Slide 1"></div>
            <div class="slide"><img src="image/home/2.jpg" alt="Slide 2"></div>
        </div>
    </div>

    <!-- Sambutan -->
    <div class="container">
        <div class="sambutan" data-aos="fade-up">
            "Selamat Datang di Batik Bali Lestari — Desain Eksklusif dengan Sentuhan Budaya Bali di Setiap Lembaran Kain"
        </div>
    </div>

    <!-- Katalog Produk -->
    <div class="container py-4">
        <div class="catalog-header text-center" data-aos="fade-up">
            <h2>Produk Batik</h2>
        </div>

        <div class="product-grid" data-aos="fade-up" data-aos-delay="100">
            <?php
            $result = mysqli_query($conn, "SELECT * FROM produk ORDER BY tanggal_dibuat DESC LIMIT 6");
            if ($result && mysqli_num_rows($result) > 0):
                while ($row = mysqli_fetch_assoc($result)):
                    $gambarPath = "gambar/" . htmlspecialchars($row['cover']);
                    $gambar = (!empty($row['cover']) && file_exists($gambarPath)) ? $gambarPath : "gambar/default.jpg";
                    $kode_produk = !empty($row['kode_produk']) ? urlencode($row['kode_produk']) : $row['id'];
            ?>
                    <div class="product-card" onclick="location.href='detail_produk.php?produk=<?= $kode_produk; ?>'">
                        <img src="<?= $gambar; ?>" alt="<?= htmlspecialchars($row['nama']); ?>">
                        <div class="card-body">
                            <h5 class="card-title"><?= htmlspecialchars($row['nama']); ?></h5>
                            <div class="price">Rp<?= number_format($row['harga'] ?? 0, 3, ',', '.'); ?></div>
                        </div>
                    </div>
                <?php endwhile;
            else: ?>
                <p class="text-danger text-center">Produk tidak ditemukan.</p>
            <?php endif; ?>
        </div>

        <!-- Tombol Lihat Lebih Banyak -->
        <div class="text-center mt-4" data-aos="fade-up" data-aos-delay="150">
            <a href="produk.php" class="btn btn-danger">Lihat Lebih Banyak</a>
        </div>
    </div>

    <!-- Ringkasan Tentang -->
    <div class="summary-section" data-aos="fade-up" data-aos-delay="50">
        <div class="summary-wrapper">
            <div class="summary-text" data-aos="fade-right" data-aos-delay="100">
                <h3>Tentang Batik Bali Lestari</h3>
                <p>PT Konia Putra Lestari, melalui brand <strong>Batik Bali Lestari</strong>, telah berdiri sejak 1997 dan menjadi salah satu produsen serta distributor busana batik dan perlengkapan muslim terkemuka di Indonesia. Dengan lebih dari 300 gerai di berbagai department store nasional, kami terus menghadirkan produk batik berkualitas yang mengangkat budaya Indonesia dan mendukung pertumbuhan UMKM batik lokal.</p>
                <a href="about.php" class="btn">Lihat Selengkapnya <i class="fas fa-arrow-right"></i></a>
            </div>
            <div class="image-grid" data-aos="zoom-in" data-aos-delay="150">
                <img src="image/home/profil1.jpg" alt="Batik 1">
                <img src="image/home/profil2.jpg" alt="Batik 2">
                <img src="image/home/profil3.jpg" alt="Batik 3">
                <img src="image/home/profil4.jpg" alt="Batik 4">
            </div>
        </div>
    </div>

    <!-- Ringkasan Kontak -->
    <div class="summary-section" data-aos="fade-up" data-aos-delay="150" style="margin-bottom: 40px;">
        <div class="summary-wrapper">
            <div class="summary-text" data-aos="fade-left" data-aos-delay="200">
                <h3>Hubungi Kami</h3>
                <p>PT Konia Putra Lestari membuka jalur komunikasi bagi Anda yang ingin mengetahui lebih lanjut tentang produk atau kerja sama. Silakan hubungi kami melalui email atau telepon yang tersedia. Tim kami akan dengan senang hati membantu Anda.</p>
                <a href="kontak.php" class="btn">Lihat Selengkapnya <i class="fas fa-arrow-right"></i></a>
            </div>
            <div class="image-grid" data-aos="zoom-in" data-aos-delay="250">
                <img src="image/home/kontak1.png" alt="Kontak 1">
                <img src="image/home/kontak2.png" alt="Kontak 2">
            </div>
        </div>
    </div>

    <?php include 'footer.php'; ?>

    <script>
        AOS.init({
            duration: 600,
            once: true
        });
    </script>

</body>

</html>