<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Cinematix | Reset Password</title>
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

    /* === NAVBAR === */
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
      color: #ffd700;
      cursor: pointer;
    }

    .nav-links {
      list-style: none;
      display: flex;
      gap: 20px;
      transition: all 0.3s ease;
    }

    .nav-links a {
      color: #fff;
      text-decoration: none;
      font-size: 14px;
      padding: 8px 12px;
      border-radius: 6px;
      transition: all 0.3s;
    }

    .nav-links a:hover,
    .nav-links a.active {
      color: #ffcc00;
      background: rgba(255, 204, 0, 0.1);
    }

    .nav-dropdown {
      position: relative;
    }

    .nav-dropdown>a::after {
      content: ' ▼';
      font-size: 12px;
      margin-left: 5px;
      transition: transform 0.3s ease;
    }

    .nav-dropdown:hover>a::after {
      transform: rotate(180deg);
    }

    .nav-dropdown-content {
      display: none;
      position: absolute;
      top: 100%;
      left: 0;
      background: #111;
      border: 1px solid rgba(255, 204, 0, 0.3);
      border-radius: 8px;
      min-width: 200px;
      box-shadow: 0 8px 16px rgba(0, 0, 0, 0.3);
      z-index: 1000;
      overflow: hidden;
    }

    .nav-dropdown:hover .nav-dropdown-content {
      display: block;
    }

    .nav-dropdown-content a {
      display: block;
      padding: 12px 16px;
      color: #fff;
      text-decoration: none;
      border-bottom: 1px solid rgba(255, 255, 255, 0.1);
      transition: all 0.3s;
      position: relative;
    }

    .nav-dropdown-content a:hover {
      background: rgba(255, 204, 0, 0.1);
      color: #ffcc00;
      padding-left: 20px;
    }

    .nav-dropdown-content a:last-child {
      border-bottom: none;
    }

    .nav-dropdown-content a::before {
      content: '▶';
      position: absolute;
      left: 8px;
      top: 50%;
      transform: translateY(-50%);
      font-size: 10px;
      color: #666;
      transition: all 0.3s;
      opacity: 0;
    }

    .nav-dropdown-content a:hover::before {
      opacity: 1;
      color: #ffcc00;
      left: 12px;
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

    /* Tombol hamburger */
    .menu-toggle {
      display: none;
      font-size: 26px;
      color: #ffcc00;
      cursor: pointer;
    }

    /* Reset Password Section */
    .reset-section {
      flex: 1;
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 120px 20px 60px;
    }

    .reset-box {
      background-color: #111;
      padding: 40px 50px;
      border-radius: 12px;
      box-shadow: 0 0 20px rgba(255, 204, 0, 0.2);
      width: 100%;
      max-width: 400px;
      text-align: center;
    }

    .reset-box h2 {
      color: #ffcc00;
      margin-bottom: 10px;
    }

    .reset-box p {
      color: #ccc;
      margin-bottom: 25px;
      font-size: 14px;
    }

    .input-group {
      margin-bottom: 20px;
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
      transition: 0.3s;
    }

    .input-group input:focus {
      border-color: #ffcc00;
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
    }

    .btn-submit:hover {
      background-color: #ffd633;
    }

    .back-to-login {
      margin-top: 15px;
      font-size: 14px;
      color: #ccc;
    }

    .back-to-login a {
      color: #ffcc00;
      text-decoration: none;
    }

    .back-to-login a:hover {
      text-decoration: underline;
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
  </style>
</head>

<body>
  <!-- Navbar -->
  <header class="navbar">
    <div class="logo" onclick="window.location.href='index.php'" style="cursor:pointer;">Cinematix</div>
    <div class="menu-toggle" id="menu-toggle">☰</div>

    <nav>
      <ul class="nav-links" id="nav-links">
        <li><a href="index.php">Home</a></li>
        <li class="nav-dropdown">
          <a href="index.php?controller=user&action=pesanan">Film & Tiket</a>
          <div class="nav-dropdown-content">
            <a href="index.php?controller=user&action=pesanan">Pemesanan Tiket</a>
            <a href="index.php?controller=user&action=purchaseHistory">Riwayat Pembelian</a>
          </div>
        </li>
        <li><a href="index.php#movies">Sedang Tayang</a></li>
        <li><a href="index.php?controller=user&action=beritaEvent">Berita & Event</a></li>
      </ul>
    </nav>
    <a href="index.php?controller=auth&action=login" class="btn-login">Masuk / Daftar</a>
  </header>

  <!-- Reset Password Section -->
  <section class="reset-section">
    <div class="reset-box">
      <h2>Reset Password</h2>
      <p>Masukkan password baru Anda.</p>

      <?php if (isset($flash) && $flash): ?>
        <div class="alert alert-<?= $flash['type'] ?>">
          <?= htmlspecialchars($flash['message']) ?>
        </div>
      <?php endif; ?>

      <form action="index.php?controller=auth&action=doResetPassword" method="POST">
        <input type="hidden" name="token" value="<?= htmlspecialchars($_GET['token'] ?? '') ?>">

        <div class="input-group">
          <label for="password">Password Baru</label>
          <input type="password" id="password" name="password" placeholder="Masukkan password baru" required>
        </div>

        <div class="input-group">
          <label for="confirm">Konfirmasi Password</label>
          <input type="password" id="confirm" name="confirm" placeholder="Konfirmasi password baru" required>
        </div>

        <button type="submit" class="btn-submit">Reset Password</button>
      </form>

      <div class="back-to-login">
        <p><a href="index.php?controller=auth&action=login">← Kembali ke Login</a></p>
      </div>
    </div>
  </section>
</body>

</html>