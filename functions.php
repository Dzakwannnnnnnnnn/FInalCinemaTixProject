<?php

function dd($value)
{
  echo "<pre>";
  var_dump($value);
  echo "</pre>";

  die();
}
function urlIs($value)
{
  return $_SERVER['REQUEST_URI'] == $value;
}

// Session management functions
function startSession()
{
  if (session_status() == PHP_SESSION_NONE) {
    session_start();
  }
}

function isLoggedIn()
{
  startSession();
  return isset($_SESSION['user_id']);
}

function isAdmin()
{
  startSession();
  return isset($_SESSION['role']) && $_SESSION['role'] === 'admin';
}

function requireLogin()
{
  if (!isLoggedIn()) {
    header('Location: index.php?controller=auth&action=login');
    exit();
  }
}

function requireAdmin()
{
  requireLogin();
  if (!isAdmin()) {
    header('Location: index.php?controller=user&action=index');
    exit();
  }
}

function logout()
{
  startSession();
  session_destroy();
  header('Location: index.php');
  exit();
}

// Sanitization functions
function sanitize($data)
{
  return htmlspecialchars(strip_tags(trim($data)));
}

function sanitizeEmail($email)
{
  return filter_var(trim($email), FILTER_SANITIZE_EMAIL);
}

// Password functions
function hashPassword($password)
{
  return password_hash($password, PASSWORD_DEFAULT);
}

function verifyPassword($password, $hash)
{
  return password_verify($password, $hash);
}

// File upload functions
function uploadImage($file, $targetDir = 'public/uploads/')
{
  if (!isset($file) || $file['error'] !== UPLOAD_ERR_OK) {
    return false;
  }

  $allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
  if (!in_array($file['type'], $allowedTypes)) {
    return false;
  }

  $maxSize = 5 * 1024 * 1024; // 5MB
  if ($file['size'] > $maxSize) {
    return false;
  }

  $fileName = time() . '_' . basename($file['name']);
  $targetPath = $targetDir . $fileName;

  if (move_uploaded_file($file['tmp_name'], $targetPath)) {
    return $fileName;
  }

  return false;
}

// Flash message functions
function setFlashMessage($type, $message)
{
  startSession();
  $_SESSION['flash'] = ['type' => $type, 'message' => $message];
}

function getFlashMessage()
{
  startSession();
  if (isset($_SESSION['flash'])) {
    $flash = $_SESSION['flash'];
    unset($_SESSION['flash']);
    return $flash;
  }
  return null;
}
