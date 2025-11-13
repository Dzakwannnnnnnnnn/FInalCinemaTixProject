<?php
// Pastikan path ini sesuai dengan struktur folder Anda
require_once __DIR__ . '/../../../functions.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">x
  <title>Cinema Tix</title>
  <link rel="icon" type="image/png" href="public/favicon.png">
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      font-family: "Poppins", sans-serif;
    }

    body {
      background-color: #000;
      color: #fff;
    }

    /* === NAVBAR === */
    .navbar {
      background-color: #111;
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding: 15px 80px;
      position: fixed;
      width: 100%;
      top: 0;
      z-index: 100;
    }

    .navbar-left {
      display: flex;
      align-items: center;
      gap: 20px;
    }

    .navbar-right {
      display: flex;
      align-items: center;
      gap: 15px;
    }

    .logo {
      font-size: 24px;
      font-weight: bold;
      color: #ffd700;
      cursor: pointer;
    }

    .nav-links {
      list-style: none;
      display: flex;
      gap: 20px;
      transition: all 0.3s ease;
    }

    .nav-links a {
      color: #fff;
      text-decoration: none;
      font-size: 14px;
      padding: 8px 12px;
      border-radius: 6px;
      transition: all 0.3s;
    }

    .nav-links a:hover,
    .nav-links a.active {
      color: #ffcc00;
      background: rgba(255, 204, 0, 0.1);
    }

    .nav-dropdown {
      position: relative;
    }

    .nav-dropdown>a::after {
      content: ' ▼';
      font-size: 12px;
      margin-left: 5px;
      transition: transform 0.3s ease;
    }

    .nav-dropdown:hover>a::after {
      transform: rotate(180deg);
    }

    .nav-dropdown-content {
      display: none;
      position: absolute;
      top: 100%;
      left: 0;
      background: #111;
      border: 1px solid rgba(255, 204, 0, 0.3);
      border-radius: 8px;
      min-width: 200px;
      box-shadow: 0 8px 16px rgba(0, 0, 0, 0.3);
      z-index: 1000;
      overflow: hidden;
    }

    .nav-dropdown:hover .nav-dropdown-content {
      display: block;
    }

    .nav-dropdown-content a {
      display: block;
      padding: 12px 16px;
      color: #fff;
      text-decoration: none;
      border-bottom: 1px solid rgba(255, 255, 255, 0.1);
      transition: all 0.3s;
      position: relative;
    }

    .nav-dropdown-content a:hover {
      background: rgba(255, 204, 0, 0.1);
      color: #ffcc00;
      padding-left: 20px;
    }

    .nav-dropdown-content a:last-child {
      border-bottom: none;
    }

    .nav-dropdown-content a::before {
      content: '▶';
      position: absolute;
      left: 8px;
      top: 50%;
      transform: translateY(-50%);
      font-size: 10px;
      color: #666;
      transition: all 0.3s;
      opacity: 0;
    }

    .nav-dropdown-content a:hover::before {
      opacity: 1;
      color: #ffcc00;
      left: 12px;
    }

    .btn-login {
      border: 1px solid #ffcc00;
      color: #ffcc00;
      padding: 6px 15px;
      border-radius: 8px;
      text-decoration: none;
      transition: 0.3s;
    }

    .btn-login:hover {
      background-color: #ffcc00;
      color: #111;
    }

    /* Tombol hamburger */
    .menu-toggle {
      display: none;
      font-size: 26px;
      color: #ffcc00;
      cursor: pointer;
    }

    /* === HERO === */
    .hero {
      height: 100vh;
      display: flex;
      align-items: center;
      justify-content: flex-start;
      padding: 0 80px;
      background-size: cover;
      background-position: center;
      background-repeat: no-repeat;
      position: relative;
      overflow: hidden;
    }

    .hero-bg {
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background-size: cover;
      background-position: center;
      background-repeat: no-repeat;
      opacity: 0;
      transition: opacity 2s ease-in-out;
      background-image: linear-gradient(rgba(0, 0, 0, 0.3), rgba(0, 0, 0, 0.3));
    }

    .hero-bg.active {
      opacity: 1;
    }

    .hero-overlay {
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background: rgba(0, 0, 0, 0.2);
      z-index: 1;
    }

    .hero-content {
      position: relative;
      z-index: 2;
      max-width: 600px;
      animation: fadeInUp 1s ease-out;
    }

    @keyframes fadeInUp {
      from {
        opacity: 0;
        transform: translateY(30px);
      }

      to {
        opacity: 1;
        transform: translateY(0);
      }
    }

    .hero h1 {
      font-size: 42px;
      font-weight: 700;
      margin-bottom: 20px;
      line-height: 1.3;
    }

    .hero p {
      font-size: 16px;
      color: #ccc;
      margin-bottom: 30px;
    }

    .btn-primary {
      background-color: #ffcc00;
      color: #000;
      font-weight: bold;
      padding: 10px 25px;
      border-radius: 8px;
      text-decoration: none;
      transition: 0.3s;
      display: inline-block;
    }

    .btn-primary:hover {
      background-color: #ffd633;
      transform: translateY(-2px);
    }

    /* SECTION & GRID */
    .container {
      margin-top: 0;
    }

    .section {
      padding: 80px 0;
      border-top: 1px solid rgba(255, 255, 255, 0.1);
      margin: 0 80px;
    }

    .section-title {
      font-family: 'Montserrat', sans-serif;
      color: #fff;
      font-size: 32px;
      margin-bottom: 30px;
      text-align: center;
    }

    .movies-grid {
      display: grid;
      grid-template-columns: repeat(3, 1fr);
      gap: 30px;
    }

    .movie-card {
      background: linear-gradient(180deg, rgba(255, 255, 255, 0.05), rgba(0, 0, 0, 0.1));
      border-radius: 12px;
      overflow: hidden;
      transition: transform 0.3s ease, box-shadow 0.3s ease;
      box-shadow: 0 8px 18px rgba(0, 0, 0, 0.45);
      border: 1px solid rgba(255, 255, 255, 0.1);
    }

    .movie-card:hover {
      transform: translateY(-8px);
      box-shadow: 0 18px 40px rgba(0, 0, 0, 0.6);
    }

    .movie-card img {
      width: 100%;
      height: 400px;
      object-fit: cover;
      display: block;
    }

    .movie-meta {
      padding: 20px;
    }

    .movie-meta h3 {
      font-size: 18px;
      margin-bottom: 8px;
      color: #fff;
    }

    .genre {
      color: #ffcc00;
      font-size: 14px;
      margin-bottom: 8px;
    }

    .sub {
      color: #aaa;
      font-size: 14px;
      display: flex;
      align-items: center;
      gap: 10px;
    }

    .rating {
      color: #ffcc00;
    }

    .news-grid {
      display: grid;
      grid-template-columns: repeat(3, 1fr);
      gap: 25px;
    }

    .news-card {
      background: #111;
      border-radius: 10px;
      overflow: hidden;
      transition: transform 0.3s ease;
      border: 1px solid rgba(255, 255, 255, 0.1);
    }

    .news-card:hover {
      transform: translateY(-5px);
    }

    .news-card img {
      width: 100%;
      height: 200px;
      object-fit: cover;
      display: block;
    }

    .news-card h4 {
      padding: 15px 15px 8px;
      font-size: 16px;
      color: #fff;
    }

    .news-card p {
      padding: 0 15px 15px;
      color: #ccc;
      font-size: 14px;
      line-height: 1.5;
    }

    .howto .steps {
      display: flex;
      gap: 20px;
      margin-top: 30px;
    }

    .step {
      flex: 1;
      background: #121212;
      padding: 25px 15px;
      border-radius: 10px;
      text-align: center;
      border: 1px solid rgba(255, 255, 255, 0.1);
      transition: transform 0.3s ease;
    }

    .step:hover {
      transform: translateY(-5px);
    }

    .step-icon {
      width: 60px;
      height: 60px;
      border-radius: 50%;
      background: #1f1f1f;
      color: #ffcc00;
      display: inline-flex;
      align-items: center;
      justify-content: center;
      font-weight: 700;
      margin-bottom: 15px;
      border: 2px solid #ffcc00;
    }

    .step-title {
      font-weight: 700;
      color: #fff;
    }

    /* FOOTER */
    .site-footer {
      background: linear-gradient(to top, #000, #0a0a0a);
      color: #ccc;
      padding: 50px 0 20px;
      border-top: 2px solid #ffcc00;
      position: relative;
      overflow: hidden;
      margin-top: 50px;
    }

    .site-footer::before {
      content: "";
      position: absolute;
      top: 0;
      left: -100%;
      width: 200%;
      height: 3px;
      background: linear-gradient(90deg, transparent, #ffcc00, transparent);
      animation: footer-shine 4s linear infinite;
    }

    @keyframes footer-shine {
      0% {
        left: -100%;
        opacity: 0;
      }

      50% {
        opacity: 1;
      }

      100% {
        left: 100%;
        opacity: 0;
      }
    }

    .footer-inner {
      display: flex;
      justify-content: space-between;
      align-items: flex-start;
      flex-wrap: wrap;
      max-width: 1200px;
      margin: 0 auto;
      padding: 0 40px;
    }

    .foot-left .logo {
      font-size: 26px;
      font-weight: 700;
      color: #ffcc00;
      margin-bottom: 10px;
    }

    .foot-left .tag {
      font-size: 14px;
      color: #aaa;
      max-width: 250px;
    }

    .footer-nav {
      display: flex;
      flex-direction: column;
      gap: 10px;
    }

    .footer-nav a {
      color: #ccc;
      text-decoration: none;
      transition: 0.3s;
      font-size: 15px;
    }

    .footer-nav a:hover {
      color: #ffcc00;
      transform: translateX(4px);
    }

    .socials {
      display: flex;
      gap: 12px;
    }

    .socials a {
      color: #ffcc00;
      text-decoration: none;
      font-weight: bold;
      border: 1px solid #ffcc00;
      padding: 8px 12px;
      border-radius: 8px;
      transition: all 0.3s ease;
      font-size: 14px;
    }

    .socials a:hover {
      background: #ffcc00;
      color: #000;
      transform: scale(1.1);
    }

    /* RESPONSIVE */
    @media (max-width: 1100px) {
      .movies-grid {
        grid-template-columns: repeat(2, 1fr);
      }

      .news-grid {
        grid-template-columns: repeat(2, 1fr);
      }

      .hero h1 {
        font-size: 36px;
      }
    }

    @media (max-width: 768px) {
      .navbar {
        padding: 15px 20px;
      }

      .menu-toggle {
        display: block;
      }

      .nav-links {
        position: absolute;
        top: 65px;
        right: 0;
        background: #111;
        flex-direction: column;
        width: 100%;
        text-align: center;
        gap: 0;
        overflow: hidden;
        max-height: 0;
        transition: max-height 0.4s ease;
        padding: 0;
      }

      .nav-links li {
        border-top: 1px solid rgba(255, 255, 255, 0.1);
        padding: 14px 0;
      }

      .nav-links.active {
        max-height: 300px;
      }

      .btn-login {
        display: none;
      }

      .hero {
        padding: 0 20px;
        text-align: center;
        justify-content: center;
      }

      .hero-content {
        max-width: 100%;
      }

      .hero h1 {
        font-size: 28px;
      }

      .section {
        margin: 0 20px;
        padding: 50px 0;
      }

      .movies-grid,
      .news-grid {
        grid-template-columns: 1fr;
      }

      .howto .steps {
        flex-direction: column;
      }

      .footer-inner {
        flex-direction: column;
        align-items: center;
        text-align: center;
        gap: 25px;
      }

      .socials {
        justify-content: center;
      }
    }
  </style>
</head>

<body>
  <header class="navbar">
    <div class="navbar-left">
      <div class="logo" onclick="window.location.href='index.php'">Cinematix</div>
    </div>

    <div class="navbar-right">
      <nav>
        <ul class="nav-links" id="nav-links">
          <li><a href="#" class="active">Home</a></li>
          <li class="nav-dropdown">
            <a href="index.php?controller=user&action=pesanan">Film & Tiket</a>
            <div class="nav-dropdown-content">
              <a href="index.php?controller=user&action=pesanan">Pemesanan Tiket</a>
              <a href="index.php?controller=user&action=purchaseHistory">Riwayat Pembelian</a>
            </div>
          </li>
          <li><a href="index.php#movies">Sedang Tayang</a></li>
          <li><a href="index.php?controller=user&action=beritaEvent">Berita & Event</a></li>
        </ul>
      </nav>

      <?php if (isLoggedIn()): ?>
        <div style="display: flex; align-items: center; gap: 15px;">
          <span style="color: #fff; font-weight:bold;">Halo, <?= htmlspecialchars($_SESSION['user_name']) ?>!</span>
          <?php if (isAdmin()): ?>
            <a href="index.php?controller=admin&action=index" class="btn-login"
              style="background: #ffcc00; color: #000; padding: 6px 12px;">Admin Panel</a>
          <?php endif; ?>
          <a href="index.php?controller=auth&action=logout" class="btn-login">Logout</a>
        </div>
      <?php else: ?>
        <a href="index.php?controller=auth&action=login" class="btn-login">Masuk/Daftar</a>
      <?php endif; ?>

      <div class="menu-toggle" id="menu-toggle">☰</div>
    </div>
  </header>

  <section class="hero" id="hero">
    <!-- Background layers untuk smooth crossfade -->
    <div class="hero-bg active" id="bg1"></div>
    <div class="hero-bg" id="bg2"></div>
    <div class="hero-bg" id="bg3"></div>

    <div class="hero-overlay"></div>
    <div class="hero-content">
      <h1>Nikmati Pengalaman Nonton<br>Terbaik<br>Tanpa Antri di Bioskop</h1>
      <p>Temukan film terbaru dan jadwal bioskop favoritmu.</p>
      <a href="index.php?controller=user&action=pesanan" class="btn-primary">Pesan Tiket Sekarang</a>
    </div>
  </section>

  <main class="container">
    <section id="movies" class="section">
      <h2 class="section-title">Film Ter-hits Bulan Ini</h2>
      <?php if (isset($films) && !empty($films)): ?>
        <div class="movies-grid">
          <?php foreach ($films as $film): ?>
            <article class="movie-card">
              <img src="public/uploads/<?= htmlspecialchars($film['poster_url']); ?>"
                alt="<?= htmlspecialchars($film['judul']); ?>" loading="lazy"
                onerror="this.src='https://via.placeholder.com/300x400/333/fff?text=Poster+Tidak+Tersedia'">
              <div class="movie-meta">
                <h3><?= htmlspecialchars($film['judul']); ?></h3>
                <div class="genre"><?= htmlspecialchars($film['genre'] ?? 'Action'); ?></div>
                <div class="sub">
                  <span class="rating"><?= htmlspecialchars($film['rating_usia']); ?></span>
                  <span>•</span>
                  <span><?= htmlspecialchars($film['durasi'] ?? '120 menit'); ?></span>
                </div>
                <div class="movie-actions" style="margin-top: 15px;">
                  <a href="index.php?controller=film&action=detail&id=<?= $film['film_id']; ?>" class="btn-primary"
                    style="padding: 8px 15px; font-size: 14px; display: block; text-align: center;">
                    Lihat Detail
                  </a>
                </div>
              </div>
            </article>
          <?php endforeach; ?>
        </div>
        <div style="text-align: center; margin-top: 30px;">
          <a href="index.php?controller=user&action=pesanan" class="btn-primary"
            style="padding: 12px 25px; font-size: 16px;">
            Lihat Film Lainnya
          </a>
        </div>
      <?php else: ?>
        <div style="text-align: center; padding: 40px; color: #ccc;">
          <p style="font-size: 18px; margin-bottom: 15px;">😔 Tidak ada film yang sedang tayang</p>
          <p style="font-size: 14px;">Silakan check kembali nanti untuk update film terbaru.</p>
        </div>
      <?php endif; ?>
    </section>

    <section id="news" class="section">
      <h2 class="section-title">Berita & Event</h2>
      <?php if (isset($news) && !empty($news)): ?>
        <div class="news-grid">
          <?php foreach ($news as $item): ?>
            <article class="news-card"
              onclick="window.location.href='index.php?controller=user&action=detailBerita&id=<?= $item['id_news']; ?>'"
              style="cursor: pointer;">
              <img src="public/uploads/<?= htmlspecialchars($item['foto_news']); ?>"
                alt="<?= htmlspecialchars($item['judul_news']); ?>" loading="lazy"
                onerror="this.src='https://via.placeholder.com/400x200/333/fff?text=Berita+Tidak+Tersedia'">
              <h4><?= htmlspecialchars($item['judul_news']); ?></h4>
              <p>
                <?= htmlspecialchars(substr($item['deskripsi_news'], 0, 100)) . (strlen($item['deskripsi_news']) > 100 ? '...' : ''); ?>
              </p>
            </article>
          <?php endforeach; ?>
        </div>
        <div style="text-align: center; margin-top: 30px;">
          <a href="index.php?controller=user&action=beritaEvent" class="btn-primary"
            style="padding: 12px 25px; font-size: 16px;">
            Tampilkan Berita Lebih Banyak
          </a>
        </div>
      <?php else: ?>
        <div style="text-align: center; padding: 40px; color: #ccc;">
          <p style="font-size: 18px; margin-bottom: 15px;">📄 Tidak ada berita tersedia</p>
          <p style="font-size: 14px;">Silakan check kembali nanti untuk update berita terbaru.</p>
        </div>
      <?php endif; ?>
    </section>

    <section class="section howto">
      <h2 class="section-title">Cara Pesan Tiket</h2>
      <div class="steps">
        <div class="step">
          <div class="step-icon">1</div>
          <div class="step-title">Pilih Film</div>
        </div>
        <div class="step">
          <div class="step-icon">2</div>
          <div class="step-title">Pilih Kursi</div>
        </div>
        <div class="step">
          <div class="step-icon">3</div>
          <div class="step-title">Bayar</div>
        </div>
        <div class="step">
          <div class="step-icon">4</div>
          <div class="step-title">Dapatkan E-Ticket</div>
        </div>
      </div>
    </section>
  </main>

  <footer class="site-footer">
    <div class="footer-inner">
      <div class="foot-left">
        <div class="logo">Cinematix</div>
        <p class="tag">Cinematix — Enjoy Your Movie & Your Moment.</p>
      </div>
      <div class="foot-center">
        <nav class="footer-nav">
          <a href="#">Home</a>
          <a href="#">Tentang</a>
          <a href="#">Kontak</a>
        </nav>
      </div>
      <div class="foot-right">
        <div class="socials">
          <a href="#">IG</a>
          <a href="#">TT</a>
          <a href="#">YT</a>
        </div>
      </div>
    </div>
  </footer>

  <script>
    // Smooth slideshow dengan multiple background layers
    const images = [
      "public/uploads/dune.jpg",
      "public/uploads/star.jpg",
      "public/uploads/gost.jpg"
    ];

    let currentIndex = 0;
    let nextIndex = 1;
    let isTransitioning = false;

    // Preload semua gambar
    function preloadImages() {
      images.forEach(src => {
        const img = new Image();
        img.src = src;
      });
    }

    // Inisialisasi slideshow
    function initSlideshow() {
      const bg1 = document.getElementById('bg1');
      const bg2 = document.getElementById('bg2');
      const bg3 = document.getElementById('bg3');

      // Set background pertama
      bg1.style.backgroundImage = `url('${images[0]}')`;
      bg1.classList.add('active');

      // Preload dan set background kedua
      bg2.style.backgroundImage = `url('${images[1]}')`;
      bg3.style.backgroundImage = `url('${images[2]}')`;
    }

    // Transisi slideshow yang smooth
    function changeBackground() {
      if (isTransitioning) return;

      isTransitioning = true;

      const backgrounds = [
        document.getElementById('bg1'),
        document.getElementById('bg2'),
        document.getElementById('bg3')
      ];

      const currentBg = backgrounds[currentIndex % 3];
      const nextBg = backgrounds[nextIndex % 3];

      // Mulai transisi
      currentBg.classList.remove('active');
      nextBg.classList.add('active');

      // Update indices
      currentIndex = nextIndex;
      nextIndex = (nextIndex + 1) % images.length;

      // Preload gambar berikutnya
      const futureIndex = (nextIndex + 1) % images.length;
      const futureBg = backgrounds[futureIndex % 3];
      futureBg.style.backgroundImage = `url('${images[futureIndex]}')`;

      // Reset flag setelah transisi selesai
      setTimeout(() => {
        isTransitioning = false;
      }, 2000);
    }

    // Jalankan slideshow
    preloadImages();
    initSlideshow();

    // Tunggu sebentar sebelum memulai transisi pertama
    setTimeout(() => {
      setInterval(changeBackground, 5000);
    }, 3000);

    // Navbar toggle
    const menuToggle = document.getElementById("menu-toggle");
    const navLinks = document.getElementById("nav-links");

    menuToggle.addEventListener("click", () => {
      navLinks.classList.toggle("active");
    });

    // Tutup menu mobile saat klik link
    document.querySelectorAll('.nav-links a').forEach(link => {
      link.addEventListener('click', () => {
        navLinks.classList.remove('active');
      });
    });

    // Smooth scroll untuk anchor links
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
      anchor.addEventListener('click', function (e) {
        e.preventDefault();
        const target = document.querySelector(this.getAttribute('href'));
        if (target) {
          target.scrollIntoView({
            behavior: 'smooth',
            block: 'start'
          });
        }
      });
    });
  </script>
</body>

</html>