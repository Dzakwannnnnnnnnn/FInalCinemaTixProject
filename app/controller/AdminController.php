<?php
// app/controller/AdminController.php
require_once __DIR__ . '/../model/filmModel.php';
require_once __DIR__ . '/../model/NewsModel.php';
require_once __DIR__ . '/../model/UserModel.php';
require_once __DIR__ . '/../model/StudioModel.php';
require_once __DIR__ . '/../model/BookingModel.php';
require_once __DIR__ . '/../model/PaymentModel.php';

class AdminController
{
  private $filmModel;
  private $newsModel;
  private $userModel;
  private $studioModel;
  private $kursiModel;
  private $jadwalModel;
  private $bookingModel;
  private $paymentModel;

  public function __construct()
  {
    requireAdmin();
    $this->filmModel = new FilmModel();
    $this->newsModel = new NewsModel();
    $this->userModel = new UserModel();
    $this->studioModel = new StudioModel();
    $this->kursiModel = new KursiModel();
    $this->jadwalModel = new JadwalModel();
    $this->bookingModel = new BookingModel();
    $this->paymentModel = new PaymentModel();
  }

  // Dashboard Admin
  public function index()
  {
    $films = $this->filmModel->getAllFilms();
    $news = $this->newsModel->getAllNews();
    $users = $this->userModel->getAllUsers();

    $bookings = $this->bookingModel->getAllBookings();
    $stats = [
      'total_film' => count($films),
      'total_users' => count($users),
      'total_news' => count($news),
      'total_booking' => count($bookings)
    ];

    require_once __DIR__ . '/../view/admin/panelAdmin.php';
  }

  // Film Management
  public function films()
  {
    $films = $this->filmModel->getAllFilms();
    require_once __DIR__ . '/../view/admin/films.php';
  }

  public function addFilm()
  {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      $judul = sanitize($_POST['judul'] ?? '');
      $genre = sanitize($_POST['genre'] ?? '');
      $durasi = (int) ($_POST['durasi'] ?? 0);
      $rating_usia = sanitize($_POST['rating_usia'] ?? '');
      $rating_bintang = isset($_POST['rating_bintang']) && $_POST['rating_bintang'] !== '' ? (float) $_POST['rating_bintang'] : null;
      $deskripsi = sanitize($_POST['deskripsi'] ?? '');

      // Handle file upload
      $poster_url = '';
      if (isset($_FILES['poster']) && $_FILES['poster']['error'] === UPLOAD_ERR_OK) {
        $poster_url = uploadImage($_FILES['poster']);
        if (!$poster_url) {
          setFlashMessage('error', 'Gagal upload poster');
          header('Location: index.php?controller=admin&action=addFilm');
          exit;
        }
      }

      if ($this->filmModel->addFilm($judul, $genre, $durasi, $rating_usia, $deskripsi, $poster_url, $rating_bintang)) {
        setFlashMessage('success', 'Film berhasil ditambahkan');
        header('Location: index.php?controller=admin&action=films');
        exit;
      } else {
        setFlashMessage('error', 'Gagal menambahkan film');
      }
    }

