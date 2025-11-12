<?php
// app/model/KursiModel.php
require_once __DIR__ . '/Database.php';

class KursiModel
{
  private $db;

  public function __construct()
  {
    $this->db = new Database();
  }

  // Get all seats
  public function getAllKursi()
  {
    $query = "SELECT * FROM kursi ORDER BY kursi_id DESC";
    $stmt = $this->db->getConnection()->prepare($query);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }

  // Get seats by studio ID
  public function getKursiByStudioId($studio_id)
  {
    $query = "SELECT * FROM kursi WHERE studio_id = ? ORDER BY nomor_kursi";
    $stmt = $this->db->getConnection()->prepare($query);
    $stmt->execute([$studio_id]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }

  // Get available seats for a schedule (not booked)
  public function getAvailableSeats($jadwal_id)
  {
    $query = "SELECT k.* FROM kursi k
              JOIN jadwal j ON k.studio_id = j.studio_id
              WHERE j.jadwal_id = ? AND k.status = 'aktif'
              AND k.kursi_id NOT IN (
                SELECT b.kursi_id FROM booking b WHERE b.jadwal_id = ?
              )
              ORDER BY k.nomor_kursi";
    $stmt = $this->db->getConnection()->prepare($query);
    $stmt->execute([$jadwal_id, $jadwal_id]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }

  // Add new seat
  public function addKursi($studio_id, $nomor_kursi, $status = 'aktif')
  {
    $query = "INSERT INTO kursi (studio_id, nomor_kursi, status) VALUES (?, ?, ?)";
    $stmt = $this->db->getConnection()->prepare($query);
    return $stmt->execute([$studio_id, $nomor_kursi, $status]);
  }

  // Update seat status
  public function updateKursiStatus($id, $status)
  {
    $query = "UPDATE kursi SET status = ? WHERE kursi_id = ?";
    $stmt = $this->db->getConnection()->prepare($query);
    return $stmt->execute([$status, $id]);
  }

  // Delete seat
  public function deleteKursi($id)
  {
    $query = "DELETE FROM kursi WHERE kursi_id = ?";
    $stmt = $this->db->getConnection()->prepare($query);
    return $stmt->execute([$id]);
  }

  // Get seat by ID
  public function getKursiById($id)
  {
    $query = "SELECT * FROM kursi WHERE kursi_id = ?";
    $stmt = $this->db->getConnection()->prepare($query);
    $stmt->execute([$id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
  }

  // Generate seats for a studio based on capacity
  public function generateSeatsForStudio($studio_id)
  {
    // Get studio capacity
    require_once __DIR__ . '/StudioModel.php';
    $studioModel = new StudioModel();
    $studio = $studioModel->getStudioById($studio_id);
    if (!$studio)
      return false;

    $kapasitas = $studio['kapasitas'];
    $rows = ceil($kapasitas / 15); // 15 seats per row
    $seatsPerRow = 15;

    $this->db->getConnection()->beginTransaction();
    try {
      for ($row = 0; $row < $rows; $row++) {
        $rowLetter = chr(65 + $row); // A, B, C, ...
        $seatsInThisRow = min($seatsPerRow, $kapasitas - ($row * $seatsPerRow));

        for ($col = 1; $col <= $seatsInThisRow; $col++) {
          $nomor_kursi = $rowLetter . $col;
          $this->addKursi($studio_id, $nomor_kursi);
        }
      }
      $this->db->getConnection()->commit();
      return true;
    } catch (Exception $e) {
      $this->db->getConnection()->rollBack();
      return false;
    }
  }
}
