<?php
// app/view/admin/heroSlides.php
$flash = getFlashMessage();
?>
<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <title>Kelola Slider Home - CinemaTix</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    .sidebar { background: linear-gradient(135deg, #1a1a1a 0%, #2d2d2d 100%); color: white; }
    .sidebar .nav-link { color: #ddd; padding: 12px 20px; margin: 5px 0; border-radius: 8px; transition: all 0.3s ease; }
    .sidebar .nav-link:hover { background: rgba(255, 204, 0, 0.1); color: #ffcc00; transform: translateX(5px); }
    .sidebar .nav-link.active { background: #ffcc00; color: #000; font-weight: bold; }
    .slide-thumb { width: 100%; max-height: 180px; object-fit: cover; border-radius: 8px; border: 1px solid #ddd; }
    .card-title { font-weight: 700; }
  </style>
</head>

<body class="bg-light">
  <div class="d-flex">
    <nav class="sidebar p-3" style="width: 280px; height: 100vh; position: fixed; top: 0; left: 0; overflow-y: auto;">
      <div class="text-center mb-4">
        <h4 class="fw-bold" style="color: #ffcc00;">Admin CinemaTix</h4>
        <small class="text-muted">Management System</small>
      </div>
      <ul class="nav flex-column">
        <li class="nav-item"><a href="index.php?controller=admin&action=index" class="nav-link">Dashboard</a></li>
        <li class="nav-item"><a href="index.php?controller=admin&action=users" class="nav-link">Users</a></li>
        <li class="nav-item"><a href="index.php?controller=admin&action=films" class="nav-link">Film</a></li>
        <li class="nav-item"><a href="index.php?controller=admin&action=studio" class="nav-link">Studio</a></li>
        <li class="nav-item"><a href="index.php?controller=admin&action=kursi" class="nav-link">Kursi</a></li>
        <li class="nav-item"><a href="index.php?controller=admin&action=jadwal" class="nav-link">Jadwal</a></li>
        <li class="nav-item"><a href="index.php?controller=admin&action=bookings" class="nav-link">Bookings</a></li>
        <li class="nav-item"><a href="index.php?controller=admin&action=payments" class="nav-link">Payments</a></li>
        <li class="nav-item"><a href="index.php?controller=admin&action=news" class="nav-link">Berita & Event</a></li>
        <li class="nav-item"><a href="index.php?controller=admin&action=heroSlides" class="nav-link active">Slider Home</a></li>
        <li class="nav-item"><a href="index.php?controller=admin&action=siteContent" class="nav-link">Contact & About</a></li>
        <li class="nav-item mt-4"><a href="index.php" class="nav-link text-success">Kembali ke User</a></li>
        <li class="nav-item"><a href="index.php?controller=auth&action=logout" class="nav-link text-danger">Logout</a></li>
      </ul>
    </nav>

    <div class="container-fluid p-4" style="margin-left: 280px;">
      <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
          <h2 class="fw-bold">Kelola Slider Homepage</h2>
          <p class="text-muted mb-0">Tambah, edit, urutkan, dan hapus foto slide halaman utama</p>
        </div>
      </div>

      <?php if ($flash): ?>
        <div class="alert alert-<?= $flash['type'] === 'success' ? 'success' : 'danger' ?> alert-dismissible fade show" role="alert">
          <?= htmlspecialchars($flash['message']) ?>
          <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
      <?php endif; ?>

      <div class="card shadow-sm mb-4">
        <div class="card-header bg-white">
          <h5 class="mb-0">Tambah Slide Baru</h5>
        </div>
        <div class="card-body">
          <form method="POST" enctype="multipart/form-data">
            <input type="hidden" name="operation" value="add">
            <div class="row g-3">
              <div class="col-md-4">
                <label class="form-label">Foto Slide</label>
                <input type="file" name="slide_image" class="form-control" accept="image/*" required>
              </div>
              <div class="col-md-4">
                <label class="form-label">Judul</label>
                <input type="text" name="title" class="form-control" placeholder="Contoh: Nikmati Pengalaman Nonton">
              </div>
              <div class="col-md-4">
                <label class="form-label">Teks Tombol</label>
                <input type="text" name="button_text" class="form-control" value="Pesan Tiket Sekarang">
              </div>
              <div class="col-md-8">
                <label class="form-label">Subjudul</label>
                <input type="text" name="subtitle" class="form-control" placeholder="Contoh: Temukan film terbaru...">
              </div>
              <div class="col-md-4">
                <label class="form-label">Link Tombol</label>
                <input type="text" name="button_link" class="form-control" value="index.php?controller=user&action=pesanan">
              </div>
              <div class="col-12">
                <button type="submit" class="btn btn-primary">Tambah Slide</button>
              </div>
            </div>
          </form>
        </div>
      </div>

      <div class="row g-4">
        <?php if (!empty($slides)): ?>
          <?php foreach ($slides as $slide): ?>
            <div class="col-md-6 col-xl-4">
              <div class="card shadow-sm h-100">
                <div class="card-body">
                  <img src="<?= htmlspecialchars($slide['image'] ?? '') ?>" alt="Slide" class="slide-thumb mb-3"
                    onerror="this.src='https://via.placeholder.com/600x300?text=Image+Not+Found'">

                  <form method="POST" enctype="multipart/form-data" class="mb-2">
                    <input type="hidden" name="operation" value="update">
                    <input type="hidden" name="id" value="<?= (int) ($slide['id'] ?? 0) ?>">

                    <div class="mb-2">
                      <label class="form-label">Ganti Foto (opsional)</label>
                      <input type="file" name="slide_image" class="form-control form-control-sm" accept="image/*">
                    </div>
                    <div class="mb-2">
                      <label class="form-label">Urutan</label>
                      <input type="number" name="sort_order" class="form-control form-control-sm"
                        value="<?= (int) ($slide['sort_order'] ?? 0) ?>">
                    </div>
                    <div class="mb-2">
                      <label class="form-label">Judul</label>
                      <input type="text" name="title" class="form-control form-control-sm"
                        value="<?= htmlspecialchars($slide['title'] ?? '') ?>">
                    </div>
                    <div class="mb-2">
                      <label class="form-label">Subjudul</label>
                      <input type="text" name="subtitle" class="form-control form-control-sm"
                        value="<?= htmlspecialchars($slide['subtitle'] ?? '') ?>">
                    </div>
                    <div class="mb-2">
                      <label class="form-label">Teks Tombol</label>
                      <input type="text" name="button_text" class="form-control form-control-sm"
                        value="<?= htmlspecialchars($slide['button_text'] ?? 'Pesan Tiket Sekarang') ?>">
                    </div>
                    <div class="mb-3">
                      <label class="form-label">Link Tombol</label>
                      <input type="text" name="button_link" class="form-control form-control-sm"
                        value="<?= htmlspecialchars($slide['button_link'] ?? 'index.php?controller=user&action=pesanan') ?>">
                    </div>

                    <div class="d-flex gap-2">
                      <button type="submit" class="btn btn-sm btn-outline-primary">Simpan</button>
                    </div>
                  </form>

                  <form method="POST" onsubmit="return confirm('Yakin hapus slide ini?')">
                    <input type="hidden" name="operation" value="delete">
                    <input type="hidden" name="id" value="<?= (int) ($slide['id'] ?? 0) ?>">
                    <button type="submit" class="btn btn-sm btn-outline-danger">Hapus Slide</button>
                  </form>
                </div>
              </div>
            </div>
          <?php endforeach; ?>
        <?php else: ?>
          <div class="col-12">
            <div class="alert alert-warning mb-0">Belum ada slide. Tambahkan slide pertama.</div>
          </div>
        <?php endif; ?>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