    require_once __DIR__ . '/../view/admin/addFilm.php';
  }

  public function editFilm()
  {
    $id = $_GET['id'] ?? 0;
    $film = $this->filmModel->getFilmById($id);

    if (!$film) {
      setFlashMessage('error', 'Film tidak ditemukan');
      header('Location: index.php?controller=admin&action=films');
      exit;
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      $judul = sanitize($_POST['judul'] ?? '');
      $genre = sanitize($_POST['genre'] ?? '');
      $durasi = (int) ($_POST['durasi'] ?? 0);
      $rating_usia = sanitize($_POST['rating_usia'] ?? '');
      $rating_bintang = isset($_POST['rating_bintang']) && $_POST['rating_bintang'] !== '' ? (float) $_POST['rating_bintang'] : null;
      $deskripsi = sanitize($_POST['deskripsi'] ?? '');

      // Handle file upload
      $poster_url = $film['poster_url'];
      if (isset($_FILES['poster']) && $_FILES['poster']['error'] === UPLOAD_ERR_OK) {
        $new_poster = uploadImage($_FILES['poster']);
        if ($new_poster) {
          $poster_url = $new_poster;
        }
      }

      if ($this->filmModel->updateFilm($id, $judul, $genre, $durasi, $rating_usia, $deskripsi, $poster_url, $rating_bintang)) {
        setFlashMessage('success', 'Film berhasil diupdate');
        header('Location: index.php?controller=admin&action=films');
        exit;
      } else {
        setFlashMessage('error', 'Gagal mengupdate film');
      }
    }

    require_once __DIR__ . '/../view/admin/editFilm.php';
  }

  public function deleteFilm()
  {
    $id = $_GET['id'] ?? 0;

    if ($this->filmModel->deleteFilm($id)) {
      setFlashMessage('success', 'Film berhasil dihapus');
    } else {
      setFlashMessage('error', 'Gagal menghapus film');
    }

    header('Location: index.php?controller=admin&action=films');
    exit;
  }

  // News Management
  public function news()
  {
    $news = $this->newsModel->getAllNews();
    require_once __DIR__ . '/../view/admin/news.php';
  }

  public function addNews()
  {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      $judul_news = sanitize($_POST['judul_news'] ?? '');
      $deskripsi_news = sanitize($_POST['deskripsi_news'] ?? '');

      // Handle file upload
      $foto_news = '';
      if (isset($_FILES['foto_news']) && $_FILES['foto_news']['error'] === UPLOAD_ERR_OK) {
        $foto_news = uploadImage($_FILES['foto_news']);
        if (!$foto_news) {
          setFlashMessage('error', 'Gagal upload foto');
          header('Location: index.php?controller=admin&action=addNews');
          exit;
        }
      }

      if ($this->newsModel->addNews($judul_news, $deskripsi_news, $foto_news)) {
        setFlashMessage('success', 'Berita berhasil ditambahkan');
        header('Location: index.php?controller=admin&action=news');
        exit;
      } else {
        setFlashMessage('error', 'Gagal menambahkan berita');
      }
    }

    require_once __DIR__ . '/../view/admin/addNews.php';
  }

  public function editNews()
  {
    $id = $_GET['id'] ?? 0;
    $newsItem = $this->newsModel->getNewsById($id);

    if (!$newsItem) {
      setFlashMessage('error', 'Berita tidak ditemukan');
      header('Location: index.php?controller=admin&action=news');
      exit;
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      $judul_news = sanitize($_POST['judul_news'] ?? '');
      $deskripsi_news = sanitize($_POST['deskripsi_news'] ?? '');

      // Handle file upload
      $foto_news = $newsItem['foto_news'];
      if (isset($_FILES['foto_news']) && $_FILES['foto_news']['error'] === UPLOAD_ERR_OK) {
        $new_foto = uploadImage($_FILES['foto_news']);
        if ($new_foto) {
          $foto_news = $new_foto;
        }
      }

      if ($this->newsModel->updateNews($id, $judul_news, $deskripsi_news, $foto_news)) {
        setFlashMessage('success', 'Berita berhasil diupdate');
        header('Location: index.php?controller=admin&action=news');
        exit;
      } else {
        setFlashMessage('error', 'Gagal mengupdate berita');
      }
    }

    require_once __DIR__ . '/../view/admin/editNews.php';
  }

  public function deleteNews()
  {
    $id = $_GET['id'] ?? 0;

    if ($this->newsModel->deleteNews($id)) {
      setFlashMessage('success', 'Berita berhasil dihapus');
    } else {
      setFlashMessage('error', 'Gagal menghapus berita');
    }

    header('Location: index.php?controller=admin&action=news');
    exit;
  }

  // User Management
  public function users()
  {
    $users = $this->userModel->getAllUsers();
    require_once __DIR__ . '/../view/admin/users.php';
  }

  public function editUser()
  {
    $id = $_GET['id'] ?? 0;
    $user = $this->userModel->getUserById($id);

    if (!$user) {
      setFlashMessage('error', 'User tidak ditemukan');
      header('Location: index.php?controller=admin&action=users');
      exit;
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      $nama = sanitize($_POST['nama'] ?? '');
      $email = sanitizeEmail($_POST['email'] ?? '');
      $no_hp = sanitize($_POST['no_hp'] ?? '');

      if ($this->userModel->updateUser($id, $nama, $email, $no_hp)) {
        setFlashMessage('success', 'User berhasil diupdate');
        header('Location: index.php?controller=admin&action=users');
        exit;
      } else {
        setFlashMessage('error', 'Gagal mengupdate user');
      }
    }

    require_once __DIR__ . '/../view/admin/editUser.php';
  }

  public function deleteUser()
  {
    $id = $_GET['id'] ?? 0;

    if ($this->userModel->deleteUser($id)) {
      setFlashMessage('success', 'User berhasil dihapus');
    } else {
      setFlashMessage('error', 'Gagal menghapus user');
    }

    header('Location: index.php?controller=admin&action=users');
    exit;
  }

  // Studio Management
  public function studio()
  {
    $studios = $this->studioModel->getAllStudios();
    require_once __DIR__ . '/../view/admin/studio.php';
  }

  public function addStudio()
  {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      $nama_studio = sanitize($_POST['nama_studio'] ?? '');
      $tipe = sanitize($_POST['tipe'] ?? '');
      $kapasitas = (int) ($_POST['kapasitas'] ?? 0);

      if ($this->studioModel->addStudio($nama_studio, $tipe, $kapasitas)) {
        setFlashMessage('success', 'Studio berhasil ditambahkan');
        header('Location: index.php?controller=admin&action=studio');
        exit;
      } else {
        setFlashMessage('error', 'Gagal menambahkan studio');
      }
    }

    require_once __DIR__ . '/../view/admin/addStudio.php';
  }

  public function editStudio()
  {
    $id = $_GET['id'] ?? 0;
    $studio = $this->studioModel->getStudioById($id);

    if (!$studio) {
      setFlashMessage('error', 'Studio tidak ditemukan');
      header('Location: index.php?controller=admin&action=studio');
      exit;
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      $nama_studio = sanitize($_POST['nama_studio'] ?? '');
      $tipe = sanitize($_POST['tipe'] ?? '');
      $kapasitas = (int) ($_POST['kapasitas'] ?? 0);

      if ($this->studioModel->updateStudio($id, $nama_studio, $tipe, $kapasitas)) {
        setFlashMessage('success', 'Studio berhasil diupdate');
        header('Location: index.php?controller=admin&action=studio');
        exit;
      } else {
        setFlashMessage('error', 'Gagal mengupdate studio');
      }
    }

    require_once __DIR__ . '/../view/admin/editStudio.php';
  }

  public function deleteStudio()
  {
    $id = $_GET['id'] ?? 0;

    if ($this->studioModel->deleteStudio($id)) {
      setFlashMessage('success', 'Studio berhasil dihapus');
    } else {
      setFlashMessage('error', 'Gagal menghapus studio');
    }

    header('Location: index.php?controller=admin&action=studio');
    exit;
  }

  // Kursi Management
  public function kursi()
  {
    $studios = $this->studioModel->getAllStudios();
    $kursi = [];
    $selectedStudio = null;

    if (isset($_GET['studio_id'])) {
      $studio_id = (int) $_GET['studio_id'];
      $selectedStudio = $this->studioModel->getStudioById($studio_id);
      if ($selectedStudio) {
        $kursi = $this->kursiModel->getKursiByStudioId($studio_id);
        if (empty($kursi)) {
          // Generate seats automatically
          $this->kursiModel->generateSeatsForStudio($studio_id);
          $kursi = $this->kursiModel->getKursiByStudioId($studio_id);
        }
      }
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['kursi_id'])) {
      $kursi_id = (int) $_POST['kursi_id'];
      $new_status = $_POST['status'] === 'aktif' ? 'aktif' : 'tidak aktif';
      if ($this->kursiModel->updateKursiStatus($kursi_id, $new_status)) {
        setFlashMessage('success', 'Status kursi berhasil diupdate');
      } else {
        setFlashMessage('error', 'Gagal update status kursi');
      }
      header('Location: index.php?controller=admin&action=kursi&studio_id=' . ($selectedStudio['studio_id'] ?? ''));
      exit;
    }

    require_once __DIR__ . '/../view/admin/kursi.php';
  }

  // Jadwal Management
  public function jadwal()
  {
    $films = $this->filmModel->getAllFilms();
    $studios = $this->studioModel->getAllStudios();
    $jadwal = $this->jadwalModel->getAllJadwal();

    // Group schedules by film
    $jadwalByFilm = [];
    foreach ($jadwal as $j) {
      $jadwalByFilm[$j['film_id']][] = $j;
    }

    // Pass jadwal data to view
    $jadwalData = $jadwal;
    require_once __DIR__ . '/../view/admin/jadwal.php';
  }

  public function addJadwal()
  {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      $film_id = (int) ($_POST['film_id'] ?? 0);
      $studio_id = (int) ($_POST['studio_id'] ?? 0);
      $tanggal = sanitize($_POST['tanggal'] ?? '');
      $jam_mulai = sanitize($_POST['jam_mulai'] ?? '');
      $harga_tiket = (int) ($_POST['harga_tiket'] ?? 0);

      // Validate no studio conflict
      $existingJadwal = $this->jadwalModel->getAllJadwal();
      foreach ($existingJadwal as $j) {
        if ($j['studio_id'] == $studio_id && $j['tanggal'] == $tanggal && $j['jam_mulai'] == $jam_mulai) {
          setFlashMessage('error', 'Studio sudah digunakan untuk jadwal yang sama');
          header('Location: index.php?controller=admin&action=addJadwal');
          exit;
        }
      }

      if ($this->jadwalModel->addJadwal($film_id, $studio_id, $tanggal, $jam_mulai, $harga_tiket)) {
        setFlashMessage('success', 'Jadwal berhasil ditambahkan');
        header('Location: index.php?controller=admin&action=jadwal');
        exit;
      } else {
        setFlashMessage('error', 'Gagal menambahkan jadwal');
      }
    }

    $films = $this->filmModel->getAllFilms();
    $studios = $this->studioModel->getAllStudios();
    require_once __DIR__ . '/../view/admin/addJadwal.php';
  }

  public function editJadwal()
  {
    $id = $_GET['id'] ?? 0;
    $jadwal = $this->jadwalModel->getJadwalById($id);

    if (!$jadwal) {
      setFlashMessage('error', 'Jadwal tidak ditemukan');
      header('Location: index.php?controller=admin&action=jadwal');
      exit;
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      $film_id = (int) ($_POST['film_id'] ?? 0);
      $studio_id = (int) ($_POST['studio_id'] ?? 0);
      $tanggal = sanitize($_POST['tanggal'] ?? '');
      $jam_mulai = sanitize($_POST['jam_mulai'] ?? '');
      $harga_tiket = (int) ($_POST['harga_tiket'] ?? 0);

      // Validate no studio conflict (excluding current jadwal)
      $existingJadwal = $this->jadwalModel->getAllJadwal();
      foreach ($existingJadwal as $j) {
        if ($j['jadwal_id'] != $id && $j['studio_id'] == $studio_id && $j['tanggal'] == $tanggal && $j['jam_mulai'] == $jam_mulai) {
          setFlashMessage('error', 'Studio sudah digunakan untuk jadwal yang sama');
          header('Location: index.php?controller=admin&action=editJadwal&id=' . $id);
          exit;
        }
      }

      if ($this->jadwalModel->updateJadwal($id, $film_id, $studio_id, $tanggal, $jam_mulai, $harga_tiket)) {
        setFlashMessage('success', 'Jadwal berhasil diupdate');
        header('Location: index.php?controller=admin&action=jadwal');
        exit;
      } else {
        setFlashMessage('error', 'Gagal mengupdate jadwal');
      }
    }

    $films = $this->filmModel->getAllFilms();
    $studios = $this->studioModel->getAllStudios();
    require_once __DIR__ . '/../view/admin/editJadwal.php';
  }

  public function deleteJadwal()
  {
    $id = $_GET['id'] ?? 0;

    if ($this->jadwalModel->deleteJadwal($id)) {
      setFlashMessage('success', 'Jadwal berhasil dihapus');
    } else {
      setFlashMessage('error', 'Gagal menghapus jadwal');
    }

    header('Location: index.php?controller=admin&action=jadwal');
    exit;
  }

  // Booking Management
  public function bookings()
  {
    $bookings = $this->bookingModel->getAllBookings();
    require_once __DIR__ . '/../view/admin/bookings.php';
  }

  public function viewBooking()
  {
    $id = $_GET['id'] ?? 0;
    $booking = $this->bookingModel->getBookingById($id);

    if (!$booking) {
      setFlashMessage('error', 'Booking tidak ditemukan');
      header('Location: index.php?controller=admin&action=bookings');
      exit;
    }

    require_once __DIR__ . '/../view/admin/viewBooking.php';
  }

  public function editBooking()
  {
    $id = $_GET['id'] ?? 0;
    $booking = $this->bookingModel->getBookingById($id);

    if (!$booking) {
      setFlashMessage('error', 'Booking tidak ditemukan');
      header('Location: index.php?controller=admin&action=bookings');
      exit;
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      $status = sanitize($_POST['status'] ?? '');

      if ($this->bookingModel->updateBookingStatus($id, $status)) {
        setFlashMessage('success', 'Status booking berhasil diupdate');
        header('Location: index.php?controller=admin&action=bookings');
        exit;
      } else {
        setFlashMessage('error', 'Gagal mengupdate status booking');
      }
    }

    require_once __DIR__ . '/../view/admin/editBooking.php';
  }

  public function deleteBooking()
  {
    $id = $_GET['id'] ?? 0;

    if ($this->bookingModel->deleteBooking($id)) {
      setFlashMessage('success', 'Booking berhasil dihapus');
    } else {
      setFlashMessage('error', 'Gagal menghapus booking');
    }

    header('Location: index.php?controller=admin&action=bookings');
    exit;
  }

  // Payment Management
  public function payments()
  {
    $payments = $this->paymentModel->getAllPayments();
    require_once __DIR__ . '/../view/admin/payments.php';
  }

  public function viewPayment()
  {
    $id = $_GET['id'] ?? 0;
    $payment = $this->paymentModel->getPaymentById($id);

    if (!$payment) {
      setFlashMessage('error', 'Payment tidak ditemukan');
      header('Location: index.php?controller=admin&action=payments');
      exit;
    }

    require_once __DIR__ . '/../view/admin/viewPayment.php';
  }

