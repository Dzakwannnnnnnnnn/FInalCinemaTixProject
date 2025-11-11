<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Cinematix | Daftar Akun</title>
  <link rel="icon" type="image/png" href="tix_logo.png">
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      font-family: "Poppins", sans-serif;
    }

    body {
      background-color: #000;
      color: #fff;
      display: flex;
      flex-direction: column;
      min-height: 100vh;
    }

    /* Navbar */
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
      box-shadow: 0 2px 5px rgba(0, 0, 0, 0.5);
    }

    .logo {
      font-size: 24px;
      font-weight: bold;
      color: #ffcc00;
      cursor: pointer;
      transition: 0.3s;
    }

    .logo:hover {
      color: #ffd633;
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
      transition: color 0.3s;
    }

    .nav-links a:hover {
      color: #ffcc00;
    }

    .btn-login {
      border: 1px solid #ffcc00;
      color: #ffcc00;
      padding: 6px 15px;
      border-radius: 8px;
      text-decoration: none;
      transition: 0.3s;
    }

    .btn-login:hover {
      background-color: #ffcc00;
      color: #111;
    }

    /* Register Section */
    .register-section {
      flex: 1;
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 120px 20px 60px;
      animation: fadeIn 1s ease;
    }

    @keyframes fadeIn {
      from {
        opacity: 0;
        transform: translateY(20px);
      }

      to {
        opacity: 1;
        transform: translateY(0);
      }
    }

    .register-box {
      background-color: #111;
      padding: 40px 50px;
      border-radius: 12px;
      box-shadow: 0 0 25px rgba(255, 204, 0, 0.2);
      width: 100%;
      max-width: 400px;
      text-align: center;
      transition: transform 0.3s;
    }

    .register-box:hover {
      transform: translateY(-5px);
    }

    .register-box h2 {
      color: #ffcc00;
      margin-bottom: 25px;
    }

    .input-group {
      margin-bottom: 18px;
      text-align: left;
    }

    .input-group label {
      display: block;
      margin-bottom: 8px;
      font-size: 14px;
      color: #ddd;
    }

    .input-group input {
      width: 100%;
      padding: 10px 12px;
      border-radius: 8px;
      border: 1px solid #333;
      background-color: #000;
      color: #fff;
      outline: none;
      transition: border-color 0.3s, background 0.3s;
    }

    .input-group input:focus {
      border-color: #ffcc00;
      background-color: #111;
    }

    .btn-submit {
      background-color: #ffcc00;
      color: #000;
      border: none;
      padding: 10px 20px;
      border-radius: 8px;
      font-weight: bold;
      cursor: pointer;
      width: 100%;
      transition: 0.3s;
      margin-top: 5px;
    }

    .btn-submit:hover {
      background-color: #ffd633;
    }

    .register-footer {
      margin-top: 15px;
      font-size: 14px;
      color: #ccc;
    }

    .register-footer a {
      color: #ffcc00;
      text-decoration: none;
    }

    .register-footer a:hover {
      text-decoration: underline;
    }

    footer {
      text-align: center;
      padding: 15px;
      background-color: #111;
      font-size: 13px;
      color: #777;
    }

    /* Alert Messages */
    .alert {
      padding: 10px;
      margin-bottom: 20px;
      border-radius: 5px;
      text-align: center;
    }

    .alert-error {
      background-color: #ff4444;
      color: white;
    }

    .alert-success {
      background-color: #44ff44;
      color: black;
    }

    @media (max-width: 768px) {
      .navbar {
        padding: 15px 30px;
      }

      .register-box {
        padding: 30px;
      }
    }
  </style>
</head>

<body>
  <!-- Navbar -->
  <header class="navbar">
    <div class="logo" onclick="window.location.href='index.php'">Cinematix</div>
    <nav>
      <ul class="nav-links">
        <li><a href="index.php">Home</a></li>
        <li><a href="#">Pemesanan Tiket</a></li>
        <li><a href="#">Sedang Tayang</a></li>
        <li><a href="#">Berita & Event</a></li>
      </ul>
    </nav>
    <a href="index.php?controller=auth&action=login" class="btn-login">Masuk</a>
  </header>

  <!-- Register Section -->
  <section class="register-section">
    <div class="register-box">
      <h2>Buat Akun Baru</h2>

      <?php if (isset($flash) && $flash): ?>
        <div class="alert alert-<?= $flash['type'] ?>">
          <?= htmlspecialchars($flash['message']) ?>
        </div>
      <?php endif; ?>

      <form action="index.php?controller=auth&action=doRegister" method="POST">
        <div class="input-group">
          <label for="nama">Nama Lengkap</label>
          <input type="text" id="nama" name="nama" placeholder="Masukkan nama lengkap" required>
        </div>

        <div class="input-group">
          <label for="email">Email</label>
          <input type="email" id="email" name="email" placeholder="Masukkan email aktif" required>
        </div>

        <div class="input-group">
          <label for="password">Kata Sandi</label>
          <input type="password" id="password" name="password" placeholder="Masukkan kata sandi" required>
        </div>

        <div class="input-group">
          <label for="confirm">Konfirmasi Kata Sandi</label>
          <input type="password" id="confirm" name="confirm" placeholder="Ulangi kata sandi" required>
        </div>
        <div class="input-group">
          <label for="no_hp">Nomor HP</label>
          <input type="tel" id="no_hp" name="no_hp" placeholder="Masukkan nomor HP" required>
        </div>

        <button type="submit" class="btn-submit">Daftar</button>

        <div class="register-footer">
          <p>Sudah punya akun? <a href="index.php?controller=auth&action=login">Masuk di sini</a></p>
        </div>
      </form>
    </div>
  </section>

  <footer>
    © 2025 Cinematix. Semua Hak Dilindungi.
  </footer>
</body>

</html>