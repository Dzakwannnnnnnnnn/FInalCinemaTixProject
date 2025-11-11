<?php
// app/view/admin/news.php
?>
<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <title>Kelola Berita - Admin CinemaTix</title>
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
          <h2 class="fw-bold">Kelola Berita</h2>
          <p class="text-muted mb-0">Kelola berita dan event CinemaTix</p>
        </div>
        <div class="text-end">
          <a href="index.php?controller=admin&action=addNews" class="btn btn-primary">
            ➕ Tambah Berita
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

      <!-- News Table -->
      <div class="card shadow-sm">
        <div class="card-body">
          <?php if (!empty($news)): ?>
            <div class="table-responsive">
              <table class="table table-striped table-hover">
                <thead class="table-dark">
                  <tr>
                    <th>ID</th>
                    <th>Foto</th>
                    <th>Judul</th>
                    <th>Deskripsi</th>
                    <th>Aksi</th>
                  </tr>
                </thead>
                <tbody>
                  <?php foreach ($news as $item): ?>
                    <tr>
                      <td class="fw-bold"><?= htmlspecialchars($item['id_news']) ?></td>
                      <td>
                        <?php if (!empty($item['foto_news'])): ?>
                          <img src="public/uploads/<?= htmlspecialchars($item['foto_news']) ?>" width="60" height="60"
                            class="rounded shadow-sm" alt="Foto <?= htmlspecialchars($item['judul_news']) ?>"
                            style="object-fit: cover;">
                        <?php else: ?>
                          <div class="bg-secondary rounded d-flex align-items-center justify-content-center"
                            style="width: 60px; height: 60px;">
                            <small class="text-white">No Image</small>
                          </div>
                        <?php endif; ?>
                      </td>
                      <td class="fw-semibold"><?= htmlspecialchars($item['judul_news']) ?></td>
                      <td>
                        <div style="max-width: 300px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">
                          <?= htmlspecialchars($item['deskripsi_news']) ?>
                        </div>
                      </td>
                      <td>
                        <div class="btn-group btn-group-sm">
                          <a href="index.php?controller=admin&action=editNews&id=<?= $item['id_news'] ?>"
                            class="btn btn-outline-warning">
                            ✏️ Edit
                          </a>
                          <a href="index.php?controller=admin&action=deleteNews&id=<?= $item['id_news'] ?>"
                            class="btn btn-outline-danger" onclick="return confirm('Yakin ingin menghapus berita ini?')">
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
              <div class="fs-1">📰</div>
              <h5 class="text-muted">Tidak ada data berita</h5>
              <p class="text-muted">Mulai dengan menambahkan berita pertama Anda</p>
              <a href="index.php?controller=admin&action=addNews" class="btn btn-primary">
                Tambah Berita Pertama
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