<?php
$pdo = new PDO('mysql:host=localhost;dbname=cinematicket', 'root', 'Dzakwann033');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$result = $pdo->query('SHOW COLUMNS FROM booking LIKE "kursi_id"');
if ($result->rowCount() == 0) {
  $pdo->exec('ALTER TABLE booking ADD COLUMN kursi_id INT NOT NULL AFTER jadwal_id');
  $pdo->exec('ALTER TABLE booking ADD CONSTRAINT fk_booking_kursi FOREIGN KEY (kursi_id) REFERENCES kursi(kursi_id) ON DELETE CASCADE ON UPDATE CASCADE');
  echo 'Column kursi_id added successfully.';
} else {
  echo 'Column kursi_id already exists.';
}
