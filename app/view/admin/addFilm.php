<?php
// app/view/admin/addFilm.php
?>
<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <title>Tambah Film - Admin CinemaTix</title>
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
          <a href="index.php?controller=admin&action=films" class="nav-link active">
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
          <h2 class="fw-bold">Tambah Film</h2>
          <p class="text-muted mb-0">Tambah film baru ke CinemaTix</p>
        </div>
        <div class="text-end">
          <a href="index.php?controller=admin&action=films" class="btn btn-secondary">
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

      <!-- Add Film Form -->
      <div class="row justify-content-center">
        <div class="col-md-8">
          <div class="card shadow-sm">
            <div class="card-body p-4">
              <form action="index.php?controller=admin&action=addFilm" method="POST" enctype="multipart/form-data">
                <div class="mb-3">
                  <label for="judul" class="form-label fw-semibold">Judul Film *</label>
                  <input type="text" class="form-control" id="judul" name="judul" required>
                </div>

                <div class="mb-3">
                  <label for="genre" class="form-label fw-semibold">Genre *</label>
                  <input type="text" class="form-control" id="genre" name="genre" required>
                </div>

                <div class="mb-3">
                  <label for="durasi" class="form-label fw-semibold">Durasi (menit) *</label>
                  <input type="number" class="form-control" id="durasi" name="durasi" min="1" required>
                </div>

                <div class="mb-3">
                  <label for="rating_usia" class="form-label fw-semibold">Rating Usia *</label>
                  <select class="form-select" id="rating_usia" name="rating_usia" required>
                    <option value="">-- Pilih Rating Usia --</option>
                    <option value="SU">SU (Semua Umur)</option>
                    <option value="13+">13+</option>
                    <option value="17+">17+</option>
                    <option value="21+">21+</option>
                  </select>
                </div>

                <div class="mb-3">
                  <label for="rating_bintang" class="form-label fw-semibold">Rating Bintang (1-5)</label>
                  <input type="number" class="form-control" id="rating_bintang" name="rating_bintang" min="1" max="5"
                    step="0.1" placeholder="Contoh: 4.5">
                  <div class="form-text">Opsional: Masukkan rating bintang dari 1.0 sampai 5.0</div>
                </div>

                <div class="mb-3">
                  <label for="deskripsi" class="form-label fw-semibold">Deskripsi</label>
                  <textarea class="form-control" id="deskripsi" name="deskripsi" rows="4"></textarea>
                </div>

                <div class="mb-4">
                  <label for="poster" class="form-label fw-semibold">Poster Film</label>
                  <input type="file" class="form-control" id="poster" name="poster" accept="image/*">
                  <div class="form-text">Format: JPG, PNG, GIF, WebP. Maksimal 5MB.</div>
                </div>

                <div class="d-grid">
                  <button type="submit" class="btn btn-primary btn-lg">
                    <i class="bi bi-plus-circle"></i> Tambah Film
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