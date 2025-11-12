<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Pemesanan Tiket - Cinematix</title>
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

    /* ==== HERO SECTION ==== */
    .hero {
      background: linear-gradient(135deg, #0e0e0e 0%, #1a1a1a 100%);
      padding: 80px 60px;
      text-align: center;
    }

    .hero h1 {
      font-size: 3rem;
      font-weight: 700;
      color: #ffd700;
      margin-bottom: 20px;
    }

    .hero p {
      font-size: 1.2rem;
      color: #ccc;
      max-width: 600px;
      margin: 0 auto;
    }

    /* ==== FILM SECTIONS ==== */
    .film-section {
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
      margin-bottom: 60px;
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
      margin-bottom: 4px;
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

    /* Filter buttons */
    .filter-buttons {
      display: flex;
      justify-content: center;
      gap: 10px;
      margin-bottom: 40px;
      flex-wrap: wrap;
    }

    .filter-btn {
      background-color: #333;
      color: #ccc;
      border: 1px solid #555;
      padding: 10px 20px;
      border-radius: 25px;
      cursor: pointer;
      transition: all 0.3s;
      font-size: 0.9rem;
    }

    .filter-btn:hover,
    .filter-btn.active {
      background-color: #ffd700;
      color: #111;
      border-color: #ffd700;
    }

    /* Rating and Genre sections */
    .rating-section,
    .genre-section {
      margin-bottom: 80px;
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

    /* Responsive */
    @media (max-width: 768px) {
      .navbar {
        padding: 15px 20px;
      }

      .nav-links {
        position: absolute;
        top: 65px;
        right: 0;
        background: #111;
        flex-direction: column;
        width: 100%;
        text-align: center;
        gap: 0;
        overflow: hidden;
        max-height: 0;
        transition: max-height 0.4s ease;
        padding: 0;
      }

      .nav-links li {
        border-top: 1px solid rgba(255, 255, 255, 0.1);
        padding: 14px 0;
      }

      .nav-links.active {
        max-height: 300px;
      }

      .menu-toggle {
        display: block;
      }

      .hero,
      .film-section {
        padding: 40px 20px;
      }

      .hero h1 {
        font-size: 2rem;
      }

      .movie-grid {
        grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
        gap: 20px;
      }
    }
  </style>
  <script>
    // Navbar toggle
    const menuToggle = document.getElementById("menu-toggle");
    const navLinks = document.getElementById("nav-links");

    menuToggle.addEventListener("click", () => {
      navLinks.classList.toggle("active");
    });

    // Tutup menu mobile saat klik link
    document.querySelectorAll('.nav-links a').forEach(link => {
      link.addEventListener('click', () => {
        navLinks.classList.remove('active');
      });
    });

    // Filter functionality for rating section
    document.addEventListener('DOMContentLoaded', function () {
      // Rating filter
      const ratingButtons = document.querySelectorAll('.rating-section .filter-btn');
      const ratingMovies = document.querySelectorAll('#rating-movies .movie-card');
      const ratingGrid = document.getElementById('rating-movies');

      ratingButtons.forEach(button => {
        button.addEventListener('click', () => {
          // Remove active class from all buttons
          ratingButtons.forEach(btn => btn.classList.remove('active'));
          // Add active class to clicked button
          button.classList.add('active');

          const filter = button.getAttribute('data-filter');
          let visibleCount = 0;

          ratingMovies.forEach(movie => {
            if (filter === 'all') {
              movie.style.display = 'block';
              visibleCount++;
            } else {
              const rating = movie.getAttribute('data-rating');
              const isVisible = rating === filter;
              movie.style.display = isVisible ? 'block' : 'none';
              if (isVisible) visibleCount++;
            }
          });

          // Show/hide no films message
          let noFilmsMsg = ratingGrid.querySelector('.no-films-message');
          if (visibleCount === 0) {
            if (!noFilmsMsg) {
              noFilmsMsg = document.createElement('div');
              noFilmsMsg.className = 'no-films-message';
              const msgDiv = document.createElement('div');
              msgDiv.style.textAlign = 'center';
              msgDiv.style.padding = '40px';
              msgDiv.style.color = '#ccc';

              const msgP1 = document.createElement('p');
              msgP1.style.fontSize = '18px';
              msgP1.style.marginBottom = '15px';
              msgP1.textContent = '🎬 Film belum tersedia';

              const msgP2 = document.createElement('p');
              msgP2.style.fontSize = '14px';
              msgP2.textContent = 'Silakan pilih kategori lain atau check kembali nanti.';

              msgDiv.appendChild(msgP1);
              msgDiv.appendChild(msgP2);
              noFilmsMsg.appendChild(msgDiv);
              ratingGrid.appendChild(noFilmsMsg);
            }
            noFilmsMsg.style.display = 'block';
          } else {
            if (noFilmsMsg) {
              noFilmsMsg.style.display = 'none';
            }
          }
        });
      });

      // Genre filter
      const genreButtons = document.querySelectorAll('.genre-section .filter-btn');
      const genreMovies = document.querySelectorAll('#genre-movies .movie-card');
      const genreGrid = document.getElementById('genre-movies');

      genreButtons.forEach(button => {
        button.addEventListener('click', () => {
          // Remove active class from all buttons
          genreButtons.forEach(btn => btn.classList.remove('active'));
          // Add active class to clicked button
          button.classList.add('active');

          const filter = button.getAttribute('data-filter');
          let visibleCount = 0;

          genreMovies.forEach(movie => {
            if (filter === 'all') {
              movie.style.display = 'block';
              visibleCount++;
            } else {
              const genre = movie.getAttribute('data-genre');
              const isVisible = genre === filter;
              movie.style.display = isVisible ? 'block' : 'none';
              if (isVisible) visibleCount++;
            }
          });

          // Show/hide no films message
          let noFilmsMsg = genreGrid.querySelector('.no-films-message');
          if (visibleCount === 0) {
            if (!noFilmsMsg) {
              noFilmsMsg = document.createElement('div');
              noFilmsMsg.className = 'no-films-message';
              const msgDiv = document.createElement('div');
              msgDiv.style.textAlign = 'center';
              msgDiv.style.padding = '40px';
              msgDiv.style.color = '#ccc';

              const msgP1 = document.createElement('p');
              msgP1.style.fontSize = '18px';
              msgP1.style.marginBottom = '15px';
              msgP1.textContent = '🎬 Film belum tersedia';

              const msgP2 = document.createElement('p');
              msgP2.style.fontSize = '14px';
              msgP2.textContent = 'Silakan pilih kategori lain atau check kembali nanti.';

              msgDiv.appendChild(msgP1);
              msgDiv.appendChild(msgP2);
              noFilmsMsg.appendChild(msgDiv);
              genreGrid.appendChild(noFilmsMsg);
            }
            noFilmsMsg.style.display = 'block';
          } else {
            if (noFilmsMsg) {
              noFilmsMsg.style.display = 'none';
            }
          }
        });
      });
    });
  </script>
</head>

<body>

  <!-- HEADER -->
  <header class="navbar">
    <div class="logo" onclick="window.location.href='index.php'">Cinematix</div>
    <div class="menu-toggle" id="menu-toggle">☰</div>

    <nav>
      <ul class="nav-links" id="nav-links">
        <li><a href="index.php">Home</a></li>
        <li class="nav-dropdown">
          <a href="index.php?controller=user&action=pesanan" class="active">Film & Tiket</a>
          <div class="nav-dropdown-content">
            <a href="index.php?controller=user&action=pesanan">Pemesanan Tiket</a>
            <a href="index.php?controller=user&action=purchaseHistory">Riwayat Pembelian</a>
          </div>
        </li>
        <li><a href="index.php#movies">Sedang Tayang</a></li>
        <li><a href="index.php?controller=user&action=beritaEvent">Berita & Event</a></li>
      </ul>
    </nav>
    <?php if (isLoggedIn()): ?>
      <div style="display: flex; align-items: center; gap: 15px;">
        <span style="color: #fff; font-weight:bold;">Halo, <?= htmlspecialchars($_SESSION['user_name']) ?>!</span>
        <?php if (isAdmin()): ?>
          <a href="index.php?controller=admin&action=index" class="btn-login"
            style="background: #ffcc00; color: #000; padding: 6px 12px;">Admin Panel</a>
        <?php endif; ?>
        <a href="index.php?controller=auth&action=logout" class="btn-login">Logout</a>
      </div>
    <?php else: ?>
      <a href="index.php?controller=auth&action=login" class="btn-login">Masuk/Daftar</a>
    <?php endif; ?>
  </header>

  <!-- HERO SECTION -->
  <section class="hero">
    <h1>Pemesanan Tiket Bioskop</h1>
    <p>Pilih film favorit Anda dan pesan tiket dengan mudah. Nikmati pengalaman menonton yang tak terlupakan!</p>
  </section>

  <!-- FILM SEDANG HITS -->
  <section class="film-section">
    <h2 class="section-title">Film Sedang Hits</h2>
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
              <p>Rating: <?= htmlspecialchars($film['rating_usia']); ?></p>
              <?php if (isset($film['rating_bintang']) && $film['rating_bintang'] > 0): ?>
                <p style="color: #ffcc00; font-weight: bold;">
                  ⭐ <?= number_format($film['rating_bintang'], 1); ?>/5
                </p>
              <?php endif; ?>
              <a href="index.php?controller=film&action=detail&id=<?= $film['film_id']; ?>" class="btn-book">Lihat
                Detail</a>
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

  <!-- FILM BERDASARKAN RATING USIA -->
  <section class="film-section rating-section">
    <h2 class="section-title">Berdasarkan Rating Usia</h2>
    <div class="filter-buttons">
      <button class="filter-btn active" data-filter="all">Semua</button>
      <button class="filter-btn" data-filter="SU">SU</button>
      <button class="filter-btn" data-filter="13+">13+</button>
      <button class="filter-btn" data-filter="17+">17+</button>
      <button class="filter-btn" data-filter="21+">21+</button>
    </div>
    <div class="movie-grid" id="rating-movies">
      <?php foreach ($filmsByRating as $rating => $films): ?>
        <?php foreach ($films as $film): ?>
          <div class="movie-card" data-rating="<?= htmlspecialchars($rating); ?>">
            <img src="public/uploads/<?= htmlspecialchars($film['poster_url']); ?>"
              alt="<?= htmlspecialchars($film['judul']); ?>"
              onerror="this.src='https://via.placeholder.com/300x400/333/fff?text=Poster+Tidak+Tersedia'">
            <div class="movie-info">
              <h3><?= htmlspecialchars($film['judul']); ?></h3>
              <p>Genre: <?= htmlspecialchars($film['genre']); ?></p>
              <p>Rating: <?= htmlspecialchars($film['rating_usia']); ?></p>
              <?php if (isset($film['rating_bintang']) && $film['rating_bintang'] > 0): ?>
                <p style="color: #ffcc00; font-weight: bold;">
                  ⭐ <?= number_format($film['rating_bintang'], 1); ?>/5
                </p>
              <?php endif; ?>
              <a href="index.php?controller=film&action=detail&id=<?= $film['film_id']; ?>" class="btn-book">Lihat
                Detail</a>
            </div>
          </div>
        <?php endforeach; ?>
      <?php endforeach; ?>
    </div>
  </section>

  <!-- FILM BERDASARKAN GENRE -->
  <section class="film-section genre-section">
    <h2 class="section-title">Berdasarkan Genre</h2>
    <div class="filter-buttons">
      <button class="filter-btn active" data-filter="all">Semua</button>
      <button class="filter-btn" data-filter="Action">Action</button>
      <button class="filter-btn" data-filter="Drama">Drama</button>
      <button class="filter-btn" data-filter="Comedy">Comedy</button>
      <button class="filter-btn" data-filter="Horror">Horror</button>
      <button class="filter-btn" data-filter="Romance">Romance</button>
      <button class="filter-btn" data-filter="Thriller">Thriller</button>
    </div>
    <div class="movie-grid" id="genre-movies">
      <?php foreach ($filmsByGenre as $genre => $films): ?>
        <?php foreach ($films as $film): ?>
          <div class="movie-card" data-genre="<?= htmlspecialchars($genre); ?>">
            <img src="public/uploads/<?= htmlspecialchars($film['poster_url']); ?>"
              alt="<?= htmlspecialchars($film['judul']); ?>"
              onerror="this.src='https://via.placeholder.com/300x400/333/fff?text=Poster+Tidak+Tersedia'">
            <div class="movie-info">
              <h3><?= htmlspecialchars($film['judul']); ?></h3>
              <p>Genre: <?= htmlspecialchars($film['genre']); ?></p>
              <p>Rating: <?= htmlspecialchars($film['rating_usia']); ?></p>
              <?php if (isset($film['rating_bintang']) && $film['rating_bintang'] > 0): ?>
                <p style="color: #ffcc00; font-weight: bold;">
                  ⭐ <?= number_format($film['rating_bintang'], 1); ?>/5
                </p>
              <?php endif; ?>
              <a href="index.php?controller=film&action=detail&id=<?= $film['film_id']; ?>" class="btn-book">Lihat
                Detail</a>
            </div>
          </div>
        <?php endforeach; ?>
      <?php endforeach; ?>
    </div>
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