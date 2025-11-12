<?php
require_once __DIR__ . '/../layout/header.php';
?>
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
  <h1 class="h2">Edit Payment Status</h1>
  <div class="btn-toolbar mb-2 mb-md-0">
    <div class="btn-group me-2">
      <a href="index.php?controller=admin&action=viewPayment&id=<?= $payment['pembayaran_id'] ?? '' ?>"
        class="btn btn-sm btn-outline-secondary">Back to View</a>
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
            <p><strong>Payment ID:</strong> <?= $payment['pembayaran_id'] ?? 'N/A' ?></p>
            <p><strong>Booking ID:</strong> <?= $payment['booking_id'] ?? 'N/A' ?></p>
            <p><strong>Current Status:</strong>
              <span
                class="badge bg-<?= ($payment['status'] ?? '') == 'completed' ? 'success' : (($payment['status'] ?? '') == 'failed' ? 'danger' : 'warning') ?>">
                <?= ucfirst($payment['status'] ?? 'unknown') ?>
              </span>
            </p>
            <p><strong>Payment Date:</strong> <?= !empty($payment['tanggal_pembayaran']) ? htmlspecialchars($payment['tanggal_pembayaran']) : 'Not set' ?></p>
          </div>
          <div class="col-md-6">
            <h6>Payment Details</h6>
            <p><strong>Payment Method:</strong> <?= htmlspecialchars($payment['nama_method'] ?? 'N/A') ?></p>
            <p><strong>Amount:</strong> Rp <?= isset($payment['jumlah']) && $payment['jumlah'] !== null ? number_format((float)$payment['jumlah'], 0, ',', '.') : '0' ?></p>
            <p><strong>User:</strong> <?= htmlspecialchars($payment['nama_user'] ?? 'N/A') ?></p>
          </div>
        </div>
        <hr>
        <div class="row">
          <div class="col-md-12">
            <h6>Film & Schedule Information</h6>
            <p><strong>Film:</strong> <?= htmlspecialchars($payment['judul'] ?? 'N/A') ?></p>
            <p><strong>Date & Time:</strong>
              <?= htmlspecialchars(($payment['tanggal'] ?? 'N/A') . ' ' . ($payment['jam_mulai'] ?? '')) ?></p>
            <p><strong>Studio:</strong> <?= htmlspecialchars($payment['nama_studio'] ?? 'N/A') ?></p>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="col-md-4">
    <div class="card">
      <div class="card-header">
        <h5 class="card-title mb-0">Update Status</h5>
      </div>
      <div class="card-body">
        <form method="POST" action="">
          <div class="mb-3">
            <label for="status" class="form-label">Status</label>
            <select class="form-select" id="status" name="status" required>
              <option value="pending" <?= ($payment['status'] ?? '') == 'pending' ? 'selected' : '' ?>>Pending</option>
              <option value="completed" <?= ($payment['status'] ?? '') == 'completed' ? 'selected' : '' ?>>Completed</option>
              <option value="failed" <?= ($payment['status'] ?? '') == 'failed' ? 'selected' : '' ?>>Failed</option>
            </select>
          </div>
          <button type="submit" class="btn btn-primary w-100">Update Status</button>
        </form>
      </div>
    </div>
  </div>
</div>
</main>
</div>
</div>

<?php require_once __DIR__ . '/../layout/footer.php'; ?>