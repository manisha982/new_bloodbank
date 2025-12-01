<?php
require_once 'db.php';

if (isset($_POST['district'])) {
    $district = $conn->real_escape_string($_POST['district']);
    $result = $conn->query("SELECT DISTINCT city FROM hospitals WHERE district = '$district' ORDER BY city ASC");

    echo '<option value="">Select City</option>';
    while ($row = $result->fetch_assoc()) {
        echo '<option value="' . htmlspecialchars($row['city']) . '">' . htmlspecialchars($row['city']) . '</option>';
    }
}



