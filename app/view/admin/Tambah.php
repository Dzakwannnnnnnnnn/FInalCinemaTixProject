<?php
include 'koneksi.php';

if (isset($_POST['submit'])) {
    $judul = mysqli_real_escape_string($conn, $_POST['judul']);
    $genre = mysqli_real_escape_string($conn, $_POST['genre']);
    $durasi = mysqli_real_escape_string($conn, $_POST['durasi']);
    $rating_usia = mysqli_real_escape_string($conn, $_POST['rating_usia']);

    $poster_name = null;
    if (isset($_FILES['poster']) && $_FILES['poster']['error'] === 0) {
        $poster_name = time() . "_" . basename($_FILES['poster']['name']);
        $poster_tmp = $_FILES['poster']['tmp_name'];
        $poster_path = "../uploads/" . $poster_name;

        if (!file_exists('../uploads')) {
            mkdir('../uploads', 0777, true);
        }

        move_uploaded_file($poster_tmp, $poster_path);
    }

    $query = "INSERT INTO film (judul, genre, durasi, rating_usia, poster_url)
              VALUES ('$judul', '$genre', '$durasi', '$rating_usia', '$poster_name')";

    if (mysqli_query($conn, $query)) {
        echo "<script>
                alert('Data film berhasil ditambahkan!');
                window.location.href='panelAdmin.php';
              </script>";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Tambah Film | Admin CinemaTix</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
  <style>
    body {
      font-family: 'Segoe UI', sans-serif;
      background-color: #f8f9fa;
    }

    .sidebar {
      width: 250px;
      height: 100vh;
      background-color: #212529;
      color: #fff;
      position: fixed;
      left: 0;
      top: 0;
      padding: 20px;
    }

    .sidebar h4 {
      text-align: center;
      margin-bottom: 30px;
    }

    .sidebar ul {
      list-style: none;
      padding: 0;
    }

    .sidebar ul li {
      margin: 15px 0;
    }

    .sidebar ul li a {
      color: #ddd;
      text-decoration: none;
      display: block;
      padding: 8px 12px;
      border-radius: 6px;
      transition: 0.3s;
    }

    .sidebar ul li a:hover {
      background-color: #0d6efd;
      color: #fff;
    }

    .content {
      margin-left: 270px;
      padding: 40px;
    }

    .card {
      border: none;
      border-radius: 12px;
      box-shadow: 0 4px 8px rgba(0,0,0,0.1);
    }

    .btn-primary {
      background-color: #0d6efd;
      border: none;
    }

    .btn-primary:hover {
      background-color: #0b5ed7;
    }
  </style>
</head>
<body>

  <!-- Sidebar -->
  <div class="sidebar">
    <h4><i class="bi bi-film"></i> Admin<br>CinemaTix</h4>
    <ul>
      <li><a href="Dashboard.php"><i class="bi bi-speedometer2"></i> Dashboard</a></li>
      <li><a href="Users.php"><i class="bi bi-people"></i> Users</a></li>
      <li><a href="DaftarFilm.php" class="active"><i class="bi bi-camera-reels"></i> Film</a></li>
      <li><a href="Studio.php"><i class="bi bi-building"></i> Studio</a></li>
      <li><a href="Kursi.php"><i class="bi bi-grid-3x3-gap"></i> Kursi</a></li>
      <li><a href="Jadwal.php"><i class="bi bi-calendar-event"></i> Jadwal</a></li>
      <li><a href="Booking.php"><i class="bi bi-ticket-perforated"></i> Booking</a></li>
      <li><a href="Pembayaran.php"><i class="bi bi-wallet2"></i> Pembayaran</a></li>
    </ul>
  </div>

  <!-- Content -->
  <div class="content">
    <h2 class="fw-bold mb-3">Tambah Film</h2>
    <p class="text-muted mb-4">Isi data film baru untuk ditambahkan ke database CinemaTix.</p>

    <div class="card p-4">
      <form action="" method="POST" enctype="multipart/form-data">
        <div class="mb-3">
          <label class="form-label fw-semibold">Judul Film</label>
          <input type="text" name="judul" class="form-control" required>
        </div>

        <div class="mb-3">
          <label class="form-label fw-semibold">Genre</label>
          <input type="text" name="genre" class="form-control" required>
        </div>

        <div class="mb-3">
          <label class="form-label fw-semibold">Durasi (menit)</label>
          <input type="number" name="durasi" class="form-control" required>
        </div>

        <div class="mb-3">
          <label class="form-label fw-semibold">Rating Usia</label>
          <select name="rating_usia" class="form-select" required>
            <option value="">-- Pilih Rating Usia --</option>
            <option value="SU">SU (Semua Umur)</option>
            <option value="13+">13+</option>
            <option value="17+">17+</option>
            <option value="21+">21+</option>
          </select>
        </div>

        <div class="mb-3">
          <label class="form-label fw-semibold">Poster Film (opsional)</label>
          <input type="file" name="poster" class="form-control">
        </div>

        <button type="submit" name="submit" class="btn btn-primary w-100 mt-2">
          <i class="bi bi-plus-circle"></i> Tambah Film
        </button>
      </form>
    </div>
  </div>

</body>
</html>
