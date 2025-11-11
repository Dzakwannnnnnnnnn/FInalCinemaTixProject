<?php
// app/view/admin/addStudio.php
?>
<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <title>Tambah Studio - Admin CinemaTix</title>
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
          <a href="index.php?controller=admin&action=studio" class="nav-link active">
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
          <h2 class="fw-bold">Tambah Studio</h2>
          <p class="text-muted mb-0">Tambah data studio CinemaTix</p>
        </div>
        <div class="text-end">
          <a href="index.php?controller=admin&action=studio" class="btn btn-secondary">
            ← Kembali
          </a>
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

      <!-- Add Studio Form -->
      <div class="row justify-content-center">
        <div class="col-md-8">
          <div class="card shadow-sm">
            <div class="card-body p-4">
              <form action="index.php?controller=admin&action=addStudio" method="POST">
                <div class="mb-3">
                  <label for="nama_studio" class="form-label fw-semibold">Nama Studio *</label>
                  <input type="text" class="form-control" id="nama_studio" name="nama_studio" required>
                </div>

                <div class="mb-3">
                  <label for="tipe" class="form-label fw-semibold">Tipe Studio *</label>
                  <select class="form-select" id="tipe" name="tipe" required>
                    <option value="">-- Pilih Tipe Studio --</option>
                    <option value="2D">2D</option>
                    <option value="3D">3D</option>
                    <option value="IMAX">IMAX</option>
                    <option value="4DX">4DX</option>
                  </select>
                </div>

                <div class="mb-4">
                  <label for="kapasitas" class="form-label fw-semibold">Kapasitas (orang) *</label>
                  <input type="number" class="form-control" id="kapasitas" name="kapasitas" min="1" required>
                </div>

                <div class="d-grid">
                  <button type="submit" class="btn btn-primary btn-lg">
                    <i class="bi bi-plus-circle"></i> Tambah Studio
                  </button>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
