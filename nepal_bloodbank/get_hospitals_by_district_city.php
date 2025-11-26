<?php
require_once 'db.php';

if (isset($_POST['district']) && isset($_POST['district'])) {
    $district = $conn->real_escape_string($_POST['district']);
    $city = $conn->real_escape_string($_POST['city']);
    $result = $conn->query("SELECT hospital_name FROM hospitals WHERE district = '$district' AND city = '$city' ORDER BY hospital_name ASC");

    echo '<option value="">Select Hospital</option>';
    while ($row = $result->fetch_assoc()) {
        echo '<option value="' . htmlspecialchars($row['hospital_name']) . '">' . htmlspecialchars($row['hospital_name']) . '</option>';
    }
}
