<?php
// Pastikan path ini sesuai dengan struktur folder Anda
require_once __DIR__ . '/../../../functions.php';
?>
<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Berita & Event | Cinematix</title>
  <link rel="icon" type="image/png" href="public/favicon.ico">
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      font-family: "Poppins", sans-serif;
    }

    body {
      background-color: #fff;
      color: #111;
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

    /* MAIN CONTENT */
    .container {
      display: flex;
      justify-content: space-between;
      align-items: flex-start;
      padding: 120px 80px 80px;
      gap: 50px;
    }

    .main-news {
      flex: 3;
      display: grid;
      grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
      gap: 40px;
    }

    .news-card {
      background-color: #fff;
      border-radius: 12px;
      overflow: hidden;
      box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
      transition: transform 0.3s ease;
    }

    .news-card:hover {
      transform: translateY(-5px);
    }

    .news-card img {
      width: 100%;
      height: 220px;
      object-fit: cover;
    }

    .news-content {
      padding: 20px;
    }

    .category {
      font-size: 13px;
      font-weight: 600;
      color: #287bff;
      margin-bottom: 8px;
      text-transform: uppercase;
    }

    .news-title {
      font-size: 20px;
      font-weight: 700;
      margin-bottom: 10px;
      line-height: 1.3;
      color: #111;
    }

    .news-meta {
      font-size: 13px;
      color: #555;
      margin-bottom: 12px;
    }

    .news-desc {
      font-size: 15px;
      color: #333;
      line-height: 1.6;
    }

    /* SIDEBAR */
    .sidebar {
      flex: 1;
      border-left: 1px solid #ddd;
      padding-left: 40px;
    }

    .sidebar h3 {
      font-size: 18px;
      font-weight: 700;
      margin-bottom: 20px;
      border-bottom: 2px solid #111;
      display: inline-block;
      padding-bottom: 5px;
    }

    .sidebar ul {
      list-style: none;
    }

    .sidebar li {
      margin-bottom: 18px;
      border-bottom: 1px solid #eee;
      padding-bottom: 12px;
    }

    .sidebar a {
      text-decoration: none;
      color: #111;
      font-weight: 600;
      line-height: 1.4;
    }

    .sidebar a:hover {
      color: #ffcc00;
    }

    footer {
      background-color: #111;
      color: #fff;
      text-align: center;
      padding: 25px;
      margin-top: 60px;
    }

    /* RESPONSIVE */
    @media (max-width: 768px) {
      .container {
        flex-direction: column;
        padding: 120px 20px 40px;
        gap: 30px;
      }

      .sidebar {
        border-left: none;
        border-top: 1px solid #ddd;
        padding-left: 0;
        padding-top: 30px;
      }

      .navbar {
        padding: 15px 20px;
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

      .menu-toggle {
        display: block;
      }

      .main-news {
        grid-template-columns: 1fr;
      }

      .news-card {
        max-width: 100%;
      }

      .news-title {
        font-size: 18px;
      }

      .news-desc {
        font-size: 14px;
      }
    }

    @media (max-width: 480px) {
      .container {
        padding: 100px 15px 30px;
      }

      .news-content {
        padding: 15px;
      }

      .news-title {
        font-size: 16px;
      }

      .sidebar h3 {
        font-size: 16px;
      }

      .sidebar li {
        margin-bottom: 12px;
      }
    }
  </style>
</head>

<body>
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
        <li><a href="index.php?controller=user&action=beritaEvent" class="active">Berita & Event</a></li>
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
      <a href="index.php?controller=auth&action=login" class="btn-login">Masuk / Daftar</a>
    <?php endif; ?>
  </header>

  <main class="container">
    <div class="main-news">
      <?php if (isset($news) && !empty($news)): ?>
        <?php foreach ($news as $item): ?>
          <div class="news-card"
            onclick="window.location.href='index.php?controller=user&action=detailBerita&id=<?= $item['id_news']; ?>'"
            style="cursor: pointer;">
            <?php if (!empty($item['foto_news'])): ?>
              <img src="public/uploads/<?= htmlspecialchars($item['foto_news']) ?>"
                alt="<?= htmlspecialchars($item['judul_news']) ?>" />
            <?php else: ?>
              <img src="https://via.placeholder.com/400x220/333/fff?text=Berita+Tidak+Tersedia" alt="No Image" />
            <?php endif; ?>
            <div class="news-content">
              <div class="category">CINEMATIX NEWS</div>
              <div class="news-title"><?= htmlspecialchars($item['judul_news']) ?></div>
              <div class="news-meta">by Cinematix Admin – <?= date('F j, Y') ?></div>
              <div class="news-desc">
                <?= htmlspecialchars(substr($item['deskripsi_news'], 0, 150)) ?>...
              </div>
            </div>
          </div>
        <?php endforeach; ?>
      <?php else: ?>
        <div style="grid-column: 1 / -1; text-align: center; padding: 60px; color: #666;">
          <h3 style="font-size: 24px; margin-bottom: 15px;">📄 Belum ada berita tersedia</h3>
          <p style="font-size: 16px;">Silakan check kembali nanti untuk update berita terbaru.</p>
        </div>
      <?php endif; ?>
    </div>

    <aside class="sidebar">
      <h3>Berita Terbaru</h3>
      <ul>
        <?php if (isset($news) && !empty($news)): ?>
          <?php foreach (array_slice($news, 0, 5) as $item): ?>
            <li><a href="index.php?controller=user&action=detailBerita&id=<?= $item['id_news']; ?>"
                style="cursor: pointer;"><?= htmlspecialchars($item['judul_news']) ?></a></li>
          <?php endforeach; ?>
        <?php else: ?>
          <li><a href="#">Tidak ada berita terbaru</a></li>
        <?php endif; ?>
      </ul>
    </aside>
  </main>

  <footer>
    © 2025 Cinematix — Semua Hak Dilindungi
  </footer>
</body>

</html>