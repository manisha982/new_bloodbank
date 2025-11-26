<?php
session_start();

// 🧱 If not logged in at all → send to main login
if (!isset($_SESSION['username']) || !isset($_SESSION['role'])) {
    header("Location: ../Admin_login.php");
    exit;
}

// 🚫 If not an admin → deny access
if ($_SESSION['role'] !== 'Admin') {
    echo "<h2 style='color: red; text-align: center; margin-top: 100px;'>
        ⛔ Access Denied<br>Only administrators can access this page.
    </h2>";
    exit;
}
