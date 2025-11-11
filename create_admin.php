<?php
require_once 'config/koneksi.php';
require_once 'functions.php';

try {
  $pdo = new PDO('mysql:host=localhost;dbname=cinematicket', 'root', '');
  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

  // Check if admin exists
  $stmt = $pdo->prepare('SELECT COUNT(*) FROM users WHERE role = ?');
  $stmt->execute(['admin']);
  $count = $stmt->fetchColumn();

  if ($count == 0) {
    $hashedPassword = password_hash('admin123', PASSWORD_DEFAULT);
    $stmt = $pdo->prepare('INSERT INTO users (nama, email, password, no_hp, role) VALUES (?, ?, ?, ?, ?)');
    $stmt->execute(['Administrator', 'admin@cinematix.com', $hashedPassword, '081234567890', 'admin']);
    echo 'Admin user created successfully!' . PHP_EOL;
    echo 'Email: admin@cinematix.com' . PHP_EOL;
    echo 'Password: admin123' . PHP_EOL;
  } else {
    echo 'Admin user already exists.' . PHP_EOL;
  }
} catch (PDOException $e) {
  echo 'Database error: ' . $e->getMessage() . PHP_EOL;
}
