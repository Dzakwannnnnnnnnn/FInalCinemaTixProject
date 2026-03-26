<?php
require_once __DIR__ . '/../../../functions.php';

$aboutContent = isset($aboutContent) && is_array($aboutContent) ? $aboutContent : [];
$contactContent = isset($contactContent) && is_array($contactContent) ? $contactContent : [];
$basePath = rtrim(str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME'] ?? '')), '/');
$faviconIco = ($basePath !== '' ? $basePath : '') . '/public/favicon.ico';
$faviconPng = ($basePath !== '' ? $basePath : '') . '/public/favicon.png';
?>
<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>About - CinemaTix</title>
  <link rel="shortcut icon" href="<?= htmlspecialchars($faviconIco) ?>">
  <link rel="icon" type="image/x-icon" href="<?= htmlspecialchars($faviconIco) ?>">
  <link rel="icon" type="image/png" href="<?= htmlspecialchars($faviconPng) ?>">
  <style>
    * { box-sizing: border-box; margin: 0; padding: 0; font-family: "Poppins", sans-serif; }
    body { background: #060606; color: #fff; }
    .page-wrap { max-width: 1120px; margin: 0 auto; padding: 40px 24px 80px; }
    .topbar { display: flex; justify-content: space-between; align-items: center; margin-bottom: 40px; }
    .logo { color: #ffcc00; font-size: 28px; font-weight: 700; text-decoration: none; }
    .nav-links { display: flex; gap: 14px; }
    .nav-links a { color: #ddd; text-decoration: none; padding: 10px 14px; border-radius: 10px; transition: 0.3s ease; }
    .nav-links a:hover, .nav-links a.active { background: rgba(255, 204, 0, 0.12); color: #ffcc00; }
    .hero { padding: 72px 36px; border-radius: 28px; background: radial-gradient(circle at top right, rgba(255, 204, 0, 0.18), transparent 35%), linear-gradient(135deg, #151515, #0a0a0a); border: 1px solid rgba(255, 255, 255, 0.08); box-shadow: 0 20px 60px rgba(0, 0, 0, 0.35); }
    .hero h1 { font-size: 48px; margin-bottom: 16px; }
    .hero p { max-width: 760px; font-size: 18px; line-height: 1.7; color: #d0d0d0; }
    .content-grid { display: grid; grid-template-columns: repeat(2, 1fr); gap: 24px; margin-top: 28px; }
    .content-card { padding: 28px; border-radius: 22px; background: linear-gradient(180deg, rgba(255, 255, 255, 0.05), rgba(255, 255, 255, 0.02)); border: 1px solid rgba(255, 255, 255, 0.09); }
    .content-card h2 { color: #ffcc00; margin-bottom: 14px; font-size: 24px; }
    .content-card p { color: #d6d6d6; line-height: 1.8; }
    .closing { margin-top: 24px; padding: 24px 28px; border-left: 4px solid #ffcc00; background: rgba(255, 204, 0, 0.06); border-radius: 18px; color: #f0f0f0; line-height: 1.8; }
    .contact-section { margin-top: 28px; display: grid; grid-template-columns: 1.15fr 0.85fr; gap: 24px; }
    .contact-card,
    .contact-highlight { padding: 28px; border-radius: 22px; background: linear-gradient(180deg, rgba(255, 255, 255, 0.05), rgba(255, 255, 255, 0.02)); border: 1px solid rgba(255, 255, 255, 0.09); }
    .contact-card p,
    .contact-highlight p { color: #d6d6d6; line-height: 1.8; margin-bottom: 12px; }
    .contact-list { display: grid; gap: 14px; margin-top: 18px; }
    .contact-item { padding: 16px 18px; border-radius: 14px; background: rgba(255, 255, 255, 0.03); border: 1px solid rgba(255, 255, 255, 0.07); }
    .contact-label { display: block; color: #ffcc00; font-size: 13px; font-weight: 700; margin-bottom: 6px; text-transform: uppercase; letter-spacing: 0.08em; }
    .contact-badge { display: inline-block; margin-bottom: 14px; padding: 8px 14px; border-radius: 999px; background: rgba(255, 204, 0, 0.12); color: #ffcc00; border: 1px solid rgba(255, 204, 0, 0.32); font-size: 13px; font-weight: 700; }
    .cta { margin-top: 32px; }
    .cta a { display: inline-block; background: #ffcc00; color: #111; text-decoration: none; font-weight: 700; padding: 12px 22px; border-radius: 10px; }
    @media (max-width: 768px) {
      .topbar { flex-direction: column; gap: 16px; align-items: flex-start; }
      .nav-links { flex-wrap: wrap; }
      .hero { padding: 40px 24px; }
      .hero h1 { font-size: 36px; }
      .content-grid,
      .contact-section { grid-template-columns: 1fr; }
    }
  </style>
</head>

<body>
  <div class="page-wrap">
    <div class="topbar">
      <a href="index.php" class="logo">Cinematix</a>
      <div class="nav-links">
        <a href="index.php">Home</a>
        <a href="index.php?controller=user&action=pesanan">Film & Tiket</a>
        <a href="index.php?controller=user&action=beritaEvent">Berita & Event</a>
        <a href="index.php?controller=user&action=about" class="active">About & Contact</a>
      </div>
    </div>

    <section class="hero">
      <h1><?= htmlspecialchars($aboutContent['hero_title'] ?? 'Tentang CinemaTix') ?></h1>
      <p><?= htmlspecialchars($aboutContent['hero_subtitle'] ?? '') ?></p>
    </section>

    <div class="content-grid">
      <section class="content-card">
        <h2><?= htmlspecialchars($aboutContent['story_title'] ?? 'Cerita Kami') ?></h2>
        <p><?= htmlspecialchars($aboutContent['story_body'] ?? '') ?></p>
      </section>
      <section class="content-card">
        <h2><?= htmlspecialchars($aboutContent['vision_title'] ?? 'Visi') ?></h2>
        <p><?= htmlspecialchars($aboutContent['vision_body'] ?? '') ?></p>
      </section>
      <section class="content-card">
        <h2><?= htmlspecialchars($aboutContent['mission_title'] ?? 'Misi') ?></h2>
        <p><?= htmlspecialchars($aboutContent['mission_body'] ?? '') ?></p>
      </section>
      <section class="content-card">
        <h2>Kenapa CinemaTix</h2>
        <p>Mulai dari mencari film, memilih kursi, sampai menerima e-ticket, semua dibuat supaya penonton bisa menikmati proses booking tanpa ribet.</p>
      </section>
    </div>

    <div class="closing">
      <?= htmlspecialchars($aboutContent['closing_text'] ?? '') ?>
    </div>

    <section id="contact" class="contact-section">
      <div class="contact-card">
        <h2 style="color:#ffcc00; margin-bottom: 14px;">Contact</h2>
        <p><?= htmlspecialchars($contactContent['headline'] ?? '') ?></p>
        <div class="contact-list">
          <div class="contact-item">
            <span class="contact-label">Alamat</span>
            <div><?= htmlspecialchars($contactContent['address'] ?? '') ?></div>
          </div>
          <div class="contact-item">
            <span class="contact-label">Email</span>
            <div><?= htmlspecialchars($contactContent['email'] ?? '') ?></div>
          </div>
          <div class="contact-item">
            <span class="contact-label">Telepon</span>
            <div><?= htmlspecialchars($contactContent['phone'] ?? '') ?></div>
          </div>
          <div class="contact-item">
            <span class="contact-label">Jam Operasional</span>
            <div><?= htmlspecialchars($contactContent['hours'] ?? '') ?></div>
          </div>
        </div>
      </div>
      <div class="contact-highlight">
        <span class="contact-badge"><?= htmlspecialchars($contactContent['badge'] ?? 'CinemaTix Care') ?></span>
        <h2 style="color:#ffcc00; margin-bottom: 14px;"><?= htmlspecialchars($contactContent['highlight_title'] ?? 'Layanan Bantuan Cepat') ?></h2>
        <p><?= htmlspecialchars($contactContent['highlight_body'] ?? '') ?></p>
        <p><?= htmlspecialchars($contactContent['highlight_note'] ?? '') ?></p>
      </div>
    </section>

    <div class="cta">
      <a href="index.php?controller=user&action=pesanan">Pesan Tiket Sekarang</a>
    </div>
  </div>
</body>

</html>
