<?php
// app/controller/FilmController.php
require_once __DIR__ . '/../../config/koneksi.php';
require_once __DIR__ . '/../model/FilmModel.php';

class FilmController
{
  public function detail()
  {
    $id = $_GET['id'] ?? null;
    if (!$id) {
      echo "Film ID tidak ditemukan.";
      return;
    }

    $filmModel = new FilmModel();
    $film = $filmModel->getFilmById($id);

    if (!$film) {
      echo "Film tidak ditemukan.";
      return;
    }

    // Pass film data to view
    require_once __DIR__ . '/../view/users/detail.php';
  }
}
