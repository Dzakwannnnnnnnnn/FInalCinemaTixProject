<?php
// app/controller/BookingController.php
require_once __DIR__ . '/../../config/koneksi.php';
require_once __DIR__ . '/../model/FilmModel.php';
require_once __DIR__ . '/../model/JadwalModel.php';
require_once __DIR__ . '/../model/KursiModel.php';
require_once __DIR__ . '/../model/BookingModel.php';
require_once __DIR__ . '/../model/PaymentModel.php';

class BookingController
{
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

    $kursiModel = new KursiModel();
    $bookingModel = new BookingModel();

    $availableSeats = $kursiModel->getAvailableSeats($jadwal_id);
    $bookedSeats = $bookingModel->getBookedSeats($jadwal_id);

    echo json_encode([
      'availableSeats' => $availableSeats,
      'bookedSeats' => $bookedSeats
    ]);
  }

  public function selectPaymentMethod()
  {
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
    $film = $filmModel->getFilmById($jadwal['film_id']);
    $kursi_ids_array = is_array($kursi_ids) ? $kursi_ids : explode(',', $kursi_ids);
    $total_harga = $jadwal['harga_tiket'] * count($kursi_ids_array);

    // Pass data to view
    require_once __DIR__ . '/../view/users/payment_method.php';
  }

  public function processPayment()
  {
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
      echo "Gagal membuat booking.";
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

    // Get booking details (simplified - in real app, get all related bookings)
    $booking = $bookingModel->getBookingsByUserId($_SESSION['user_id']);
    $booking = array_filter($booking, function ($b) use ($booking_id) {
      return $b['booking_id'] == $booking_id;
    });
    $booking = reset($booking);

    if (!$booking) {
      echo "Booking tidak ditemukan.";
      return;
    }

    // Calculate total payment including admin fee
    $paymentModel = new PaymentModel();
    $allPayments = $paymentModel->getAllPayments();

    // Find all payments for this booking (there might be multiple seats)
    $relatedPayments = array_filter($allPayments, function ($p) use ($booking_id) {
      return $p['booking_id'] == $booking_id;
    });

    $payment = reset($relatedPayments);
    $admin_fee = 0;
    $total_ticket_price = 0;

    if ($payment && isset($payment['nama_method'])) {
      // Calculate admin fee based on payment method
      switch ($payment['nama_method']) {
        case 'e_wallet':
          $admin_fee = 2500;
          break;
        case 'credit_card':
          $admin_fee = 5000;
          break;
      }

      // Sum up all ticket prices for this booking session
      foreach ($relatedPayments as $p) {
        $total_ticket_price += $p['jumlah_bayar'];
      }
    }

    // Generate barcode
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
