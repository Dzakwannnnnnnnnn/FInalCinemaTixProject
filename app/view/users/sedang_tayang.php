<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Film Sedang Tayang - Cinematix</title>
  <style>
    /* ==== GLOBAL STYLE ==== */
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      font-family: 'Poppins', sans-serif;
    }

    body {
      background-color: #0e0e0e;
      color: #fff;
      overflow-x: hidden;
    }

    a {
      text-decoration: none;
      color: inherit;
    }

    /* ==== NAVBAR ==== */
    header {
      background-color: #111;
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding: 15px 60px;
      position: sticky;
      top: 0;
      z-index: 100;
      border-bottom: 1px solid #222;
    }

    .logo {
      color: #ffd700;
      font-weight: 700;
      font-size: 1.5rem;
    }

    nav a {
      margin: 0 15px;
      color: #ddd;
      transition: 0.3s;
    }

    nav a:hover {
      color: #ffd700;
    }

    .btn-login {
      background-color: transparent;
      border: 1px solid #ffd700;
      color: #ffd700;
      padding: 8px 20px;
      border-radius: 6px;
      transition: 0.3s;
    }

    .btn-login:hover {
      background-color: #ffd700;
      color: #111;
    }

    /* ==== SECTION FILM ==== */
    .movie-section {
      padding: 80px 60px;
      background: linear-gradient(to bottom, #0e0e0e 80%, #111);
    }

    .section-title {
      text-align: center;
      font-size: 2.2rem;
      font-weight: 600;
      margin-bottom: 50px;
      color: #ffd700;
    }

    .movie-grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
      gap: 30px;
    }

    .movie-card {
      position: relative;
      background-color: #1a1a1a;
      border-radius: 14px;
      overflow: hidden;
      box-shadow: 0 4px 15px rgba(0, 0, 0, 0.4);
      transition: transform 0.3s, box-shadow 0.3s;
    }

    .movie-card:hover {
      transform: translateY(-8px);
      box-shadow: 0 8px 25px rgba(0, 0, 0, 0.6);
    }

    .movie-card img {
      width: 100%;
      height: 330px;
      object-fit: cover;
      transition: 0.3s;
    }

    .movie-info {
      padding: 18px;
    }

    .movie-info h3 {
      font-size: 1.1rem;
      margin-bottom: 8px;
      color: #fff;
    }

    .movie-info p {
      font-size: 0.9rem;
      color: #bbb;
    }

    .btn-book {
      display: inline-block;
      margin-top: 12px;
      background-color: #ffd700;
      color: #111;
      font-weight: 600;
      padding: 8px 16px;
      border-radius: 6px;
      transition: 0.3s;
    }

    .btn-book:hover {
      background-color: #ffcc00;
    }

    /* ==== FOOTER ==== */
    footer {
      background-color: #111;
      padding: 40px 60px;
      display: flex;
      justify-content: space-between;
      align-items: center;
      flex-wrap: wrap;
      border-top: 1px solid #222;
    }

    footer .logo {
      font-size: 1.3rem;
      color: #ffd700;
      font-weight: 700;
    }

    footer p {
      color: #999;
      font-size: 0.9rem;
    }

    .socials a {
      margin: 0 10px;
      color: #ffd700;
      font-weight: 600;
      transition: 0.3s;
    }

    .socials a:hover {
      color: #fff;
    }
  </style>
</head>

<body>

  <!-- HEADER -->
  <header>
    <div class="logo">Cinematix</div>
    <nav>
      <a href="#">Home</a>
      <a href="#">Pemesanan Tiket</a>
      <a href="#">Sedang Tayang</a>
      <a href="#">Berita & Event</a>
    </nav>
    <a href="#" class="btn-login">Masuk / Daftar</a>
  </header>

  <!-- SECTION FILM -->
  <section class="movie-section">
    <h2 class="section-title">Film Sedang Tayang</h2>
    <?php if (isset($films) && !empty($films)): ?>
      <div class="movie-grid">
        <?php foreach ($films as $film): ?>
          <div class="movie-card">
            <img src="public/uploads/<?= htmlspecialchars($film['poster_url']); ?>"
              alt="<?= htmlspecialchars($film['judul']); ?>"
              onerror="this.src='https://via.placeholder.com/300x400/333/fff?text=Poster+Tidak+Tersedia'">
            <div class="movie-info">
              <h3><?= htmlspecialchars($film['judul']); ?></h3>
              <p>Genre: <?= htmlspecialchars($film['genre']); ?></p>
              <a href="index.php?controller=booking&action=book&id=<?= $film['film_id']; ?>" class="btn-book">Pesan
                Tiket</a>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
    <?php else: ?>
      <div style="text-align: center; padding: 40px; color: #ccc;">
        <p style="font-size: 18px; margin-bottom: 15px;">😔 Tidak ada film yang sedang tayang</p>
        <p style="font-size: 14px;">Silakan check kembali nanti untuk update film terbaru.</p>
      </div>
    <?php endif; ?>
  </section>

  <!-- FOOTER -->
  <footer>
    <div class="logo">Cinematix</div>
    <p>© 2025 Cinematix. Enjoy Your Movie & Your Moment.</p>
    <div class="socials">
      <a href="#">IG</a>
      <a href="#">TT</a>
      <a href="#">YT</a>
    </div>
  </footer>

</body>

</html>