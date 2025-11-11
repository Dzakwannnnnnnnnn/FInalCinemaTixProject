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
    requireLogin();

    $filmModel = new FilmModel();

    // Get all films for "Film Sedang Hits" section
    $films = $filmModel->getNowPlaying();

    // Get films by rating usia (assuming we have different age ratings)
    $filmsByRating = [];
    $ratings = ['SU', '13+', '17+', '21+'];
    foreach ($ratings as $rating) {
      $filmsByRating[$rating] = $filmModel->getFilmsByRatingUsia($rating);
    }

    // Get films by genre
    $genres = ['Action', 'Drama', 'Comedy', 'Horror', 'Romance', 'Thriller'];
    $filmsByGenre = [];
    foreach ($genres as $genre) {
      $filmsByGenre[$genre] = $filmModel->getFilmsByGenre($genre);
    }

    include __DIR__ . '/../view/users/pesanan_tiket.php';
  }

  public function tayang()
  {
    // Redirect to home page with anchor to movies section
    header('Location: index.php#movies');
    exit();
  }

  public function beritaEvent()
  {
    $newsModel = new NewsModel();
    $news = $newsModel->getAllNews();

    include __DIR__ . '/../view/users/beritaEvent.php';
  }
}
