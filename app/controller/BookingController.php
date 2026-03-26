<?php
// app/controller/BookingController.php
require_once __DIR__ . '/../../config/koneksi.php';
require_once __DIR__ . '/../model/FilmModel.php';
require_once __DIR__ . '/../model/JadwalModel.php';
require_once __DIR__ . '/../model/KursiModel.php';
require_once __DIR__ . '/../model/BookingModel.php';
require_once __DIR__ . '/../model/PaymentModel.php';
require_once __DIR__ . '/../model/StudioModel.php';

class BookingController
{
  private function isScheduleExpired($jadwal)
  {
    if (!$jadwal || empty($jadwal['tanggal']) || empty($jadwal['jam_mulai'])) {
      return true;
    }

    $showTimestamp = strtotime($jadwal['tanggal'] . ' ' . $jadwal['jam_mulai']);
    if ($showTimestamp === false) {
      return true;
    }

    return $showTimestamp <= time();
  }

  public function selectSchedule()
  {
    startSession();
    // Check if user is logged in
    if (!isset($_SESSION['user_id'])) {
      header('Location: index.php?controller=auth&action=login');
      exit;
    }

    $film_id = $_GET['film_id'] ?? null;
    if (!$film_id) {
      echo "Film ID tidak ditemukan.";
      return;
    }

    $filmModel = new FilmModel();
    $jadwalModel = new JadwalModel();

    $film = $filmModel->getFilmById($film_id);
    $jadwal = $jadwalModel->getJadwalByFilmId($film_id);

    if (!$film) {
      echo "Film tidak ditemukan.";
      return;
    }

    // Pass data to view
    require_once __DIR__ . '/../view/users/schedule_selection.php';
  }

  public function selectSeats()
  {
    startSession();
    // Check if user is logged in
    if (!isset($_SESSION['user_id'])) {
      header('Location: index.php?controller=auth&action=login');
      exit;
    }

    $jadwal_id = $_GET['jadwal_id'] ?? null;
    if (!$jadwal_id) {
      echo "Jadwal ID tidak ditemukan.";
      return;
    }

    $jadwalModel = new JadwalModel();
    $kursiModel = new KursiModel();
    $filmModel = new FilmModel();

    $jadwal = $jadwalModel->getJadwalById($jadwal_id);
    if (!$jadwal) {
      echo "Jadwal tidak ditemukan.";
      return;
    }

    if ($this->isScheduleExpired($jadwal)) {
      echo "Jadwal sudah habis.";
      return;
    }

    $film = $filmModel->getFilmById($jadwal['film_id']);
    $jadwalList = $jadwalModel->getJadwalByFilmId($jadwal['film_id']);

    // Pass data to view
    require_once __DIR__ . '/../view/users/seat_selection.php';
  }

  public function getAvailableSeats()
  {
    header('Content-Type: application/json');

    $jadwal_id = $_GET['jadwal_id'] ?? null;
    if (!$jadwal_id) {
      echo json_encode(['error' => 'Jadwal ID tidak ditemukan']);
      return;
    }

    $jadwalModel = new JadwalModel();
    $kursiModel = new KursiModel();
    $bookingModel = new BookingModel();
    $jadwal = $jadwalModel->getJadwalById($jadwal_id);

    if (!$jadwal || $this->isScheduleExpired($jadwal)) {
      echo json_encode(['error' => 'Jadwal sudah habis']);
      return;
    }

    $availableSeats = $kursiModel->getSeatsByJadwal($jadwal_id);
    $bookedSeats = $bookingModel->getBookedSeats($jadwal_id);

    echo json_encode([
      'availableSeats' => $availableSeats,
      'bookedSeats' => $bookedSeats
    ]);
  }

  public function selectPaymentMethod()
  {
    startSession();
    // Check if user is logged in
    if (!isset($_SESSION['user_id'])) {
      header('Location: index.php?controller=auth&action=login');
      exit;
    }

    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
      echo "Method tidak diizinkan.";
      return;
    }

