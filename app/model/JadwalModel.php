<?php
// app/model/JadwalModel.php
require_once __DIR__ . '/Database.php';

class JadwalModel
{
  private $db;

  public function __construct()
  {
    $this->db = new Database();
  }

  // Get all schedules
  public function getAllJadwal()
  {
    $query = "SELECT
                j.*,
                f.judul,
                s.nama_studio,
                s.tipe,
                TIMESTAMP(j.tanggal, j.jam_mulai) AS waktu_tayang,
                CASE
                  WHEN TIMESTAMP(j.tanggal, j.jam_mulai) <= NOW() THEN 1
                  ELSE 0
                END AS is_expired,
                (
                  SELECT COUNT(*)
                  FROM kursi k
                  WHERE k.studio_id = j.studio_id AND k.status = 'aktif'
                ) AS total_kursi_aktif,
                (
                  SELECT COUNT(*)
                  FROM booking b
                  WHERE b.jadwal_id = j.jadwal_id
                ) AS total_kursi_terbooking
              FROM jadwal j
              JOIN film f ON j.film_id = f.film_id
              JOIN studio s ON j.studio_id = s.studio_id
              ORDER BY j.jadwal_id DESC";
    $stmt = $this->db->getConnection()->prepare($query);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }

  // Get schedule by ID
  public function getJadwalById($id)
  {
    $query = "SELECT
                j.*,
                s.nama_studio,
                s.tipe,
                TIMESTAMP(j.tanggal, j.jam_mulai) AS waktu_tayang,
                CASE
                  WHEN TIMESTAMP(j.tanggal, j.jam_mulai) <= NOW() THEN 1
                  ELSE 0
                END AS is_expired
              FROM jadwal j
              JOIN studio s ON j.studio_id = s.studio_id
              WHERE j.jadwal_id = ?";
    $stmt = $this->db->getConnection()->prepare($query);
    $stmt->execute([$id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
  }

  // Get schedules by film ID
  public function getJadwalByFilmId($film_id)
  {
    $query = "SELECT
                j.*,
                s.nama_studio,
                s.tipe,
                f.judul,
                TIMESTAMP(j.tanggal, j.jam_mulai) AS waktu_tayang,
                CASE
                  WHEN TIMESTAMP(j.tanggal, j.jam_mulai) <= NOW() THEN 1
                  ELSE 0
                END AS is_expired,
                (
                  SELECT COUNT(*)
                  FROM kursi k
                  WHERE k.studio_id = j.studio_id AND k.status = 'aktif'
                ) AS total_kursi_aktif,
                (
                  SELECT COUNT(*)
                  FROM booking b
                  WHERE b.jadwal_id = j.jadwal_id
                ) AS total_kursi_terbooking
              FROM jadwal j
              JOIN studio s ON j.studio_id = s.studio_id
              JOIN film f ON j.film_id = f.film_id
              WHERE j.film_id = ? ORDER BY j.tanggal, j.jam_mulai";
    $stmt = $this->db->getConnection()->prepare($query);
    $stmt->execute([$film_id]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }

  // Add new schedule
  public function addJadwal($film_id, $studio_id, $tanggal, $jam_mulai, $harga_tiket)
  {
    $query = "INSERT INTO jadwal (film_id, studio_id, tanggal, jam_mulai, harga_tiket) VALUES (?, ?, ?, ?, ?)";
    $stmt = $this->db->getConnection()->prepare($query);
    return $stmt->execute([$film_id, $studio_id, $tanggal, $jam_mulai, $harga_tiket]);
  }

  // Update schedule
  public function updateJadwal($id, $film_id, $studio_id, $tanggal, $jam_mulai, $harga_tiket)
  {
    $query = "UPDATE jadwal SET film_id = ?, studio_id = ?, tanggal = ?, jam_mulai = ?, harga_tiket = ? WHERE jadwal_id = ?";
    $stmt = $this->db->getConnection()->prepare($query);
    return $stmt->execute([$film_id, $studio_id, $tanggal, $jam_mulai, $harga_tiket, $id]);
  }

  // Delete schedule
  public function deleteJadwal($id)
  {
    $query = "DELETE FROM jadwal WHERE jadwal_id = ?";
    $stmt = $this->db->getConnection()->prepare($query);
    return $stmt->execute([$id]);
  }
}
