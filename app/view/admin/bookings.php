<?php
require_once __DIR__ . '/../layout/header.php';
?>

<div class="container-fluid">
  <div class="row">
    <?php require_once __DIR__ . '/../layout/sidebar.php'; ?>

    <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
      <div
        class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Booking Management</h1>
        <div class="btn-toolbar mb-2 mb-md-0">
          <div class="btn-group me-2">
            <a href="index.php?controller=admin&action=index" class="btn btn-sm btn-outline-secondary">Back to
              Dashboard</a>
          </div>
        </div>
      </div>

      <?php if (isset($_SESSION['flash_message'])): ?>
        <div class="alert alert-<?= $_SESSION['flash_message']['type'] ?> alert-dismissible fade show" role="alert">
          <?= $_SESSION['flash_message']['message'] ?>
          <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        <?php unset($_SESSION['flash_message']); ?>
      <?php endif; ?>

      <div class="table-responsive">
        <table class="table table-striped table-sm">
          <thead>
            <tr>
              <th>ID</th>
              <th>User</th>
              <th>Film</th>
              <th>Schedule</th>
              <th>Seat</th>
              <th>Status</th>
              <th>Booking Date</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($bookings as $booking): ?>
              <tr>
                <td><?= $booking['booking_id'] ?></td>
                <td>
                  <?php
                  // Get user info
                  $userModel = new UserModel();
                  $user = $userModel->getUserById($booking['user_id']);
                  echo $user ? htmlspecialchars($user['nama']) : 'Unknown';
                  ?>
                </td>
                <td>
                  <?php
                  // Get film info
                  $jadwalModel = new JadwalModel();
                  $jadwal = $jadwalModel->getJadwalById($booking['jadwal_id']);
                  if ($jadwal) {
                    $filmModel = new FilmModel();
                    $film = $filmModel->getFilmById($jadwal['film_id']);
                    echo $film ? htmlspecialchars($film['judul']) : 'Unknown';
                  } else {
                    echo 'Unknown';
                  }
                  ?>
                </td>
                <td>
                  <?php
                  if ($jadwal) {
                    echo htmlspecialchars($jadwal['tanggal'] . ' ' . $jadwal['jam_mulai']);
                  } else {
                    echo 'Unknown';
                  }
                  ?>
                </td>
                <td>
                  <?php
                  // Get seat info
                  $kursiModel = new KursiModel();
                  $kursi = $kursiModel->getKursiById($booking['kursi_id']);
                  echo $kursi ? htmlspecialchars($kursi['nomor_kursi']) : 'Unknown';
                  ?>
                </td>
                <td>
                  <span
                    class="badge bg-<?= $booking['status'] == 'confirmed' ? 'success' : ($booking['status'] == 'cancelled' ? 'danger' : 'warning') ?>">
                    <?= ucfirst($booking['status']) ?>
                  </span>
                </td>
                <td><?= htmlspecialchars($booking['tanggal_booking']) ?></td>
                <td>
                  <a href="index.php?controller=admin&action=viewBooking&id=<?= $booking['booking_id'] ?>"
                    class="btn btn-sm btn-outline-primary">View</a>
                  <a href="index.php?controller=admin&action=editBooking&id=<?= $booking['booking_id'] ?>"
                    class="btn btn-sm btn-outline-secondary">Edit</a>
                  <a href="index.php?controller=admin&action=deleteBooking&id=<?= $booking['booking_id'] ?>"
                    class="btn btn-sm btn-outline-danger"
                    onclick="return confirm('Are you sure you want to delete this booking?')">Delete</a>
                </td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    </main>
  </div>
</div>

<?php require_once __DIR__ . '/../layout/footer.php'; ?>