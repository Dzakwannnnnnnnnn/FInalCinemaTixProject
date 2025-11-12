<?php
require_once __DIR__ . '/../layout/header.php';
?>
<!-- Header -->
<div class="d-flex justify-content-between align-items-center mb-4">
  <div>
    <h2 class="fw-bold">Booking Management</h2>
    <p class="text-muted mb-0">Kelola data booking CinemaTix</p>
  </div>
  <div class="text-end">
    <a href="index.php?controller=admin&action=index" class="btn btn-success me-2">
      📊 Dashboard
    </a>
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
              class="badge bg-<?= $booking['status'] == 'sukses' ? 'success' : ($booking['status'] == 'batal' ? 'danger' : 'warning') ?>">
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