    $jadwal_id = $_POST['jadwal_id'] ?? null;
    $kursi_ids = $_POST['kursi_ids'] ?? [];

    if (!$jadwal_id || empty($kursi_ids)) {
      echo "Data booking tidak lengkap.";
      return;
    }

    // Store booking data in session temporarily
    $_SESSION['temp_booking'] = [
      'jadwal_id' => $jadwal_id,
      'kursi_ids' => is_array($kursi_ids) ? $kursi_ids : explode(',', $kursi_ids),
      'seat_count' => count(is_array($kursi_ids) ? $kursi_ids : explode(',', $kursi_ids))
    ];

    $jadwalModel = new JadwalModel();
    $filmModel = new FilmModel();

    $jadwal = $jadwalModel->getJadwalById($jadwal_id);
    if (!$jadwal || $this->isScheduleExpired($jadwal)) {
      echo "Jadwal sudah habis.";
      return;
    }

    $film = $filmModel->getFilmById($jadwal['film_id']);
    $kursi_ids_array = is_array($kursi_ids) ? $kursi_ids : explode(',', $kursi_ids);
    $total_harga = $jadwal['harga_tiket'] * count($kursi_ids_array);

    // Pass data to view
    require_once __DIR__ . '/../view/users/payment_method.php';
  }

  public function processPayment()
  {
    startSession();
    // Check if user is logged in
    if (!isset($_SESSION['user_id'])) {
      header('Location: index.php?controller=auth&action=login');
      exit;
    }

    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
      echo "Method tidak diizinkan.";
      return;
    }

    $payment_method = $_POST['payment_method'] ?? null;
    $temp_booking = $_SESSION['temp_booking'] ?? null;

    if (!$payment_method || !$temp_booking) {
      echo "Data pembayaran tidak lengkap.";
      return;
    }

    $bookingModel = new BookingModel();
    $paymentModel = new PaymentModel();
    $jadwalModel = new JadwalModel();
    $filmModel = new FilmModel();

    $user_id = $_SESSION['user_id'];
    $jadwal_id = $temp_booking['jadwal_id'];
    $kursi_ids = $temp_booking['kursi_ids'];

    // Get jadwal and film info for display
    $jadwal = $jadwalModel->getJadwalById($jadwal_id);
    if (!$jadwal || $this->isScheduleExpired($jadwal)) {
      echo "Jadwal sudah habis.";
      unset($_SESSION['temp_booking']);
      return;
    }

    $film = $filmModel->getFilmById($jadwal['film_id']);

    // Calculate total price based on payment method
    $base_price = $jadwal['harga_tiket'] * count($kursi_ids);
    $admin_fee = 0;

    switch ($payment_method) {
      case 'e_wallet':
        $admin_fee = 2500;
        break;
      case 'credit_card':
        $admin_fee = 5000;
        break;
    }

    $total_harga = $base_price + $admin_fee;

    // Create bookings for multiple seats
    $booking_ids = $bookingModel->createBookingMultipleSeats($user_id, $jadwal_id, $kursi_ids);

    if (!$booking_ids) {
      echo "Gagal membuat booking. Kursi kemungkinan sudah dipilih user lain atau jadwal sudah habis.";
      return;
    }

    // Create payment record for each booking
    $payment_success = true;
    foreach ($booking_ids as $booking_id) {
      $result = $paymentModel->createPayment($booking_id, $payment_method, $jadwal['harga_tiket'], 'sukses');
      if (!$result) {
        $payment_success = false;
        break;
      }
    }

    if ($payment_success) {
      // Clear temp booking data
      unset($_SESSION['temp_booking']);

      // Generate e-ticket
      $this->generateETicket($booking_ids[0]); // Use first booking ID for e-ticket

      // Show processing page
      require_once __DIR__ . '/../view/users/process_payment.php';
      exit;
    } else {
      echo "Gagal memproses pembayaran.";
    }
  }

  public function eTicket()
  {
    // Check if user is logged in
    if (!isset($_SESSION['user_id'])) {
      header('Location: index.php?controller=auth&action=login');
      exit;
    }

    $booking_id = $_GET['booking_id'] ?? null;
    if (!$booking_id) {
      echo "Booking ID tidak ditemukan.";
      return;
    }

    $bookingModel = new BookingModel();
    $jadwalModel = new JadwalModel();
    $filmModel = new FilmModel();
    $paymentModel = new PaymentModel();

    // Get the specific booking
    $booking = $bookingModel->getBookingById($booking_id);

    if (!$booking || $booking['user_id'] != $_SESSION['user_id']) {
      echo "Booking tidak ditemukan.";
      return;
    }

    // Get jadwal and film info
    $jadwal = $jadwalModel->getJadwalById($booking['jadwal_id']);
    $film = $filmModel->getFilmById($jadwal['film_id']);

    // Get studio info by joining with studio table
    $studioModel = new StudioModel();
    $studio = $studioModel->getStudioById($jadwal['studio_id']);
    $jadwal['nama_studio'] = $studio['nama_studio'] ?? 'N/A';
    $jadwal['tipe'] = $studio['tipe'] ?? 'N/A';

    // Get all bookings in the same transaction (exact timestamp + jadwal)
    $relatedBookings = $bookingModel->getTransactionBookings(
      $_SESSION['user_id'],
      $jadwal['jadwal_id'],
      $booking['tanggal_booking']
    );

    // Get payment info for all related bookings
    $payments = $paymentModel->getAllPayments();
    $bookingPayments = array_filter($payments, function ($p) use ($relatedBookings) {
      foreach ($relatedBookings as $booking) {
        if ($p['booking_id'] == $booking['booking_id']) {
          return true;
        }
      }
      return false;
    });

    // Calculate admin fee based on payment method (use first payment found)
    $admin_fee = 0;
    $firstPayment = reset($bookingPayments);
    if ($firstPayment) {
      switch ($firstPayment['nama_method']) {
        case 'e_wallet':
          $admin_fee = 2500;
          break;
        case 'credit_card':
          $admin_fee = 5000;
          break;
      }
    }

    // Collect all seat numbers and booking IDs
    $allSeats = [];
    $allBookingIds = [];
    foreach ($relatedBookings as $b) {
      $allSeats[] = $b['nomor_kursi'];
      $allBookingIds[] = $b['booking_id'];
    }

    // Calculate total ticket price (base price for all seats)
    $total_ticket_price = $jadwal['harga_tiket'] * count($allSeats);

    // Prepare booking data for the template - multiple bookings
    $bookingData = [
      'judul' => $film['judul'] ?? 'N/A',
      'tanggal' => $jadwal['tanggal'] ?? '',
      'jam_mulai' => $jadwal['jam_mulai'] ?? '',
      'nama_studio' => $jadwal['nama_studio'] ?? 'N/A',
      'tipe' => $jadwal['tipe'] ?? 'N/A',
      'nomor_kursi' => implode(', ', $allSeats),
      'booking_ids' => $allBookingIds,
      'seat_count' => count($allSeats)
    ];

    // Generate barcode using the first booking ID
    require_once __DIR__ . '/../../vendor/autoload.php';
    $generator = new Picqer\Barcode\BarcodeGeneratorPNG();
    $barcode = base64_encode($generator->getBarcode($booking_id, $generator::TYPE_CODE_128));

    // Pass data to view
    require_once __DIR__ . '/../view/users/e_ticket.php';
  }

  private function generateETicket($booking_id)
  {
    // In a real application, you might save e-ticket data to database
    // For now, we'll just use the booking ID as reference
    return true;
  }

  // Legacy method for backward compatibility
  public function bookSeats()
  {
    // Redirect to new flow
    $this->selectPaymentMethod();
  }
}
