<?php
// app/view/admin/kursi.php
?>
<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <title>Kelola Kursi - Admin CinemaTix</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    .sidebar {
      background: linear-gradient(135deg, #1a1a1a 0%, #2d2d2d 100%);
      color: white;
    }

    .sidebar .nav-link {
      color: #ddd;
      padding: 12px 20px;
      margin: 5px 0;
      border-radius: 8px;
      transition: all 0.3s ease;
    }

    .sidebar .nav-link:hover {
      background: rgba(255, 204, 0, 0.1);
      color: #ffcc00;
      transform: translateX(5px);
    }

    .sidebar .nav-link.active {
      background: #ffcc00;
      color: #000;
      font-weight: bold;
    }

    .seat-grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(50px, 1fr));
      gap: 10px;
      max-width: 800px;
      margin: 0 auto;
    }

    .seat {
      width: 40px;
      height: 40px;
      border-radius: 6px;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 10px;
      font-weight: bold;
      cursor: pointer;
      transition: all 0.3s;
      border: 2px solid;
    }

    .seat.aktif {
      background-color: #28a745;
      border-color: #28a745;
      color: white;
    }

    .seat.tidak-aktif {
      background-color: #6c757d;
      border-color: #6c757d;
      color: white;
    }

    .seat.booked {
      background-color: #dc3545;
      border-color: #dc3545;
      color: white;
      cursor: not-allowed;
    }

    .seat:hover:not(.booked) {
      transform: scale(1.1);
    }

    .screen {
      background-color: #333;
      height: 20px;
      border-radius: 10px;
      margin: 20px 0 40px 0;
      display: flex;
      align-items: center;
      justify-content: center;
      color: #fff;
      font-weight: bold;
    }

    .legend {
      display: flex;
      justify-content: center;
      gap: 20px;
      margin: 20px 0;
    }

    .legend-item {
      display: flex;
      align-items: center;
      gap: 8px;
      color: #333;
    }

    .legend-seat {
      width: 20px;
      height: 20px;
      border-radius: 4px;
    }
  </style>
</head>

