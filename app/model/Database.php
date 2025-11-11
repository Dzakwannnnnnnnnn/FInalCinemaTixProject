<?php
// app/model/Database.php

class Database
{
  private $host = "localhost";
  private $dbname = "cinematicket"; // ganti sesuai nama database kamu
  private $username = "root";       // sesuaikan
  private $password = "Dzakwann033";           // sesuaikan
  private $conn;

  public function __construct()
  {
    $this->connect();
  }

  // 🔗 Membuat koneksi ke database
  private function connect()
  {
    try {
      $dsn = "mysql:host={$this->host};dbname={$this->dbname};charset=utf8mb4";
      $this->conn = new PDO($dsn, $this->username, $this->password);

      // Set mode error biar bisa debug lebih jelas
      $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
      // Kalo gagal konek, tampilin error-nya
      die("❌ Koneksi database gagal: " . $e->getMessage());
    }
  }

  // 🔄 Ambil koneksi (buat dipakai di model lain)
  public function getConnection()
  {
    return $this->conn;
  }
}
