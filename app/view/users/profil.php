<?php
session_start();

// Cek apakah user sudah login
if (!isset($_SESSION['user_id'])) {
  header("Location: loginUser.php");
  exit();
}

// Panggil koneksi database
include 'koneksi.php';

// Ambil data user dari database berdasarkan session
$user_id = $_SESSION['user_id'];
$query = $mysqli->prepare("SELECT nama, email, created_at FROM users WHERE id = ?");
$query->bind_param("i", $user_id);
$query->execute();
$result = $query->get_result();
$user = $result->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Profil Saya | Cinematix</title>
  <link rel="icon" type="image/png" href="tix_logo.png">
  <style>
    body {
      margin: 0;
      font-family: "Poppins", sans-serif;
      background-color: #000;
      color: #fff;
    }

    .navbar {
      background-color: #111;
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding: 15px 80px;
      position: fixed;
      width: 100%;
      top: 0;
      z-index: 100;
    }

    .logo {
      font-size: 24px;
      font-weight: bold;
      color: #ffcc00;
      cursor: pointer;
    }

    .nav-links {
      list-style: none;
      display: flex;
      gap: 30px;
    }

    .nav-links a {
      color: #fff;
      text-decoration: none;
      font-size: 15px;
      transition: 0.3s;
    }

    .nav-links a:hover {
      color: #ffcc00;
    }

    .profile-section {
      padding: 140px 20px 50px;
      display: flex;
      flex-direction: column;
      align-items: center;
      text-align: center;
    }

    .profile-box {
      background-color: #111;
      padding: 40px 50px;
      border-radius: 12px;
      box-shadow: 0 0 20px rgba(255, 204, 0, 0.2);
      max-width: 500px;
      width: 100%;
    }

    .profile-box h2 {
      color: #ffcc00;
      margin-bottom: 20px;
    }

    .profile-item {
      margin: 10px 0;
      font-size: 15px;
      color: #ddd;
    }

    .btn-logout {
      margin-top: 25px;
      display: inline-block;
      background-color: #ff0000;
      color: #fff;
      padding: 10px 20px;
      border-radius: 8px;
      text-decoration: none;
      font-weight: bold;
      transition: 0.3s;
    }

    .btn-logout:hover {
      background-color: #cc0000;
    }
  </style>
</head>
<body>

  <!-- Navbar -->
  <header class="navbar">
    <div class="logo" onclick="window.location.href='index.php'" style="cursor:pointer;">Cinematix</div>
    <nav>
      <ul class="nav-links">
        <li><a href="index.php">Home</a></li>
        <li><a href="#">Pemesanan Tiket</a></li>
        <li><a href="#">Sedang Tayang</a></li>
        <li><a href="#">Berita & Event</a></li>
      </ul>
    </nav>
  </header>

  <!-- Profile Section -->
  <section class="profile-section">
    <div class="profile-box">
      <h2>Profil Akun</h2>
      <div class="profile-item"><strong>Nama:</strong> <?= htmlspecialchars($user['nama']); ?></div>
      <div class="profile-item"><strong>Email:</strong> <?= htmlspecialchars($user['email']); ?></div>
      <div class="profile-item"><strong>Bergabung sejak:</strong> <?= htmlspecialchars($user['created_at']); ?></div>
      
      <a href="logout.php" class="btn-logout">Keluar</a>
    </div>
  </section>

</body>
</html>
