<?php
// app/controller/UserController.php

require_once __DIR__ . '/../../config/koneksi.php';
require_once __DIR__ . '/../model/FilmModel.php';
require_once __DIR__ . '/../model/UserModel.php';
require_once __DIR__ . '/../model/NewsModel.php';
require_once __DIR__ . '/../model/BookingModel.php';
require_once __DIR__ . '/../model/PaymentModel.php';
require_once __DIR__ . '/../model/JadwalModel.php';

class UserController
{
  public function index()
  {
    $filmModel = new FilmModel();
    $films = $filmModel->getNowPlaying();

    $newsModel = new NewsModel();
    $news = $newsModel->getAllNews();

    include __DIR__ . '/../view/users/index.php';
  }

  public function login()
  {
    include __DIR__ . '/../view/users/loginUser.php';
  }

  public function register()
  {
    include __DIR__ . '/../view/users/registerUser.php';
  }

  public function profil()
  {
    include __DIR__ . '/../view/users/profil.php';
  }

  public function pesanan()
  {
    // Allow access without login - users can browse films but need to login for booking

    $filmModel = new FilmModel();

    // Get all films for "Film Sedang Hits" section
    $films = $filmModel->getNowPlaying();

    // Get films by rating usia (assuming we have different age ratings)
    $filmsByRating = [];
    $ratings = ['SU', '13+', '17+', '21+'];
    foreach ($ratings as $rating) {
      $filmsByRating[$rating] = $filmModel->getFilmsByRatingUsia($rating);
    }

    // Get films by genre
    $genres = ['Action', 'Drama', 'Comedy', 'Horror', 'Romance', 'Thriller'];
    $filmsByGenre = [];
    foreach ($genres as $genre) {
      $filmsByGenre[$genre] = $filmModel->getFilmsByGenre($genre);
    }

    include __DIR__ . '/../view/users/pesanan_tiket.php';
  }

  public function tayang()
  {
    // Redirect to home page with anchor to movies section
    header('Location: index.php#movies');
    exit();
  }

  public function beritaEvent()
  {
    $newsModel = new NewsModel();
    $news = $newsModel->getAllNews();

    include __DIR__ . '/../view/users/beritaEvent.php';
  }

  public function detailBerita()
  {
    $news_id = $_GET['id'] ?? null;
    if (!$news_id) {
      header('Location: index.php?controller=user&action=beritaEvent');
      exit;
    }

    $newsModel = new NewsModel();
    $news = $newsModel->getNewsById($news_id);

    if (!$news) {
      header('Location: index.php?controller=user&action=beritaEvent');
      exit;
    }

    include __DIR__ . '/../view/users/detail_berita.php';
  }

  public function purchaseHistory()
  {
    startSession();
    // Check if user is logged in
    if (!isset($_SESSION['user_id'])) {
      header('Location: index.php?controller=auth&action=login');
      exit;
    }

    $bookingModel = new BookingModel();
    $paymentModel = new PaymentModel();
    $jadwalModel = new JadwalModel();
    $filmModel = new FilmModel();

    // Get user's completed bookings (those with payments)
    $bookings = $bookingModel->getBookingsByUserId($_SESSION['user_id']);
    $purchaseHistory = [];

    foreach ($bookings as $booking) {
      // Get payment details for this booking
      $payments = $paymentModel->getAllPayments();
      $bookingPayments = array_filter($payments, function ($p) use ($booking) {
        return $p['booking_id'] == $booking['booking_id'];
      });

      if (!empty($bookingPayments)) {
        // Get schedule details
        $jadwal = $jadwalModel->getJadwalById($booking['jadwal_id']);
        if ($jadwal) {
          $film = $filmModel->getFilmById($jadwal['film_id']);

          // Calculate total payment
          $totalAmount = 0;
          $adminFee = 0;
          foreach ($bookingPayments as $payment) {
            $totalAmount += $payment['jumlah_bayar'];
            // Calculate admin fee based on payment method
            switch ($payment['nama_method']) {
              case 'e_wallet':
                $adminFee = 2500;
                break;
              case 'credit_card':
                $adminFee = 5000;
                break;
            }
          }

          $purchaseHistory[] = [
            'booking_id' => $booking['booking_id'],
            'film_title' => $film ? $film['judul'] : 'Unknown Film',
            'jadwal_date' => $jadwal['tanggal'],
            'jadwal_time' => $jadwal['jam_mulai'],
            'studio' => $jadwal['nama_studio'] ?? 'Unknown Studio',
            'seat' => $booking['nomor_kursi'],
            'total_amount' => $totalAmount,
            'admin_fee' => $adminFee,
            'purchase_date' => $booking['created_at'] ?? date('Y-m-d H:i:s')
          ];
        }
      }
    }

    // Sort by purchase date (newest first)
    usort($purchaseHistory, function ($a, $b) {
      return strtotime($b['purchase_date']) - strtotime($a['purchase_date']);
    });

    include __DIR__ . '/../view/users/purchase_history.php';
  }
}
