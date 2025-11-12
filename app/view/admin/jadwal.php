<?php
// app/view/admin/jadwal.php

// Data sudah diproses di controller, langsung gunakan variabel yang dikirim
?>
<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <title>Jadwal Management - CinemaTix</title>
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

    .film-card {
      background: #f8f9fa;
      border: 1px solid #dee2e6;
      border-radius: 10px;
      padding: 20px;
      margin-bottom: 20px;
    }

    .schedule-item {
      background: white;
      border: 1px solid #e9ecef;
      border-radius: 8px;
      padding: 15px;
      margin-bottom: 10px;
    }

    .schedule-item:hover {
      box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
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
          <h2 class="fw-bold">📅 Manajemen Jadwal</h2>
          <p class="text-muted mb-0">Kelola jadwal tayang film</p>
        </div>
        <div class="text-end">
          <a href="index.php?controller=admin&action=addJadwal" class="btn btn-success">
            ➕ Tambah Jadwal
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

      <!-- Films and Schedules -->
      <?php if (!empty($films)): ?>
        <?php foreach ($films as $film): ?>
          <div class="film-card">
            <div class="d-flex align-items-center mb-3">
              <div class="me-3">
                <?php if (!empty($film['poster_url'])): ?>
                  <img src="public/uploads/<?= htmlspecialchars($film['poster_url']) ?>" width="80" height="120"
                    class="rounded" alt="Poster" style="object-fit: cover;">
                <?php else: ?>
                  <div class="bg-secondary rounded d-flex align-items-center justify-content-center"
                    style="width: 80px; height: 120px;">
                    <small class="text-white">No Image</small>
                  </div>
                <?php endif; ?>
              </div>
              <div class="flex-grow-1">
                <h4 class="mb-1 fw-bold"><?= htmlspecialchars($film['judul']) ?></h4>
                <p class="mb-1 text-muted">
                  <span class="badge bg-info me-2"><?= htmlspecialchars($film['genre']) ?></span>
                  <?= htmlspecialchars($film['durasi']) ?> menit |
                  Rating: <?= htmlspecialchars($film['rating_usia']) ?>
                </p>
                <p class="mb-0 text-muted small">
                  <?= htmlspecialchars(substr($film['deskripsi'], 0, 100)) ?>...
                </p>
              </div>
            </div>

            <!-- Schedules for this film -->
            <div class="schedules-section">
              <h5 class="mb-3">📅 Jadwal Tayang</h5>
              <?php if (isset($jadwalByFilm[$film['film_id']]) && !empty($jadwalByFilm[$film['film_id']])): ?>
                <div class="row">
                  <?php foreach ($jadwalByFilm[$film['film_id']] as $schedule): ?>
                    <div class="col-md-6 col-lg-4">
                      <div class="schedule-item">
                        <div class="d-flex justify-content-between align-items-start mb-2">
                          <div>
                            <h6 class="mb-1 fw-bold">
                              📅 <?= date('d/m/Y', strtotime($schedule['tanggal'])) ?>
                            </h6>
                            <p class="mb-1 text-primary fw-semibold">
                              🕐 <?= htmlspecialchars($schedule['jam_mulai']) ?>
                            </p>
                            <p class="mb-1">
                              🏢 Studio <?= htmlspecialchars($schedule['nama_studio']) ?>
                              <span class="badge bg-secondary ms-1">
                                <?= htmlspecialchars($schedule['tipe']) ?>
                              </span>
                            </p>
                            <p class="mb-0 text-success fw-semibold">
                              💰 Rp <?= number_format($schedule['harga_tiket'], 0, ',', '.') ?>
                            </p>
                          </div>
                          <div class="btn-group btn-group-sm">
                            <a href="index.php?controller=admin&action=editJadwal&id=<?= $schedule['jadwal_id'] ?>"
                              class="btn btn-outline-warning btn-sm">✏️</a>
                            <a href="index.php?controller=admin&action=deleteJadwal&id=<?= $schedule['jadwal_id'] ?>"
                              class="btn btn-outline-danger btn-sm"
                              onclick="return confirm('Yakin ingin menghapus jadwal ini?')">🗑️</a>
                          </div>
                        </div>
                      </div>
                    </div>
                  <?php endforeach; ?>
                </div>
              <?php else: ?>
                <div class="text-center py-4">
                  <div class="fs-3">📅</div>
                  <p class="text-muted mb-2">Belum ada jadwal untuk film ini</p>
                  <a href="index.php?controller=admin&action=addJadwal&film_id=<?= $film['film_id'] ?>"
                    class="btn btn-primary btn-sm">
                    Tambah Jadwal Pertama
                  </a>
                </div>
              <?php endif; ?>
            </div>
          </div>
        <?php endforeach; ?>
      <?php else: ?>
        <div class="text-center py-5">
          <div class="fs-1">🎬</div>
          <h3 class="text-muted">Belum ada film</h3>
          <p class="text-muted">Tambahkan film terlebih dahulu sebelum membuat jadwal</p>
          <a href="index.php?controller=admin&action=addFilm" class="btn btn-primary">
            Tambah Film
          </a>
        </div>
      <?php endif; ?>
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