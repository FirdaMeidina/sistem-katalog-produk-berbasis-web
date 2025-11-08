<?php
include 'header.php'; // pastikan header sudah include koneksi juga

// Total Produk
$jumlah_produk = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM produk"))['total'];

// Total Kategori
$jumlah_kategori = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM kategori"))['total'];

// Total Admin
$jumlah_admin = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM admin"))['total'];

// Ambil Data Klik Marketplace
$query = "
    SELECT DATE(tanggal) AS tanggal, 
           SUM(CASE WHEN marketplace = 'shopee' THEN 1 ELSE 0 END) AS shopee_clicks,
           SUM(CASE WHEN marketplace = 'tokopedia' THEN 1 ELSE 0 END) AS tokopedia_clicks,
           SUM(CASE WHEN marketplace = 'lazada' THEN 1 ELSE 0 END) AS lazada_clicks
    FROM produk_clicks
    GROUP BY DATE(tanggal)
    ORDER BY tanggal DESC
    LIMIT 7
";

$result = mysqli_query($conn, $query);

// Ambil data klik per hari untuk grafik
$klik_data = [];
while ($row = mysqli_fetch_assoc($result)) {
    $klik_data[] = $row;
}
?>

<div class="container mt-5">
    <h2 class="mb-4">Dashboard</h2>
    <div class="alert alert-info">
        Selamat datang di Panel Admin <strong class="text-capitalize"><?= $_SESSION['nama_lengkap']; ?></strong>. Gunakan menu di atas untuk mengelola data.
    </div>

    <div class="row text-center">
        <!-- Panel-statistik lainnya seperti Total Produk, Kategori, dan Admin -->
        <div class="col-md-4 mb-3">
            <a href="kelola_produk.php" class="text-decoration-none">
                <div class="panel panel-primary shadow-sm p-3 rounded">
                    <div class="panel-heading">
                        <h5>Total Produk</h5>
                    </div>
                    <div class="panel-body">
                        <h3><?= $jumlah_produk ?></h3>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-md-4 mb-3">
            <a href="kelola_kategori.php" class="text-decoration-none">
                <div class="panel panel-success shadow-sm p-3 rounded">
                    <div class="panel-heading">
                        <h5>Total Kategori</h5>
                    </div>
                    <div class="panel-body">
                        <h3><?= $jumlah_kategori ?></h3>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-md-4 mb-3">
            <a href="kelola_admin.php" class="text-decoration-none">
                <div class="panel panel-warning shadow-sm p-3 rounded">
                    <div class="panel-heading">
                        <h5>Total Admin</h5>
                    </div>
                    <div class="panel-body">
                        <h3><?= $jumlah_admin ?></h3>
                    </div>
                </div>
            </a>
        </div>
    </div>

    <!-- Grafik Klik Marketplace -->
    <div class="card shadow mb-4">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">📊 Statistik Klik Marketplace</h5>
        </div>
        <div class="card-body">
            <canvas id="klikMarketplaceChart" height="400"></canvas>
        </div>
    </div>
</div>

<!-- Grafik Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Data klik yang diambil dari PHP
    const klikData = <?php echo json_encode($klik_data); ?>;

    // Mengambil tanggal dan klik per marketplace
    const labels = klikData.map(data => data.tanggal);
    const klikShopee = klikData.map(data => data.shopee_clicks);
    const klikTokopedia = klikData.map(data => data.tokopedia_clicks);
    const klikLazada = klikData.map(data => data.lazada_clicks);

    // Menyiapkan chart
    const ctx = document.getElementById('klikMarketplaceChart').getContext('2d');
    const klikMarketplaceChart = new Chart(ctx, {
        type: 'bar', // Grafik batang
        data: {
            labels: labels, // Label menggunakan tanggal
            datasets: [{
                    label: 'Shopee',
                    borderColor: 'rgba(255, 99, 132, 1)',
                    backgroundColor: 'rgba(255, 99, 132, 0.2)',
                    data: klikShopee, // Data klik Shopee
                    fill: true,
                    borderWidth: 1
                },
                {
                    label: 'Tokopedia',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    backgroundColor: 'rgba(54, 162, 235, 0.2)',
                    data: klikTokopedia, // Data klik Tokopedia
                    fill: true,
                    borderWidth: 1
                },
                {
                    label: 'Lazada',
                    borderColor: 'rgba(255, 159, 64, 1)',
                    backgroundColor: 'rgba(255, 159, 64, 0.2)',
                    data: klikLazada, // Data klik Lazada
                    fill: true,
                    borderWidth: 1
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'top',
                    labels: {
                        boxWidth: 20,
                        padding: 15
                    }
                },
                tooltip: {
                    callbacks: {
                        label: function(tooltipItem) {
                            return tooltipItem.dataset.label + ': ' + tooltipItem.raw + ' Klik';
                        }
                    }
                }
            },
            scales: {
                x: {
                    title: {
                        display: true,
                        text: 'Tanggal'
                    },
                    grid: {
                        display: false
                    }
                },
                y: {
                    title: {
                        display: true,
                        text: 'Jumlah Klik'
                    },
                    beginAtZero: true,
                    grid: {
                        display: true,
                        color: 'rgba(0, 0, 0, 0.1)'
                    },
                    ticks: {
                        stepSize: 1, // Langkah angka Y menjadi 1
                        min: 0, // Minimum pada sumbu Y
                        max: Math.max(...klikShopee.concat(klikTokopedia, klikLazada)) + 1, // Max disesuaikan berdasarkan data
                        callback: function(value) {
                            return value; // Menampilkan angka bulat tanpa desimal
                        }
                    }
                }
            }
        }
    });
</script>

<?php
include 'footer.php';
?>