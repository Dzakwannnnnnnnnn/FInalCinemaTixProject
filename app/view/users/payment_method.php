<?php
// Pastikan path ini sesuai dengan struktur folder Anda
require_once __DIR__ . '/../../../functions.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Pilih Metode Pembayaran - Cinema Tix</title>
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

    /* === PAYMENT METHOD SELECTION === */
    .payment-selection {
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

    .booking-details {
      color: #ccc;
      font-size: 16px;
      margin-bottom: 20px;
    }

    .payment-methods {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
      gap: 20px;
      margin-top: 30px;
    }

    .payment-card {
      background-color: #111;
      border: 2px solid #333;
      border-radius: 12px;
      padding: 20px;
      transition: all 0.3s ease;
      cursor: pointer;
    }

    .payment-card:hover {
      border-color: #ffcc00;
      transform: translateY(-5px);
    }

    .payment-card.selected {
      border-color: #ffcc00;
      background-color: rgba(255, 204, 0, 0.1);
    }

    .payment-icon {
      font-size: 48px;
      color: #ffcc00;
      margin-bottom: 15px;
      text-align: center;
    }

    .payment-name {
      font-size: 20px;
      font-weight: bold;
      color: #fff;
      margin-bottom: 10px;
      text-align: center;
    }

    .payment-description {
      color: #ccc;
      font-size: 14px;
      text-align: center;
      margin-bottom: 15px;
    }

    .payment-fee {
      color: #ffcc00;
      font-size: 16px;
      font-weight: bold;
      text-align: center;
    }

    .booking-summary {
      background-color: #111;
      padding: 20px;
      border-radius: 12px;
      margin-top: 40px;
      border: 1px solid rgba(255, 255, 255, 0.1);
    }

    .summary-title {
      font-size: 20px;
      font-weight: bold;
      margin-bottom: 15px;
      color: #ffcc00;
    }

    .summary-details p {
      margin-bottom: 5px;
      color: #ccc;
    }

    .total-price {
      font-size: 18px;
      font-weight: bold;
      color: #ffcc00;
      margin-top: 15px;
      padding-top: 15px;
      border-top: 1px solid #333;
    }

    .btn-confirm {
      background-color: #ffcc00;
      color: #000;
      font-weight: bold;
      padding: 12px 30px;
      border-radius: 8px;
      border: none;
      cursor: pointer;
      font-size: 16px;
      transition: 0.3s;
      width: 100%;
      margin-top: 20px;
    }

    .btn-confirm:hover {
      background-color: #ffd633;
    }

    .btn-confirm:disabled {
      background-color: #666;
      cursor: not-allowed;
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

      .payment-selection {
        padding: 20px;
        margin-top: 60px;
      }

      .payment-methods {
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

  <main class="payment-selection">
    <div class="film-info">
      <h1 class="film-title">Pilih Metode Pembayaran</h1>
      <p class="booking-details">
        Film: <?= htmlspecialchars($film['judul'] ?? 'N/A'); ?> |
        Jadwal: <?= date('l, d F Y', strtotime($jadwal['tanggal'] ?? '')); ?> |
        Jam: <?= date('H:i', strtotime($jadwal['jam_mulai'] ?? '')); ?>
      </p>
    </div>

    <form id="paymentForm" action="index.php?controller=booking&action=processPayment" method="POST">
      <input type="hidden" name="jadwal_id" value="<?= htmlspecialchars($jadwal['jadwal_id'] ?? ''); ?>">
      <input type="hidden" name="kursi_ids" value="<?= htmlspecialchars(implode(',', $kursi_ids ?? [])); ?>">
      <input type="hidden" name="total_harga" value="<?= htmlspecialchars($total_harga ?? 0); ?>">

      <div class="payment-methods">
        <div class="payment-card" onclick="selectPayment('transfer_bank')" data-method="transfer_bank">
          <div class="payment-icon">🏦</div>
          <div class="payment-name">Transfer Bank</div>
          <div class="payment-description">Transfer ke rekening bank kami</div>
          <div class="payment-fee">Biaya: Rp 0</div>
        </div>

        <div class="payment-card" onclick="selectPayment('e_wallet')" data-method="e_wallet">
          <div class="payment-icon">📱</div>
          <div class="payment-name">E-Wallet</div>
          <div class="payment-description">Bayar menggunakan GoPay, OVO, Dana, dll</div>
          <div class="payment-fee">Biaya: Rp 2.500</div>
        </div>

        <div class="payment-card" onclick="selectPayment('credit_card')" data-method="credit_card">
          <div class="payment-icon">💳</div>
          <div class="payment-name">Kartu Kredit</div>
          <div class="payment-description">Bayar menggunakan kartu kredit</div>
          <div class="payment-fee">Biaya: Rp 5.000</div>
        </div>

        <div class="payment-card" onclick="selectPayment('cash')" data-method="cash">
          <div class="payment-icon">💵</div>
          <div class="payment-name">Bayar di Loket</div>
          <div class="payment-description">Bayar langsung di loket bioskop</div>
          <div class="payment-fee">Biaya: Rp 0</div>
        </div>
      </div>

      <input type="hidden" name="payment_method" id="selectedPaymentMethod" value="">

      <div class="booking-summary">
        <h3 class="summary-title">Ringkasan Pemesanan</h3>
        <div class="summary-details">
          <p>Film: <?= htmlspecialchars($film['judul'] ?? 'N/A'); ?></p>
          <p>Jadwal: <?= date('l, d F Y', strtotime($jadwal['tanggal'] ?? '')); ?> -
            <?= date('H:i', strtotime($jadwal['jam_mulai'] ?? '')); ?>
          </p>
          <p>Studio: <?= htmlspecialchars($jadwal['nama_studio'] ?? 'N/A'); ?>
            (<?= htmlspecialchars($jadwal['tipe'] ?? 'N/A'); ?>)</p>
          <p>Kursi: <?= htmlspecialchars(implode(', ', $kursi_ids ?? [])); ?></p>
          <p>Jumlah Tiket: <?= count($kursi_ids ?? []); ?></p>
          <p>Harga Tiket: Rp <?= number_format($jadwal['harga_tiket'] ?? 0, 0, ',', '.'); ?></p>
          <p>Subtotal: Rp <?= number_format((count($kursi_ids ?? []) * ($jadwal['harga_tiket'] ?? 0)), 0, ',', '.'); ?>
          </p>
          <p>Biaya Admin: <span id="adminFee">Rp 0</span></p>
        </div>
        <div class="total-price">
          Total Pembayaran: Rp <span id="finalTotal"><?= number_format($total_harga ?? 0, 0, ',', '.'); ?></span>
        </div>
        <button type="submit" class="btn-confirm" id="btnConfirm" disabled>Konfirmasi Pembayaran</button>
      </div>
    </form>
  </main>

  <script>
    let selectedPaymentMethod = '';
    let adminFee = 0;

    function selectPayment(method) {
      // Remove selected class from all cards
      document.querySelectorAll('.payment-card').forEach(card => {
        card.classList.remove('selected');
      });

      // Add selected class to clicked card
      event.currentTarget.classList.add('selected');

      selectedPaymentMethod = method;
      document.getElementById('selectedPaymentMethod').value = method;

      // Set admin fee based on payment method
      switch (method) {
        case 'transfer_bank':
          adminFee = 0;
          break;
        case 'e_wallet':
          adminFee = 2500;
          break;
        case 'credit_card':
          adminFee = 5000;
          break;
        case 'cash':
          adminFee = 0;
          break;
        default:
          adminFee = 0;
      }

      updateSummary();
    }

    function updateSummary() {
      document.getElementById('adminFee').textContent = 'Rp ' + adminFee.toLocaleString('id-ID');
      const subtotal = <?= count($kursi_ids ?? []) ?> * <?= $jadwal['harga_tiket'] ?? 0 ?>;
      const finalTotal = subtotal + adminFee;
      document.getElementById('finalTotal').textContent = finalTotal.toLocaleString('id-ID');

      const btnConfirm = document.getElementById('btnConfirm');
      btnConfirm.disabled = !selectedPaymentMethod;
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