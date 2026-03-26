<?php
$flash = getFlashMessage();
?>
<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <title>Kelola Contact & About - CinemaTix</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    .sidebar { background: linear-gradient(135deg, #1a1a1a 0%, #2d2d2d 100%); color: white; }
    .sidebar .nav-link { color: #ddd; padding: 12px 20px; margin: 5px 0; border-radius: 8px; transition: all 0.3s ease; }
    .sidebar .nav-link:hover { background: rgba(255, 204, 0, 0.1); color: #ffcc00; transform: translateX(5px); }
    .sidebar .nav-link.active { background: #ffcc00; color: #000; font-weight: bold; }
    textarea.form-control { min-height: 110px; }
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
        <li class="nav-item"><a href="index.php?controller=admin&action=heroSlides" class="nav-link">Slider Home</a></li>
        <li class="nav-item"><a href="index.php?controller=admin&action=siteContent" class="nav-link active">Contact & About</a></li>
        <li class="nav-item mt-4"><a href="index.php" class="nav-link text-success">Kembali ke User</a></li>
        <li class="nav-item"><a href="index.php?controller=auth&action=logout" class="nav-link text-danger">Logout</a></li>
      </ul>
    </nav>

    <div class="container-fluid p-4" style="margin-left: 280px;">
      <div class="mb-4">
        <h2 class="fw-bold">Kelola Contact & About</h2>
        <p class="text-muted mb-0">Edit informasi contact homepage dan isi halaman About.</p>
      </div>

      <?php if ($flash): ?>
        <div class="alert alert-<?= $flash['type'] === 'success' ? 'success' : 'danger' ?> alert-dismissible fade show" role="alert">
          <?= htmlspecialchars($flash['message']) ?>
          <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
      <?php endif; ?>

      <form method="POST">
        <div class="card shadow-sm mb-4">
          <div class="card-header bg-white">
            <h5 class="mb-0">Section Contact</h5>
          </div>
          <div class="card-body">
            <div class="row g-3">
              <div class="col-12">
                <label class="form-label">Headline Contact</label>
                <textarea name="contact_headline" class="form-control"><?= htmlspecialchars($contact['headline'] ?? '') ?></textarea>
              </div>
              <div class="col-md-6">
                <label class="form-label">Alamat</label>
                <input type="text" name="contact_address" class="form-control" value="<?= htmlspecialchars($contact['address'] ?? '') ?>">
              </div>
              <div class="col-md-6">
                <label class="form-label">Email</label>
                <input type="email" name="contact_email" class="form-control" value="<?= htmlspecialchars($contact['email'] ?? '') ?>">
              </div>
              <div class="col-md-6">
                <label class="form-label">Telepon</label>
                <input type="text" name="contact_phone" class="form-control" value="<?= htmlspecialchars($contact['phone'] ?? '') ?>">
              </div>
              <div class="col-md-6">
                <label class="form-label">Jam Operasional</label>
                <input type="text" name="contact_hours" class="form-control" value="<?= htmlspecialchars($contact['hours'] ?? '') ?>">
              </div>
              <div class="col-md-6">
                <label class="form-label">Badge</label>
                <input type="text" name="contact_badge" class="form-control" value="<?= htmlspecialchars($contact['badge'] ?? '') ?>">
              </div>
              <div class="col-md-6">
                <label class="form-label">Judul Highlight</label>
                <input type="text" name="contact_highlight_title" class="form-control" value="<?= htmlspecialchars($contact['highlight_title'] ?? '') ?>">
              </div>
              <div class="col-md-6">
                <label class="form-label">Isi Highlight</label>
                <textarea name="contact_highlight_body" class="form-control"><?= htmlspecialchars($contact['highlight_body'] ?? '') ?></textarea>
              </div>
              <div class="col-md-6">
                <label class="form-label">Catatan Tambahan</label>
                <textarea name="contact_highlight_note" class="form-control"><?= htmlspecialchars($contact['highlight_note'] ?? '') ?></textarea>
              </div>
            </div>
          </div>
        </div>

        <div class="card shadow-sm mb-4">
          <div class="card-header bg-white">
            <h5 class="mb-0">Halaman About</h5>
          </div>
          <div class="card-body">
            <div class="row g-3">
              <div class="col-md-6">
                <label class="form-label">Judul Hero</label>
                <input type="text" name="about_hero_title" class="form-control" value="<?= htmlspecialchars($about['hero_title'] ?? '') ?>">
              </div>
              <div class="col-md-6">
                <label class="form-label">Subjudul Hero</label>
                <input type="text" name="about_hero_subtitle" class="form-control" value="<?= htmlspecialchars($about['hero_subtitle'] ?? '') ?>">
              </div>
              <div class="col-md-6">
                <label class="form-label">Judul Cerita Kami</label>
                <input type="text" name="about_story_title" class="form-control" value="<?= htmlspecialchars($about['story_title'] ?? '') ?>">
              </div>
              <div class="col-md-6">
                <label class="form-label">Isi Cerita Kami</label>
                <textarea name="about_story_body" class="form-control"><?= htmlspecialchars($about['story_body'] ?? '') ?></textarea>
              </div>
              <div class="col-md-6">
                <label class="form-label">Judul Visi</label>
                <input type="text" name="about_vision_title" class="form-control" value="<?= htmlspecialchars($about['vision_title'] ?? '') ?>">
              </div>
              <div class="col-md-6">
                <label class="form-label">Isi Visi</label>
                <textarea name="about_vision_body" class="form-control"><?= htmlspecialchars($about['vision_body'] ?? '') ?></textarea>
              </div>
              <div class="col-md-6">
                <label class="form-label">Judul Misi</label>
                <input type="text" name="about_mission_title" class="form-control" value="<?= htmlspecialchars($about['mission_title'] ?? '') ?>">
              </div>
              <div class="col-md-6">
                <label class="form-label">Isi Misi</label>
                <textarea name="about_mission_body" class="form-control"><?= htmlspecialchars($about['mission_body'] ?? '') ?></textarea>
              </div>
              <div class="col-12">
                <label class="form-label">Closing Text</label>
                <textarea name="about_closing_text" class="form-control"><?= htmlspecialchars($about['closing_text'] ?? '') ?></textarea>
              </div>
            </div>
          </div>
        </div>

        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
      </form>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
