<?php
// app/view/admin/panelAdmin.php

// Data sudah diproses di controller, langsung gunakan variabel yang dikirim
?>
<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <title>Admin Panel - CinemaTix</title>
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

    .table img {
      transition: transform 0.3s ease;
    }

    .table img:hover {
      transform: scale(1.5);
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
          <a href="index.php?controller=admin&action=index" class="nav-link active">
            📊 Dashboard
          </a>
        </li>
        <li class="nav-item">
          <a href="index.php?controller=admin&action=users" class="nav-link">
            👥 Users
          </a>
        </li>
        <li class="nav-item">
          <a href="index.php?controller=admin&action=sedangTayang" class="nav-link">
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
          <a href="index.php?controller=admin&action=jadwal" class="nav-link">
            📅 Jadwal
          </a>
        </li>
        <li class="nav-item">
          <a href="index.php?controller=admin&action=bookings" class="nav-link">
            🎫 Bookings
          </a>
        </li>
        <li class="nav-item">
          <a href="index.php?controller=admin&action=payments" class="nav-link">
            💳 Payments
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
          <h2 class="fw-bold">Dashboard Admin</h2>
          <p class="text-muted mb-0">Selamat datang, <?= htmlspecialchars($_SESSION['user_name'] ?? 'Admin') ?>!</p>
        </div>
        <div class="text-end">
          <a href="index.php" class="btn btn-success me-2">
            👤 Kembali ke User
          </a>
          <span class="badge bg-warning text-dark">Admin</span>
        </div>
      </div>

      <!-- Stats Cards -->
      <div class="row mb-4">
        <div class="col-md-3">
          <div class="card bg-primary text-white">
            <div class="card-body">
              <div class="d-flex justify-content-between">
                <div>
                  <h4 class="mb-0"><?= $stats['total_film'] ?></h4>
                  <small>Total Film</small>
                </div>
                <div class="align-self-center">
                  <span class="fs-2">🎬</span>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-md-3">
          <div class="card bg-success text-white">
            <div class="card-body">
              <div class="d-flex justify-content-between">
                <div>
                  <h4 class="mb-0"><?= $stats['total_users'] ?></h4>
                  <small>Total Users</small>
                </div>
                <div class="align-self-center">
                  <span class="fs-2">👥</span>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-md-3">
          <div class="card bg-info text-white">
            <div class="card-body">
              <div class="d-flex justify-content-between">
                <div>
                  <h4 class="mb-0"><?= $stats['total_booking'] ?></h4>
                  <small>Total Booking</small>
                </div>
                <div class="align-self-center">
                  <span class="fs-2">🎫</span>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-md-3">
          <div class="card bg-warning text-dark">
            <div class="card-body">
              <div class="d-flex justify-content-between">
                <div>
                  <h4 class="mb-0"><?= $stats['total_news'] ?></h4>
                  <small>Total Berita</small>
                </div>
                <div class="align-self-center">
                  <span class="fs-2">📰</span>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Quick Actions -->
      <div class="row mb-4">
        <div class="col-12">
          <div class="card">
            <div class="card-header">
              <h5 class="mb-0">⚡ Quick Actions</h5>
            </div>
            <div class="card-body">
              <div class="row g-3">
                <div class="col-md-3">
                  <a href="index.php?controller=admin&action=films" class="btn btn-outline-primary w-100">
                    🎬 Kelola Film
                  </a>
                </div>
                <div class="col-md-3">
                  <a href="index.php?controller=admin&action=users" class="btn btn-outline-success w-100">
                    👥 Kelola Users
                  </a>
                </div>
                <div class="col-md-3">
                  <a href="index.php?controller=admin&action=news" class="btn btn-outline-info w-100">
                    📰 Kelola Berita
                  </a>
                </div>
                <div class="col-md-3">
                  <a href="index.php?controller=admin&action=addFilm" class="btn btn-outline-warning w-100">
                    ➕ Tambah Film
                  </a>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Recent Films -->
      <div class="row">
        <div class="col-md-6">
          <div class="card shadow-sm">
            <div class="card-header bg-white d-flex justify-content-between align-items-center py-3">
              <h5 class="card-title mb-0 fw-bold">🎬 Film Terbaru</h5>
              <a href="index.php?controller=admin&action=films" class="btn btn-primary btn-sm">
                Lihat Semua
              </a>
            </div>
            <div class="card-body">
              <?php if (!empty($films)): ?>
                <div class="list-group list-group-flush">
                  <?php foreach (array_slice($films, 0, 5) as $film): ?>
                    <div class="list-group-item d-flex align-items-center">
                      <div class="me-3">
                        <?php if (!empty($film['poster_url'])): ?>
                          <img src="public/uploads/<?= htmlspecialchars($film['poster_url']) ?>" width="50" height="70"
                            class="rounded" alt="Poster" style="object-fit: cover;">
                        <?php else: ?>
                          <div class="bg-secondary rounded d-flex align-items-center justify-content-center"
                            style="width: 50px; height: 70px;">
                            <small class="text-white">No Image</small>
                          </div>
                        <?php endif; ?>
                      </div>
                      <div class="flex-grow-1">
                        <h6 class="mb-1 fw-semibold"><?= htmlspecialchars($film['judul']) ?></h6>
                        <small class="text-muted">
                          <span class="badge bg-info me-1"><?= htmlspecialchars($film['genre']) ?></span>
                          <?= htmlspecialchars($film['durasi']) ?> menit
                        </small>
                      </div>
                      <div class="btn-group btn-group-sm">
                        <a href="index.php?controller=admin&action=editFilm&id=<?= $film['film_id'] ?>"
                          class="btn btn-outline-warning btn-sm">✏️</a>
                        <a href="index.php?controller=admin&action=deleteFilm&id=<?= $film['film_id'] ?>"
                          class="btn btn-outline-danger btn-sm"
                          onclick="return confirm('Yakin ingin menghapus film ini?')">🗑️</a>
                      </div>
                    </div>
                  <?php endforeach; ?>
                </div>
              <?php else: ?>
                <div class="text-center py-4">
                  <div class="fs-2">🎬</div>
                  <p class="text-muted mb-2">Belum ada film</p>
                  <a href="index.php?controller=admin&action=addFilm" class="btn btn-primary btn-sm">
                    Tambah Film Pertama
                  </a>
                </div>
              <?php endif; ?>
            </div>
          </div>
        </div>

        <div class="col-md-6">
          <div class="card shadow-sm">
            <div class="card-header bg-white d-flex justify-content-between align-items-center py-3">
              <h5 class="card-title mb-0 fw-bold">📰 Berita Terbaru</h5>
              <a href="index.php?controller=admin&action=news" class="btn btn-primary btn-sm">
                Lihat Semua
              </a>
            </div>
            <div class="card-body">
              <?php if (!empty($news)): ?>
                <div class="list-group list-group-flush">
                  <?php foreach (array_slice($news, 0, 5) as $item): ?>
                    <div class="list-group-item d-flex align-items-center">
                      <div class="me-3">
                        <?php if (!empty($item['foto_news'])): ?>
                          <img src="public/uploads/<?= htmlspecialchars($item['foto_news']) ?>" width="50" height="50"
                            class="rounded" alt="Foto" style="object-fit: cover;">
                        <?php else: ?>
                          <div class="bg-secondary rounded d-flex align-items-center justify-content-center"
                            style="width: 50px; height: 50px;">
                            <small class="text-white">No Image</small>
                          </div>
                        <?php endif; ?>
                      </div>
                      <div class="flex-grow-1">
                        <h6 class="mb-1 fw-semibold"><?= htmlspecialchars($item['judul_news']) ?></h6>
                        <small class="text-muted">
                          <?= htmlspecialchars(substr($item['deskripsi_news'], 0, 50)) ?>...
                        </small>
                      </div>
                      <div class="btn-group btn-group-sm">
                        <a href="index.php?controller=admin&action=editNews&id=<?= $item['id_news'] ?>"
                          class="btn btn-outline-warning btn-sm">✏️</a>
                        <a href="index.php?controller=admin&action=deleteNews&id=<?= $item['id_news'] ?>"
                          class="btn btn-outline-danger btn-sm"
                          onclick="return confirm('Yakin ingin menghapus berita ini?')">🗑️</a>
                      </div>
                    </div>
                  <?php endforeach; ?>
                </div>
              <?php else: ?>
                <div class="text-center py-4">
                  <div class="fs-2">📰</div>
                  <p class="text-muted mb-2">Belum ada berita</p>
                  <a href="index.php?controller=admin&action=addNews" class="btn btn-primary btn-sm">
                    Tambah Berita Pertama
                  </a>
                </div>
              <?php endif; ?>
            </div>
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