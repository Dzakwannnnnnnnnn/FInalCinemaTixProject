<?php
require_once __DIR__ . '/../../../functions.php';
?>

<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?php echo htmlspecialchars($news['judul_news'] ?? 'Detail Berita'); ?> - CinemaTix</title>
  <link rel="icon" type="image/png" href="public/favicon.ico">
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
      min-height: 100vh;
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

    /* Main Content */
    .main-content {
      padding: 120px 80px 60px;
      max-width: 1200px;
      margin: 0 auto;
    }

    .news-detail {
      background: #111;
      border-radius: 12px;
      overflow: hidden;
      box-shadow: 0 8px 32px rgba(255, 204, 0, 0.1);
    }

    .news-image {
      width: 100%;
      height: 400px;
      object-fit: cover;
    }

    .news-content {
      padding: 40px;
    }

    .news-title {
      font-size: 32px;
      font-weight: bold;
      color: #ffcc00;
      margin-bottom: 20px;
      line-height: 1.2;
    }

    .news-meta {
      display: flex;
      gap: 20px;
      margin-bottom: 30px;
      color: #ccc;
      font-size: 14px;
    }

    .news-description {
      font-size: 18px;
      line-height: 1.8;
      color: #fff;
      margin-bottom: 40px;
    }

    .back-button {
      display: inline-block;
      background: #ffcc00;
      color: #000;
      padding: 12px 24px;
      border-radius: 8px;
      text-decoration: none;
      font-weight: bold;
      transition: 0.3s;
    }

    .back-button:hover {
      background: #ffd633;
      transform: translateY(-2px);
    }

    /* Responsive */
    @media (max-width: 768px) {
      .navbar {
        padding: 15px 20px;
      }

      .nav-links {
        display: none;
      }

      .menu-toggle {
        display: block;
      }

      .nav-links.active {
        display: flex;
        flex-direction: column;
        position: absolute;
        top: 100%;
        left: 0;
        width: 100%;
        background: #111;
        padding: 20px;
        gap: 15px;
      }

      .main-content {
        padding: 120px 20px 60px;
      }

      .news-content {
        padding: 20px;
      }

      .news-title {
        font-size: 24px;
      }

      .news-description {
        font-size: 16px;
      }
    }
  </style>
</head>

<body>
  <!-- Navbar -->
  <header class="navbar">
    <div class="logo" onclick="window.location.href='index.php'">Cinematix</div>
    <div class="menu-toggle" id="menu-toggle">☰</div>

    <nav>
      <ul class="nav-links" id="nav-links">
        <li><a href="index.php">Home</a></li>
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
    <a href="index.php?controller=auth&action=login" class="btn-login">Masuk / Daftar</a>
  </header>

  <!-- Main Content -->
  <main class="main-content">
    <div class="news-detail">
      <?php if (!empty($news['foto_news'])): ?>
        <img src="public/uploads/<?php echo htmlspecialchars($news['foto_news']); ?>"
          alt="<?php echo htmlspecialchars($news['judul_news']); ?>" class="news-image">
      <?php endif; ?>

      <div class="news-content">
        <h1 class="news-title"><?php echo htmlspecialchars($news['judul_news']); ?></h1>

        <div class="news-meta">
          <span>📅 <?php echo date('d M Y', strtotime($news['created_at'] ?? 'now')); ?></span>
          <span>📰 Berita CinemaTix</span>
        </div>

        <div class="news-description">
          <?php echo nl2br(htmlspecialchars($news['deskripsi_news'])); ?>
        </div>

        <a href="index.php?controller=user&action=beritaEvent" class="back-button">← Kembali ke Berita</a>
      </div>
    </div>
  </main>

  <script>
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