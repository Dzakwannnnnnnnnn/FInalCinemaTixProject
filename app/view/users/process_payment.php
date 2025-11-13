<?php
// Pastikan path ini sesuai dengan struktur folder Anda
require_once __DIR__ . '/../../../functions.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Memproses Pembayaran - Cinema Tix</title>
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
      display: flex;
      flex-direction: column;
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

    /* === PAYMENT PROCESSING === */
    .payment-processing {
      margin-top: 80px;
      padding: 40px 80px;
      flex: 1;
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      text-align: center;
    }

    .processing-container {
      background-color: #111;
      border-radius: 20px;
      padding: 60px;
      max-width: 600px;
      width: 100%;
      box-shadow: 0 20px 40px rgba(0, 0, 0, 0.5);
    }

    .processing-icon {
      font-size: 80px;
      margin-bottom: 30px;
      animation: pulse 2s infinite;
    }

    @keyframes pulse {
      0% {
        transform: scale(1);
      }

      50% {
        transform: scale(1.1);
      }

      100% {
        transform: scale(1);
      }
    }

    .processing-title {
      font-size: 32px;
      font-weight: bold;
      color: #ffcc00;
      margin-bottom: 20px;
    }

    .processing-message {
      font-size: 18px;
      color: #ccc;
      margin-bottom: 40px;
      line-height: 1.6;
    }

    .payment-details {
      background-color: #222;
      border-radius: 12px;
      padding: 30px;
      margin-bottom: 40px;
      text-align: left;
    }

    .detail-row {
      display: flex;
      justify-content: space-between;
      margin-bottom: 15px;
      padding-bottom: 15px;
      border-bottom: 1px solid #333;
    }

    .detail-row:last-child {
      border-bottom: none;
      margin-bottom: 0;
      padding-bottom: 0;
    }

    .detail-label {
      color: #ccc;
      font-size: 16px;
    }

    .detail-value {
      color: #fff;
      font-weight: bold;
      font-size: 16px;
    }

    .total-amount {
      font-size: 20px;
      color: #ffcc00;
    }

    .progress-bar {
      width: 100%;
      height: 8px;
      background-color: #333;
      border-radius: 4px;
      margin-bottom: 30px;
      overflow: hidden;
    }

    .progress-fill {
      height: 100%;
      background: linear-gradient(90deg, #ffcc00, #ffd700);
      border-radius: 4px;
      width: 0%;
      animation: fillProgress 3s ease-in-out forwards;
    }

    @keyframes fillProgress {
      0% {
        width: 0%;
      }

      100% {
        width: 100%;
      }
    }

    .btn-back {
      background-color: #ffcc00;
      color: #000;
      font-weight: bold;
      padding: 15px 40px;
      border-radius: 8px;
      border: none;
      cursor: pointer;
      font-size: 16px;
      transition: 0.3s;
      text-decoration: none;
      display: inline-block;
    }

    .btn-back:hover {
      background-color: #ffd633;
      transform: translateY(-2px);
    }

    .payment-method-info {
      margin-top: 20px;
      padding: 20px;
      background-color: #222;
      border-radius: 12px;
      text-align: left;
    }

    .payment-method-title {
      font-size: 18px;
      font-weight: bold;
      color: #ffcc00;
      margin-bottom: 15px;
    }

    .payment-instructions {
      color: #ccc;
      line-height: 1.6;
    }

    .payment-instructions ol {
      padding-left: 20px;
    }

    .payment-instructions li {
      margin-bottom: 8px;
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

      .payment-processing {
        padding: 20px;
        margin-top: 60px;
      }

      .processing-container {
        padding: 30px;
      }

      .processing-title {
        font-size: 24px;
      }

      .payment-details {
        padding: 20px;
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

  <main class="payment-processing">
    <div class="processing-container">
      <div class="processing-icon">💳</div>
      <h1 class="processing-title">Memproses Pembayaran</h1>
      <p class="processing-message">
        Mohon tunggu sebentar, sistem sedang memproses pembayaran Anda...
      </p>

      <div class="progress-bar">
        <div class="progress-fill"></div>
      </div>

      <div class="payment-details">
        <div class="detail-row">
          <span class="detail-label">Film:</span>
          <span class="detail-value"><?= htmlspecialchars($film['judul'] ?? 'N/A'); ?></span>
        </div>
        <div class="detail-row">
          <span class="detail-label">Jadwal:</span>
          <span class="detail-value">
            <?= date('d F Y', strtotime($jadwal['tanggal'] ?? '')); ?> -
            <?= date('H:i', strtotime($jadwal['jam_mulai'] ?? '')); ?>
          </span>
        </div>
        <div class="detail-row">
          <span class="detail-label">Studio:</span>
          <span class="detail-value">
            <?= htmlspecialchars($jadwal['nama_studio'] ?? 'N/A'); ?>
            (<?= htmlspecialchars($jadwal['tipe'] ?? 'N/A'); ?>)
          </span>
        </div>
        <div class="detail-row">
          <span class="detail-label">Kursi:</span>
          <span class="detail-value"><?= htmlspecialchars(implode(', ', $kursi_ids ?? [])); ?></span>
        </div>
        <div class="detail-row">
          <span class="detail-label">Jumlah Tiket:</span>
          <span class="detail-value"><?= count($kursi_ids ?? []); ?> tiket</span>
        </div>
        <div class="detail-row">
          <span class="detail-label">Metode Pembayaran:</span>
          <span class="detail-value">
            <?php
            $method = $payment_method ?? '';
            switch ($method) {
              case 'transfer_bank':
                echo 'Transfer Bank';
                break;
              case 'e_wallet':
                echo 'E-Wallet';
                break;
              case 'credit_card':
                echo 'Kartu Kredit';
                break;
              case 'cash':
                echo 'Bayar di Loket';
                break;
              default:
                echo 'N/A';
            }
            ?>
          </span>
        </div>
        <div class="detail-row">
          <span class="detail-label total-amount">Total Pembayaran:</span>
          <span class="detail-value total-amount">Rp <?= number_format($total_harga ?? 0, 0, ',', '.'); ?></span>
        </div>
      </div>

      <?php if (isset($payment_method) && $payment_method === 'transfer_bank'): ?>
        <div class="payment-method-info">
          <h3 class="payment-method-title">Instruksi Transfer Bank</h3>
          <div class="payment-instructions">
            <ol>
              <li>Buka aplikasi banking Anda</li>
              <li>Pilih menu Transfer</li>
              <li>Masukkan nomor rekening: <strong>1234567890</strong> (a/n CinemaTix)</li>
              <li>Masukkan nominal: <strong>Rp <?= number_format($total_harga ?? 0, 0, ',', '.'); ?></strong></li>
              <li>Tambahkan kode booking <strong>#<?= $booking_ids[0] ?? 'N/A'; ?></strong> di berita transfer</li>
              <li>Konfirmasi dan selesaikan transfer</li>
            </ol>
            <p style="margin-top: 15px; color: #ffcc00; font-weight: bold;">
              ⚠️ Pastikan transfer selesai dalam 1 jam untuk menghindari pembatalan booking otomatis.
            </p>
          </div>
        </div>
      <?php elseif (isset($payment_method) && $payment_method === 'e_wallet'): ?>
        <div class="payment-method-info">
          <h3 class="payment-method-title">Instruksi E-Wallet</h3>
          <div class="payment-instructions">
            <ol>
              <li>Buka aplikasi e-wallet Anda (GoPay, OVO, Dana, dll)</li>
              <li>Pilih menu Bayar/Transfer</li>
              <li>Scan QR Code atau pilih CinemaTix sebagai merchant</li>
              <li>Konfirmasi pembayaran sebesar <strong>Rp <?= number_format($total_harga ?? 0, 0, ',', '.'); ?></strong>
              </li>
              <li>Masukkan PIN untuk menyelesaikan transaksi</li>
            </ol>
          </div>
        </div>
      <?php elseif (isset($payment_method) && $payment_method === 'credit_card'): ?>
        <div class="payment-method-info">
          <h3 class="payment-method-title">Instruksi Kartu Kredit</h3>
          <div class="payment-instructions">
            <ol>
              <li>Masukkan nomor kartu kredit Anda</li>
              <li>Masukkan tanggal expired dan CVV</li>
              <li>Klik "Bayar Sekarang"</li>
              <li>Masukkan OTP yang dikirim ke nomor Anda</li>
              <li>Transaksi akan diproses secara otomatis</li>
            </ol>
          </div>
        </div>
      <?php elseif (isset($payment_method) && $payment_method === 'cash'): ?>
        <div class="payment-method-info">
          <h3 class="payment-method-title">Instruksi Bayar di Loket</h3>
          <div class="payment-instructions">
            <ol>
              <li>Datang ke loket bioskop pada hari tayang</li>
              <li>Tunjukkan kode booking: <strong>#<?= $booking_ids[0] ?? 'N/A'; ?></strong></li>
              <li>Bayar sebesar <strong>Rp <?= number_format($total_harga ?? 0, 0, ',', '.'); ?></strong> di kasir</li>
              <li>Ambil tiket fisik Anda</li>
            </ol>
          </div>
        </div>
      <?php endif; ?>

      <a href="index.php?controller=booking&action=eTicket&booking_id=<?= $booking_ids[0] ?? ''; ?>" class="btn-back">
        Lihat E-Ticket
      </a>
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

    // Auto redirect after 5 seconds
    setTimeout(() => {
      window.location.href = 'index.php?controller=booking&action=eTicket&booking_id=<?= $booking_ids[0] ?? ''; ?>';
    }, 5000);
  </script>
</body>

</html>