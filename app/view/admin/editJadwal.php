<?php
// app/view/admin/editJadwal.php

// Data sudah diproses di controller, langsung gunakan variabel yang dikirim
?>
<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <title>Edit Jadwal - CinemaTix</title>
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

    .form-container {
      background: white;
      border-radius: 15px;
      padding: 30px;
      box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
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
          <a href="index.php?controller=admin&action=kursi" class="nav-link">
            💺 Kursi
          </a>
        </li>
        <li class="nav-item">
          <a href="index.php?controller=admin&action=jadwal" class="nav-link active">
            📅 Jadwal
          </a>
        </li>
        <li class="nav-item">
          <a href="index.php?controller=admin&action=pesananTiket" class="nav-link">
            🎫 Booking
          </a>
        </li>
        <li class="nav-item">
          <a href="index.php?controller=admin&action=pembayaran" class="nav-link">
            💳 Pembayaran
          </a>
        </li>
        <li class="nav-item">
          <a href="index.php?controller=admin&action=beritaEvent" class="nav-link">
            📰 Berita & Event
          </a>
        </li>
        <li class="nav-item mt-4">
          <a href="index.php" class="nav-link text-success">
            👤 Kembali ke User
          </a>
        </li>
        <li class="nav-item">
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
          <h2 class="fw-bold">✏️ Edit Jadwal</h2>
          <p class="text-muted mb-0">Ubah informasi jadwal tayang</p>
        </div>
        <div class="text-end">
          <a href="index.php?controller=admin&action=jadwal" class="btn btn-secondary">
            ← Kembali ke Jadwal
          </a>
        </div>
      </div>

      <!-- Flash Messages -->
      <?php if (isset($_SESSION['flash_message'])): ?>
        <div class="alert alert-<?= $_SESSION['flash_message']['type'] ?> alert-dismissible fade show" role="alert">
          <?= htmlspecialchars($_SESSION['flash_message']['message']) ?>
          <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        <?php unset($_SESSION['flash_message']); ?>
      <?php endif; ?>

      <!-- Form -->
      <div class="row justify-content-center">
        <div class="col-lg-8">
          <div class="form-container">
            <form action="index.php?controller=admin&action=editJadwal&id=<?= $jadwal['jadwal_id'] ?>" method="POST">
              <div class="row">
                <div class="col-md-6 mb-3">
                  <label for="film_id" class="form-label fw-semibold">🎬 Film</label>
                  <select class="form-select" id="film_id" name="film_id" required>
                    <option value="">-- Pilih Film --</option>
                    <?php foreach ($films as $film): ?>
                      <option value="<?= $film['film_id'] ?>" <?= ($jadwal['film_id'] == $film['film_id']) ? 'selected' : '' ?>>
                        <?= htmlspecialchars($film['judul']) ?>
                      </option>
                    <?php endforeach; ?>
                  </select>
                </div>

                <div class="col-md-6 mb-3">
                  <label for="studio_id" class="form-label fw-semibold">🏢 Studio</label>
                  <select class="form-select" id="studio_id" name="studio_id" required>
                    <option value="">-- Pilih Studio --</option>
                    <?php foreach ($studios as $studio): ?>
                      <option value="<?= $studio['studio_id'] ?>" <?= ($jadwal['studio_id'] == $studio['studio_id']) ? 'selected' : '' ?>>
                        <?= htmlspecialchars($studio['nama_studio']) ?> (<?= htmlspecialchars($studio['tipe']) ?>)
                      </option>
                    <?php endforeach; ?>
                  </select>
                </div>
              </div>

              <div class="row">
                <div class="col-md-6 mb-3">
                  <label for="tanggal" class="form-label fw-semibold">📅 Tanggal</label>
                  <input type="date" class="form-control" id="tanggal" name="tanggal"
                    value="<?= htmlspecialchars($jadwal['tanggal']) ?>" required>
                </div>

                <div class="col-md-6 mb-3">
                  <label for="jam_mulai" class="form-label fw-semibold">🕐 Jam Mulai</label>
                  <select class="form-select" id="jam_mulai" name="jam_mulai" required>
                    <option value="">-- Pilih Jam --</option>
                    <option value="11:30" <?= ($jadwal['jam_mulai'] == '11:30') ? 'selected' : '' ?>>11:30</option>
                    <option value="13:00" <?= ($jadwal['jam_mulai'] == '13:00') ? 'selected' : '' ?>>13:00</option>
                    <option value="15:30" <?= ($jadwal['jam_mulai'] == '15:30') ? 'selected' : '' ?>>15:30</option>
                    <option value="18:00" <?= ($jadwal['jam_mulai'] == '18:00') ? 'selected' : '' ?>>18:00</option>
                    <option value="20:30" <?= ($jadwal['jam_mulai'] == '20:30') ? 'selected' : '' ?>>20:30</option>
                    <option value="22:00" <?= ($jadwal['jam_mulai'] == '22:00') ? 'selected' : '' ?>>22:00</option>
                  </select>
                </div>
              </div>

              <div class="mb-3">
                <label for="harga_tiket" class="form-label fw-semibold">💰 Harga Tiket (Rp)</label>
                <input type="number" class="form-control" id="harga_tiket" name="harga_tiket"
                  value="<?= htmlspecialchars($jadwal['harga_tiket']) ?>" min="0" step="1000" required>
              </div>

              <div class="d-flex gap-2 mt-4">
                <button type="submit" class="btn btn-success btn-lg">
                  💾 Update Jadwal
                </button>
                <a href="index.php?controller=admin&action=jadwal" class="btn btn-secondary btn-lg">
                  ❌ Batal
                </a>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    // Highlight active menu
    document.addEventListener('DOMContentLoaded', function () {
      const currentPage = window.location.href;
      const navLinks = document.querySelectorAll('.nav-link');

      navLinks.forEach(link => {
        if (link.href === currentPage) {
          link.classList.add('active');
        }
      });
    });
  </script>
</body>

</html>