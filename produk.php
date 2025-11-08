<?php
include 'header.php';
include 'koneksi/koneksi.php';

ini_set('display_errors', 1);
error_reporting(E_ALL);
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

$conn = $conn ?? ($koneksi ?? null);
if (!$conn) {
    die('Koneksi database gagal.');
}

function slugify($text)
{
    $text = strtolower(trim($text));
    $text = preg_replace('/[^a-z0-9]+/', '-', $text);
    return trim($text, '-');
}

$kategoriMap = [];
$sqlKategori = "SELECT id, nama_kategori FROM kategori";
$resultKategori = mysqli_query($conn, $sqlKategori);
while ($row = mysqli_fetch_assoc($resultKategori)) {
    $slug = slugify($row['nama_kategori']);
    $kategoriMap[$slug] = (int)$row['id'];
}

$params = [];
$sql = "SELECT * FROM produk ";

if (!empty($_GET['kategori'])) {
    $slug = strtolower(trim($_GET['kategori']));
    if (isset($kategoriMap[$slug])) {
        $sql .= "WHERE kategori_id = ? ";
        $params[] = $kategoriMap[$slug];
    } else {
        $sql .= "WHERE 1=0 ";
    }
}

$sql .= "ORDER BY id DESC";

$stmt = mysqli_prepare($conn, $sql);
if ($params) {
    $types = str_repeat('i', count($params));
    mysqli_stmt_bind_param($stmt, $types, ...$params);
}
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Produk Batik</title>
    <style>
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(30px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            padding: 0;
            font-family: 'Segoe UI', sans-serif;
            background-color: #fff;
        }

        .container {
            max-width: 1140px;
            margin: 0 auto;
            padding: 20px;
            animation: fadeIn 0.8s ease-out;
        }

        h2 {
            width: 100%;
            font-size: 28px;
            color: #b30000;
            border-left: 6px solid #f15f7f;
            padding-left: 15px;
            margin-bottom: 30px;
            animation: fadeIn 1s ease-in-out;
        }

        .row {
            display: flex;
            flex-wrap: wrap;
            margin: -12px;
        }

        .col {
            padding: 12px;
            width: 50%;
            /* Default: 2 produk per baris di semua HP */
            animation: fadeIn 0.7s ease-in-out;
        }

        @media (min-width: 768px) {
            .col {
                width: 33.3333%;
                /* 3 produk per baris di tablet ke atas */
            }
        }

        .mb-4 {
            margin-bottom: 1.5rem;
        }

        .card {
            background: #fff;
            overflow: hidden;
            border-radius: 10px;
            box-shadow: 0 3px 12px rgba(0, 0, 0, 0.08);
            display: flex;
            flex-direction: column;
            height: 100%;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            cursor: pointer;
            text-align: center;
            border: 1px solid #eee;
        }

        .card:hover {
            transform: scale(1.03);
            box-shadow: 0 12px 25px rgba(241, 95, 127, 0.4);
            border: 1px solid #f15f7f;
        }

        .card-img-wrapper {
            overflow: hidden;
            height: 280px;
            background-color: #fff;
            padding: 10px;
            border-radius: 10px 10px 0 0;
        }

        .card-img-top {
            width: 100%;
            height: 100%;
            object-fit: contain;
            transition: transform 0.3s ease-in-out;
        }

        .card-img-wrapper:hover .card-img-top {
            transform: scale(1.08);
        }

        .card-body {
            flex-grow: 1;
            padding: 1rem;
            display: flex;
            flex-direction: column;
            justify-content: center;
            animation: fadeIn 0.5s ease;
        }

        .card-title {
            color: #333;
            margin-bottom: 0.5rem;
            font-size: 1.4rem;
            font-weight: bold;
        }

        .text-danger {
            color: #d6001c;
            font-weight: bold;
            font-size: 1.5rem;
            margin: 0;
        }

        @media (max-width: 767.98px) {
            .card-img-wrapper {
                height: 180px;
            }

            .card-title {
                font-size: 1.2rem;
            }

            .text-danger {
                font-size: 1.2rem;
            }
        }

        @media (max-width: 479.98px) {
            .card-img-wrapper {
                height: 160px;
            }

            .card-title {
                font-size: 1.1rem;
            }

            .text-danger {
                font-size: 1.1rem;
            }
        }
    </style>
</head>

<body>

    <div class="container">
        <h2><b>Produk Batik</b></h2>
        <div class="row">
            <?php if ($result && mysqli_num_rows($result) > 0): ?>
                <?php while ($row = mysqli_fetch_assoc($result)):
                    $coverPath = "gambar/" . htmlspecialchars($row['cover']);
                    $cover = (!empty($row['cover']) && file_exists($coverPath)) ? $coverPath : "gambar/default.jpg";
                    $kode_produk = !empty($row['kode_produk']) ? urlencode($row['kode_produk']) : $row['id'];
                ?>
                    <div class="col mb-4">
                        <div class="card" onclick="location.href='detail_produk.php?produk=<?= $kode_produk; ?>'">
                            <div class="card-img-wrapper">
                                <img src="<?= $cover ?>" alt="<?= htmlspecialchars($row['nama']); ?>" class="card-img-top" />
                            </div>
                            <div class="card-body">
                                <h5 class="card-title"><?= htmlspecialchars($row['nama']); ?></h5>
                                <h5 class="text-danger">Rp<?= number_format($row['harga'] ?? 0, 3, ',', '.'); ?></h5>
                            </div>
                        </div>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <div class="col text-center" style="width:100%;">
                    <p class="text-danger">Produk tidak ditemukan dalam kategori ini.</p>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <?php include 'footer.php'; ?>
</body>

</html>