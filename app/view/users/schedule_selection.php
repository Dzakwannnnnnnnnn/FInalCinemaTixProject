<?php
// Pastikan path ini sesuai dengan struktur folder Anda
require_once __DIR__ . '/../../../functions.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Pilih Jadwal - Cinema Tix</title>
  <link rel="icon" type="images/png" href="tix_logo.png">
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

    .logo {
      font-size: 24px;
      font-weight: bold;
      color: #ffd700;
      cursor: pointer;
    }

    .nav-links {
      list-style: none;
      display: flex;
      gap: 30px;
      transition: all 0.3s ease;
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

    /* Tombol hamburger */
    .menu-toggle {
      display: none;
      font-size: 26px;
      color: #ffcc00;
      cursor: pointer;
    }

    /* === SCHEDULE SELECTION === */
    .schedule-selection {
      margin-top: 80px;
      padding: 40px 80px;
    }

    .film-info {
      text-align: center;
      margin-bottom: 40px;
    }

    .film-title {
      font-size: 28px;
      font-weight: 700;
      margin-bottom: 10px;
      color: #fff;
    }

    .film-details {
      color: #ccc;
      font-size: 16px;
    }

    .schedule-grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
      gap: 20px;
      margin-top: 30px;
    }

    .schedule-card {
      background-color: #111;
      border: 1px solid #333;
      border-radius: 12px;
      padding: 20px;
      transition: all 0.3s ease;
      cursor: pointer;
    }

    .schedule-card:hover {
      border-color: #ffcc00;
      transform: translateY(-5px);
    }

    .schedule-date {
      font-size: 18px;
      font-weight: bold;
      color: #ffcc00;
      margin-bottom: 10px;
    }

    .schedule-time {
      font-size: 16px;
      color: #fff;
      margin-bottom: 10px;
    }

    .schedule-studio {
      font-size: 14px;
      color: #ccc;
      margin-bottom: 15px;
    }

    .schedule-price {
      font-size: 18px;
      font-weight: bold;
      color: #ffcc00;
    }

    .btn-select {
      background-color: #ffcc00;
      color: #000;
      padding: 10px 20px;
      border: none;
      border-radius: 8px;
      font-weight: bold;
      cursor: pointer;
      transition: 0.3s;
      margin-top: 15px;
      width: 100%;
    }

    .btn-select:hover {
      background-color: #ffd633;
    }

    /* RESPONSIVE */
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

      .schedule-selection {
        padding: 20px;
        margin-top: 60px;
      }

      .schedule-grid {
        grid-template-columns: 1fr;
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
        <li><a href="index.php?controller=user&action=pesanan">Pemesanan Tiket</a></li>
        <li><a href="#movies">Sedang Tayang</a></li>
        <li><a href="#news">Berita & Event</a></li>
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
  </header>

  <main class="schedule-selection">
    <div class="film-info">
      <h1 class="film-title"><?= htmlspecialchars($film['judul'] ?? 'Pilih Jadwal Film'); ?></h1>
      <p class="film-details">
        Rating: <?= htmlspecialchars($film['rating_usia'] ?? 'N/A'); ?> |
        Durasi: <?= htmlspecialchars($film['durasi'] ?? 'N/A'); ?> menit
      </p>
    </div>

    <div class="schedule-grid">
      <?php if (isset($jadwal) && !empty($jadwal)): ?>
        <?php foreach ($jadwal as $schedule): ?>
          <div class="schedule-card" onclick="selectSchedule(<?= $schedule['jadwal_id'] ?>)">
            <div class="schedule-date">
              <?= date('l, d F Y', strtotime($schedule['tanggal'])) ?>
            </div>
            <div class="schedule-time">
              Jam: <?= date('H:i', strtotime($schedule['jam_mulai'])) ?>
            </div>
            <div class="schedule-studio">
              Studio: <?= htmlspecialchars($schedule['nama_studio']) ?> (<?= htmlspecialchars($schedule['tipe']) ?>)
            </div>
            <div class="schedule-price">
              Rp <?= number_format($schedule['harga_tiket'], 0, ',', '.') ?>
            </div>
            <button class="btn-select" onclick="event.stopPropagation(); selectSchedule(<?= $schedule['jadwal_id'] ?>)">
              Pilih Jadwal
            </button>
          </div>
        <?php endforeach; ?>
      <?php else: ?>
        <div style="grid-column: 1 / -1; text-align: center; padding: 60px; color: #666;">
          <h3 style="font-size: 24px; margin-bottom: 15px;">📅 Jadwal tidak tersedia</h3>
          <p style="font-size: 16px;">Belum ada jadwal tayang untuk film ini.</p>
        </div>
      <?php endif; ?>
    </div>
  </main>

  <script>
    function selectSchedule(jadwalId) {
      window.location.href = `index.php?controller=booking&action=selectSeats&jadwal_id=${jadwalId}`;
    }

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
  </script>
</body>

</html>