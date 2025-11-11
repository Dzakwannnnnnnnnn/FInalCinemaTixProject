<?php
// app/controller/AuthController.php
require_once __DIR__ . '/../../functions.php';
require_once __DIR__ . '/../model/UserModel.php';

class AuthController
{
  private $userModel;

  public function __construct()
  {
    $this->userModel = new UserModel();
  }

  // Menampilkan halaman login
  public function login()
  {
    startSession();
    // If already logged in, redirect to dashboard
    if (isLoggedIn()) {
      header('Location: index.php?controller=user&action=index');
      exit();
    }

    $flash = getFlashMessage();
    require __DIR__ . '/../view/auth/loginUser.php';
  }

  // Proses login
  public function doLogin()
  {
    startSession();

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      $email = sanitizeEmail($_POST['email'] ?? '');
      $password = sanitize($_POST['password'] ?? '');

      // Validation
      if (empty($email) || empty($password)) {
        setFlashMessage('error', 'Email dan password harus diisi!');
        header("Location: index.php?controller=auth&action=login");
        exit;
      }

      $user = $this->userModel->getUserByEmail($email);

      if ($user && verifyPassword($password, $user['password'])) {
        $_SESSION['user_id'] = $user['user_id'];
        $_SESSION['user_name'] = $user['nama'];
        $_SESSION['role'] = $user['role'];

        // Redirect based on role
        if ($user['role'] === 'admin') {
          header("Location: index.php?controller=admin&action=index");
        } else {
          header("Location: index.php?controller=user&action=index");
        }
        exit;
      } else {
        setFlashMessage('error', 'Email atau password salah!');
        header("Location: index.php?controller=auth&action=login");
        exit;
      }
    }
  }

  // Menampilkan halaman register
  public function register()
  {
    startSession();
    // If already logged in, redirect to dashboard
    if (isLoggedIn()) {
      header('Location: index.php?controller=user&action=index');
      exit();
    }

    $flash = getFlashMessage();
    require __DIR__ . '/../view/auth/registerUser.php';
  }

  // Proses register
  public function doRegister()
  {
    startSession();

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      $nama = sanitize($_POST['nama'] ?? '');
      $email = sanitizeEmail($_POST['email'] ?? '');
      $password = sanitize($_POST['password'] ?? '');
      $confirm = sanitize($_POST['confirm'] ?? '');
      $no_hp = sanitize($_POST['no_hp'] ?? '');

      // Validation
      if (empty($nama) || empty($email) || empty($password) || empty($confirm) || empty($no_hp)) {
        setFlashMessage('error', 'Semua field harus diisi!');
        header("Location: index.php?controller=auth&action=register");
        exit;
      }

      if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        setFlashMessage('error', 'Format email tidak valid!');
        header("Location: index.php?controller=auth&action=register");
        exit;
      }

      if (strlen($password) < 6) {
        setFlashMessage('error', 'Password minimal 6 karakter!');
        header("Location: index.php?controller=auth&action=register");
        exit;
      }

      if ($password !== $confirm) {
        setFlashMessage('error', 'Konfirmasi password tidak cocok!');
        header("Location: index.php?controller=auth&action=register");
        exit;
      }

      if ($this->userModel->getUserByEmail($email)) {
        setFlashMessage('error', 'Email sudah terdaftar!');
        header("Location: index.php?controller=auth&action=register");
        exit;
      }

      $success = $this->userModel->registerUser($nama, $email, $password, $no_hp);

      if ($success) {
        setFlashMessage('success', 'Registrasi berhasil! Silakan login.');
        header("Location: index.php?controller=auth&action=login");
        exit;
      } else {
        setFlashMessage('error', 'Terjadi kesalahan. Coba lagi.');
        header("Location: index.php?controller=auth&action=register");
        exit;
      }
    }
  }

  // Logout user
  public function logout()
  {
    logout();
  }
}
