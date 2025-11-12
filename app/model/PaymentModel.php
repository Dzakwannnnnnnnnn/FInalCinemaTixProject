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
    $query = "SELECT p.*, b.booking_id, p.metode_bayar as nama_method, u.`nama` as nama_user,
                     p.jumlah_bayar as jumlah, p.tanggal_bayar as tanggal_pembayaran
              FROM pembayaran p
              JOIN booking b ON p.booking_id = b.booking_id
              JOIN users u ON b.user_id = u.user_id
              ORDER BY p.pembayaran_id DESC";
    $stmt = $this->db->getConnection()->prepare($query);
    $stmt->execute();
    $payments = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Map status values for consistency
    foreach ($payments as &$payment) {
      $payment['status'] = $this->mapStatusFromDb($payment['status']);
    }

    return $payments;
  }

  // Get payment by ID
  public function getPaymentById($id)
  {
    $query = "SELECT p.*, b.booking_id, p.metode_bayar as nama_method, u.`nama` as nama_user, f.judul, j.tanggal, j.jam_mulai, s.nama_studio,
                     p.jumlah_bayar as jumlah, p.tanggal_bayar as tanggal_pembayaran
              FROM pembayaran p
              JOIN booking b ON p.booking_id = b.booking_id
              JOIN users u ON b.user_id = u.user_id
              JOIN jadwal j ON b.jadwal_id = j.jadwal_id
              JOIN film f ON j.film_id = f.film_id
              JOIN studio s ON j.studio_id = s.studio_id
              WHERE p.pembayaran_id = ?";
    $stmt = $this->db->getConnection()->prepare($query);
    $stmt->execute([$id]);
    $payment = $stmt->fetch(PDO::FETCH_ASSOC);

    // Map status value for consistency
    if ($payment) {
      $payment['status'] = $this->mapStatusFromDb($payment['status']);
    }

    return $payment;
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

  // Get allowed status values from database schema
  public function getAllowedStatusValues()
  {
    try {
      $query = "SELECT COLUMN_TYPE 
                FROM INFORMATION_SCHEMA.COLUMNS 
                WHERE TABLE_NAME = 'pembayaran' 
                AND COLUMN_NAME = 'status' 
                AND TABLE_SCHEMA = DATABASE()";
      $stmt = $this->db->getConnection()->prepare($query);
      $stmt->execute();
      $result = $stmt->fetch(PDO::FETCH_ASSOC);

      if ($result && isset($result['COLUMN_TYPE'])) {
        // Parse ENUM values if it's an ENUM column
        if (preg_match("/^enum\((.*)\)$/", $result['COLUMN_TYPE'], $matches)) {
          $enum_values = str_getcsv($matches[1], ",", "'");
          return array_map('trim', $enum_values);
        }
      }

      // Default allowed values if we can't determine from schema
      return ['pending', 'completed', 'failed', 'canceled'];
    } catch (Exception $e) {
      // Fallback to default values
      return ['pending', 'completed', 'failed', 'canceled'];
    }
  }

  // Validate status value
  private function validateStatus($status)
  {
    $allowedStatuses = $this->getAllowedStatusValues();
    $status = strtolower(trim($status));

    // If status is not in allowed values, use the first allowed value as default
    if (!in_array($status, $allowedStatuses)) {
      error_log("Invalid status value: '$status'. Allowed values: " . implode(', ', $allowedStatuses));
      return $allowedStatuses[0]; // Return first allowed status as default
    }

    return $status;
  }

  // Map status from database to display values
  private function mapStatusFromDb($dbStatus)
  {
    $statusMap = [
      'sukses' => 'completed',
      'gagal' => 'failed',
      'pending' => 'pending'
    ];

    return $statusMap[$dbStatus] ?? $dbStatus;
  }

  // Map status to database values
  private function mapStatusToDb($displayStatus)
  {
    $statusMap = [
      'completed' => 'sukses',
      'failed' => 'gagal',
      'pending' => 'pending'
    ];

    return $statusMap[$displayStatus] ?? $displayStatus;
  }

  // Create payment
  public function createPayment($booking_id, $metode_bayar, $jumlah_bayar, $status = 'pending')
  {
    $validatedStatus = $this->validateStatus($status);

    $query = "INSERT INTO pembayaran (booking_id, metode_bayar, jumlah_bayar, status) VALUES (?, ?, ?, ?)";
    $stmt = $this->db->getConnection()->prepare($query);
    return $stmt->execute([$booking_id, $metode_bayar, $jumlah_bayar, $validatedStatus]);
  }

  // Update payment status
  public function updatePaymentStatus($id, $status)
  {
    // Map display status to database status
    $dbStatus = $this->mapStatusToDb($status);
    $validatedStatus = $this->validateStatus($dbStatus);

    $query = "UPDATE pembayaran SET status = ? WHERE pembayaran_id = ?";
    $stmt = $this->db->getConnection()->prepare($query);

    try {
      $result = $stmt->execute([$validatedStatus, $id]);

      // Check if any row was affected
      if ($result && $stmt->rowCount() > 0) {
        error_log("Payment $id status updated to: $validatedStatus - Rows affected: " . $stmt->rowCount());
        return true;
      } else {
        error_log("No rows affected when updating payment $id");
        return false;
      }
    } catch (PDOException $e) {
      error_log("Error updating payment status: " . $e->getMessage());
      return false;
    }
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