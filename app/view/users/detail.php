<?php
// Pastikan path ini sesuai dengan struktur folder Anda
require_once __DIR__ . '/../../../functions.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Detail Film - Cinema Tix</title>
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

    /* === FILM DETAIL === */
    .film-detail {
      margin-top: 80px;
      padding: 40px 80px;
      display: flex;
      gap: 40px;
      align-items: flex-start;
    }

    .poster {
      flex-shrink: 0;
      width: 300px;
      height: 450px;
      border-radius: 12px;
      overflow: hidden;
      box-shadow: 0 8px 18px rgba(0, 0, 0, 0.45);
      border: 1px solid rgba(255, 255, 255, 0.1);
    }

    .poster img {
      width: 100%;
      height: 100%;
      object-fit: cover;
      display: block;
    }

    .film-info {
      flex: 1;
    }

    .film-title {
      font-size: 36px;
      font-weight: 700;
      margin-bottom: 20px;
      color: #fff;
    }

    .film-meta {
      display: flex;
      gap: 20px;
      margin-bottom: 20px;
      align-items: center;
    }

    .rating-usia {
      background: #ffcc00;
      color: #000;
      padding: 4px 8px;
      border-radius: 4px;
      font-weight: bold;
      font-size: 14px;
    }

    .rating-film {
      color: #ffcc00;
      font-size: 18px;
      font-weight: bold;
    }

    .stars {
      color: #ffcc00;
      font-size: 16px;
    }

    .film-description {
      font-size: 16px;
      line-height: 1.6;
      color: #ccc;
      margin-bottom: 30px;
    }

    .btn-booking {
      background-color: #ffcc00;
      color: #000;
      font-weight: bold;
      padding: 12px 25px;
      border-radius: 8px;
      text-decoration: none;
      transition: 0.3s;
      display: inline-block;
      font-size: 16px;
    }

    .btn-booking:hover {
      background-color: #ffd633;
      transform: translateY(-2px);
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

      .film-detail {
        flex-direction: column;
        padding: 20px;
        margin-top: 60px;
      }

      .poster {
        width: 100%;
        max-width: 300px;
        height: 450px;
        align-self: center;
      }

      .film-title {
        font-size: 28px;
        text-align: center;
      }

      .film-meta {
        justify-content: center;
        flex-wrap: wrap;
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

  <main class="film-detail">
    <?php if (isset($film) && !empty($film)): ?>
      <div class="poster">
        <img src="public/uploads/<?= htmlspecialchars($film['poster_url'] ?? ''); ?>"
          alt="<?= htmlspecialchars($film['judul'] ?? ''); ?>"
          onerror="this.src='https://via.placeholder.com/300x450/333/fff?text=Poster+Tidak+Tersedia'">
      </div>

      <div class="film-info">
        <h1 class="film-title"><?= htmlspecialchars($film['judul'] ?? 'Judul tidak tersedia'); ?></h1>

        <div class="film-meta">
          <span class="rating-usia"><?= htmlspecialchars($film['rating_usia'] ?? 'N/A'); ?></span>
          <span class="rating-film">
            <span class="stars">
              <?php
              $rating = $film['rating_bintang'] ?? 0;
              $fullStars = floor($rating);
              $halfStar = ($rating - $fullStars) >= 0.5;
              $emptyStars = 5 - $fullStars - ($halfStar ? 1 : 0);

              echo str_repeat('★', $fullStars);
              if ($halfStar)
                echo '☆';
              echo str_repeat('☆', $emptyStars);
              ?>
            </span>
            <?php if ($rating > 0): ?>
              <?= number_format($rating, 1); ?>/5
            <?php else: ?>
              Belum ada rating
            <?php endif; ?>
          </span>
        </div>

        <div class="film-description">
          <?= nl2br(htmlspecialchars($film['deskripsi'] ?? 'Deskripsi film belum tersedia.')); ?>
        </div>

        <a href="index.php?controller=booking&action=selectSchedule&film_id=<?= htmlspecialchars($film['film_id'] ?? ''); ?>"
          class="btn-booking">
          Booking Tiket
        </a>
      </div>
    <?php else: ?>
      <div style="text-align: center; padding: 40px; color: #ccc;">
        <p style="font-size: 18px; margin-bottom: 15px;">🎬 Film tidak ditemukan</p>
        <p style="font-size: 14px;">Silakan kembali ke halaman utama atau pilih film lain.</p>
        <a href="index.php" class="btn-booking" style="margin-top: 20px;">Kembali ke Home</a>
      </div>
    <?php endif; ?>
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
  </script>
</body>

</html>