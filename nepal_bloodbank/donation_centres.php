<?php
require_once 'db.php';

$query = "SELECT district, hospital_name FROM hospitals ORDER BY district, hospital_name";
$result = $conn->query($query);

$districts = [];

while ($row = $result->fetch_assoc()) {
    $district = $row['district'];
    $hospital = $row['hospital_name'];

    if (!isset($districts[$district])) {
        $districts[$district] = [];
    }

    $districts[$district][] = $hospital;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Nepal Blood Bank - Donation Centers</title>
  <link rel="stylesheet" href="donation_centres.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
</head>
<body>

<header>
  <nav style="background: linear-gradient(135deg, #d32f2f, #b71c1c)">
    <div class="logo">Nepal Blood Bank</div>
    <ul class="nav-links">
      <li><a href="index.php">Home</a></li>
      <li><a href="find_donors.php">Find Donors</a></li>
      <li><a href="donation_centres.php" class="active">Donation Centres</a></li>
      <li><a href="#service">Services
        <ul class="menu">
          <li><a href="donate_now.php">Donate Now</a></li>
          <li><a href="request.php">Request Blood</a></li>
          <li><a href="available.php">Available Blood</a></li>
          <li><a href="compatibility.php">Compatibility</a></li>
        </ul>
      </a></li>
      <li><a href="index.php#contact">Contact</a></li>
      <li><a href="emergency.php" class="emergency-btn">Emergency</a></li>
    </ul>
  </nav>
</header>

<div class="container">
  <?php if (!empty($districts)): ?>
    <?php foreach ($districts as $districtName => $hospitals): ?>
      <div class="area">
        <h2><?= htmlspecialchars($districtName) ?></h2>
        <ul class="dropdown">
          <?php foreach ($hospitals as $hospital): ?>
            <li><a href="#"><?= htmlspecialchars($hospital) ?></a></li>
          <?php endforeach; ?>
        </ul>
      </div>
    <?php endforeach; ?>
  <?php else: ?>
    <p style="color: white; text-align: center;">No donation centers found.</p>
  <?php endif; ?>
</div>

<script src="donation_centres.js"></script>
</body>
</html>
