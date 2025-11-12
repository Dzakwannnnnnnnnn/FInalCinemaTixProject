<?php
// app/view/admin/editFilm.php
?>
<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <title>Edit Film - Admin CinemaTix</title>
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
          <h2 class="fw-bold">Edit Film</h2>
          <p class="text-muted mb-0">Edit data film CinemaTix</p>
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
        <div
          class="alert alert-<?php echo $flash['type'] === 'success' ? 'success' : 'danger'; ?> alert-dismissible fade show"
          role="alert">
          <?php echo htmlspecialchars($flash['message']); ?>
          <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
      <?php endif; ?>

      <!-- Edit Film Form -->
      <div class="row justify-content-center">
        <div class="col-md-8">
          <div class="card shadow-sm">
            <div class="card-body p-4">
              <form action="index.php?controller=admin&action=editFilm&id=<?php echo $film['film_id']; ?>" method="POST"
                enctype="multipart/form-data">
                <div class="mb-3">
                  <label for="judul" class="form-label fw-semibold">Judul Film *</label>
                  <input type="text" class="form-control" id="judul" name="judul"
                    value="<?php echo htmlspecialchars($film['judul']); ?>" required>
                </div>

                <div class="mb-3">
                  <label for="genre" class="form-label fw-semibold">Genre *</label>
                  <input type="text" class="form-control" id="genre" name="genre"
                    value="<?php echo htmlspecialchars($film['genre']); ?>" required>
                </div>

                <div class="mb-3">
                  <label for="durasi" class="form-label fw-semibold">Durasi (menit) *</label>
                  <input type="number" class="form-control" id="durasi" name="durasi"
                    value="<?php echo htmlspecialchars($film['durasi']); ?>" min="1" required>
                </div>

                <div class="mb-3">
                  <label for="rating_usia" class="form-label fw-semibold">Rating Usia *</label>
                  <select class="form-select" id="rating_usia" name="rating_usia" required>
                    <option value="">-- Pilih Rating Usia --</option>
                    <option value="SU" <?php echo $film['rating_usia'] === 'SU' ? 'selected' : ''; ?>>SU (Semua Umur)
                    </option>
                    <option value="13+" <?php echo $film['rating_usia'] === '13+' ? 'selected' : ''; ?>>13+</option>
                    <option value="17+" <?php echo $film['rating_usia'] === '17+' ? 'selected' : ''; ?>>17+</option>
                    <option value="21+" <?php echo $film['rating_usia'] === '21+' ? 'selected' : ''; ?>>21+</option>
                  </select>
                </div>

                <div class="mb-3">
                  <label for="rating_bintang" class="form-label fw-semibold">Rating Bintang (1-5)</label>
                  <input type="number" class="form-control" id="rating_bintang" name="rating_bintang" min="1" max="5"
                    step="0.1" value="<?php echo htmlspecialchars($film['rating_bintang'] ?? ''); ?>"
                    placeholder="Contoh: 4.5">
                  <div class="form-text">Opsional: Masukkan rating bintang dari 1.0 sampai 5.0</div>
                </div>

                <div class="mb-3">
                  <label for="deskripsi" class="form-label fw-semibold">Deskripsi</label>
                  <textarea class="form-control" id="deskripsi" name="deskripsi"
                    rows="4"><?php echo htmlspecialchars($film['deskripsi'] ?? ''); ?></textarea>
                </div>

                <div class="mb-3">
                  <label class="form-label fw-semibold">Poster Saat Ini</label>
                  <div class="mb-2">
                    <?php if (!empty($film['poster_url'])): ?>
                      <img src="public/uploads/<?php echo htmlspecialchars($film['poster_url']); ?>" width="150"
                        height="200" class="rounded shadow-sm" alt="Poster" style="object-fit: cover;">
                    <?php else: ?>
                      <div class="bg-secondary rounded d-flex align-items-center justify-content-center"
                        style="width: 150px; height: 200px;">
                        <small class="text-white">No Image</small>
                      </div>
                    <?php endif; ?>
                  </div>
                </div>

                <div class="mb-4">
                  <label for="poster" class="form-label fw-semibold">Ganti Poster Film</label>
                  <input type="file" class="form-control" id="poster" name="poster" accept="image/*">
                  <div class="form-text">Biarkan kosong jika tidak ingin mengganti poster. Format: JPG, PNG, GIF, WebP.
                    Maksimal 5MB.</div>
                </div>

                <div class="d-grid">
                  <button type="submit" class="btn btn-primary btn-lg">
                    <i class="bi bi-pencil-square"></i> Update Film
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