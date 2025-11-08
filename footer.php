<style>
  html,
  body {
    margin: 0;
    padding: 0;
  }

  footer {
    font-family: Arial, sans-serif;
    font-size: 14px;
    color: #555;
  }

  footer .footer-bg {
    width: 100%;
    background-color: rgb(255, 194, 194);
    border-top: 4px solid rgb(233, 26, 26);
  }

  footer .footer-container {
    width: 100%;
    max-width: 1170px;
    margin: 0 auto;
    padding: 40px 15px;
    box-sizing: border-box;
    position: relative;
  }

  footer .footer-container h4 {
    margin-top: 0;
    margin-bottom: 15px;
    color: rgb(231, 2, 2);
    cursor: pointer;
    position: relative;
  }

  /* Arrow toggle hanya untuk dropdown-mobile h4 */
  .dropdown-mobile h4::after {
    content: "";
    font-size: 0;
    position: absolute;
    right: 0;
    top: 4px;
    transition: transform 0.3s ease;
  }

  /* Arrow muncul di mobile */
  @media (max-width: 767px) {
    .dropdown-mobile h4::after {
      content: "▼";
      font-size: 12px;
    }
  }

  .dropdown-mobile.active h4::after {
    transform: rotate(180deg);
  }

  footer .footer-container p,
  footer .footer-container ul {
    margin: 0 0 10px 0;
    padding: 0;
  }

  footer .footer-container ul {
    list-style: none;
  }

  footer .footer-container ul li {
    margin-bottom: 8px;
  }

  .footer-link {
    color: #555;
    text-decoration: none;
    transition: color 0.3s ease;
  }

  .footer-link:hover,
  .footer-link:focus,
  .footer-link:active {
    color: maroon !important;
  }

  footer .copyright {
    width: 100%;
    background-color: rgb(231, 2, 2);
    color: white;
    text-align: center;
    padding: 12px 15px;
    box-sizing: border-box;
    font-size: 14px;
  }

  .row {
    display: flex;
    justify-content: center;
    flex-wrap: wrap;
    /* Agar responsive tetap berjalan */
    box-sizing: border-box;
    margin-left: auto;
    margin-right: auto;
  }


  .row::after {
    content: "";
    display: table;
    clear: both;
  }

  [class*="col-"] {
    float: left;
    padding-left: 15px;
    padding-right: 15px;
    box-sizing: border-box;
  }

  .col-xs-12 {
    width: 100%;
  }

  @media (min-width: 768px) {
    .col-md-4 {
      width: 33.3333%;
    }

    .col-sm-4 {
      width: 33.3333%;
    }
  }

  /* MOBILE STYLES */
  @media (max-width: 767px) {
    .dropdown-mobile ul {
      display: none;
    }

    .dropdown-mobile.active ul {
      display: block;
    }

    /* Lebih lega padding kiri-kanan footer container */
    .footer-container {
      padding-left: 20px !important;
      padding-right: 20px !important;
      padding-top: 20px !important;
      padding-bottom: 20px !important;
    }

    /* Kolom full width dengan padding cukup */
    .row>[class*="col-"] {
      width: 100% !important;
      float: none !important;
      padding-left: 15px !important;
      padding-right: 15px !important;
      margin-bottom: 20px;
    }

    footer .copyright {
      font-size: 13px;
      padding: 10px 15px;
    }
  }
</style>

<footer>
  <div class="footer-bg">
    <div class="footer-container">
      <div class="row">
        <!-- Info -->
        <div class="col-xs-12 col-md-4">
          <h4><b>Batik Bali Lestari</b></h4>
          <p>Jl. Raya Pondok Petir No. 8–9</p>
          <p>Kelurahan Pondok Petir, Kecamatan Bojongsari</p>
          <p>Kota Depok, Jawa Barat 16517</p>
          <p><i class="glyphicon glyphicon-earphone"></i> 0813-9891-7208</p>
          <p><i class="glyphicon glyphicon-envelope"></i> batik.bali.lestari97@gmail.com</p>
          <p><i class="glyphicon glyphicon-time"></i> Senin - Jumat: 08:00 - 17:00</p>
        </div>

        <!-- Menu & Store -->
        <div class="col-xs-12 col-md-4">
          <div class="row">
            <div class="col-xs-12 col-sm-4 dropdown-mobile">
              <h4><b>Menu</b></h4>
              <ul>
                <li><a href="produk.php" class="footer-link">Produk</a></li>
                <li><a href="about.php" class="footer-link">Profil Perusahaan</a></li>
                <li><a href="kontak.php" class="footer-link">Kontak</a></li>
              </ul>
            </div>

            <div class="col-xs-12 col-sm-4 dropdown-mobile">
              <h4><b>Store</b></h4>
              <ul>
                <li><a href="https://www.ramayana.co.id/" target="_blank" class="footer-link">Ramayana</a></li>
                <li><a href="https://www.matahari.com/" target="_blank" class="footer-link">Matahari</a></li>
                <li><a href="https://www.suzuyagroup.com/" target="_blank" class="footer-link">Suzuya</a></li>
                <li><a href="https://www.yogyaonline.co.id/" target="_blank" class="footer-link">Yogya</a></li>
              </ul>
            </div>

            <!-- Ikuti Kami (TANPA panah toggle) -->
            <div class="col-xs-12 col-sm-4">
              <h4><b>Ikuti Kami</b></h4>
              <ul>
                <li>
                  <a href="https://www.instagram.com/batikbalilestari" class="footer-link" target="_blank" style="color:#E4405F;">
                    <i class="fab fa-instagram"></i> Instagram
                  </a>
                </li>
                <li>
                  <a href="https://www.facebook.com/batikbalilestari" class="footer-link" target="_blank" style="color:#1877F2;">
                    <i class="fab fa-facebook"></i> Facebook
                  </a>
                </li>
                <li>
                  <a href="https://twitter.com/bali_lestari" class="footer-link" target="_blank" style="color:#1DA1F2;">
                    <i class="fab fa-twitter"></i> Twitter
                  </a>
                </li>
              </ul>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="copyright">
    <p>&copy; <?php echo date("Y"); ?> PT Konia Putra Lestari - Batik Bali Lestari</p>
  </div>
</footer>

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
    navigation: {
      nextEl: ".swiper-button-next",
      prevEl: ".swiper-button-prev",
    },
  });
</script>



<script>
  document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.dropdown-mobile h4').forEach(header => {
      header.addEventListener('click', function() {
        this.parentElement.classList.toggle('active');
      });
    });
  });
</script>