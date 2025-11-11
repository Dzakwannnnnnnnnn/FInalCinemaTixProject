<?php
// app/model/StudioModel.php
require_once __DIR__ . '/Database.php';

class StudioModel
{
  private $db;

  public function __construct()
  {
    $this->db = new Database();
  }

  // Get all studios
  public function getAllStudios()
  {
    $query = "SELECT * FROM studio ORDER BY studio_id DESC";
    $stmt = $this->db->getConnection()->prepare($query);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }

  // Get studio by ID
  public function getStudioById($id)
  {
    $query = "SELECT * FROM studio WHERE studio_id = ?";
    $stmt = $this->db->getConnection()->prepare($query);
    $stmt->execute([$id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
  }

  // Add new studio
  public function addStudio($nama_studio, $tipe, $kapasitas)
  {
    $query = "INSERT INTO studio (nama_studio, tipe, kapasitas) VALUES (?, ?, ?)";
    $stmt = $this->db->getConnection()->prepare($query);
    return $stmt->execute([$nama_studio, $tipe, $kapasitas]);
  }

  // Update studio
  public function updateStudio($id, $nama_studio, $tipe, $kapasitas)
  {
    $query = "UPDATE studio SET nama_studio = ?, tipe = ?, kapasitas = ? WHERE studio_id = ?";
    $stmt = $this->db->getConnection()->prepare($query);
    return $stmt->execute([$nama_studio, $tipe, $kapasitas, $id]);
  }

  // Delete studio
  public function deleteStudio($id)
  {
    $query = "DELETE FROM studio WHERE studio_id = ?";
    $stmt = $this->db->getConnection()->prepare($query);
    return $stmt->execute([$id]);
  }
}
