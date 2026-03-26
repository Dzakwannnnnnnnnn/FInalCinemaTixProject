<?php
require_once __DIR__ . '/../../../functions.php';

$seats = explode(', ', $bookingData['nomor_kursi'] ?? '');
$seatCount = (int) ($bookingData['seat_count'] ?? 1);
$ticketPrice = (int) ($jadwal['harga_tiket'] ?? 0);
$totalTransaction = (int) (($total_ticket_price ?? 0) + ($admin_fee ?? 0));
?>
<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>E-Ticket Thermal 80mm - CinemaTix</title>
  <style>
    :root {
      --paper-width: 80mm;
      --font-main: "Courier New", Courier, monospace;
    }

    * {
      box-sizing: border-box;
    }

    body {
      margin: 0;
      padding: 16px;
      font-family: var(--font-main);
      background: #f2f2f2;
      color: #000;
    }

    .tickets-wrap {
      display: flex;
      flex-direction: column;
      align-items: center;
      gap: 14px;
    }

    .receipt {
      width: var(--paper-width);
      background: #fff;
      border: 1px solid #000;
      padding: 10px 8px;
    }

    .center {
      text-align: center;
    }

    .title {
      font-size: 15px;
      font-weight: 700;
      line-height: 1.2;
      margin-bottom: 2px;
    }

    .subtitle {
      font-size: 11px;
      margin-bottom: 8px;
    }

    .divider {
      border-top: 1px dashed #000;
      margin: 6px 0;
    }

    .kv {
      font-size: 11px;
      line-height: 1.45;
    }

    .kv .label {
      font-weight: 700;
      display: inline-block;
      min-width: 78px;
    }

    .film-title {
      font-size: 12px;
      font-weight: 700;
      margin-bottom: 4px;
      text-transform: uppercase;
      word-break: break-word;
    }

    .barcode-wrap {
      margin-top: 8px;
      text-align: center;
    }

    .barcode {
      width: 58mm;
      max-width: 100%;
      height: 15mm;
      object-fit: contain;
      image-rendering: crisp-edges;
    }

    .barcode-text {
      font-size: 10px;
      margin-top: 2px;
      word-break: break-all;
    }

    .footer-note {
      margin-top: 6px;
      text-align: center;
      font-size: 10px;
      line-height: 1.35;
    }

    .cut-line {
      width: var(--paper-width);
      border-top: 1px dashed #888;
      text-align: center;
      font-size: 9px;
      color: #666;
      padding-top: 2px;
    }

    .actions {
      margin-top: 14px;
      display: flex;
      gap: 10px;
      justify-content: center;
      flex-wrap: wrap;
    }

    .btn {
      border: 1px solid #000;
      background: #fff;
      color: #000;
      padding: 8px 14px;
      font-size: 13px;
      cursor: pointer;
      text-decoration: none;
    }

    .btn:hover {
      background: #000;
      color: #fff;
    }

    @media print {
      body {
        background: #fff;
        padding: 0;
        margin: 0;
      }

      .tickets-wrap {
        gap: 0;
      }

      .receipt {
        border: none;
        width: 80mm;
        margin: 0;
        padding: 6mm 4mm 4mm 4mm;
        page-break-inside: avoid;
      }

      .cut-line {
        width: 80mm;
        margin: 0;
        padding-bottom: 4mm;
        page-break-after: always;
      }

      .actions {
        display: none !important;
      }

      @page {
        size: 80mm auto;
        margin: 0;
      }
    }
  </style>
</head>

<body>
  <div class="tickets-wrap">
    <?php for ($i = 0; $i < ($seatCount > 0 ? $seatCount : 1); $i++): ?>
      <?php
      $seatNumber = $seats[$i] ?? 'N/A';
      $currentBookingId = $bookingData['booking_ids'][$i] ?? $booking_id ?? 'N/A';
      ?>
      <section class="receipt">
        <div class="center">
          <div class="title">CINEMATIX E-TICKET</div>
          <div class="subtitle">Valid untuk 1 kursi</div>
        </div>

        <div class="divider"></div>

        <div class="film-title"><?= htmlspecialchars($bookingData['judul'] ?? 'N/A') ?></div>

        <div class="kv"><span class="label">Tanggal</span>: <?= date('d-m-Y', strtotime($bookingData['tanggal'] ?? '')) ?></div>
        <div class="kv"><span class="label">Jam</span>: <?= date('H:i', strtotime($bookingData['jam_mulai'] ?? '')) ?></div>
        <div class="kv"><span class="label">Studio</span>: <?= htmlspecialchars($bookingData['nama_studio'] ?? 'N/A') ?></div>
        <div class="kv"><span class="label">Tipe</span>: <?= htmlspecialchars($bookingData['tipe'] ?? 'N/A') ?></div>
        <div class="kv"><span class="label">Kursi</span>: <?= htmlspecialchars($seatNumber) ?></div>
        <div class="kv"><span class="label">Booking ID</span>: #<?= htmlspecialchars($currentBookingId) ?></div>
        <div class="kv"><span class="label">Harga Tiket</span>: Rp <?= number_format($ticketPrice, 0, ',', '.') ?></div>
        <?php if ($admin_fee > 0): ?>
          <div class="kv"><span class="label">Admin</span>: Rp <?= number_format((int) $admin_fee, 0, ',', '.') ?></div>
        <?php endif; ?>
        <div class="kv"><span class="label">Total Transaksi</span>: Rp <?= number_format($totalTransaction, 0, ',', '.') ?></div>

        <div class="barcode-wrap">
          <img src="data:image/png;base64,<?= $barcode ?? '' ?>" alt="Barcode" class="barcode">
          <div class="barcode-text"><?= htmlspecialchars((string) $currentBookingId) ?></div>
        </div>

        <div class="footer-note">
          Tunjukkan tiket ini saat masuk studio.<br>
          Simpan struk sampai film selesai.
        </div>
      </section>
      <div class="cut-line">----- potong di sini -----</div>
    <?php endfor; ?>
  </div>

  <div class="actions">
    <button class="btn" onclick="window.print()">Print Thermal 80mm</button>
    <a href="index.php" class="btn">Kembali ke Beranda</a>
  </div>
</body>

</html>
