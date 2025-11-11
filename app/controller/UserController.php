<?php
// app/controller/UserController.php

require_once __DIR__ . '/../../config/koneksi.php';
require_once __DIR__ . '/../model/FilmModel.php';
require_once __DIR__ . '/../model/UserModel.php';
require_once __DIR__ . '/../model/NewsModel.php';

class UserController
{
  public function index()
  {
    $filmModel = new FilmModel();
    $films = $filmModel->getNowPlaying();

    $newsModel = new NewsModel();
    $news = $newsModel->getAllNews();

    include __DIR__ . '/../view/users/index.php';
  }

  public function login()
  {
    include __DIR__ . '/../view/users/loginUser.php';
  }

  public function register()
  {
    include __DIR__ . '/../view/users/registerUser.php';
  }

  public function profil()
  {
    include __DIR__ . '/../view/users/profil.php';
  }

  public function pesanan()
  {
    include __DIR__ . '/../view/users/pesanan_tiket.php';
  }

  public function tayang()
  {
    $filmModel = new FilmModel();
    $films = $filmModel->getNowPlaying();

    include __DIR__ . '/../view/users/sedang_tayang.php';
  }

  public function event()
  {
    include __DIR__ . '/../view/users/beritaEvent.php';
  }
}
