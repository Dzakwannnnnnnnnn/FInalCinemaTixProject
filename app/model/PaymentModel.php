<?php
// app/model/PaymentModel.php
require_once __DIR__ . '/Database.php';

class PaymentModel
{
  private $db;

  public function __construct()
  {
    $this->db = new Database();
  }

  // Get all payments
  public function getAllPayments()
  {
    $query = "SELECT p.*, b.booking_id, p.metode_bayar as nama_method, u.`nama` as nama_user
              FROM pembayaran p
              JOIN booking b ON p.booking_id = b.booking_id
              JOIN users u ON b.user_id = u.user_id
              ORDER BY p.pembayaran_id DESC";
    $stmt = $this->db->getConnection()->prepare($query);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }

  // Get payment by ID
  public function getPaymentById($id)
  {
    $query = "SELECT p.*, b.booking_id, p.metode_bayar as nama_method, u.`nama` as nama_user, f.judul, j.tanggal, j.jam_mulai, s.nama_studio
              FROM pembayaran p
              JOIN booking b ON p.booking_id = b.booking_id
              JOIN users u ON b.user_id = u.user_id
              JOIN jadwal j ON b.jadwal_id = j.jadwal_id
              JOIN film f ON j.film_id = f.film_id
              JOIN studio s ON j.studio_id = s.studio_id
              WHERE p.pembayaran_id = ?";
    $stmt = $this->db->getConnection()->prepare($query);
    $stmt->execute([$id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
  }

  // Get all payment methods
  public function getAllPaymentMethods()
  {
    $query = "SELECT * FROM payment_method ORDER BY payment_method_id DESC";
    $stmt = $this->db->getConnection()->prepare($query);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }

  // Get payment method by ID
  public function getPaymentMethodById($id)
  {
    $query = "SELECT * FROM payment_method WHERE payment_method_id = ?";
    $stmt = $this->db->getConnection()->prepare($query);
    $stmt->execute([$id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
  }

  // Get payments by booking ID
  public function getPaymentsByBookingId($booking_id)
  {
    $query = "SELECT p.*, p.metode_bayar as nama_method FROM pembayaran p
              WHERE p.booking_id = ? ORDER BY p.tanggal_pembayaran DESC";
    $stmt = $this->db->getConnection()->prepare($query);
    $stmt->execute([$booking_id]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }

  // Create payment
  public function createPayment($booking_id, $metode_bayar, $jumlah_bayar, $status = 'pending')
  {
    $query = "INSERT INTO pembayaran (booking_id, metode_bayar, jumlah_bayar, status) VALUES (?, ?, ?, ?)";
    $stmt = $this->db->getConnection()->prepare($query);
    return $stmt->execute([$booking_id, $metode_bayar, $jumlah_bayar, $status]);
  }

  // Update payment status
  public function updatePaymentStatus($id, $status)
  {
    $query = "UPDATE pembayaran SET status = ? WHERE pembayaran_id = ?";
    $stmt = $this->db->getConnection()->prepare($query);
    return $stmt->execute([$status, $id]);
  }

  // Add payment method
  public function addPaymentMethod($nama_method, $tipe, $status = 'aktif')
  {
    $query = "INSERT INTO payment_method (nama_method, tipe, status) VALUES (?, ?, ?)";
    $stmt = $this->db->getConnection()->prepare($query);
    return $stmt->execute([$nama_method, $tipe, $status]);
  }

  // Update payment method
  public function updatePaymentMethod($id, $nama_method, $tipe, $status)
  {
    $query = "UPDATE payment_method SET nama_method = ?, tipe = ?, status = ? WHERE payment_method_id = ?";
    $stmt = $this->db->getConnection()->prepare($query);
    return $stmt->execute([$nama_method, $tipe, $status, $id]);
  }

  // Delete payment method
  public function deletePaymentMethod($id)
  {
    $query = "DELETE FROM payment_method WHERE payment_method_id = ?";
    $stmt = $this->db->getConnection()->prepare($query);
    return $stmt->execute([$id]);
  }

  // Delete payment
  public function deletePayment($id)
  {
    $query = "DELETE FROM pembayaran WHERE pembayaran_id = ?";
    $stmt = $this->db->getConnection()->prepare($query);
    return $stmt->execute([$id]);
  }
}
