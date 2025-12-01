<?php
include "db.php"; // database connection
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Find Donors - Nepal Blood Bank</title>
  <link rel="stylesheet" href="find_donor.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" />
</head>

<body>

  <header>
    <nav>
      <div class="logo">Nepal Blood Bank</div>
      <ul class="nav-links">
        <li><a href="index.php">Home</a></li>
        <li><a href="find_donors.php" class="active">Find Donors</a></li>
        <li><a href="donation_centres.php">Donation Centres</a></li>
        <li><a href="#">Services
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

  <main>
    <div class="wrapper">
      <h2 id="blood-search">🔎 Find Blood Donors</h2>

      <!-- Search Form -->
      <form method="POST" action="">
        <label for="blood_group">Select Blood Group:</label>
        <select name="blood_group" required>
          <option value="">-- Select --</option>
          <option value="A+">A+</option>
          <option value="A-">A-</option>
          <option value="B+">B+</option>
          <option value="B-">B-</option>
          <option value="AB+">AB+</option>
          <option value="AB-">AB-</option>
          <option value="O+">O+</option>
          <option value="O-">O-</option>
        </select>

        <label for="district">Select District:</label>
        <select name="district">
          <option value="">-- Select --</option>
          <option value="Kathmandu">Kathmandu</option>
          <option value="Butwal">Butwal</option>
          <!-- Add more if needed -->
        </select>

        <button type="submit" name="search">Search</button>
      </form>

      <hr>

      <!-- Search Results -->
      <?php
      if (isset($_POST['search'])) {
        $blood_group = mysqli_real_escape_string($conn, $_POST['blood_group']);
        $district = mysqli_real_escape_string($conn, $_POST['district']);

        $sql = "SELECT fullname, age, gender, blood_group, phone, address, district 
              FROM donate_now 
              WHERE blood_group = '$blood_group'";

        if (!empty($district)) {
          $sql .= " AND district = '$district'";
        }

        $result = mysqli_query($conn, $sql);

        if (!$result) {
          echo "<p>Error in query: " . mysqli_error($conn) . "</p>";
        } elseif (mysqli_num_rows($result) > 0) {
          echo "<h3>✅ Matching Donors Found:</h3>";
          echo "<table>";
          echo "<tr><th>Name</th><th>Age</th><th>Gender</th><th>Blood Group</th><th>Contact</th><th>Address</th><th>District</th></tr>";
          while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr>
                  <td>" . htmlspecialchars($row['fullname']) . "</td>
                  <td>" . (int)$row['age'] . "</td>
                  <td>" . htmlspecialchars($row['gender']) . "</td>
                  <td>" . htmlspecialchars($row['blood_group']) . "</td>
                  <td>" . htmlspecialchars($row['phone']) . "</td>
                  <td>" . htmlspecialchars($row['address']) . "</td>
                  <td>" . htmlspecialchars($row['district']) . "</td>
                </tr>";
          }
          echo "</table>";
        } else {
          echo "<p>❌ No donors found for <strong>$blood_group</strong>" . (!empty($district) ? " in <strong>$district</strong>" : "") . ".</p>";
        }
      }
      ?>
    </div>
  </main>

</body>

</html>