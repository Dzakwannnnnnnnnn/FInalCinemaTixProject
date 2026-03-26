<?php
// app/controller/UserController.php

require_once __DIR__ . '/../../config/koneksi.php';
require_once __DIR__ . '/../model/FilmModel.php';
require_once __DIR__ . '/../model/UserModel.php';
require_once __DIR__ . '/../model/NewsModel.php';
require_once __DIR__ . '/../model/BookingModel.php';
require_once __DIR__ . '/../model/PaymentModel.php';
require_once __DIR__ . '/../model/JadwalModel.php';
require_once __DIR__ . '/../model/SiteContentModel.php';

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

  public function about()
  {
    $siteContentModel = new SiteContentModel();
    $aboutContent = $siteContentModel->getSection('about');
    $contactContent = $siteContentModel->getSection('contact');

    include __DIR__ . '/../view/users/about.php';
  }

  public function detailBerita(){
      // Ganti startSession() dengan session_start() langsung
      if (session_status() == PHP_SESSION_NONE) {
          session_start();
      }
      
      // Debug - cek session
      echo "<script>console.log('Session user_id:', '" . ($_SESSION['user_id'] ?? 'not set') . "')</script>";
      
      // Check if user is logged in
      if (!isset($_SESSION['user_id'])) {
          // Redirect ke login dengan pesan
          $_SESSION['login_message'] = 'Silakan login untuk mengakses halaman ini';
          header('Location: index.php?controller=auth&action=login');
          exit;
      }

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
    $userId = (int) $_SESSION['user_id'];
    // Keep history concise: remove data older than 10 days.
    $bookingModel->cleanupOldBookingsByUser($userId, 10);

    $transactions = $bookingModel->getGroupedPurchaseHistoryByUserId($userId);
    $purchaseHistory = [];

    foreach ($transactions as $trx) {
      $adminFee = 0;
      switch ($trx['payment_method']) {
        case 'e_wallet':
          $adminFee = 2500;
          break;
        case 'credit_card':
          $adminFee = 5000;
          break;
      }

      $bookingIds = array_filter(explode(',', $trx['booking_ids'] ?? ''));
      $firstBookingId = !empty($bookingIds) ? $bookingIds[0] : null;

      $purchaseHistory[] = [
        'booking_id' => $firstBookingId,
        'booking_ids' => $bookingIds,
        'seat_count' => (int) ($trx['seat_count'] ?? 0),
        'film_title' => $trx['film_title'] ?? 'Unknown Film',
        'jadwal_date' => $trx['jadwal_date'] ?? '',
        'jadwal_time' => $trx['jadwal_time'] ?? '',
        'studio' => $trx['studio'] ?? 'Unknown Studio',
        'seat' => $trx['seats'] ?? '',
        'total_amount' => (float) ($trx['ticket_total'] ?? 0),
        'admin_fee' => $adminFee,
        'purchase_date' => $trx['purchase_date'] ?? date('Y-m-d H:i:s')
      ];
    }

    // Sort by purchase date (newest first)
    usort($purchaseHistory, function ($a, $b) {
      return strtotime($b['purchase_date']) - strtotime($a['purchase_date']);
    });

    include __DIR__ . '/../view/users/purchase_history.php';
  }
}
