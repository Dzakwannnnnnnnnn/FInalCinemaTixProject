<?php
// app/view/admin/editNews.php
?>
<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <title>Edit Berita - Admin CinemaTix</title>
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
          <a href="index.php?controller=admin&action=news" class="nav-link active">
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
          <h2 class="fw-bold">Edit Berita</h2>
          <p class="text-muted mb-0">Edit berita CinemaTix</p>
        </div>
        <div class="text-end">
          <a href="index.php?controller=admin&action=news" class="btn btn-secondary">
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

      <!-- Edit News Form -->
      <div class="row justify-content-center">
        <div class="col-md-8">
          <div class="card shadow-sm">
            <div class="card-body p-4">
              <form action="index.php?controller=admin&action=editNews&id=<?= $newsItem['id_news'] ?>" method="POST"
                enctype="multipart/form-data">
                <div class="mb-3">
                  <label for="judul_news" class="form-label fw-semibold">Judul Berita *</label>
                  <input type="text" class="form-control" id="judul_news" name="judul_news"
                    value="<?= htmlspecialchars($newsItem['judul_news']) ?>" required>
                </div>

                <div class="mb-3">
                  <label for="deskripsi_news" class="form-label fw-semibold">Deskripsi Berita *</label>
                  <textarea class="form-control" id="deskripsi_news" name="deskripsi_news" rows="6"
                    required><?= htmlspecialchars($newsItem['deskripsi_news']) ?></textarea>
                </div>

                <div class="mb-3">
                  <label class="form-label fw-semibold">Foto Saat Ini</label>
                  <div class="mb-2">
                    <?php if (!empty($newsItem['foto_news'])): ?>
                      <img src="public/uploads/<?= htmlspecialchars($newsItem['foto_news']) ?>" width="150" height="150"
                        class="rounded shadow-sm" alt="Foto" style="object-fit: cover;">
                    <?php else: ?>
                      <div class="bg-secondary rounded d-flex align-items-center justify-content-center"
                        style="width: 150px; height: 150px;">
                        <small class="text-white">No Image</small>
                      </div>
                    <?php endif; ?>
                  </div>
                </div>

                <div class="mb-4">
                  <label for="foto_news" class="form-label fw-semibold">Ganti Foto Berita</label>
                  <input type="file" class="form-control" id="foto_news" name="foto_news" accept="image/*">
                  <div class="form-text">Biarkan kosong jika tidak ingin mengganti foto. Format: JPG, PNG, GIF, WebP.
                    Maksimal 5MB.</div>
                </div>

                <div class="d-grid">
                  <button type="submit" class="btn btn-primary btn-lg">
                    <i class="bi bi-pencil-square"></i> Update Berita
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