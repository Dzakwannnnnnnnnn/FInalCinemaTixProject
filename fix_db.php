<?php
$config = require 'config/koneksi.php';
try {
  $pdo = new PDO('mysql:host=' . $config['host'] . ';dbname=' . $config['database'], $config['username'], $config['password']);
  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

  // Check if kursi_id column exists
  $result = $pdo->query('SHOW COLUMNS FROM booking LIKE "kursi_id"');
  if ($result->rowCount() == 0) {
    $pdo->exec('ALTER TABLE booking ADD COLUMN kursi_id INT NOT NULL AFTER jadwal_id');
    $pdo->exec('ALTER TABLE booking ADD CONSTRAINT fk_booking_kursi FOREIGN KEY (kursi_id) REFERENCES kursi(kursi_id) ON DELETE CASCADE ON UPDATE CASCADE');
    echo 'Column kursi_id added successfully to booking table.';
  } else {
    echo 'Column kursi_id already exists.';
  }
} catch (Exception $e) {
  echo 'Error: ' . $e->getMessage();
}
