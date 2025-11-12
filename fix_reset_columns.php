<?php
include 'config/koneksi.php';

try {
  $pdo->exec('ALTER TABLE users ADD COLUMN reset_token VARCHAR(255) NULL');
  $pdo->exec('ALTER TABLE users ADD COLUMN reset_expiry DATETIME NULL');
  echo 'Columns added successfully';
} catch (Exception $e) {
  echo 'Error: ' . $e->getMessage();
}
?>