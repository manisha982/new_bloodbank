<?php
require_once '../includes/../db.php'; // adjust path to your DB connection file
// Handle delete
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    $conn->query("DELETE FROM donate_now WHERE id = $id") or die("Delete failed: " . $conn->error);
    header("Location: index.php?page=donate_requests&deleted1");
    exit;
}

// Handle update status (example: change status)
if (isset($_POST['update_status'])) {
    $id     = intval($_POST['id']);
    $status = $_POST['status'];
    $stmt   = $conn->prepare("UPDATE donate_now SET status = ? WHERE id = ?");
    $stmt->bind_param("si", $status, $id);
    $stmt->execute();
    header("Location: index.php?page=donate_requests");
    exit;
}

// Fetch all requests
$result = $conn->query("SELECT * FROM donate_now ORDER BY submission_date DESC");
?>


<div class="p-3 border-bottom bg-light">
  <div class="row g-3">
    <div class="col-md-3">
      <select id="statusFilter" class="form-select">
        <option value="">All Status</option>
        <option value="Pending">Pending</option>
        <option value="Processing">Processing</option>
        <option value="Fulfilled">Fulfilled</option>
      </select>
    </div>
    <div class="col-md-3">
      <select id="bloodFilter" class="form-select">
        <option value="">All Blood Groups</option>
        <option value="A+">A+</option>
        <option value="A-">A-</option>
        <option value="B+">B+</option>
        <option value="B-">B-</option>
        <option value="O+">O+</option>
        <option value="O-">O-</option>
        <option value="AB+">AB+</option>
        <option value="AB-">AB-</option>
      </select>
    </div>
    <div class="col-md-3">
      <input type="text" id="districtFilter" class="form-control" placeholder="Search District">
    </div>
    <div class="col-md-3">
      <button class="btn btn-secondary w-100" onclick="resetFilters()">Reset Filters</button>
    </div>
  </div>
</div>


<div class="container-fluid py-4">
  <h3 class="mb-4 text-danger fw-bold"><i class="bi bi-droplet-fill"></i> Donation Requests</h3>

  <div class="card shadow-sm mb-4">
    <div class="card-body p-0">
      <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
          <thead class="table-light">
            <tr>
              <th>#</th>
              <th>Name</th>
              <th>Blood Group</th>
              <th>District</th>
              <th>City</th>
              <th>Hospital</th>
              <th>Date</th>
              <th>Status</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
            <?php if ($result->num_rows > 0): ?>
              <?php $i=1; while ($row = $result->fetch_assoc()): ?>
              <tr>
                <td><?= $i++ ?></td>
                <td><?= htmlspecialchars($row['fullname']) ?></td>
                <td><?= htmlspecialchars($row['blood_group']) ?></td>
                <td><?= htmlspecialchars($row['district']) ?></td>
                <td><?= htmlspecialchars($row['area']) ?></td>
                <td><?= htmlspecialchars($row['hospital']) ?></td>
                <td><?= htmlspecialchars($row['donation_date']) ?></td>
                <td>
                  <span class="badge 
                    <?= ($row['status']=='fulfilled' ? 'bg-success' : ($row['status']=='processing' ? 'bg-info' : 'bg-warning text-dark')) ?>">
                    <?= ucfirst($row['status']) ?>
                  </span>
                </td>
                <td>
                    <form method="POST" style="display:inline;">
                    <input type="hidden" name="id" value="<?= $row['id'] ?>">
                    <input type="hidden" name="update_status" value="1"> <!-- this makes sure PHP sees it -->
                    <select name="status" onchange="this.form.submit()" class="form-select form-select-sm" style="width:auto; display:inline-block;">
                        <option value="pending"    <?= ($row['status']=='pending'    ? 'selected' : '') ?>>Pending</option>
                        <option value="processing" <?= ($row['status']=='processing' ? 'selected' : '') ?>>Processing</option>
                        <option value="fulfilled"  <?= ($row['status']=='fulfilled'  ? 'selected' : '') ?>>Fulfilled</option>
                    </select>
                    </form>
                    <a href="index.php?page=donate_requests&delete=<?php echo $row['id']; ?>"
                    class="btn btn-sm btn-danger"
                    onclick="return confirm('Are you sure you want to delete this request?')">
                    Delete
                    </a>                
                </td>
              </tr>
              <?php endwhile; ?>
            <?php else: ?>
              <tr>
                <td colspan="9" class="text-center py-3 text-muted">No donation requests found</td>
              </tr>
            <?php endif; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>


<script>
document.addEventListener("DOMContentLoaded", function () {
  const statusFilter = document.getElementById("statusFilter");
  const bloodFilter = document.getElementById("bloodFilter");
  const districtFilter = document.getElementById("districtFilter");
  const table = document.querySelector("table tbody");

  function filterTable() {
    const statusVal = statusFilter.value.toLowerCase();
    const bloodVal = bloodFilter.value.toLowerCase();
    const districtVal = districtFilter.value.toLowerCase();

    const rows = table.querySelectorAll("tr");

    rows.forEach(row => {
      const cells = row.querySelectorAll("td");
      if (cells.length < 9) return; // skip if not a data row

      const statusText = cells[7].innerText.toLowerCase();
      const bloodText = cells[2].innerText.toLowerCase();
      const districtText = cells[3].innerText.toLowerCase();

      const matchesStatus = !statusVal || statusText.includes(statusVal);
      const matchesBlood = !bloodVal || bloodText.includes(bloodVal);
      const matchesDistrict = !districtVal || districtText.includes(districtVal);

      if (matchesStatus && matchesBlood && matchesDistrict) {
        row.style.display = "";
      } else {
        row.style.display = "none";
      }
    });
  }

  statusFilter.addEventListener("change", filterTable);
  bloodFilter.addEventListener("change", filterTable);
  districtFilter.addEventListener("input", filterTable);
});

function resetFilters() {
  document.getElementById("statusFilter").value = "";
  document.getElementById("bloodFilter").value = "";
  document.getElementById("districtFilter").value = "";
  const rows = document.querySelectorAll("table tbody tr");
  rows.forEach(row => row.style.display = "");
}
</script>
