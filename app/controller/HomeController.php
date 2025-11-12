<?php
// app/controller/HomeController.php
require_once __DIR__ . '/../../config/koneksi.php';
require_once __DIR__ . '/../model/FilmModel.php';
require_once __DIR__ . '/../model/NewsModel.php';

class HomeController
{
  public function index()
  {
    $filmModel = new FilmModel();
    $films = $filmModel->getNowPlaying();

    $newsModel = new NewsModel();
    $news = $newsModel->getLatestNews(3); // Get only 3 latest news

    // arahkan ke halaman utama
    require_once __DIR__ . '/../view/users/index.php';
  }
}
