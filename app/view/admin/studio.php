<?php
// app/view/admin/studio.php
?>
<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <title>Kelola Studio - Admin CinemaTix</title>
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
          <h2 class="fw-bold">Kelola Studio</h2>
          <p class="text-muted mb-0">Kelola data studio CinemaTix</p>
        </div>
        <div class="text-end">
          <a href="index.php?controller=admin&action=addStudio" class="btn btn-primary">
            ➕ Tambah Studio
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

      <!-- Studios Table -->
      <div class="card shadow-sm">
        <div class="card-body">
          <?php if (!empty($studios)): ?>
            <div class="table-responsive">
              <table class="table table-striped table-hover">
                <thead class="table-dark">
                  <tr>
                    <th>ID</th>
                    <th>Nama Studio</th>
                    <th>Tipe</th>
                    <th>Kapasitas</th>
                    <th>Aksi</th>
                  </tr>
                </thead>
                <tbody>
                  <?php foreach ($studios as $studio): ?>
                    <tr>
                      <td class="fw-bold"><?= htmlspecialchars($studio['studio_id']) ?></td>
                      <td class="fw-semibold"><?= htmlspecialchars($studio['nama_studio']) ?></td>
                      <td>
                        <span class="badge bg-info"><?= htmlspecialchars($studio['tipe']) ?></span>
                      </td>
                      <td><?= htmlspecialchars($studio['kapasitas']) ?> orang</td>
                      <td>
                        <div class="btn-group btn-group-sm">
                          <a href="index.php?controller=admin&action=editStudio&id=<?= $studio['studio_id'] ?>"
                            class="btn btn-outline-warning">
                            ✏️ Edit
                          </a>
                          <a href="index.php?controller=admin&action=deleteStudio&id=<?= $studio['studio_id'] ?>"
                            class="btn btn-outline-danger" onclick="return confirm('Yakin ingin menghapus studio ini?')">
                            🗑️ Hapus
                          </a>
                        </div>
                      </td>
                    </tr>
                  <?php endforeach; ?>
                </tbody>
              </table>
            </div>
          <?php else: ?>
            <div class="text-center py-5">
              <div class="fs-1">🏢</div>
              <h5 class="text-muted">Tidak ada data studio</h5>
              <p class="text-muted">Mulai dengan menambahkan studio pertama Anda</p>
              <a href="index.php?controller=admin&action=addStudio" class="btn btn-primary">
                Tambah Studio Pertama
              </a>
            </div>
          <?php endif; ?>
        </div>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>