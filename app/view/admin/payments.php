<?php
require_once __DIR__ . '/../layout/header.php';
?>
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
  <h1 class="h2">Payment Management</h1>
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
        <th>Booking ID</th>
        <th>User</th>
        <th>Payment Method</th>
        <th>Amount</th>
        <th>Status</th>
        <th>Payment Date</th>
        <th>Actions</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($payments as $payment): ?>
        <tr>
          <td><?= $payment['pembayaran_id'] ?></td>
          <td><?= $payment['booking_id'] ?></td>
          <td><?= htmlspecialchars($payment['nama_user'] ?? '') ?></td>
          <td><?= htmlspecialchars($payment['nama_method'] ?? '') ?></td>
          <td>Rp <?= number_format($payment['jumlah'] ?? 0, 0, ',', '.') ?></td>
          <td>
            <span
              class="badge bg-<?= $payment['status'] == 'completed' ? 'success' : ($payment['status'] == 'failed' ? 'danger' : 'warning') ?>">
              <?= ucfirst($payment['status']) ?>
            </span>
          </td>
          <td><?= htmlspecialchars($payment['tanggal_pembayaran'] ?? '') ?></td>
          <td>
            <a href="index.php?controller=admin&action=viewPayment&id=<?= $payment['pembayaran_id'] ?>"
              class="btn btn-sm btn-outline-primary">View</a>
            <a href="index.php?controller=admin&action=editPayment&id=<?= $payment['pembayaran_id'] ?>"
              class="btn btn-sm btn-outline-secondary">Edit</a>
            <a href="index.php?controller=admin&action=deletePayment&id=<?= $payment['pembayaran_id'] ?>"
              class="btn btn-sm btn-outline-danger"
              onclick="return confirm('Are you sure you want to delete this payment?')">Delete</a>
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