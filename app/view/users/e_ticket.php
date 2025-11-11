<?php
// Pastikan path ini sesuai dengan struktur folder Anda
require_once __DIR__ . '/../../../functions.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>E-Ticket - Cinema Tix</title>
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
      display: flex;
      justify-content: center;
      align-items: center;
      min-height: 100vh;
      padding: 20px;
    }

    .e-ticket {
      background-color: #111;
      border: 2px solid #ffcc00;
      border-radius: 15px;
      padding: 30px;
      max-width: 600px;
      width: 100%;
      box-shadow: 0 10px 30px rgba(255, 204, 0, 0.3);
      position: relative;
    }

    .e-ticket::before {
      content: "";
      position: absolute;
      top: 50%;
      left: -10px;
      width: 20px;
      height: 20px;
      background-color: #000;
      border-radius: 50%;
      border: 2px solid #ffcc00;
    }

    .e-ticket::after {
      content: "";
      position: absolute;
      top: 50%;
      right: -10px;
      width: 20px;
      height: 20px;
      background-color: #000;
      border-radius: 50%;
      border: 2px solid #ffcc00;
    }

    .ticket-header {
      text-align: center;
      margin-bottom: 30px;
    }

    .ticket-title {
      font-size: 28px;
      font-weight: bold;
      color: #ffcc00;
      margin-bottom: 10px;
    }

    .ticket-subtitle {
      color: #ccc;
      font-size: 16px;
    }

    .ticket-content {
      display: flex;
      flex-direction: column;
      gap: 20px;
    }

    .ticket-info {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 15px;
    }

    .info-item {
      background-color: #222;
      padding: 15px;
      border-radius: 8px;
      border: 1px solid #333;
    }

    .info-label {
      color: #ccc;
      font-size: 12px;
      text-transform: uppercase;
      margin-bottom: 5px;
    }

    .info-value {
      color: #fff;
      font-size: 16px;
      font-weight: bold;
    }

    .barcode-section {
      text-align: center;
      margin-top: 30px;
      padding: 20px;
      background-color: #222;
      border-radius: 8px;
      border: 1px solid #333;
    }

    .barcode-title {
      color: #ffcc00;
      font-size: 18px;
      margin-bottom: 15px;
    }

    .barcode {
      max-width: 100%;
      height: auto;
    }

    .print-instruction {
      margin-top: 20px;
      color: #ccc;
      font-size: 14px;
      text-align: center;
    }

    .btn-print {
      background-color: #ffcc00;
      color: #000;
      font-weight: bold;
      padding: 12px 30px;
      border-radius: 8px;
      border: none;
      cursor: pointer;
      font-size: 16px;
      margin-top: 20px;
      width: 100%;
      transition: 0.3s;
    }

    .btn-print:hover {
      background-color: #ffd633;
    }

    .btn-back {
      background-color: transparent;
      color: #ffcc00;
      border: 1px solid #ffcc00;
      padding: 10px 20px;
      border-radius: 8px;
      text-decoration: none;
      display: inline-block;
      margin-top: 15px;
      transition: 0.3s;
    }

    .btn-back:hover {
      background-color: #ffcc00;
      color: #000;
    }

    /* RESPONSIVE */
    @media (max-width: 768px) {
      .e-ticket {
        padding: 20px;
      }

      .ticket-info {
        grid-template-columns: 1fr;
      }

      .ticket-title {
        font-size: 24px;
      }
    }
  </style>
</head>

<body>
  <div class="e-ticket">
    <div class="ticket-header">
      <h1 class="ticket-title">E-Ticket CinemaTix</h1>
      <p class="ticket-subtitle">Terima kasih atas pembelian tiket Anda!</p>
    </div>

    <div class="ticket-content">
      <div class="ticket-info">
        <div class="info-item">
          <div class="info-label">Film</div>
          <div class="info-value"><?= htmlspecialchars($booking['judul'] ?? 'N/A'); ?></div>
        </div>
        <div class="info-item">
          <div class="info-label">Tanggal & Waktu</div>
          <div class="info-value">
            <?= date('d F Y', strtotime($booking['tanggal'] ?? '')); ?><br>
            <?= date('H:i', strtotime($booking['jam_mulai'] ?? '')); ?>
          </div>
        </div>
        <div class="info-item">
          <div class="info-label">Studio</div>
          <div class="info-value"><?= htmlspecialchars($booking['nama_studio'] ?? 'N/A'); ?>
            (<?= htmlspecialchars($booking['tipe'] ?? 'N/A'); ?>)</div>
        </div>
        <div class="info-item">
          <div class="info-label">Kursi</div>
          <div class="info-value"><?= htmlspecialchars($booking['nomor_kursi'] ?? 'N/A'); ?></div>
        </div>
        <div class="info-item">
          <div class="info-label">Booking ID</div>
          <div class="info-value">#<?= htmlspecialchars($booking_id ?? 'N/A'); ?></div>
        </div>
        <div class="info-item">
          <div class="info-label">Total Pembayaran</div>
          <div class="info-value">Rp <?= number_format($booking['harga_tiket'] ?? 0, 0, ',', '.'); ?></div>
        </div>
      </div>

      <div class="barcode-section">
        <h3 class="barcode-title">Scan Barcode untuk Print</h3>
        <img src="data:image/png;base64,<?= $barcode ?? ''; ?>" alt="Barcode" class="barcode">
        <p class="print-instruction">
          Tunjukkan barcode ini di loket bioskop untuk mencetak tiket fisik Anda.
        </p>
      </div>

      <button class="btn-print" onclick="window.print()">Print E-Ticket</button>
      <a href="index.php" class="btn-back">Kembali ke Home</a>
    </div>
  </div>

  <script>
    // Optional: Add any client-side functionality if needed
  </script>
</body>

</html>