<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <title>Admin Panel - CinemaTix</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    .sidebar { background: linear-gradient(135deg, #1a1a1a 0%, #2d2d2d 100%); color: white; }
    .sidebar .nav-link { color: #ddd; padding: 12px 20px; margin: 5px 0; border-radius: 8px; transition: all 0.3s ease; }
    .sidebar .nav-link:hover { background: rgba(255, 204, 0, 0.1); color: #ffcc00; transform: translateX(5px); }
    .sidebar .nav-link.active { background: #ffcc00; color: #000; font-weight: bold; }
    .table img { transition: transform 0.3s ease; }
    .table img:hover { transform: scale(1.5); }
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
        <li class="nav-item"><a href="index.php?controller=admin&action=siteContent" class="nav-link">Contact & About</a></li>
        <li class="nav-item mt-4"><a href="index.php" class="nav-link text-success">Kembali ke User</a></li>
        <li class="nav-item"><a href="index.php?controller=auth&action=logout" class="nav-link text-danger">Logout</a></li>
      </ul>
    </nav>

    <div class="container-fluid p-4" style="margin-left: 280px;">
