<?php
require_once __DIR__ . '/../../../functions.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>E-Ticket - CinemaTix</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background-color: #000;
      color: #fff;
      margin: 0;
      padding: 20px;
      min-height: 100vh;
      display: flex;
      flex-direction: column;
      justify-content: center;
      align-items: center;
    }

    .ticket-container {
      display: flex;
      flex-direction: column;
      align-items: center;
      gap: 30px;
    }

    .e-ticket {
      background-color: #fff;
      border: 2px solid #ffcc00;
      border-radius: 10px;
      width: 13cm;
      height: 5cm;
      position: relative;
      display: flex;
      align-items: center;
      padding: 10px;
      box-shadow: 0 0 20px rgba(255, 204, 0, 0.3);
    }

    .e-ticket::before,
    .e-ticket::after {
      content: '';
      position: absolute;
      width: 20px;
      height: 20px;
      background-color: #000;
      border: 2px solid #ffcc00;
      border-radius: 50%;
      top: 50%;
      transform: translateY(-50%);
    }

    .e-ticket::before {
      left: -10px;
    }

    .e-ticket::after {
      right: -10px;
    }

    .ticket-info {
      flex: 1;
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 5px;
      font-size: 8px;
    }

    .info-item {
      background-color: #f0f0f0;
      padding: 3px;
      border-radius: 3px;
      border: 1px solid #ccc;
    }

    .info-label {
      color: #666;
      font-size: 6px;
      text-transform: uppercase;
      margin-bottom: 2px;
    }

    .info-value {
      color: #000;
      font-size: 8px;
      font-weight: bold;
    }

    .barcode-section {
      margin-left: 10px;
      text-align: center;
    }

    .barcode-title {
      color: #ffcc00;
      font-size: 8px;
      margin-bottom: 3px;
    }

    .barcode {
      width: 60px;
      height: 20px;
    }

    .print-instruction {
      color: #ccc;
      font-size: 6px;
      margin-top: 3px;
      line-height: 1.1;
    }

    /* ✅ FIX: bagian print */
    @media print {

      html,
      body {
        background: white !important;
        margin: 0;
        padding: 0;
        height: 100%;
        overflow: hidden;
      }

      .ticket-container {
        margin: 0;
        padding: 0;
        height: auto;
        display: flex;
        justify-content: center;
        align-items: center;
        page-break-inside: avoid;
      }

      .e-ticket {
        border: 2px solid #000 !important;
        box-shadow: none !important;
        margin: 0 auto;
        page-break-inside: avoid;
        transform: scale(1);
      }

      .e-ticket::before,
      .e-ticket::after {
        background-color: white !important;
        border: 2px solid #000 !important;
      }

      .info-item {
        background-color: #f0f0f0 !important;
        border: 1px solid #000 !important;
      }

      .info-label {
        color: #666 !important;
      }

      .info-value {
        color: #000 !important;
      }

      .barcode-title {
        color: #000 !important;
        font-weight: bold !important;
      }

      .print-instruction {
        color: #666 !important;
      }

      .action-buttons {
        display: none !important;
      }

      /* ✅ Set ukuran dan margin halaman fix */
      @page {
        size: A4;
        margin: 0;
      }
    }
  </style>

</head>

<body>
  <div class="ticket-container">
    <div class="e-ticket">
      <div class="ticket-info">
        <div class="info-item">
          <div class="info-label">Film</div>
          <div class="info-value"><?= htmlspecialchars($booking['judul'] ?? 'N/A') ?></div>
        </div>
        <div class="info-item">
          <div class="info-label">Tanggal & Waktu</div>
          <div class="info-value">
            <?= date('d F Y', strtotime($booking['tanggal'] ?? '')) ?><br>
            <?= date('H:i', strtotime($booking['jam_mulai'] ?? '')) ?>
          </div>
        </div>
        <div class="info-item">
          <div class="info-label">Studio</div>
          <div class="info-value"><?= htmlspecialchars($booking['nama_studio'] ?? 'N/A') ?>
            (<?= htmlspecialchars($booking['tipe'] ?? 'N/A') ?>)</div>
        </div>
        <div class="info-item">
          <div class="info-label">Kursi</div>
          <div class="info-value"><?= htmlspecialchars($booking['nomor_kursi'] ?? 'N/A') ?></div>
        </div>
        <div class="info-item">
          <div class="info-label">Booking ID</div>
          <div class="info-value">#<?= htmlspecialchars($booking_id ?? 'N/A') ?></div>
        </div>
        <div class="info-item">
          <div class="info-label">Total Biaya</div>
          <div class="info-value">Rp <?= number_format(($total_ticket_price ?? 0) + ($admin_fee ?? 0), 0, ',', '.') ?>
          </div>
        </div>

      </div>

      <div class="barcode-section">
        <div class="barcode-title">Scan untuk Print</div>
        <img src="data:image/png;base64,<?= $barcode ?? '' ?>" alt="Barcode" class="barcode">
        <div class="print-instruction">
          Tunjukkan di loket untuk cetak tiket
        </div>
      </div>
    </div>

    <div class="action-buttons">
      <button class="btn-print" onclick="window.print()">Print E-Ticket</button>
      <a href="index.php" class="btn-back">Kembali ke Beranda</a>
    </div>
  </div>

  <style>
    .action-buttons {
      display: flex;
      gap: 15px;
      justify-content: center;
      margin-top: 30px;
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
      transition: 0.3s;
    }

    .btn-print:hover {
      background-color: #ffd633;
    }

    .btn-back {
      background-color: transparent;
      color: #ffcc00;
      border: 1px solid #ffcc00;
      padding: 12px 30px;
      border-radius: 8px;
      text-decoration: none;
      font-size: 16px;
      transition: 0.3s;
    }

    .btn-back:hover {
      background-color: #ffcc00;
      color: #000;
    }
  </style>
</body>

</html>