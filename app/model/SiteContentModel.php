<?php
// app/model/SiteContentModel.php

class SiteContentModel
{
  private $filePath;

  public function __construct()
  {
    $this->filePath = __DIR__ . '/../../config/site_content.json';
    $this->ensureStorage();
  }

  private function ensureStorage()
  {
    if (!file_exists($this->filePath)) {
      $default = [
        'contact' => [
          'headline' => 'Butuh bantuan soal jadwal film, pemesanan tiket, atau kendala pembayaran? Tim CinemaTix siap bantu kamu dengan cepat.',
          'address' => 'Jl. Cinema Raya No. 21, Makassar, Sulawesi Selatan',
          'email' => 'support@cinematix.local',
          'phone' => '+62 411 555 0123',
          'hours' => 'Setiap hari, 10.00 - 22.00 WITA',
          'badge' => 'CinemaTix Care',
          'highlight_title' => 'Layanan Bantuan Cepat',
          'highlight_body' => 'Kami sarankan datang 15 menit sebelum jam tayang agar proses check-in tiket dan masuk studio lebih nyaman.',
          'highlight_note' => 'Untuk kerja sama event, promo brand, atau screening komunitas, hubungi tim kami melalui email support.'
        ],
        'about' => [
          'hero_title' => 'Tentang CinemaTix',
          'hero_subtitle' => 'Platform pemesanan tiket bioskop yang dibuat untuk pengalaman booking yang cepat, praktis, dan nyaman.',
          'story_title' => 'Cerita Kami',
          'story_body' => 'CinemaTix hadir untuk memudahkan penonton menemukan film favorit, memilih kursi terbaik, dan menyelesaikan pembayaran tanpa antre panjang di lokasi bioskop.',
          'vision_title' => 'Visi',
          'vision_body' => 'Menjadi platform booking bioskop yang sederhana, modern, dan mudah diakses oleh semua penonton.',
          'mission_title' => 'Misi',
          'mission_body' => 'Menghadirkan pengalaman pemesanan tiket yang efisien, informasi film yang jelas, dan dukungan pelanggan yang responsif.',
          'closing_text' => 'Kami percaya pengalaman menonton yang menyenangkan dimulai sejak proses booking pertama.'
        ]
      ];

      file_put_contents($this->filePath, json_encode($default, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE));
    }
  }

  public function getContent()
  {
    $content = @file_get_contents($this->filePath);
    if ($content === false || trim($content) === '') {
      return [];
    }

    $decoded = json_decode($content, true);
    return is_array($decoded) ? $decoded : [];
  }

  public function getSection($section)
  {
    $content = $this->getContent();
    $sectionData = $content[$section] ?? [];
    return is_array($sectionData) ? $sectionData : [];
  }

  public function updateSections($data)
  {
    return file_put_contents(
      $this->filePath,
      json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE)
    ) !== false;
  }
}
