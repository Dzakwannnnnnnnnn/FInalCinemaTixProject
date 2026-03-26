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
  <form method="POST" action="index.php?controller=admin&action=bookings" id="bulkDeleteForm">
    <div class="mb-2 d-flex gap-2">
      <button type="submit" class="btn btn-danger btn-sm" id="deleteSelectedBtn" disabled
        onclick="return confirm('Hapus semua booking yang dipilih?')">
        Hapus Terpilih
      </button>
      <small class="text-muted align-self-center" id="selectedCountText">0 booking dipilih</small>
    </div>

    <table class="table table-striped table-sm">
      <thead>
        <tr>
          <th style="width: 36px;">
            <input type="checkbox" id="selectAllCheckbox" title="Select all">
          </th>
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
            <td>
              <input type="checkbox" class="booking-checkbox" name="selected_booking_ids[]"
                value="<?= (int) $booking['booking_id'] ?>">
            </td>
            <td><?= $booking['booking_id'] ?></td>
            <td>
              <?php
              $userModel = new UserModel();
              $user = $userModel->getUserById($booking['user_id']);
              echo $user ? htmlspecialchars($user['nama']) : 'Unknown';
              ?>
            </td>
            <td>
              <?php
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
  </form>
</div>
</main>
</div>
</div>

<script>
  (function () {
    const selectAll = document.getElementById('selectAllCheckbox');
    const checkboxes = document.querySelectorAll('.booking-checkbox');
    const deleteBtn = document.getElementById('deleteSelectedBtn');
    const selectedCountText = document.getElementById('selectedCountText');

    function updateBulkState() {
      const total = checkboxes.length;
      let checked = 0;
      checkboxes.forEach(cb => {
        if (cb.checked) checked++;
      });

      deleteBtn.disabled = checked === 0;
      selectedCountText.textContent = `${checked} booking dipilih`;

      if (checked === 0) {
        selectAll.indeterminate = false;
        selectAll.checked = false;
      } else if (checked === total) {
        selectAll.indeterminate = false;
        selectAll.checked = true;
      } else {
        selectAll.indeterminate = true;
      }
    }

    selectAll.addEventListener('change', function () {
      checkboxes.forEach(cb => {
        cb.checked = selectAll.checked;
      });
      updateBulkState();
    });

    checkboxes.forEach(cb => {
      cb.addEventListener('change', updateBulkState);
    });

    updateBulkState();
  })();
</script>

<?php require_once __DIR__ . '/../layout/footer.php'; ?>
