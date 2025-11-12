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

  // Forgot password page
  public function forgotPassword()
  {
    startSession();
    // If already logged in, redirect to dashboard
    if (isLoggedIn()) {
      header('Location: index.php?controller=user&action=index');
      exit();
    }

    $flash = getFlashMessage();
    require __DIR__ . '/../view/auth/forgotPassword.php';
  }

  // Process forgot password
  public function doForgotPassword()
  {
    startSession();

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      $email = sanitizeEmail($_POST['email'] ?? '');

      if (empty($email)) {
        setFlashMessage('error', 'Email harus diisi!');
        header("Location: index.php?controller=auth&action=forgotPassword");
        exit;
      }

      $user = $this->userModel->getUserByEmail($email);

      if ($user) {
        // Generate reset token
        $resetToken = bin2hex(random_bytes(32));
        $resetExpiry = date('Y-m-d H:i:s', strtotime('+1 hour'));

        // Store reset token in database
        $this->userModel->storeResetToken($user['user_id'], $resetToken, $resetExpiry);

        // Send reset email
        $this->sendResetEmail($email, $resetToken);

        setFlashMessage('success', 'Link reset password telah dikirim ke email Anda!');
      } else {
        // Don't reveal if email exists or not for security
        setFlashMessage('success', 'Jika email terdaftar, link reset password akan dikirim!');
      }

      header("Location: index.php?controller=auth&action=forgotPassword");
      exit;
    }
  }

  // Reset password page
  public function resetPassword()
  {
    startSession();
    // If already logged in, redirect to dashboard
    if (isLoggedIn()) {
      header('Location: index.php?controller=user&action=index');
      exit();
    }

    $token = $_GET['token'] ?? '';

    if (empty($token)) {
      setFlashMessage('error', 'Token reset tidak valid!');
      header("Location: index.php?controller=auth&action=login");
      exit;
    }

    // Verify token
    $user = $this->userModel->getUserByResetToken($token);

    if (!$user || strtotime($user['reset_expiry']) < time()) {
      setFlashMessage('error', 'Token reset tidak valid atau sudah kadaluarsa!');
      header("Location: index.php?controller=auth&action=login");
      exit;
    }

    $flash = getFlashMessage();
    require __DIR__ . '/../view/auth/resetPassword.php';
  }

  // Process reset password
  public function doResetPassword()
  {
    startSession();

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      $token = $_POST['token'] ?? '';
      $password = sanitize($_POST['password'] ?? '');
      $confirm = sanitize($_POST['confirm'] ?? '');

      if (empty($token) || empty($password) || empty($confirm)) {
        setFlashMessage('error', 'Semua field harus diisi!');
        header("Location: index.php?controller=auth&action=resetPassword&token=" . urlencode($token));
        exit;
      }

      if (strlen($password) < 6) {
        setFlashMessage('error', 'Password minimal 6 karakter!');
        header("Location: index.php?controller=auth&action=resetPassword&token=" . urlencode($token));
        exit;
      }

      if ($password !== $confirm) {
        setFlashMessage('error', 'Konfirmasi password tidak cocok!');
        header("Location: index.php?controller=auth&action=resetPassword&token=" . urlencode($token));
        exit;
      }

      // Verify token
      $user = $this->userModel->getUserByResetToken($token);

      if (!$user || strtotime($user['reset_expiry']) < time()) {
        setFlashMessage('error', 'Token reset tidak valid atau sudah kadaluarsa!');
        header("Location: index.php?controller=auth&action=login");
        exit;
      }

      // Update password and clear reset token
      if ($this->userModel->resetPassword($user['user_id'], $password)) {
        setFlashMessage('success', 'Password berhasil direset! Silakan login dengan password baru.');
        header("Location: index.php?controller=auth&action=login");
        exit;
      } else {
        setFlashMessage('error', 'Terjadi kesalahan. Coba lagi.');
        header("Location: index.php?controller=auth&action=resetPassword&token=" . urlencode($token));
        exit;
      }
    }
  }

  // Send reset email
  private function sendResetEmail($email, $token)
  {
    require_once __DIR__ . '/../../vendor/autoload.php';

    $mail = new PHPMailer\PHPMailer\PHPMailer(true);

    try {
      // Server settings
      $mail->isSMTP();
      $mail->Host = 'smtp.gmail.com';
      $mail->SMTPAuth = true;
      $mail->Username = 'your-email@gmail.com'; // Replace with your Gmail
      $mail->Password = 'your-app-password'; // Replace with your Gmail app password
      $mail->SMTPSecure = PHPMailer\PHPMailer\PHPMailer::ENCRYPTION_STARTTLS;
      $mail->Port = 587;

      // Recipients
      $mail->setFrom('your-email@gmail.com', 'Cinematix');
      $mail->addAddress($email);

      // Content
      $mail->isHTML(true);
      $mail->Subject = 'Reset Password - Cinematix';
      $resetLink = "http://localhost/CinemaTixProject/index.php?controller=auth&action=resetPassword&token=" . urlencode($token);
      $mail->Body = "
      <html>
      <head>
        <title>Reset Password Cinematix</title>
        <style>
          body { font-family: Arial, sans-serif; background-color: #f4f4f4; padding: 20px; }
          .container { background-color: #fff; padding: 20px; border-radius: 8px; max-width: 600px; margin: 0 auto; }
          .header { background-color: #ffd700; color: #000; padding: 10px; text-align: center; border-radius: 8px 8px 0 0; }
          .content { padding: 20px; }
          .button { background-color: #ffd700; color: #000; padding: 10px 20px; text-decoration: none; border-radius: 5px; display: inline-block; }
          .footer { text-align: center; color: #666; font-size: 12px; margin-top: 20px; }
        </style>
      </head>
      <body>
        <div class='container'>
          <div class='header'>
            <h2>Reset Password Cinematix</h2>
          </div>
          <div class='content'>
            <p>Halo,</p>
            <p>Anda telah meminta reset password untuk akun Cinematix Anda.</p>
            <p>Klik tombol berikut untuk mereset password Anda:</p>
            <p style='text-align: center;'><a href='$resetLink' class='button'>Reset Password</a></p>
            <p>Atau salin link berikut ke browser Anda:</p>
            <p>$resetLink</p>
            <p><strong>Link ini akan kadaluarsa dalam 1 jam.</strong></p>
            <p>Jika Anda tidak meminta reset password, abaikan email ini.</p>
          </div>
          <div class='footer'>
            <p>Salam,<br>Tim Cinematix</p>
          </div>
        </div>
      </body>
      </html>
      ";
      $mail->AltBody = "Reset Password Cinematix\n\nAnda telah meminta reset password untuk akun Cinematix Anda.\n\nKlik link berikut untuk mereset password Anda:\n$resetLink\n\nLink ini akan kadaluarsa dalam 1 jam.\n\nJika Anda tidak meminta reset password, abaikan email ini.\n\nSalam,\nTim Cinematix";

      $mail->send();
      error_log("Reset email sent successfully to $email");
    } catch (Exception $e) {
      error_log("Failed to send reset email to $email: " . $mail->ErrorInfo);
      // Fallback to PHP mail if SMTP fails
      $subject = 'Reset Password - Cinematix';
      $message = "
      <html>
      <head>
        <title>Reset Password Cinematix</title>
      </head>
      <body>
        <h2>Reset Password Cinematix</h2>
        <p>Anda telah meminta reset password untuk akun Cinematix Anda.</p>
        <p>Klik link berikut untuk mereset password Anda:</p>
        <p><a href=\"$resetLink\">$resetLink</a></p>
        <p>Link ini akan kadaluarsa dalam 1 jam.</p>
        <p>Jika Anda tidak meminta reset password, abaikan email ini.</p>
        <br>
        <p>Salam,<br>Tim Cinematix</p>
      </body>
      </html>
      ";

      $headers = "MIME-Version: 1.0" . "\r\n";
      $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
      $headers .= "From: Cinematix <noreply@cinematix.com>" . "\r\n";

      mail($email, $subject, $message, $headers);
    }
  }
}
