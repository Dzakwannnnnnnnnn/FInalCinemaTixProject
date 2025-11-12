<?php
// Pastikan path ini sesuai dengan struktur folder Anda
require_once __DIR__ . '/../../../functions.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Pilih Kursi - Cinema Tix</title>
  <link rel="icon" type="images/png" href="tix_logo.png">
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

    /* === SEAT SELECTION === */
    .seat-selection {
      margin-top: 80px;
      padding: 40px 80px;
    }

    .film-info {
      text-align: center;
      margin-bottom: 40px;
    }

    .film-title {
      font-size: 28px;
      font-weight: 700;
      margin-bottom: 10px;
      color: #fff;
    }

    .schedule-info {
      color: #ccc;
      font-size: 16px;
    }

    .screen {
      background-color: #333;
      height: 20px;
      border-radius: 10px;
      margin: 40px 0;
      display: flex;
      align-items: center;
      justify-content: center;
      color: #fff;
      font-weight: bold;
      position: relative;
    }

    .screen::before {
      content: "";
      position: absolute;
      top: -10px;
      left: 0;
      right: 0;
      height: 2px;
      background: linear-gradient(90deg, transparent, #ffcc00, transparent);
    }

    .seats-container {
      display: flex;
      flex-direction: column;
      align-items: center;
      gap: 20px;
      max-width: 800px;
      margin: 0 auto;
    }

    .seat-row {
      display: flex;
      gap: 10px;
      align-items: center;
    }

    .row-label {
      width: 30px;
      text-align: center;
      color: #ffcc00;
      font-weight: bold;
    }

    .seat {
      width: 40px;
      height: 40px;
      border: 2px solid #666;
      border-radius: 8px;
      display: flex;
      align-items: center;
      justify-content: center;
      cursor: pointer;
      transition: all 0.3s;
      font-size: 12px;
      font-weight: bold;
      background-color: #333;
      color: #fff;
    }

    .seat.available {
      background-color: #2ecc71;
      /* Hijau untuk kursi tersedia */
      border-color: #27ae60;
    }

    .seat.available:hover {
      border-color: #ffcc00;
      background-color: #27ae60;
      color: #000;
    }

    .seat.selected {
      background-color: #3498db;
      /* Biru untuk kursi terpilih */
      border-color: #2980b9;
      color: #fff;
    }

    .seat.booked {
      background-color: #e74c3c;
      /* Merah untuk kursi sudah dipesan */
      border-color: #c0392b;
      color: #fff;
      cursor: not-allowed;
    }

    .legend {
      display: flex;
      justify-content: center;
      gap: 30px;
      margin: 30px 0;
      flex-wrap: wrap;
    }

    .legend-item {
      display: flex;
      align-items: center;
      gap: 8px;
      color: #ccc;
      font-size: 14px;
    }

    .legend-seat {
      width: 20px;
      height: 20px;
      border-radius: 4px;
    }

    .legend-seat.available {
      background-color: #2ecc71;
      border: 2px solid #27ae60;
    }

    .legend-seat.selected {
      background-color: #3498db;
      border: 2px solid #2980b9;
    }

    .legend-seat.booked {
      background-color: #e74c3c;
      border: 2px solid #c0392b;
    }

    .booking-summary {
      background-color: #111;
      padding: 20px;
      border-radius: 12px;
      margin-top: 30px;
      border: 1px solid rgba(255, 255, 255, 0.1);
      max-width: 800px;
      margin-left: auto;
      margin-right: auto;
    }

    .summary-title {
      font-size: 20px;
      font-weight: bold;
      margin-bottom: 15px;
      color: #ffcc00;
    }

    .selected-seats {
      margin-bottom: 15px;
    }

    .selected-seats p {
      margin-bottom: 5px;
      color: #ccc;
    }

    .total-price {
      font-size: 18px;
      font-weight: bold;
      color: #ffcc00;
      margin-bottom: 20px;
    }

    .btn-book {
      background-color: #ffcc00;
      color: #000;
      font-weight: bold;
      padding: 12px 30px;
      border-radius: 8px;
      border: none;
      cursor: pointer;
      font-size: 16px;
      transition: 0.3s;
      width: 100%;
    }

    .btn-book:hover {
      background-color: #ffd633;
    }

    .btn-book:disabled {
      background-color: #666;
      cursor: not-allowed;
    }

    /* RESPONSIVE */
    @media (max-width: 768px) {
      .navbar {
        padding: 15px 20px;
      }

      .menu-toggle {
        display: block;
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

      .btn-login {
        display: none;
      }

      .seat-selection {
        padding: 20px;
        margin-top: 60px;
      }

      .seat-row {
        gap: 5px;
      }

      .seat {
        width: 35px;
        height: 35px;
        font-size: 10px;
      }

      .legend {
        gap: 15px;
      }
    }
  </style>
</head>

<body>
  <header class="navbar">
    <div class="logo" onclick="window.location.href='index.php'">Cinematix</div>

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

  <main class="seat-selection">
    <?php if (isset($film) && !empty($film) && isset($jadwal) && !empty($jadwal)): ?>
      <div class="film-info">
        <h1 class="film-title"><?= htmlspecialchars($film['judul'] ?? 'Judul tidak tersedia'); ?></h1>
        <p class="schedule-info">
          Jadwal: <?= date('l, d F Y', strtotime($jadwal['tanggal'] ?? '')); ?> |
          Jam: <?= date('H:i', strtotime($jadwal['jam_mulai'] ?? '')); ?> |
          Studio: <?= htmlspecialchars($jadwal['nama_studio'] ?? 'N/A'); ?>
          (<?= htmlspecialchars($jadwal['tipe'] ?? 'N/A'); ?>)
        </p>
      </div>

      <form id="bookingForm" action="index.php?controller=booking&action=selectPaymentMethod" method="POST">
        <input type="hidden" name="jadwal_id" value="<?= $jadwal['jadwal_id'] ?? '' ?>">

        <!-- Screen -->
        <div class="screen">LAYAR</div>

        <!-- Seats Container -->
        <div class="seats-container" id="seatsContainer">
          <!-- Seats will be loaded here via JavaScript -->
        </div>

        <!-- Legend -->
        <div class="legend">
          <div class="legend-item">
            <div class="legend-seat available"></div>
            <span>Tersedia</span>
          </div>
          <div class="legend-item">
            <div class="legend-seat selected"></div>
            <span>Terpilih</span>
          </div>
          <div class="legend-item">
            <div class="legend-seat booked"></div>
            <span>Sudah Dipesan</span>
          </div>
        </div>

        <!-- Booking Summary -->
        <div class="booking-summary">
          <h3 class="summary-title">Ringkasan Pemesanan</h3>
          <div class="selected-seats">
            <p>Kursi Terpilih: <span id="selectedSeatsText">Belum ada</span></p>
            <p>Jumlah Kursi: <span id="seatCount">0</span></p>
          </div>
          <div class="total-price">
            Total: Rp <span id="totalPrice">0</span>
          </div>
          <button type="submit" class="btn-book" id="btnBook" disabled>Booking Sekarang</button>
        </div>
      </form>
    <?php else: ?>
      <div style="text-align: center; color: #ccc; margin: 50px 0;">
        <p>Maaf, data film atau jadwal tidak tersedia.</p>
        <a href="index.php" style="color: #ffcc00; text-decoration: none;">Kembali ke Home</a>
      </div>
    <?php endif; ?>
  </main>

  <script>
    let selectedSeats = [];
    let seatPrice = <?= $jadwal['harga_tiket'] ?? 0 ?>;

    // Load seats when page loads
    document.addEventListener('DOMContentLoaded', function () {
      loadSeats();
    });

    function loadSeats() {
      const jadwalId = document.querySelector('input[name="jadwal_id"]').value;

      if (!jadwalId) {
        document.getElementById('seatsContainer').innerHTML = '<p style="color: #ccc; text-align: center;">Jadwal tidak valid</p>';
        return;
      }

      // Fetch available seats from server
      fetch(`index.php?controller=booking&action=getAvailableSeats&jadwal_id=${jadwalId}`)
        .then(response => response.json())
        .then(data => {
          renderSeats(data.availableSeats, data.bookedSeats);
        })
        .catch(error => {
          console.error('Error loading seats:', error);
          // Fallback to demo layout if API fails
          renderDemoSeats();
        });
    }

    function renderSeats(availableSeats, bookedSeats) {
      const seatsContainer = document.getElementById('seatsContainer');
      seatsContainer.innerHTML = '';

      // Group seats by row
      const seatsByRow = {};
      availableSeats.forEach(seat => {
        const row = seat.nomor_kursi.charAt(0);
        if (!seatsByRow[row]) seatsByRow[row] = [];
        seatsByRow[row].push(seat);
      });

      // Create rows
      Object.keys(seatsByRow).sort().forEach(row => {
        const rowDiv = document.createElement('div');
        rowDiv.className = 'seat-row';

        const rowLabel = document.createElement('div');
        rowLabel.className = 'row-label';
        rowLabel.textContent = row;
        rowDiv.appendChild(rowLabel);

        // Sort seats by number
        seatsByRow[row].sort((a, b) => parseInt(a.nomor_kursi.slice(1)) - parseInt(b.nomor_kursi.slice(1)));

        seatsByRow[row].forEach(seat => {
          const seatDiv = document.createElement('div');
          const isBooked = bookedSeats.some(bs => bs.kursi_id === seat.kursi_id);
          seatDiv.className = `seat ${isBooked ? 'booked' : 'available'}`;
          seatDiv.textContent = seat.nomor_kursi;
          seatDiv.dataset.seatId = seat.kursi_id;
          if (!isBooked) {
            seatDiv.onclick = () => toggleSeat(seatDiv);
          }
          rowDiv.appendChild(seatDiv);
        });

        seatsContainer.appendChild(rowDiv);
      });
    }

    function renderDemoSeats() {
      const seatsContainer = document.getElementById('seatsContainer');
      seatsContainer.innerHTML = '';

      // Create 5 rows of seats
      const rows = ['A', 'B', 'C', 'D', 'E'];
      rows.forEach(row => {
        const rowDiv = document.createElement('div');
        rowDiv.className = 'seat-row';

        const rowLabel = document.createElement('div');
        rowLabel.className = 'row-label';
        rowLabel.textContent = row;
        rowDiv.appendChild(rowLabel);

        // Create 10 seats per row
        for (let i = 1; i <= 10; i++) {
          const seatDiv = document.createElement('div');
          // Randomly mark some seats as booked for demo
          const isBooked = Math.random() > 0.7;
          seatDiv.className = `seat ${isBooked ? 'booked' : 'available'}`;
          seatDiv.textContent = row + i;
          seatDiv.dataset.seatId = row + i;
          if (!isBooked) {
            seatDiv.onclick = () => toggleSeat(seatDiv);
          }
          rowDiv.appendChild(seatDiv);
        }

        seatsContainer.appendChild(rowDiv);
      });
    }

    function toggleSeat(seatElement) {
      if (seatElement.classList.contains('booked')) return;

      const seatId = seatElement.dataset.seatId;
      const index = selectedSeats.indexOf(seatId);

      if (index > -1) {
        // Deselect seat
        selectedSeats.splice(index, 1);
        seatElement.classList.remove('selected');
        seatElement.classList.add('available');
      } else {
        // Select seat
        selectedSeats.push(seatId);
        seatElement.classList.remove('available');
        seatElement.classList.add('selected');
      }

      updateSummary();
    }

    function updateSummary() {
      const selectedSeatsText = selectedSeats.length > 0 ? selectedSeats.join(', ') : 'Belum ada';
      const seatCount = selectedSeats.length;
      const totalPrice = seatCount * seatPrice;

      document.getElementById('selectedSeatsText').textContent = selectedSeatsText;
      document.getElementById('seatCount').textContent = seatCount;
      document.getElementById('totalPrice').textContent = totalPrice.toLocaleString('id-ID');

      const btnBook = document.getElementById('btnBook');
      btnBook.disabled = selectedSeats.length === 0;

      // Add hidden inputs for selected seats
      const form = document.getElementById('bookingForm');
      // Remove existing hidden inputs
      const existingInputs = form.querySelectorAll('input[name="kursi_ids[]"]');
      existingInputs.forEach(input => input.remove());

      // Add new hidden inputs
      selectedSeats.forEach(seat => {
        const input = document.createElement('input');
        input.type = 'hidden';
        input.name = 'kursi_ids[]';
        input.value = seat;
        form.appendChild(input);
      });
    }

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
  </script>
</body>

</html>