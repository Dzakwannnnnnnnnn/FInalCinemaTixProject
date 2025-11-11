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
  <link rel="icon" type="images/png" href="tix_logo.png" />
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

    /* NAVBAR */
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
      color: #ffcc00;
      cursor: pointer;
    }

    .nav-links {
      list-style: none;
      display: flex;
      gap: 30px;
    }

    .nav-links a {
      color: #fff;
      text-decoration: none;
      font-size: 15px;
      transition: color 0.3s;
    }

    .nav-links a:hover,
    .nav-links a.active {
      color: #ffcc00;
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
        display: none;
      }
    }
  </style>
</head>

<body>
  <header class="navbar">
    <div class="logo" onclick="window.location.href='index.php'">Cinematix</div>
    <nav>
      <ul class="nav-links">
        <li><a href="index.php">Home</a></li>
        <li><a href="index.php?controller=user&action=pesanan">Pemesanan Tiket</a></li>
        <li><a href="index.php?controller=user&action=tayang">Sedang Tayang</a></li>
        <li><a href="index.php?controller=user&action=beritaEvent" style="color:#ffcc00;">Berita & Event</a></li>
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
          <div class="news-card">
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
            <li><a href="#"><?= htmlspecialchars($item['judul_news']) ?></a></li>
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