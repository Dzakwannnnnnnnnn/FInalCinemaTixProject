<?php
require_once __DIR__ . '/../../../functions.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Pilih Jadwal - Cinema Tix</title>
  <link rel="icon" type="image/png" href="public/favicon.ico">
  <style>
    * { margin: 0; padding: 0; box-sizing: border-box; font-family: "Poppins", sans-serif; }
    body { background-color: #000; color: #fff; }
    .navbar { background-color: #111; display: flex; justify-content: space-between; align-items: center; padding: 15px 80px; position: fixed; width: 100%; top: 0; z-index: 100; }
    .logo { font-size: 24px; font-weight: bold; color: #ffd700; cursor: pointer; }
    .nav-links { list-style: none; display: flex; gap: 20px; transition: all 0.3s ease; }
    .nav-links a { color: #fff; text-decoration: none; font-size: 14px; padding: 8px 12px; border-radius: 6px; transition: all 0.3s; }
    .nav-links a:hover, .nav-links a.active { color: #ffcc00; background: rgba(255, 204, 0, 0.1); }
    .nav-dropdown { position: relative; }
    .nav-dropdown > a::after { content: ' ▼'; font-size: 12px; margin-left: 5px; transition: transform 0.3s ease; }
    .nav-dropdown:hover > a::after { transform: rotate(180deg); }
    .nav-dropdown-content { display: none; position: absolute; top: 100%; left: 0; background: #111; border: 1px solid rgba(255, 204, 0, 0.3); border-radius: 8px; min-width: 200px; box-shadow: 0 8px 16px rgba(0, 0, 0, 0.3); z-index: 1000; overflow: hidden; }
    .nav-dropdown:hover .nav-dropdown-content { display: block; }
    .nav-dropdown-content a { display: block; padding: 12px 16px; color: #fff; text-decoration: none; border-bottom: 1px solid rgba(255, 255, 255, 0.1); transition: all 0.3s; position: relative; }
    .nav-dropdown-content a:hover { background: rgba(255, 204, 0, 0.1); color: #ffcc00; padding-left: 20px; }
    .nav-dropdown-content a:last-child { border-bottom: none; }
    .btn-login { border: 1px solid #ffcc00; color: #ffcc00; padding: 6px 15px; border-radius: 8px; text-decoration: none; transition: 0.3s; }
    .btn-login:hover { background-color: #ffcc00; color: #111; }
    .menu-toggle { display: none; font-size: 26px; color: #ffcc00; cursor: pointer; }
    .schedule-selection { margin-top: 80px; padding: 40px 80px; }
    .film-info { text-align: center; margin-bottom: 40px; }
    .film-title { font-size: 28px; font-weight: 700; margin-bottom: 10px; color: #fff; }
    .film-details { color: #ccc; font-size: 16px; }
    .schedule-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 20px; margin-top: 30px; }
    .schedule-card { background-color: #111; border: 1px solid #333; border-radius: 12px; padding: 20px; transition: all 0.3s ease; cursor: pointer; }
    .schedule-card:hover { border-color: #ffcc00; transform: translateY(-5px); }
    .schedule-card.expired { opacity: 0.65; border-color: #444; cursor: not-allowed; }
    .schedule-card.expired:hover { border-color: #444; transform: none; }
    .schedule-date { font-size: 18px; font-weight: bold; color: #ffcc00; margin-bottom: 10px; }
    .schedule-time { font-size: 16px; color: #fff; margin-bottom: 10px; }
    .schedule-studio { font-size: 14px; color: #ccc; margin-bottom: 15px; }
    .schedule-price { font-size: 18px; font-weight: bold; color: #ffcc00; }
    .seat-remaining { margin-top: 8px; color: #9fd3ff; font-size: 13px; }
    .btn-select { background-color: #ffcc00; color: #000; padding: 10px 20px; border: none; border-radius: 8px; font-weight: bold; cursor: pointer; transition: 0.3s; margin-top: 15px; width: 100%; }
    .btn-select:hover { background-color: #ffd633; }
    .btn-select:disabled { background-color: #555; color: #ddd; cursor: not-allowed; }
    .day-status { margin-top: 10px; font-size: 13px; color: #ff6b6b; font-weight: 600; }

    @media (max-width: 768px) {
      .navbar { padding: 15px 20px; }
      .menu-toggle { display: block; }
      .nav-links { position: absolute; top: 65px; right: 0; background: #111; flex-direction: column; width: 100%; text-align: center; gap: 0; overflow: hidden; max-height: 0; transition: max-height 0.4s ease; padding: 0; }
      .nav-links li { border-top: 1px solid rgba(255, 255, 255, 0.1); padding: 14px 0; }
      .nav-links.active { max-height: 300px; }
      .btn-login { display: none; }
      .schedule-selection { padding: 20px; margin-top: 60px; }
      .schedule-grid { grid-template-columns: 1fr; }
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
        <li><a href="index.php?controller=user&action=beritaEvent">Berita & Event</a></li>
      </ul>
    </nav>

    <?php if (isLoggedIn()): ?>
      <div style="display: flex; align-items: center; gap: 15px;">
        <span style="color: #fff; font-weight:bold;">Halo,
          <?= isset($_SESSION['user_name']) ? htmlspecialchars($_SESSION['user_name']) : 'User' ?>!</span>
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
        <?php
        $groupedByDate = [];
        foreach ($jadwal as $item) {
          $groupedByDate[$item['tanggal']][] = $item;
        }
        ?>
        <?php foreach ($groupedByDate as $tanggal => $schedules): ?>
          <?php
          $activeCount = 0;
          foreach ($schedules as $s) {
            $ts = strtotime($s['tanggal'] . ' ' . $s['jam_mulai']);
            if ($ts !== false && $ts > time()) {
              $activeCount++;
            }
          }
          ?>
          <?php foreach ($schedules as $schedule): ?>
            <?php
            $showTimestamp = strtotime($schedule['tanggal'] . ' ' . $schedule['jam_mulai']);
            $isExpired = $showTimestamp === false ? true : ($showTimestamp <= time());
            $totalAktif = isset($schedule['total_kursi_aktif']) ? (int) $schedule['total_kursi_aktif'] : 0;
            $terbooking = isset($schedule['total_kursi_terbooking']) ? (int) $schedule['total_kursi_terbooking'] : 0;
            $sisaKursi = max(0, $totalAktif - $terbooking);
            ?>
            <div class="schedule-card <?= $isExpired ? 'expired' : '' ?>"
              onclick="selectSchedule(<?= (int) $schedule['jadwal_id'] ?>, <?= $isExpired ? 'true' : 'false' ?>)">
              <div class="schedule-date"><?= date('l, d F Y', strtotime($schedule['tanggal'])) ?></div>
              <div class="schedule-time">Jam: <?= date('H:i', strtotime($schedule['jam_mulai'])) ?></div>
              <div class="schedule-studio">
                Studio: <?= htmlspecialchars($schedule['nama_studio']) ?> (<?= htmlspecialchars($schedule['tipe']) ?>)
              </div>
              <div class="schedule-price">Rp <?= number_format($schedule['harga_tiket'], 0, ',', '.') ?></div>
              <div class="seat-remaining">Sisa kursi: <?= $sisaKursi ?> / <?= $totalAktif ?></div>
              <button class="btn-select" <?= $isExpired ? 'disabled' : '' ?>
                onclick="event.stopPropagation(); selectSchedule(<?= (int) $schedule['jadwal_id'] ?>, <?= $isExpired ? 'true' : 'false' ?>)">
                <?= $isExpired ? 'Jadwal Habis' : 'Pilih Jadwal' ?>
              </button>
              <?php if ($activeCount === 0): ?>
                <div class="day-status">Semua jam pada tanggal ini sudah habis</div>
              <?php endif; ?>
            </div>
          <?php endforeach; ?>
        <?php endforeach; ?>
      <?php else: ?>
        <div style="grid-column: 1 / -1; text-align: center; padding: 60px; color: #666;">
          <h3 style="font-size: 24px; margin-bottom: 15px;">Jadwal tidak tersedia</h3>
          <p style="font-size: 16px;">Belum ada jadwal tayang untuk film ini.</p>
        </div>
      <?php endif; ?>
    </div>
  </main>

  <script>
    function selectSchedule(jadwalId, isExpired) {
      if (isExpired) return;
      window.location.href = `index.php?controller=booking&action=selectSeats&jadwal_id=${jadwalId}`;
    }

    const menuToggle = document.getElementById("menu-toggle");
    const navLinks = document.getElementById("nav-links");

    menuToggle.addEventListener("click", () => {
      navLinks.classList.toggle("active");
    });

    document.querySelectorAll('.nav-links a').forEach(link => {
      link.addEventListener('click', () => {
        navLinks.classList.remove('active');
      });
    });
  </script>
</body>

</html>
