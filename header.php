<?php
include 'koneksi/koneksi.php';
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Batik Bali Lestari</title>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css" />

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />

    <!-- Swiper CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.css" />

    <style>
        /* Navbar background dan ukuran */
        .navbar-default {
            background-color: rgb(231, 2, 2);
            border: none;
            border-radius: 0;
            margin-bottom: 0;
            min-height: 80px;
        }

        .navbar-default .navbar-brand,
        .navbar-default .navbar-nav>li>a {
            color: #fff !important;
            font-weight: 600;
            font-size: 18px;
            line-height: 50px;
            transition: color 0.3s ease;
        }

        .navbar-default .navbar-nav>li>a:hover,
        .navbar-default .navbar-nav>.open>a,
        .navbar-default .navbar-nav>.open>a:focus,
        .navbar-default .navbar-nav>.open>a:hover {
            background-color: maroon !important;
            color: #fff !important;
        }

        .navbar-default .navbar-toggle .icon-bar {
            background-color: #fff;
        }

        .navbar-default .dropdown-menu {
            background-color: rgb(231, 2, 2);
        }

        .navbar-default .dropdown-menu>li>a {
            color: #fff;
            font-size: 16px;
        }

        .navbar-default .dropdown-menu>li>a:hover,
        .navbar-default .dropdown-menu>li>a:focus {
            background-color: #800000;
            color: #fff;
        }

        .navbar-brand img {
            width: 35px;
            height: 35px;
            margin-right: 8px;
            border-radius: 50%;
            display: inline-block;
            vertical-align: middle;
        }

        .navbar-brand strong {
            display: inline-block;
            vertical-align: middle;
            color: #fff;
            font-size: 20px;
        }

        .navbar-header .navbar-brand {
            margin-left: -20px;
        }

        .navbar-nav.navbar-right {
            padding-right: 30px;
        }

        .navbar-toggle {
            margin-top: 20px;
        }

        @media (max-width: 767px) {
            .navbar-header .navbar-brand {
                margin-left: 10px;
                /* sudah OK */
            }

            .navbar-brand strong {
                font-size: 18px;
            }

            .navbar-collapse {
                padding: 10px 0;
            }

            .navbar-default .navbar-nav>li>a {
                line-height: 30px;
            }

            .navbar-default .navbar-nav.navbar-right {
                padding-left: 15px;
                padding-right: 15px;
            }
        }
    </style>

    <!-- jQuery dan Bootstrap JS -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</head>

<body>

    <nav class="navbar navbar-default">
        <div class="container"> <!-- Tambahkan container -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse-menu" aria-expanded="false">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>

                <a class="navbar-brand" href="index.php">
                    <img src="image/logo_title.png" alt="logo" />
                    <strong>Batik Bali Lestari</strong>
                </a>
            </div>

            <div class="collapse navbar-collapse" id="navbar-collapse-menu">
                <ul class="nav navbar-nav navbar-right">
                    <li><a href="index.php">Beranda</a></li>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                            Kategori Produk <span class="caret"></span>
                        </a>
                        <ul class="dropdown-menu">
                            <li><a href="produk.php">Semua Produk</a></li>
                            <li><a href="produk.php?kategori=batik-lengan-panjang">Batik Lengan Panjang</a></li>
                            <li><a href="produk.php?kategori=batik-lengan-pendek">Batik Lengan Pendek</a></li>
                            <li><a href="produk.php?kategori=batik-slimfit">Batik Slimfit</a></li>
                            <li><a href="produk.php?kategori=dress-batik">Dress Batik</a></li>
                            <li><a href="produk.php?kategori=batik-pasangan">Batik Pasangan</a></li>
                            <li><a href="produk.php?kategori=perlengkapan-muslim-pria">Perlengkapan Muslim Pria</a></li>
                        </ul>
                    </li>
                    <li><a href="about.php">Profil</a></li>
                    <li><a href="kontak.php">Kontak</a></li>
                    <li>
                        <a href="admin/login.php" title="Login Admin" style="font-size: 20px;">
                            <i class="fa fa-user"></i>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

</body>

</html>