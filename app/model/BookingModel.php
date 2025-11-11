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
              JOIN user u ON b.user_id = u.user_id
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
      $booking_ids = [];
      foreach ($kursi_ids as $kursi_id) {
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
