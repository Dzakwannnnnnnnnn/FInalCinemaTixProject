<?php
// app/controller/AdminController.php
require_once __DIR__ . '/../model/filmModel.php';
require_once __DIR__ . '/../model/NewsModel.php';
require_once __DIR__ . '/../model/UserModel.php';

class AdminController
{
  private $filmModel;
  private $newsModel;
  private $userModel;

  public function __construct()
  {
    requireAdmin();
    $this->filmModel = new FilmModel();
    $this->newsModel = new NewsModel();
    $this->userModel = new UserModel();
  }

  // Dashboard Admin
  public function index()
  {
    $films = $this->filmModel->getAllFilms();
    $news = $this->newsModel->getAllNews();
    $users = $this->userModel->getAllUsers();

    $stats = [
      'total_film' => count($films),
      'total_users' => count($users),
      'total_news' => count($news),
      'total_booking' => 0 // TODO: Add booking count
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

      if ($this->filmModel->addFilm($judul, $genre, $durasi, $rating_usia, $deskripsi, $poster_url)) {
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
      $deskripsi = sanitize($_POST['deskripsi'] ?? '');

      // Handle file upload
      $poster_url = $film['poster_url'];
      if (isset($_FILES['poster']) && $_FILES['poster']['error'] === UPLOAD_ERR_OK) {
        $new_poster = uploadImage($_FILES['poster']);
        if ($new_poster) {
          $poster_url = $new_poster;
        }
      }

      if ($this->filmModel->updateFilm($id, $judul, $genre, $durasi, $rating_usia, $deskripsi, $poster_url)) {
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
}
