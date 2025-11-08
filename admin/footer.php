<footer class="footer-admin">
    <p>&copy; <?= date('Y'); ?> Admin Panel Batik Bali Lestari</p>
</footer>

<style>
html, body {
  height: 100%;
  margin: 0;
  padding: 0;
}
body {
  display: flex;
  flex-direction: column;
}
.container {
  flex: 1;
}
.footer-admin {
  background-color: rgb(231, 2, 2);
  color: white;
  text-align: center;
  padding: 15px 0;
  font-size: 14px;
  margin-top: auto;
}
@media (max-width: 768px) {
  .footer-admin {
    font-size: 12px;
    padding: 10px 0;
  }
}

</style>
