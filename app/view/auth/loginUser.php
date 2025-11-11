<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Cinematix | Login</title>
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
    }

    .logo {
      font-size: 24px;
      font-weight: bold;
      color: #ffcc00;
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

    /* Login Section */
    .login-section {
      flex: 1;
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 120px 20px 60px;
    }

    .login-box {
      background-color: #111;
      padding: 40px 50px;
      border-radius: 12px;
      box-shadow: 0 0 20px rgba(255, 204, 0, 0.2);
      width: 100%;
      max-width: 400px;
      text-align: center;
    }

    .login-box h2 {
      color: #ffcc00;
      margin-bottom: 25px;
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

    .login-footer {
      margin-top: 15px;
      font-size: 14px;
      color: #ccc;
    }

    .login-footer a {
      color: #ffcc00;
      text-decoration: none;
    }

    .login-footer a:hover {
      text-decoration: underline;
    }

    /* Google Button */
    .btn-google {
      margin-top: 15px;
      width: 100%;
      background-color: #222;
      border: 1px solid #333;
      color: #fff;
      padding: 10px;
      border-radius: 8px;
      font-weight: 500;
      cursor: pointer;
      transition: 0.3s;
    }

    .btn-google:hover {
      background-color: #333;
      border-color: #ffcc00;
      color: #ffcc00;
    }

    .forgot-password {
      text-align: right;
      margin-bottom: 15px;
    }

    .forgot-password a {
      font-size: 13px;
      color: #ccc;
      text-decoration: none;
    }

    .forgot-password a:hover {
      color: #ffcc00;
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
    <nav>
      <ul class="nav-links">
        <li><a href="index.php">Home</a></li>
        <li><a href="#">Pemesanan Tiket</a></li>
        <li><a href="#">Sedang Tayang</a></li>
        <li><a href="#">Berita & Event</a></li>
      </ul>
    </nav>
    <a href="index.php?controller=auth&action=login" class="btn-login">Masuk / Daftar</a>
  </header>

  <!-- Login Section -->
  <section class="login-section">
    <div class="login-box">
      <h2>Masuk ke Akun</h2>

      <?php if (isset($flash) && $flash): ?>
        <div class="alert alert-<?= $flash['type'] ?>">
          <?= htmlspecialchars($flash['message']) ?>
        </div>
      <?php endif; ?>

      <form action="index.php?controller=auth&action=doLogin" method="POST">
        <div class="input-group">
          <label for="email">Email</label>
          <input type="email" id="email" name="email" placeholder="Masukkan email" required>
        </div>

        <div class="input-group">
          <label for="password">Kata Sandi</label>
          <input type="password" id="password" name="password" placeholder="Masukkan kata sandi" required>
        </div>

        <div class="forgot-password">
          <a href="#">Lupa kata sandi?</a>
        </div>

        <button type="submit" class="btn-submit">Masuk</button><br><br>
        <div class="register-footer">
          <p>Belum punya akun? <a href="index.php?controller=auth&action=register">Daftar di sini</a></p>
        </div>
      </form>
    </div>
  </section>
</body>

</html>