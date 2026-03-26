<?php
// app/model/BookingModel.php
require_once __DIR__ . '/Database.php';

class BookingModel
{
  private $db;

  public function __construct()
  {
    $this->db = new Database();
  }

  // Get all bookings
  public function getAllBookings()
  {
    $query = "SELECT * FROM booking ORDER BY booking_id DESC";
    $stmt = $this->db->getConnection()->prepare($query);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }

  // Get booking by ID
  public function getBookingById($id)
  {
    $query = "SELECT b.*, f.judul, j.tanggal, j.jam_mulai, s.nama_studio, k.nomor_kursi, u.`nama` as nama_user, u.email
              FROM booking b
              JOIN jadwal j ON b.jadwal_id = j.jadwal_id
              JOIN film f ON j.film_id = f.film_id
              JOIN studio s ON j.studio_id = s.studio_id
              JOIN kursi k ON b.kursi_id = k.kursi_id
              JOIN users u ON b.user_id = u.user_id
              WHERE b.booking_id = ?";
    $stmt = $this->db->getConnection()->prepare($query);
    $stmt->execute([$id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
  }

  // Get bookings by user ID
  public function getBookingsByUserId($user_id)
  {
    $query = "SELECT b.*, f.judul, j.tanggal, j.jam_mulai, s.nama_studio, k.nomor_kursi
              FROM booking b
              JOIN jadwal j ON b.jadwal_id = j.jadwal_id
              JOIN film f ON j.film_id = f.film_id
              JOIN studio s ON j.studio_id = s.studio_id
              JOIN kursi k ON b.kursi_id = k.kursi_id
              WHERE b.user_id = ? ORDER BY b.tanggal_booking DESC";
    $stmt = $this->db->getConnection()->prepare($query);
    $stmt->execute([$user_id]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }

  // Delete old booking history for a specific user (cascade deletes payments)
  public function cleanupOldBookingsByUser($user_id, $days = 10)
  {
    $days = max(1, (int) $days);
    $cutoff = date('Y-m-d H:i:s', strtotime('-' . $days . ' days'));

    $query = "DELETE FROM booking WHERE user_id = ? AND tanggal_booking < ?";
    $stmt = $this->db->getConnection()->prepare($query);
    $stmt->execute([(int) $user_id, $cutoff]);
    return $stmt->rowCount();
  }

  // Get grouped purchase history by transaction
  public function getGroupedPurchaseHistoryByUserId($user_id)
  {
    $query = "SELECT
                b.user_id,
                b.jadwal_id,
                b.tanggal_booking AS purchase_date,
                GROUP_CONCAT(DISTINCT b.booking_id ORDER BY b.booking_id SEPARATOR ',') AS booking_ids,
                GROUP_CONCAT(DISTINCT k.nomor_kursi ORDER BY k.nomor_kursi SEPARATOR ', ') AS seats,
                COUNT(DISTINCT b.booking_id) AS seat_count,
                SUM(p.jumlah_bayar) AS ticket_total,
                MAX(p.metode_bayar) AS payment_method,
                j.tanggal AS jadwal_date,
                j.jam_mulai AS jadwal_time,
                s.nama_studio AS studio,
                f.judul AS film_title
              FROM booking b
              JOIN pembayaran p ON p.booking_id = b.booking_id
              JOIN jadwal j ON b.jadwal_id = j.jadwal_id
              JOIN film f ON j.film_id = f.film_id
              JOIN studio s ON j.studio_id = s.studio_id
              JOIN kursi k ON b.kursi_id = k.kursi_id
              WHERE b.user_id = ?
              GROUP BY b.user_id, b.jadwal_id, b.tanggal_booking
              ORDER BY b.tanggal_booking DESC";

    $stmt = $this->db->getConnection()->prepare($query);
    $stmt->execute([(int) $user_id]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }

  // Get bookings in the same transaction (exact booking timestamp + schedule)
  public function getTransactionBookings($user_id, $jadwal_id, $transaction_time)
  {
    $query = "SELECT b.*, k.nomor_kursi
              FROM booking b
              JOIN kursi k ON b.kursi_id = k.kursi_id
              WHERE b.user_id = ? AND b.jadwal_id = ? AND b.tanggal_booking = ?
              ORDER BY b.booking_id ASC";
    $stmt = $this->db->getConnection()->prepare($query);
    $stmt->execute([(int) $user_id, (int) $jadwal_id, $transaction_time]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }

  // Create new booking
  public function createBooking($user_id, $jadwal_id, $kursi_id)
  {
    $query = "INSERT INTO booking (user_id, jadwal_id, kursi_id) VALUES (?, ?, ?)";
    $stmt = $this->db->getConnection()->prepare($query);
    return $stmt->execute([$user_id, $jadwal_id, $kursi_id]);
  }

  // Create booking with multiple seats
  public function createBookingMultipleSeats($user_id, $jadwal_id, $kursi_ids)
  {
    $this->db->getConnection()->beginTransaction();
    try {
      $kursi_ids = array_values(array_unique(array_map('intval', (array) $kursi_ids)));
      if (empty($kursi_ids)) {
        $this->db->getConnection()->rollBack();
        return false;
      }

      // Lock schedule row and make sure the showtime is still valid.
      $scheduleStmt = $this->db->getConnection()->prepare(
        "SELECT jadwal_id
         FROM jadwal
         WHERE jadwal_id = ? AND TIMESTAMP(tanggal, jam_mulai) > NOW()
         FOR UPDATE"
      );
      $scheduleStmt->execute([$jadwal_id]);
      $lockedSchedule = $scheduleStmt->fetch(PDO::FETCH_ASSOC);
      if (!$lockedSchedule) {
        $this->db->getConnection()->rollBack();
        return false;
      }

      $booking_ids = [];
      foreach ($kursi_ids as $kursi_id) {
        // Validate seat belongs to this schedule's studio and still active.
        $seatStmt = $this->db->getConnection()->prepare(
          "SELECT k.kursi_id
           FROM kursi k
           JOIN jadwal j ON j.studio_id = k.studio_id
           WHERE j.jadwal_id = ? AND k.kursi_id = ? AND k.status = 'aktif'
           FOR UPDATE"
        );
        $seatStmt->execute([$jadwal_id, $kursi_id]);
        $seat = $seatStmt->fetch(PDO::FETCH_ASSOC);
        if (!$seat) {
          $this->db->getConnection()->rollBack();
          return false;
        }

        // Prevent duplicate booking for the same seat on the same schedule.
        $bookedStmt = $this->db->getConnection()->prepare(
          "SELECT booking_id
           FROM booking
           WHERE jadwal_id = ? AND kursi_id = ?
           FOR UPDATE"
        );
        $bookedStmt->execute([$jadwal_id, $kursi_id]);
        if ($bookedStmt->fetch(PDO::FETCH_ASSOC)) {
          $this->db->getConnection()->rollBack();
          return false;
        }

        $query = "INSERT INTO booking (user_id, jadwal_id, kursi_id) VALUES (?, ?, ?)";
        $stmt = $this->db->getConnection()->prepare($query);
        $stmt->execute([$user_id, $jadwal_id, $kursi_id]);
        $booking_ids[] = $this->db->getConnection()->lastInsertId();
      }
      $this->db->getConnection()->commit();
      return $booking_ids;
    } catch (Exception $e) {
      $this->db->getConnection()->rollBack();
      return false;
    }
  }

  // Update booking status
  public function updateBookingStatus($id, $status)
  {
    $query = "UPDATE booking SET status = ? WHERE booking_id = ?";
    $stmt = $this->db->getConnection()->prepare($query);
    return $stmt->execute([$status, $id]);
  }

  // Delete booking
  public function deleteBooking($id)
  {
    $query = "DELETE FROM booking WHERE booking_id = ?";
    $stmt = $this->db->getConnection()->prepare($query);
    return $stmt->execute([$id]);
  }

  // Delete multiple bookings
  public function deleteBookingsByIds($ids)
  {
    $ids = array_values(array_unique(array_map('intval', (array) $ids)));
    if (empty($ids)) {
      return 0;
    }

    $placeholders = implode(',', array_fill(0, count($ids), '?'));
    $query = "DELETE FROM booking WHERE booking_id IN ($placeholders)";
    $stmt = $this->db->getConnection()->prepare($query);
    $stmt->execute($ids);
    return $stmt->rowCount();
  }

  // Check if seat is already booked for a schedule
  public function isSeatBooked($jadwal_id, $kursi_id)
  {
    $query = "SELECT COUNT(*) as count FROM booking WHERE jadwal_id = ? AND kursi_id = ?";
    $stmt = $this->db->getConnection()->prepare($query);
    $stmt->execute([$jadwal_id, $kursi_id]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return $result['count'] > 0;
  }

  // Get booked seats for a schedule
  public function getBookedSeats($jadwal_id)
  {
    $query = "SELECT kursi_id FROM booking WHERE jadwal_id = ?";
    $stmt = $this->db->getConnection()->prepare($query);
    $stmt->execute([$jadwal_id]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }
}
