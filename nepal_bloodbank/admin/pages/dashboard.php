<!-- pages/dashboard.php -->
<?php
require_once '../includes/../db.php'; // adjust path to your DB connection file

// Fetch dashboard stats
$total_donors = $conn->query("SELECT COUNT(*) AS total FROM login_users")->fetch_assoc()['total'];
$total_units  = $conn->query("SELECT COUNT(*) AS total FROM donate_now")->fetch_assoc()['total'];
$pending_requests = $conn->query("SELECT COUNT(*) AS total FROM blood_requests_list WHERE status='pending'")->fetch_assoc()['total'];
$completed_donations = $conn->query("SELECT COUNT(*) AS total FROM donate_now WHERE status='fulfilled'")->fetch_assoc()['total'];

// Fetch recent blood requests
$recent_requests = $conn->query("SELECT id, fullname, blood_group, area AS hospital, status FROM blood_requests_list ORDER BY request_date DESC LIMIT 10");
?>

<div class="container-fluid py-4">
  <h3 class="mb-4 text-danger fw-bold"><i class="bi bi-speedometer2"></i> Dashboard Overview</h3>

  <!-- Stat Cards -->
  <div class="row g-4">
    <!-- Total Donors -->
    <div class="col-md-3 col-sm-6">
      <div class="card border-0 shadow-sm h-100">
        <div class="card-body text-center">
          <i class="bi bi-people-fill fs-1 text-danger"></i>
          <h6 class="mt-3">Total Donors</h6>
          <h4 class="text-danger fw-bold"><?= $total_donors ?></h4>
        </div>
      </div>
    </div>

    <!-- Blood Units -->
    <div class="col-md-3 col-sm-6">
      <div class="card border-0 shadow-sm h-100">
        <div class="card-body text-center">
          <i class="bi bi-droplet-fill fs-1 text-danger"></i>
          <h6 class="mt-3">Blood Units</h6>
          <h4 class="text-danger fw-bold"><?= $total_units ?></h4>
        </div>
      </div>
    </div>

    <!-- Pending Requests -->
    <div class="col-md-3 col-sm-6">
      <div class="card border-0 shadow-sm h-100">
        <div class="card-body text-center">
          <i class="bi bi-bell-fill fs-1 text-danger"></i>
          <h6 class="mt-3">Pending Requests</h6>
          <h4 class="text-danger fw-bold"><?= $pending_requests ?></h4>
        </div>
      </div>
    </div>

    <!-- Completed Donations -->
    <div class="col-md-3 col-sm-6">
      <div class="card border-0 shadow-sm h-100">
        <div class="card-body text-center">
          <i class="bi bi-check-circle-fill fs-1 text-danger"></i>
          <h6 class="mt-3">Completed</h6>
          <h4 class="text-danger fw-bold"><?= $completed_donations ?></h4>
        </div>
      </div>
    </div>
  </div>

  <!-- Recent Requests Table -->
  <div class="card shadow-sm mt-5">
    <div class="card-header bg-danger text-white fw-semibold d-flex justify-content-between align-items-center">
      <span><i class="bi bi-clock-history"></i> Recent Blood Requests</span>
      <a href="index.php?page=patient_request" class="btn btn-light btn-sm">View All</a>
    </div>
    <div class="card-body p-0">
      <div class="table-responsive">
        <table class="table mb-0 table-hover align-middle">
          <thead class="table-light">
            <tr>
              <th>#</th>
              <th>Patient Name</th>
              <th>Blood Group</th>
              <th>Hospital</th>
              <th>Status</th>
            </tr>
          </thead>
          <tbody>
            <?php if ($recent_requests->num_rows > 0): ?>
              <?php while ($row = $recent_requests->fetch_assoc()): ?>
                <tr>
                  <td><?= htmlspecialchars($row['id']) ?></td>
                  <td><?= htmlspecialchars($row['fullname']) ?></td>
                  <td><span class="badge bg-danger"><?= htmlspecialchars($row['blood_group']) ?></span></td>
                  <td><?= htmlspecialchars($row['hospital']) ?></td>
                  <td>
                    <?php
                      $status = $row['status'];
                      $badgeClass = ($status == 'fulfilled') ? 'bg-success' : (($status == 'pending') ? 'bg-warning text-dark' : 'bg-info');
                    ?>
                    <span class="badge <?= $badgeClass ?>"><?= ucfirst($status) ?></span>
                  </td>
                </tr>
              <?php endwhile; ?>
            <?php else: ?>
              <tr>
                <td colspan="5" class="text-center py-3 text-muted">No recent requests found</td>
              </tr>
            <?php endif; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
