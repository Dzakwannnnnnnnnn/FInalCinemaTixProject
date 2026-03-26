<?php
// app/model/HeroSlideModel.php

class HeroSlideModel
{
  private $filePath;

  public function __construct()
  {
    $this->filePath = __DIR__ . '/../../config/home_slides.json';
    $this->ensureStorage();
  }

  private function ensureStorage()
  {
    if (!file_exists($this->filePath)) {
      $default = [
        [
          'id' => 1,
          'image' => 'public/uploads/dune.jpg',
          'title' => 'Nikmati Pengalaman Nonton',
          'subtitle' => 'Temukan film terbaru dan jadwal bioskop favoritmu.',
          'button_text' => 'Pesan Tiket Sekarang',
          'button_link' => 'index.php?controller=user&action=pesanan',
          'sort_order' => 1
        ],
        [
          'id' => 2,
          'image' => 'public/uploads/star.jpg',
          'title' => 'Pengalaman Sinema Tanpa Antre',
          'subtitle' => 'Booking kursi lebih cepat langsung dari rumah.',
          'button_text' => 'Pilih Jadwal',
          'button_link' => 'index.php?controller=user&action=pesanan',
          'sort_order' => 2
        ],
        [
          'id' => 3,
          'image' => 'public/uploads/gost.jpg',
          'title' => 'Beli Tiket Online Sekarang',
          'subtitle' => 'Aman, praktis, dan langsung dapat e-ticket.',
          'button_text' => 'Mulai Booking',
          'button_link' => 'index.php?controller=user&action=pesanan',
          'sort_order' => 3
        ]
      ];
      file_put_contents($this->filePath, json_encode($default, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));
    }
  }

  public function getAllSlides()
  {
    $content = @file_get_contents($this->filePath);
    if ($content === false || trim($content) === '') {
      return [];
    }

    $slides = json_decode($content, true);
    if (!is_array($slides)) {
      return [];
    }

    usort($slides, function ($a, $b) {
      return ((int) ($a['sort_order'] ?? 0)) <=> ((int) ($b['sort_order'] ?? 0));
    });

    return $slides;
  }

  public function getSlideById($id)
  {
    foreach ($this->getAllSlides() as $slide) {
      if ((int) ($slide['id'] ?? 0) === (int) $id) {
        return $slide;
      }
    }
    return null;
  }

  public function saveAllSlides($slides)
  {
    return file_put_contents(
      $this->filePath,
      json_encode(array_values($slides), JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES)
    ) !== false;
  }

  public function addSlide($data)
  {
    $slides = $this->getAllSlides();
    $maxId = 0;
    $maxOrder = 0;
    foreach ($slides as $s) {
      $maxId = max($maxId, (int) ($s['id'] ?? 0));
      $maxOrder = max($maxOrder, (int) ($s['sort_order'] ?? 0));
    }

    $slides[] = [
      'id' => $maxId + 1,
      'image' => $data['image'] ?? '',
      'title' => $data['title'] ?? '',
      'subtitle' => $data['subtitle'] ?? '',
      'button_text' => $data['button_text'] ?? 'Pesan Tiket Sekarang',
      'button_link' => $data['button_link'] ?? 'index.php?controller=user&action=pesanan',
      'sort_order' => $maxOrder + 1
    ];

    return $this->saveAllSlides($slides);
  }

  public function updateSlide($id, $data)
  {
    $slides = $this->getAllSlides();
    $updated = false;

    foreach ($slides as &$slide) {
      if ((int) ($slide['id'] ?? 0) === (int) $id) {
        $slide['image'] = $data['image'] ?? $slide['image'];
        $slide['title'] = $data['title'] ?? $slide['title'];
        $slide['subtitle'] = $data['subtitle'] ?? $slide['subtitle'];
        $slide['button_text'] = $data['button_text'] ?? $slide['button_text'];
        $slide['button_link'] = $data['button_link'] ?? $slide['button_link'];
        $slide['sort_order'] = isset($data['sort_order']) ? (int) $data['sort_order'] : $slide['sort_order'];
        $updated = true;
        break;
      }
    }
    unset($slide);

    if (!$updated) {
      return false;
    }

    return $this->saveAllSlides($slides);
  }

  public function deleteSlide($id)
  {
    $slides = $this->getAllSlides();
    $filtered = array_values(array_filter($slides, function ($slide) use ($id) {
      return (int) ($slide['id'] ?? 0) !== (int) $id;
    }));

    if (count($filtered) === count($slides)) {
      return false;
    }

    return $this->saveAllSlides($filtered);
  }
}
