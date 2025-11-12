<?php
require_once __DIR__ . '/../../../functions.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Riwayat Pembelian - CinemaTix</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
  <style>
    body {
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      background-color: #0a0a0a;
      color: #fff;
      margin: 0;
      padding: 20px;
      min-height: 100vh;
    }

    .container {
      max-width: 1200px;
      margin: 0 auto;
      padding: 20px;
    }

    .header {
      text-align: center;
      margin-bottom: 40px;
    }

    .header h1 {
      color: #ffcc00;
      font-size: 2.5em;
      margin-bottom: 10px;
      text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);
    }

    .header p {
      color: #ccc;
      font-size: 1.1em;
    }

    .history-grid {
      display: grid;
      gap: 20px;
      grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
    }

    .history-card {
      background: linear-gradient(135deg, #1a1a1a 0%, #2a2a2a 100%);
      border-radius: 15px;
      padding: 25px;
      box-shadow: 0 8px 32px rgba(255, 204, 0, 0.1);
      border: 1px solid #333;
      transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .history-card:hover {
      transform: translateY(-5px);
      box-shadow: 0 12px 40px rgba(255, 204, 0, 0.2);
    }

    .film-title {
      color: #ffcc00;
      font-size: 1.4em;
      font-weight: bold;
      margin-bottom: 15px;
      display: flex;
      align-items: center;
      gap: 10px;
    }

    .film-title i {
      color: #ffcc00;
    }

    .booking-details {
      display: grid;
      gap: 8px;
      margin-bottom: 20px;
    }

    .detail-row {
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding: 5px 0;
      border-bottom: 1px solid #333;
    }

    .detail-label {
      color: #ccc;
      font-weight: 500;
    }

    .detail-value {
      color: #fff;
      font-weight: bold;
    }

    .price-section {
      background: rgba(255, 204, 0, 0.1);
      border-radius: 10px;
      padding: 15px;
      margin-bottom: 20px;
      border: 1px solid rgba(255, 204, 0, 0.3);
    }

    .price-row {
      display: flex;
      justify-content: space-between;
      margin-bottom: 5px;
    }

    .total-price {
      font-size: 1.2em;
      color: #ffcc00;
      font-weight: bold;
    }

    .action-buttons {
      display: flex;
      gap: 10px;
      justify-content: center;
    }

    .btn {
      padding: 12px 20px;
      border: none;
      border-radius: 8px;
      font-weight: bold;
      cursor: pointer;
      text-decoration: none;
      display: inline-flex;
      align-items: center;
      gap: 8px;
      transition: all 0.3s ease;
      font-size: 14px;
    }

    .btn-primary {
      background: #ffcc00;
      color: #000;
    }

    .btn-primary:hover {
      background: #ffd633;
      transform: translateY(-2px);
    }

    .btn-secondary {
      background: transparent;
      color: #ffcc00;
      border: 1px solid #ffcc00;
    }

    .btn-secondary:hover {
      background: #ffcc00;
      color: #000;
    }

    .empty-state {
      text-align: center;
      padding: 60px 20px;
      color: #666;
    }

    .empty-state i {
      font-size: 4em;
      margin-bottom: 20px;
      color: #444;
    }

    .empty-state h2 {
      color: #ccc;
      margin-bottom: 10px;
    }

    .empty-state p {
      margin-bottom: 30px;
    }

    .back-button {
      position: fixed;
      top: 20px;
      left: 20px;
      background: #ffcc00;
      color: #000;
      padding: 12px 20px;
      border-radius: 8px;
      text-decoration: none;
      font-weight: bold;
      display: flex;
      align-items: center;
      gap: 8px;
      box-shadow: 0 4px 12px rgba(255, 204, 0, 0.3);
      transition: all 0.3s ease;
    }

    .back-button:hover {
      background: #ffd633;
      transform: translateY(-2px);
    }

    @media (max-width: 768px) {
      .history-grid {
        grid-template-columns: 1fr;
      }

      .header h1 {
        font-size: 2em;
      }

      .back-button {
        position: static;
        margin-bottom: 20px;
        display: inline-flex;
      }

      .history-card {
        padding: 20px;
      }

      .film-title {
        font-size: 1.2em;
      }

      .action-buttons {
        flex-direction: column;
      }

      .btn {
        justify-content: center;
      }
    }

    @media (max-width: 480px) {
      .container {
        padding: 10px;
      }

      .header h1 {
        font-size: 1.8em;
      }

      .history-card {
        padding: 15px;
      }

      .detail-row {
        flex-direction: column;
        align-items: flex-start;
        gap: 5px;
      }

      .price-section {
        padding: 10px;
      }

      .btn {
        padding: 10px 15px;
        font-size: 13px;
      }
    }
  </style>
</head>

<body>
  <a href="index.php" class="back-button">
    <i class="fas fa-arrow-left"></i>
    Kembali ke Beranda
  </a>

  <div class="container">
    <div class="header">
      <h1><i class="fas fa-history"></i> Riwayat Pembelian Tiket</h1>
      <p>Lihat semua tiket yang telah Anda beli</p>
    </div>

    <?php if (empty($purchaseHistory)): ?>
      <div class="empty-state">
        <i class="fas fa-ticket-alt"></i>
        <h2>Belum Ada Riwayat Pembelian</h2>
        <p>Anda belum membeli tiket apapun. Mulai pesan tiket film favorit Anda!</p>
        <a href="index.php?controller=user&action=pesanan" class="btn btn-primary">
          <i class="fas fa-film"></i>
          Pesan Tiket Sekarang
        </a>
      </div>
    <?php else: ?>
      <div class="history-grid">
        <?php foreach ($purchaseHistory as $item): ?>
          <div class="history-card">
            <div class="film-title">
              <i class="fas fa-film"></i>
              <?= htmlspecialchars($item['film_title']) ?>
            </div>

            <div class="booking-details">
              <div class="detail-row">
                <span class="detail-label">ID Booking:</span>
                <span class="detail-value">#<?= htmlspecialchars($item['booking_id']) ?></span>
              </div>
              <div class="detail-row">
                <span class="detail-label">Tanggal Tayang:</span>
                <span class="detail-value"><?= date('d M Y', strtotime($item['jadwal_date'])) ?></span>
              </div>
              <div class="detail-row">
                <span class="detail-label">Waktu:</span>
                <span class="detail-value"><?= date('H:i', strtotime($item['jadwal_time'])) ?> WIB</span>
              </div>
              <div class="detail-row">
                <span class="detail-label">Studio:</span>
                <span class="detail-value"><?= htmlspecialchars($item['studio']) ?></span>
              </div>
              <div class="detail-row">
                <span class="detail-label">Kursi:</span>
                <span class="detail-value"><?= htmlspecialchars($item['seat']) ?></span>
              </div>
              <div class="detail-row">
                <span class="detail-label">Tanggal Pembelian:</span>
                <span class="detail-value"><?= date('d M Y H:i', strtotime($item['purchase_date'])) ?></span>
              </div>
            </div>

            <div class="price-section">
              <div class="price-row">
                <span>Harga Tiket:</span>
                <span>Rp <?= number_format($item['total_amount'], 0, ',', '.') ?></span>
              </div>
              <div class="price-row">
                <span>Biaya Admin:</span>
                <span>Rp <?= number_format($item['admin_fee'], 0, ',', '.') ?></span>
              </div>
              <div class="price-row total-price">
                <span>Total:</span>
                <span>Rp <?= number_format($item['total_amount'] + $item['admin_fee'], 0, ',', '.') ?></span>
              </div>
            </div>

            <div class="action-buttons">
              <a href="index.php?controller=booking&action=eTicket&booking_id=<?= $item['booking_id'] ?>"
                class="btn btn-primary">
                <i class="fas fa-print"></i>
                Lihat E-Tiket
              </a>
              <a href="index.php?controller=user&action=pesanan" class="btn btn-secondary">
                <i class="fas fa-plus"></i>
                Pesan Lagi
              </a>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
    <?php endif; ?>
  </div>
</body>

</html>