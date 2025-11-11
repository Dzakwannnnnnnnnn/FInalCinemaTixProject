<?php
// app/model/NewsModel.php
require_once __DIR__ . '/Database.php';

class NewsModel
{
  private $db;

  public function __construct()
  {
    $this->db = new Database();
  }

  // Get all news
  public function getAllNews()
  {
    $query = "SELECT * FROM news ORDER BY id_news DESC";
    $stmt = $this->db->getConnection()->prepare($query);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }

  // Get news by ID
  public function getNewsById($id)
  {
    $query = "SELECT * FROM news WHERE id_news = ?";
    $stmt = $this->db->getConnection()->prepare($query);
    $stmt->execute([$id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
  }

  // Add new news
  public function addNews($judul_news, $deskripsi_news, $foto_news)
  {
    $query = "INSERT INTO news (judul_news, deskripsi_news, foto_news) VALUES (?, ?, ?)";
    $stmt = $this->db->getConnection()->prepare($query);
    return $stmt->execute([$judul_news, $deskripsi_news, $foto_news]);
  }

  // Update news
  public function updateNews($id, $judul_news, $deskripsi_news, $foto_news)
  {
    $query = "UPDATE news SET judul_news = ?, deskripsi_news = ?, foto_news = ? WHERE id_news = ?";
    $stmt = $this->db->getConnection()->prepare($query);
    return $stmt->execute([$judul_news, $deskripsi_news, $foto_news, $id]);
  }

  // Delete news
  public function deleteNews($id)
  {
    $query = "DELETE FROM news WHERE id_news = ?";
    $stmt = $this->db->getConnection()->prepare($query);
    return $stmt->execute([$id]);
  }

  // Search news
  public function searchNews($keyword)
  {
    $query = "SELECT * FROM news WHERE judul_news LIKE ? OR deskripsi_news LIKE ? ORDER BY id_news DESC";
    $stmt = $this->db->getConnection()->prepare($query);
    $searchTerm = "%$keyword%";
    $stmt->execute([$searchTerm, $searchTerm]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }
}
