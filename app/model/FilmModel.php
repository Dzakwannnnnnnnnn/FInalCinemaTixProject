<?php
// app/model/FilmModel.php
require_once __DIR__ . '/Database.php';

class FilmModel
{
  private $db;

  public function __construct()
  {
    $this->db = new Database();
  }

  // Get all films
  public function getAllFilms()
  {
    $query = "SELECT * FROM film ORDER BY film_id DESC";
    $stmt = $this->db->getConnection()->prepare($query);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }

  // Get film by ID
  public function getFilmById($id)
  {
    $query = "SELECT * FROM film WHERE film_id = ?";
    $stmt = $this->db->getConnection()->prepare($query);
    $stmt->execute([$id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
  }

  // Add new film
  public function addFilm($judul, $genre, $durasi, $rating_usia, $deskripsi, $poster_url, $rating = null)
  {
    $query = "INSERT INTO film (judul, genre, durasi, rating_usia, deskripsi, poster_url) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $this->db->getConnection()->prepare($query);
    return $stmt->execute([$judul, $genre, $durasi, $rating_usia, $deskripsi, $poster_url]);
  }

  // Update film
  public function updateFilm($id, $judul, $genre, $durasi, $rating_usia, $deskripsi, $poster_url, $rating = null)
  {
    $query = "UPDATE film SET judul = ?, genre = ?, durasi = ?, rating_usia = ?, deskripsi = ?, poster_url = ? WHERE film_id = ?";
    $stmt = $this->db->getConnection()->prepare($query);
    return $stmt->execute([$judul, $genre, $durasi, $rating_usia, $deskripsi, $poster_url, $id]);
  }

  // Delete film
  public function deleteFilm($id)
  {
    $query = "DELETE FROM film WHERE film_id = ?";
    $stmt = $this->db->getConnection()->prepare($query);
    return $stmt->execute([$id]);
  }

  // Get films that are currently playing (now playing) - limit to 3-4 latest films
  public function getNowPlaying()
  {
    $query = "SELECT * FROM film ORDER BY film_id DESC LIMIT 4";
    $stmt = $this->db->getConnection()->prepare($query);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }

  // Get coming soon films
  public function getComingSoon()
  {
    $query = "SELECT * FROM film ORDER BY film_id DESC";
    $stmt = $this->db->getConnection()->prepare($query);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }

  // Search films
  public function searchFilms($keyword)
  {
    $query = "SELECT * FROM film WHERE judul LIKE ? OR genre LIKE ? ORDER BY film_id DESC";
    $stmt = $this->db->getConnection()->prepare($query);
    $searchTerm = "%$keyword%";
    $stmt->execute([$searchTerm, $searchTerm]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }

  // Get films by rating usia
  public function getFilmsByRatingUsia($ratingUsia)
  {
    $query = "SELECT * FROM film WHERE rating_usia = ? ORDER BY film_id DESC";
    $stmt = $this->db->getConnection()->prepare($query);
    $stmt->execute([$ratingUsia]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }

  // Get films by genre
  public function getFilmsByGenre($genre)
  {
    $query = "SELECT * FROM film WHERE genre LIKE ? ORDER BY film_id DESC";
    $stmt = $this->db->getConnection()->prepare($query);
    $searchTerm = "%$genre%";
    $stmt->execute([$searchTerm]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }
}