<body class="bg-light">
  <div class="d-flex">
    <!-- Sidebar -->
    <nav class="sidebar p-3" style="width: 280px; min-height: 100vh; position: fixed;">
      <div class="text-center mb-4">
        <h4 class="fw-bold" style="color: #ffcc00;">🎬 Admin CinemaTix</h4>
        <small class="text-muted">Management System</small>
      </div>

      <ul class="nav flex-column">
        <li class="nav-item">
          <a href="index.php?controller=admin&action=index" class="nav-link">
            📊 Dashboard
          </a>
        </li>
        <li class="nav-item">
          <a href="index.php?controller=admin&action=users" class="nav-link">
            👥 Users
          </a>
        </li>
        <li class="nav-item">
          <a href="index.php?controller=admin&action=films" class="nav-link">
            🎞️ Film
          </a>
        </li>
        <li class="nav-item">
          <a href="index.php?controller=admin&action=studio" class="nav-link">
            🏢 Studio
          </a>
        </li>
        <li class="nav-item">
          <a href="index.php?controller=admin&action=kursi" class="nav-link active">
            💺 Kursi
          </a>
        </li>
        <li class="nav-item">
          <a href="index.php?controller=admin&action=jadwal" class="nav-link">
            📅 Jadwal
          </a>
        </li>
        <li class="nav-item">
          <a href="index.php?controller=admin&action=bookings" class="nav-link">
            🎫 Booking
          </a>
        </li>
        <li class="nav-item">
          <a href="index.php?controller=admin&action=payments" class="nav-link">
            💳 Payments
          </a>
        </li>
        <li class="nav-item">
          <a href="index.php?controller=admin&action=news" class="nav-link">
            📰 Berita & Event
          </a>
        </li>
        <li class="nav-item mt-4">
          <a href="index.php?controller=auth&action=logout" class="nav-link text-danger">
            🚪 Logout
          </a>
        </li>
      </ul>
    </nav>

    <!-- Main Content -->
    <div class="container-fluid p-4" style="margin-left: 280px;">
      <!-- Header -->
      <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
          <h2 class="fw-bold">Kelola Kursi</h2>
          <p class="text-muted mb-0">Kelola kursi untuk setiap studio</p>
        </div>
      </div>

      <!-- Flash Message -->
      <?php
      $flash = getFlashMessage();
      if ($flash): ?>
        <div class="alert alert-<?= $flash['type'] === 'success' ? 'success' : 'danger' ?> alert-dismissible fade show"
          role="alert">
          <?= htmlspecialchars($flash['message']) ?>
          <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
      <?php endif; ?>

      <!-- Studio Selection -->
      <div class="card shadow-sm mb-4">
        <div class="card-body">
          <form method="GET" action="index.php">
            <input type="hidden" name="controller" value="admin">
            <input type="hidden" name="action" value="kursi">
            <div class="row">
              <div class="col-md-6">
                <label for="studio_id" class="form-label">Pilih Studio</label>
                <select name="studio_id" id="studio_id" class="form-select" onchange="this.form.submit()">
                  <option value="">-- Pilih Studio --</option>
                  <?php foreach ($studios as $studio): ?>
                    <option value="<?= $studio['studio_id'] ?>" <?= isset($_GET['studio_id']) && $_GET['studio_id'] == $studio['studio_id'] ? 'selected' : '' ?>>
                      <?= htmlspecialchars($studio['nama_studio']) ?> (<?= htmlspecialchars($studio['tipe']) ?>,
                      Kapasitas: <?= $studio['kapasitas'] ?>)
                    </option>
                  <?php endforeach; ?>
                </select>
              </div>
            </div>
          </form>
        </div>
      </div>

      <?php if ($selectedStudio): ?>
        <!-- Seat Layout -->
        <div class="card shadow-sm">
          <div class="card-header">
            <h5 class="mb-0">Layout Kursi - <?= htmlspecialchars($selectedStudio['nama_studio']) ?></h5>
          </div>
          <div class="card-body">
            <!-- Screen -->
            <div class="screen">LAYAR</div>

            <!-- Seats -->
            <div class="d-flex gap-4 flex-wrap justify-content-center">
              <?php
              // Group seats by row
              $seatsByRow = [];
              foreach ($kursi as $seat) {
                $row = substr($seat['nomor_kursi'], 0, 1);
                $seatsByRow[$row][] = $seat;
              }

              foreach ($seatsByRow as $row => $seats): ?>
                <div class="d-flex flex-column align-items-center">
                  <strong style="color: #ffcc00; font-size: 18px; margin-bottom: 10px;"><?= $row ?></strong>
                  <div class="d-flex gap-2 justify-content-center">
                    <?php foreach ($seats as $seat): ?>
                      <form method="POST" class="d-inline">
                        <input type="hidden" name="kursi_id" value="<?= $seat['kursi_id'] ?>">
                        <input type="hidden" name="status"
                          value="<?= $seat['status'] === 'aktif' ? 'tidak aktif' : 'aktif' ?>">
                        <button type="submit" class="btn seat <?= $seat['status'] ?>"
                          title="Klik untuk toggle status (<?= $seat['nomor_kursi'] ?>)">
                          <?= htmlspecialchars($seat['nomor_kursi']) ?>
                        </button>
                      </form>
                    <?php endforeach; ?>
                  </div>
                </div>
              <?php endforeach; ?>
            </div>

            <!-- Legend -->
            <div class="legend">
              <div class="legend-item">
                <div class="legend-seat aktif"></div>
                <span>Aktif</span>
              </div>
              <div class="legend-item">
                <div class="legend-seat tidak-aktif"></div>
                <span>Tidak Aktif</span>
              </div>
              <div class="legend-item">
                <div class="legend-seat booked"></div>
                <span>Dipesan</span>
              </div>
            </div>
          </div>
        </div>
      <?php endif; ?>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>