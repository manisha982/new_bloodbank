<?php
require_once '../includes/../db.php';

// Add Request
if (isset($_POST['add'])) {
  $full_name = $_POST['full_name'];
  $phone_number = $_POST['phone_number'];
  $blood_group = $_POST['blood_group'];
  $num_bags = intval($_POST['num_bags']);
  $district = $_POST['district'];
  $city = $_POST['city'];
  $urgency_level = $_POST['urgency_level'];
  $additional_details = $_POST['additional_details'];

  $stmt = $conn->prepare("INSERT INTO emergency_requests (full_name, phone_number, blood_group, num_bags, district, city, urgency_level, additional_details) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
  $stmt->bind_param("sssissss", $full_name, $phone_number, $blood_group, $num_bags, $district, $city, $urgency_level, $additional_details);
  $stmt->execute();
}

// Delete Request
if (isset($_GET['delete'])) {
  $id = intval($_GET['delete']);
  $conn->query("DELETE FROM emergency_requests WHERE id = $id");
  header("Location: index.php?page=emergency_request");
  exit;
}

// Edit Request
$edit_data = null;
if (isset($_GET['edit'])) {
  $id = intval($_GET['edit']);
  $result = $conn->query("SELECT * FROM emergency_requests WHERE id = $id");
  $edit_data = $result->fetch_assoc();
}

// Update Request
if (isset($_POST['update'])) {
  $id = intval($_POST['id']);
  $full_name = $_POST['full_name'];
  $phone_number = $_POST['phone_number'];
  $blood_group = $_POST['blood_group'];
  $num_bags = intval($_POST['num_bags']);
  $district = $_POST['district'];
  $city = $_POST['city'];
  $urgency_level = $_POST['urgency_level'];
  $additional_details = $_POST['additional_details'];

  $stmt = $conn->prepare("UPDATE emergency_requests SET full_name=?, phone_number=?, blood_group=?, num_bags=?, district=?, city=?, urgency_level=?, additional_details=? WHERE id=?");
  $stmt->bind_param("sssisissi", $full_name, $phone_number, $blood_group, $num_bags, $district, $city, $urgency_level, $additional_details, $id);
  $stmt->execute();
  header("Location: index.php?page=emergency_request");
  exit;
}

// Fetch Data
$requests = $conn->query("SELECT * FROM emergency_requests ORDER BY id DESC");
?>

<div class="container-fluid py-4">
  <h3 class="mb-4 text-danger fw-bold"><i class="bi bi-bell-fill"></i> Emergency Blood Requests</h3>

  <!-- Add / Edit Form -->
  <div class="card mb-4">
    <div class="card-header bg-danger text-white">
      <?= $edit_data ? 'Edit Emergency Request' : 'Add Emergency Request' ?>
    </div>
    <div class="card-body">
      <form method="POST">
        <?php if ($edit_data): ?>
          <input type="hidden" name="id" value="<?= $edit_data['id'] ?>">
        <?php endif; ?>

        <div class="row mb-3">
          <div class="col-md-6">
            <label class="form-label">Full Name</label>
            <input type="text" name="full_name" class="form-control" value="<?= $edit_data['full_name'] ?? '' ?>" required>
          </div>
          <div class="col-md-6">
            <label class="form-label">Phone Number</label>
            <input type="tel" name="phone_number" class="form-control" value="<?= $edit_data['phone_number'] ?? '' ?>" required>
          </div>
        </div>

        <div class="row mb-3">
          <div class="col-md-4">
            <label class="form-label">Blood Group</label>
            <select name="blood_group" class="form-select" required>
              <option value="">-- Select --</option>
              <?php
              $groups = ['A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-'];
              foreach ($groups as $g) {
                $sel = ($edit_data && $edit_data['blood_group'] == $g) ? 'selected' : '';
                echo "<option value='$g' $sel>$g</option>";
              }
              ?>
            </select>
          </div>
          <div class="col-md-4">
            <label class="form-label">No. of Bags</label>
            <input type="number" name="num_bags" class="form-control" value="<?= $edit_data['num_bags'] ?? '' ?>" min="1" required>
          </div>
          <div class="col-md-4">
            <label class="form-label">Urgency Level</label>
            <select name="urgency_level" class="form-select" required>
              <?php
              $levels = ['Low', 'Medium', 'High', 'Critical'];
              foreach ($levels as $l) {
                $sel = ($edit_data && $edit_data['urgency_level'] == $l) ? 'selected' : '';
                echo "<option value='$l' $sel>$l</option>";
              }
              ?>
            </select>
          </div>
        </div>


        <div class="row mb-3">
          <div class="col-md-6">
            <label class="form-label">District</label>
            <select name="district" class="form-select" required>
              <option value="">-- Select --</option>
              <?php
              $districts = [
                'Achham',
                'Arghakhanchi',
                'Baglung',
                'Baitadi',
                'Bajhang',
                'Bajura',
                'Banke',
                'Bara',
                'Bardiya',
                'Bhaktapur',
                'Bhojpur',
                'Chitwan',
                'Dadeldhura',
                'Dailekh',
                'Dang',
                'Darchula',
                'Dhading',
                'Dhankuta',
                'Dhanusha',
                'Dolakha',
                'Dolpa',
                'Doti',
                'Gorkha',
                'Gulmi',
                'Humla',
                'Ilam',
                'Jajarkot',
                'Jhapa',
                'Jumla',
                'Kailali',
                'Kalikot',
                'Kanchanpur',
                'Kapilvastu',
                'Kaski',
                'Kathmandu',
                'Kavrepalanchok',
                'Khotang',
                'Lalitpur',
                'Lamjung',
                'Mahottari',
                'Makwanpur',
                'Manang',
                'Morang',
                'Mugu',
                'Mustang',
                'Myagdi',
                'Nawalparasi',
                'Nuwakot',
                'Okhaldhunga',
                'Palpa',
                'Panchthar',
                'Parbat',
                'Parsa',
                'Ramechhap',
                'Rasuwa',
                'Rautahat',
                'Rolpa',
                'Rukum East',
                'Rukum West',
                'Rupandehi',
                'Salyan',
                'Sankhuwasabha',
                'Saptari',
                'Sarlahi',
                'Sindhuli',
                'Sindhupalchok',
                'Siraha',
                'Solukhumbu',
                'Sunsari',
                'Surkhet',
                'Syangja',
                'Tanahun',
                'Taplejung',
                'Terhathum',
                'Udayapur'
              ];
              foreach ($districts as $d) {
                $sel = ($edit_data && $edit_data['district'] == $d) ? 'selected' : '';
                echo "<option value='$d' $sel>$d</option>";
              }
              ?>
            </select>
          </div>

          <div class="col-md-6">
            <label class="form-label">City</label>
            <input type="text" name="city" class="form-control" value="<?= $edit_data['city'] ?? '' ?>" required>
          </div>
        </div>

        <div class="mb-3">
          <label class="form-label">Additional Details</label>
          <textarea name="additional_details" class="form-control" rows="3"><?= $edit_data['additional_details'] ?? '' ?></textarea>
        </div>

        <div class="text-end">
          <?php if ($edit_data): ?>
            <button type="submit" name="update" class="btn btn-warning">Update</button>
            <a href="index.php?page=emergency_request" class="btn btn-secondary">Cancel</a>
          <?php else: ?>
            <button type="submit" name="add" class="btn btn-danger">Add Request</button>
          <?php endif; ?>
        </div>
      </form>
    </div>
  </div>

  <!-- Display Table -->
  <div class="card">
    <div class="card-header bg-light fw-semibold">
      <i class="bi bi-table"></i> Emergency Requests List
    </div>
    <div class="card-body table-responsive">
      <table class="table table-bordered table-hover">
        <thead class="table-light">
          <tr>
            <th>#</th>
            <th>Name</th>
            <th>Phone</th>
            <th>Blood Group</th>
            <th>Bags</th>
            <th>District</th>
            <th>City</th>
            <th>Urgency</th>
            <th>Details</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
          <?php
          $i = 1;
          while ($row = $requests->fetch_assoc()):
          ?>
            <tr>
              <td><?= $i++ ?></td>
              <td><?= htmlspecialchars($row['full_name']) ?></td>
              <td><?= htmlspecialchars($row['phone_number']) ?></td>
              <td><?= htmlspecialchars($row['blood_group']) ?></td>
              <td><?= htmlspecialchars($row['num_bags']) ?></td>
              <td><?= htmlspecialchars($row['district']) ?></td>
              <td><?= htmlspecialchars($row['city']) ?></td>
              <td><?= htmlspecialchars($row['urgency_level']) ?></td>
              <td><?= htmlspecialchars($row['additional_details']) ?></td>
              <td>
                <a href="index.php?page=emergency_request&edit=<?= $row['id'] ?>" class="btn btn-sm btn-warning">Edit</a>
                <a href="index.php?page=emergency_request&delete=<?= $row['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Delete this request?')">Delete</a>
              </td>
            </tr>
          <?php endwhile; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>