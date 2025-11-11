<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Berita & Event | Cinematix</title>
  <link rel="icon" type="images/png" href="tix_logo.png" />
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      font-family: "Poppins", sans-serif;
    }

    body {
      background-color: #fff;
      color: #111;
    }

    /* NAVBAR */
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

    /* MAIN CONTENT */
    .container {
      display: flex;
      justify-content: space-between;
      align-items: flex-start;
      padding: 120px 80px 80px;
      gap: 50px;
    }

    .main-news {
      flex: 3;
      display: grid;
      grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
      gap: 40px;
    }

    .news-card {
      background-color: #fff;
      border-radius: 12px;
      overflow: hidden;
      box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
      transition: transform 0.3s ease;
    }

    .news-card:hover {
      transform: translateY(-5px);
    }

    .news-card img {
      width: 100%;
      height: 220px;
      object-fit: cover;
    }

    .news-content {
      padding: 20px;
    }

    .category {
      font-size: 13px;
      font-weight: 600;
      color: #287bff;
      margin-bottom: 8px;
      text-transform: uppercase;
    }

    .news-title {
      font-size: 20px;
      font-weight: 700;
      margin-bottom: 10px;
      line-height: 1.3;
    }

    .news-title:hover {
      color: #ffcc00;
      cursor: pointer;
    }

    .news-meta {
      font-size: 13px;
      color: #555;
      margin-bottom: 12px;
    }

    .news-meta a {
      color: #287bff;
      text-decoration: none;
      font-weight: 600;
    }

    .news-meta a:hover {
      text-decoration: underline;
    }

    .news-desc {
      font-size: 15px;
      color: #333;
      line-height: 1.6;
    }

    /* SIDEBAR */
    .sidebar {
      flex: 1;
      border-left: 1px solid #ddd;
      padding-left: 40px;
    }

    .sidebar h3 {
      font-size: 18px;
      font-weight: 700;
      margin-bottom: 20px;
      border-bottom: 2px solid #111;
      display: inline-block;
      padding-bottom: 5px;
    }

    .sidebar ul {
      list-style: none;
    }

    .sidebar li {
      margin-bottom: 18px;
      border-bottom: 1px solid #eee;
      padding-bottom: 12px;
    }

    .sidebar a {
      text-decoration: none;
      color: #111;
      font-weight: 600;
      line-height: 1.4;
    }

    .sidebar a:hover {
      color: #ffcc00;
    }

    footer {
      background-color: #111;
      color: #fff;
      text-align: center;
      padding: 25px;
      margin-top: 60px;
    }
  </style>
</head>
<body>
  <header class="navbar">
    <div class="logo" onclick="window.location.href='index.php'" style="cursor:pointer;">Cinematix</div>
    <nav>
      <ul class="nav-links">
        <li><a href="index.php">Home</a></li>
        <li><a href="#">Pemesanan Tiket</a></li>
        <li><a href="#">Sedang Tayang</a></li>
        <li><a href="beritaEvent.html" style="color:#ffcc00;">Berita & Event</a></li>
      </ul>
    </nav>
    <a href="#" class="btn-login" onclick="window.location.href='loginUser.php'">Masuk / Daftar</a>
  </header>

  <main class="container">
    <div class="main-news">
      <div class="news-card">
        <img src="star.jpg" alt="The Smashing Machine" />
        <div class="news-content">
          <div class="category">TIX NOW</div>
          <div class="news-title">Dwayne Johnson Banjir Pujian di Film ‘The Smashing Machine’</div>
          <div class="news-meta">by <a href="#">TIX ID Admin</a> – October 13, 2025</div>
          <div class="news-desc">
            Penggemar film di Tanah Air kini bisa menyaksikan transformasi mengejutkan dari Dwayne “The Rock” Johnson dalam film biografi yang sangat dinanti *The Smashing Machine*.
          </div>
        </div>
      </div>

      <div class="news-card">
        <img src="dune.jpg" alt="Luna Maya dan Yasmin Napper" />
        <div class="news-content">
          <div class="category">TIX NOW</div>
          <div class="news-title">Luna Maya dan Yasmin Napper Jadi Produser di Film Sosok Ketiga: Lintrik</div>
          <div class="news-meta">by <a href="#">TIX ID Admin</a> – October 10, 2025</div>
          <div class="news-desc">
            Film horor *Sosok Ketiga: Lintrik* yang dijadwalkan tayang 6 November 2025 ini merupakan proyek ambisius baru dari LEO Pictures, disutradarai oleh Fajar Nugros.
          </div>
        </div>
      </div>
    </div>

    <aside class="sidebar">
      <h3>More News</h3>
      <ul>
        <li><a href="#">Dwayne Johnson Banjir Pujian di Film ‘The Smashing Machine’</a></li>
        <li><a href="#">Luna Maya dan Yasmin Napper Jadi Produser di Film Sosok Ketiga: Lintrik</a></li>
        <li><a href="#">Rehat Sejenak Bersama Ubur-Ubur Cantik di Jakarta Aquarium Safari</a></li>
        <li><a href="#">TRON: ARES, Masuki Petualangan Baru di Dunia Neon</a></li>
        <li><a href="#">Rest Area, Teror Hantu Keresek yang Mengerikan!</a></li>
      </ul>
    </aside>
  </main>

  <footer>
    © 2025 Cinematix — Semua Hak Dilindungi
  </footer>
</body>
</html>
