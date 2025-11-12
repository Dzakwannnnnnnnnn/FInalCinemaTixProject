<?php
try {
  $pdo = new PDO('mysql:host=localhost;dbname=cinematicket', 'root', 'Dzakwann033');
  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

  // Check if rating_bintang column exists
  $result = $pdo->query('SHOW COLUMNS FROM film LIKE "rating_bintang"');
  if ($result->rowCount() == 0) {
    $pdo->exec('ALTER TABLE film ADD COLUMN rating_bintang DECIMAL(3,1) DEFAULT NULL');
    echo 'Column rating_bintang added successfully to film table.';
  } else {
    echo 'Column rating_bintang already exists.';
  }
} catch (Exception $e) {
  echo 'Error: ' . $e->getMessage();
}
