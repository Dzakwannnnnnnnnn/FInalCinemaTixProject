<?php
require_once __DIR__ . '/../layout/header.php';
?>
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
  <h1 class="h2">View Booking</h1>
  <div class="btn-toolbar mb-2 mb-md-0">
    <div class="btn-group me-2">
      <a href="index.php?controller=admin&action=bookings" class="btn btn-sm btn-outline-secondary">Back to
        Bookings</a>
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

<div class="row">
  <div class="col-md-8">
    <div class="card">
      <div class="card-header">
        <h5 class="card-title mb-0">Booking Details</h5>
      </div>
      <div class="card-body">
        <div class="row">
          <div class="col-md-6">
            <h6>Booking Information</h6>
            <p><strong>Booking ID:</strong> <?= $booking['booking_id'] ?></p>
            <p><strong>Status:</strong>
              <span
                class="badge bg-<?= $booking['status'] == 'sukses' ? 'success' : ($booking['status'] == 'batal' ? 'danger' : 'warning') ?>">
                <?= ucfirst($booking['status']) ?>
              </span>
            </p>
            <p><strong>Booking Date:</strong> <?= htmlspecialchars($booking['tanggal_booking']) ?></p>
          </div>
          <div class="col-md-6">
            <h6>User Information</h6>
            <p><strong>Name:</strong> <?= htmlspecialchars($booking['nama_user']) ?></p>
            <p><strong>Email:</strong> <?= htmlspecialchars($booking['email']) ?></p>
          </div>
        </div>
        <hr>
        <div class="row">
          <div class="col-md-6">
            <h6>Film & Schedule</h6>
            <p><strong>Film:</strong> <?= htmlspecialchars($booking['judul']) ?></p>
            <p><strong>Date:</strong> <?= htmlspecialchars($booking['tanggal']) ?></p>
            <p><strong>Time:</strong> <?= htmlspecialchars($booking['jam_mulai']) ?></p>
          </div>
          <div class="col-md-6">
            <h6>Seat Information</h6>
            <p><strong>Studio:</strong> <?= htmlspecialchars($booking['nama_studio']) ?></p>
            <p><strong>Seat:</strong> <?= htmlspecialchars($booking['nomor_kursi']) ?></p>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="col-md-4">
    <div class="card">
      <div class="card-header">
        <h5 class="card-title mb-0">Actions</h5>
      </div>
      <div class="card-body">
        <a href="index.php?controller=admin&action=editBooking&id=<?= $booking['booking_id'] ?>"
          class="btn btn-primary w-100 mb-2">Edit Status</a>
        <a href="index.php?controller=admin&action=deleteBooking&id=<?= $booking['booking_id'] ?>"
          class="btn btn-danger w-100" onclick="return confirm('Are you sure you want to delete this booking?')">Delete
          Booking</a>
      </div>
    </div>
  </div>
</div>
</main>
</div>
</div>

<?php require_once __DIR__ . '/../layout/footer.php'; ?>