public function editPayment()
{
    $id = $_GET['id'] ?? 0;
    $payment = $this->paymentModel->getPaymentById($id);

    if (!$payment) {
        setFlashMessage('error', 'Payment tidak ditemukan');
        header('Location: index.php?controller=admin&action=payments');
        exit;
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $status = $_POST['status'] ?? '';
        
        // Validate and sanitize status
        $allowedStatuses = ['pending', 'completed', 'failed', 'canceled'];
        if (!in_array($status, $allowedStatuses)) {
            $_SESSION['flash_message'] = [
                'type' => 'danger',
                'message' => 'Invalid status value'
            ];
            header('Location: index.php?controller=admin&action=payments');
            exit;
        }
        
        // Debug: log the update attempt
        error_log("Attempting to update payment $id to status: $status");
        
        if ($this->paymentModel->updatePaymentStatus($id, $status)) {
            $_SESSION['flash_message'] = [
                'type' => 'success',
                'message' => 'Payment status updated successfully'
            ];
            
            // Refresh the payment data after update
            $payment = $this->paymentModel->getPaymentById($id);
            error_log("Payment $id updated successfully to: " . $payment['status']);
        } else {
            $_SESSION['flash_message'] = [
                'type' => 'danger',
                'message' => 'Failed to update payment status'
            ];
            error_log("Failed to update payment $id");
        }
        
        header('Location: index.php?controller=admin&action=viewPayment&id=' . $id);
        exit;
    }

    require_once __DIR__ . '/../view/admin/editPayment.php';
}
  public function deletePayment()
  {
    $id = $_GET['id'] ?? 0;

    if ($this->paymentModel->deletePayment($id)) {
      setFlashMessage('success', 'Payment berhasil dihapus');
    } else {
      setFlashMessage('error', 'Gagal menghapus payment');
    }

    header('Location: index.php?controller=admin&action=payments');
    exit;
  }
}