<?php
// index.php - Letakkan session_start() di paling atas
session_start();

require_once 'app/controller/AuthController.php';
require_once 'app/controller/UserController.php';
require_once 'app/controller/HomeController.php';
require_once 'app/controller/AdminController.php';

$controller = $_GET['controller'] ?? 'home';
$action = $_GET['action'] ?? 'index';

switch ($controller) {
  case 'auth':
    $auth = new AuthController();
    if (method_exists($auth, $action)) {
      $auth->$action();
    } else {
      echo "Halaman tidak ditemukan (Auth).";
    }
    break;

  case 'user':
    $user = new UserController();
    if (method_exists($user, $action)) {
      $user->$action();
    } else {
      echo "Halaman tidak ditemukan (User).";
    }
    break;

  case 'home':
    $home = new HomeController();
    if (method_exists($home, $action)) {
      $home->$action();
    } else {
      echo "Halaman tidak ditemukan (Home).";
    }
    break;

  case 'admin':
    $admin = new AdminController();
    if (method_exists($admin, $action)) {
      $admin->$action();
    } else {
      echo "Halaman tidak ditemukan (Admin).";
    }
    break;

  default:
    echo "Controller tidak ditemukan.";
}