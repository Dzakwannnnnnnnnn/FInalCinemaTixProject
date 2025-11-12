<?php
require_once __DIR__ . '/../layout/header.php';
?>
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
  <h1 class="h2">View Payment</h1>
  <div class="btn-toolbar mb-2 mb-md-0">
    <div class="btn-group me-2">
      <a href="index.php?controller=admin&action=payments" class="btn btn-sm btn-outline-secondary">Back to
        Payments</a>
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
        <h5 class="card-title mb-0">Payment Details</h5>
      </div>
      <div class="card-body">
        <div class="row">
          <div class="col-md-6">
            <h6>Payment Information</h6>
            <p><strong>Payment ID:</strong> <?= $payment['pembayaran_id'] ?></p>
            <p><strong>Booking ID:</strong> <?= $payment['booking_id'] ?></p>
            <p><strong>Status:</strong>
              <span
                class="badge bg-<?= $payment['status'] == 'completed' ? 'success' : ($payment['status'] == 'failed' ? 'danger' : 'warning') ?>">
                <?= ucfirst($payment['status']) ?>
              </span>
            </p>
            <p><strong>Payment Date:</strong> <?= htmlspecialchars($payment['tanggal_pembayaran']) ?></p>
          </div>
          <div class="col-md-6">
            <h6>Payment Details</h6>
            <p><strong>Payment Method:</strong> <?= htmlspecialchars($payment['nama_method']) ?></p>
            <p><strong>Amount:</strong> Rp <?= number_format($payment['jumlah'], 0, ',', '.') ?></p>
            <p><strong>User:</strong> <?= htmlspecialchars($payment['nama_user']) ?></p>
          </div>
        </div>
        <hr>
        <div class="row">
          <div class="col-md-12">
            <h6>Film & Schedule Information</h6>
            <p><strong>Film:</strong> <?= htmlspecialchars($payment['judul']) ?></p>
            <p><strong>Date & Time:</strong>
              <?= htmlspecialchars($payment['tanggal'] . ' ' . $payment['jam_mulai']) ?></p>
            <p><strong>Studio:</strong> <?= htmlspecialchars($payment['nama_studio']) ?></p>
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
        <a href="index.php?controller=admin&action=editPayment&id=<?= $payment['pembayaran_id'] ?>"
          class="btn btn-primary w-100 mb-2">Edit Status</a>
        <a href="index.php?controller=admin&action=deletePayment&id=<?= $payment['pembayaran_id'] ?>"
          class="btn btn-danger w-100" onclick="return confirm('Are you sure you want to delete this payment?')">Delete
          Payment</a>
      </div>
    </div>
  </div>
</div>
</main>
</div>
</div>

<?php require_once __DIR__ . '/../layout/footer.php'; ?>