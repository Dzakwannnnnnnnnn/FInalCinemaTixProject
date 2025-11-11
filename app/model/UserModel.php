<?php
// app/model/UserModel.php
require_once __DIR__ . '/Database.php';

class UserModel
{
  private $db;

  public function __construct()
  {
    $this->db = new Database();
  }

  public function getUserByEmail($email)
  {
    $query = "SELECT * FROM users WHERE email = ?";
    $stmt = $this->db->getConnection()->prepare($query);
    $stmt->execute([$email]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
  }

  public function getUserById($id)
  {
    $query = "SELECT * FROM users WHERE user_id = ?";
    $stmt = $this->db->getConnection()->prepare($query);
    $stmt->execute([$id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
  }

  public function registerUser($nama, $email, $password, $no_hp = '')
  {
    $hashedPassword = hashPassword($password);
    $query = "INSERT INTO users (nama, email, password, no_hp) VALUES (?, ?, ?, ?)";
    $stmt = $this->db->getConnection()->prepare($query);
    return $stmt->execute([$nama, $email, $hashedPassword, $no_hp]);
  }

  public function updateUser($id, $nama, $email, $no_hp)
  {
    $query = "UPDATE users SET nama = ?, email = ?, no_hp = ? WHERE user_id = ?";
    $stmt = $this->db->getConnection()->prepare($query);
    return $stmt->execute([$nama, $email, $no_hp, $id]);
  }

  public function getAllUsers()
  {
    $query = "SELECT user_id, nama, email, no_hp, role FROM users ORDER BY user_id DESC";
    $stmt = $this->db->getConnection()->prepare($query);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }

  public function deleteUser($id)
  {
    $query = "DELETE FROM users WHERE user_id = ?";
    $stmt = $this->db->getConnection()->prepare($query);
    return $stmt->execute([$id]);
  }
}
