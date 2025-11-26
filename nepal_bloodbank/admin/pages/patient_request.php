<?php
require_once '../includes/../db.php';

// ---------------------------
// HANDLE STATUS UPDATE
// ---------------------------
if (isset($_POST['update_status'])) {
  $id     = intval($_POST['id']);
  $status = $_POST['status'];

  $stmt = $conn->prepare("UPDATE blood_requests_list SET status = ? WHERE id = ?");
  $stmt->bind_param("si", $status, $id);
  $stmt->execute();

  header("Location: " . $_SERVER['REQUEST_URI']);
  exit;
}

// ---------------------------
// FETCH RECENT REQUESTS
// ---------------------------
$recent_requests = $conn->query("
    SELECT 
        id, fullname, phone, blood_group, bags, district, area, urgency, 
        details, terms, request_date, status 
    FROM blood_requests_list 
    ORDER BY request_date DESC 
    LIMIT 10
");
?>

<!-- Recent Requests Table -->
<div class="card shadow-sm mt-5">
  <div class="card-header bg-danger text-white fw-semibold d-flex justify-content-between align-items-center">
    <span><i class="bi bi-clock-history"></i> Recent Blood Requests</span>
    <a href="requests.php" class="btn btn-light btn-sm">View All</a>
  </div>

  <div class="card-body p-0">
    <div class="table-responsive">
      <table class="table mb-0 table-hover align-middle">
        <thead class="table-light">
          <tr>
            <th>#</th>
            <th>Full Name</th>
            <th>Phone</th>
            <th>Blood Group</th>
            <th>Bags</th>
            <th>District</th>
            <th>Area</th>
            <th>Urgency</th>
            <th>Details</th>
            <th>Terms</th>
            <th>Request Date</th>
            <th>Status</th>
            <th>Action</th>
          </tr>
        </thead>

        <tbody>
          <?php if ($recent_requests->num_rows > 0): ?>
            <?php while ($row = $recent_requests->fetch_assoc()): ?>

              <?php
              // BADGE COLOR LOGIC
              $status = strtolower($row['status']);
              $badgeClass = match ($status) {
                'fulfilled'  => 'bg-success',
                'processing' => 'bg-primary',
                'pending'    => 'bg-warning text-dark',
                default      => 'bg-secondary'
              };
              ?>

              <tr>
                <td><?= $row['id'] ?></td>
                <td><?= htmlspecialchars($row['fullname']) ?></td>
                <td><?= htmlspecialchars($row['phone']) ?></td>
                <td><span class="badge bg-danger"><?= htmlspecialchars($row['blood_group']) ?></span></td>
                <td><?= htmlspecialchars($row['bags']) ?></td>
                <td><?= htmlspecialchars($row['district']) ?></td>
                <td><?= htmlspecialchars($row['area']) ?></td>
                <td><span class="badge bg-info"><?= htmlspecialchars($row['urgency']) ?></span></td>
                <td><?= htmlspecialchars($row['details']) ?></td>
                <td><?= htmlspecialchars($row['terms']) ?></td>
                <td><?= htmlspecialchars($row['request_date']) ?></td>

                <!-- CURRENT STATUS BADGE -->
                <td>
                  <span class="badge <?= $badgeClass ?>"><?= ucfirst($status) ?></span>
                </td>

                <!-- STATUS UPDATE DROPDOWN -->
                <td>
                  <form method="POST" style="display:inline;">
                    <input type="hidden" name="id" value="<?= $row['id'] ?>">
                    <input type="hidden" name="update_status" value="1">

                    <select name="status" onchange="this.form.submit()"
                      class="form-select form-select-sm" style="width:130px;">
                      <option value="pending" <?= ($status == 'pending' ? 'selected' : '') ?>>Pending</option>
                      <option value="processing" <?= ($status == 'processing' ? 'selected' : '') ?>>Processing</option>
                      <option value="fulfilled" <?= ($status == 'fulfilled' ? 'selected' : '') ?>>Fulfilled</option>
                    </select>
                  </form>
                </td>

              </tr>
            <?php endwhile; ?>

          <?php else: ?>
            <tr>
              <td colspan="13" class="text-center py-3 text-muted">
                No recent requests found
              </td>
            </tr>
          <?php endif; ?>
        </tbody>

      </table>
    </div>
  </div>
</div>