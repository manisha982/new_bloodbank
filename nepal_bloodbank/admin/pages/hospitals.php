<?php
require_once '../includes/db.php'; // Database connection

// ADD new record
if (isset($_POST['add'])) {
  $full_name = $_POST['full_name'];
  // $phone_number = $_POST['phone_number'];
  // $blood_group = $_POST['blood_group'];
  // $num_bags = $_POST['num_bags'];
  // $district = $_POST['district'];
  // $city = $_POST['city'];
  // $urgency_level = $_POST['urgency_level'];
  // $additional_details = $_POST['additional_details'];

  $sql = "INSERT INTO emergency_request 
          (full_name,
          
          --  phone_number, blood_group, num_bags, district, city, urgency_level, additional_details
          ) 
          VALUES ('$full_name'
          -- , '$phone_number', '$blood_group', '$num_bags', '$district', '$city', '$urgency_level', '$additional_details'
          )";

  if (mysqli_query($conn, $sql)) {
    echo "<div class='alert alert-success'>✅ Request added successfully!</div>";
  } else {
    echo "<div class='alert alert-danger'>❌ Error: " . mysqli_error($conn) . "</div>";
  }
}

// DELETE record
if (isset($_GET['delete'])) {
  $id = $_GET['delete'];
  $delete = "DELETE FROM emergency_request WHERE id = '$id'";
  if (mysqli_query($conn, $delete)) {
    header("Location: index.php?page=emergency_request&deleted=1");
    exit;
  } else {
    echo "<div class='alert alert-danger'>❌ Delete failed: " . mysqli_error($conn) . "</div>";
  }
}

// UPDATE record
if (isset($_POST['update'])) {
  $id = $_POST['id'];
  $full_name = $_POST['full_name'];
  $phone_number = $_POST['phone_number'];
  $blood_group = $_POST['blood_group'];
  $num_bags = $_POST['num_bags'];
  $district = $_POST['district'];
  $city = $_POST['city'];
  $urgency_level = $_POST['urgency_level'];
  $additional_details = $_POST['additional_details'];

  $sql = "UPDATE emergency_request 
          SET full_name='$full_name', phone_number='$phone_number', blood_group='$blood_group',
              num_bags='$num_bags', district='$district', city='$city', 
              urgency_level='$urgency_level', additional_details='$additional_details'
          WHERE id='$id'";

  if (mysqli_query($conn, $sql)) {
    header("Location: index.php?page=emergency_request&updated=1");
    exit;
  } else {
    echo "<div class='alert alert-danger'>❌ Update failed: " . mysqli_error($conn) . "</div>";
  }
}

// Fetch all data
$requests = mysqli_query($conn, "SELECT * FROM emergency_request ORDER BY created_at DESC");
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title>Emergency Requests</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light p-3">
  <div class="container">
    <h3 class="mb-4 text-danger fw-bold"><i class="bi bi-droplet-half"></i> Emergency Blood Requests</h3>

    <!-- Add / Edit Form -->
    <div class="card shadow-sm mb-4">
      <div class="card-header bg-danger text-white">Add / Edit Request</div>
      <div class="card-body">
        <form method="POST">
          <input type="hidden" name="id" id="edit_id">

          <div class="row g-3">
            <div class="col-md-6"><input type="text" name="full_name" id="full_name" class="form-control" placeholder="Full Name" required></div>
            <div class="col-md-6"><input type="text" name="phone_number" id="phone_number" class="form-control" placeholder="Phone Number" required></div>
            <div class="col-md-4"><input type="text" name="blood_group" id="blood_group" class="form-control" placeholder="Blood Group" required></div>
            <div class="col-md-4"><input type="number" name="num_bags" id="num_bags" class="form-control" placeholder="No. of Bags" required></div>
            <div class="col-md-4">
              <select name="urgency_level" id="urgency_level" class="form-select" required>
                <option value="">Select Urgency</option>
                <option value="Low">Low</option>
                <option value="Medium">Medium</option>
                <option value="High">High</option>
                <option value="Critical">Critical</option>
              </select>
            </div>
            <div class="col-md-6"><input type="text" name="district" id="district" class="form-control" placeholder="District" required></div>
            <div class="col-md-6"><input type="text" name="city" id="city" class="form-control" placeholder="City" required></div>
            <div class="col-12"><input type="text" name="additional_details" id="additional_details" class="form-control" placeholder="Additional Details"></div>
          </div>

          <div class="mt-3 text-end">
            <button type="submit" name="add" class="btn btn-danger" id="addBtn">Add Request</button>
            <button type="submit" name="update" class="btn btn-warning d-none" id="updateBtn">Update Request</button>
          </div>
        </form>
      </div>
    </div>

    <!-- Data Table -->
    <div class="table-responsive">
      <table class="table table-hover">
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
            <th>Created</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
          <?php $i = 1;
          while ($row = mysqli_fetch_assoc($requests)): ?>
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
              <td><?= htmlspecialchars($row['created_at']) ?></td>
              <td>
                <button class="btn btn-sm btn-warning" onclick='editRequest(<?= json_encode($row) ?>)'>Edit</button>
                <a href="index.php?page=emergency_request&delete=<?= $row['id'] ?>"
                  class="btn btn-sm btn-danger"
                  onclick="return confirm('Are you sure you want to delete this request?')">Delete</a>
              </td>
            </tr>
          <?php endwhile; ?>
        </tbody>
      </table>
    </div>
  </div>

  <script>
    function editRequest(data) {
      document.getElementById('edit_id').value = data.id;
      document.getElementById('full_name').value = data.full_name;
      document.getElementById('phone_number').value = data.phone_number;
      document.getElementById('blood_group').value = data.blood_group;
      document.getElementById('num_bags').value = data.num_bags;
      document.getElementById('district').value = data.district;
      document.getElementById('city').value = data.city;
      document.getElementById('urgency_level').value = data.urgency_level;
      document.getElementById('additional_details').value = data.additional_details;

      document.getElementById('addBtn').classList.add('d-none');
      document.getElementById('updateBtn').classList.remove('d-none');
    }
  </script>
</body>

</html>