<?php
require_once '../includes/../db.php';

// 🧱 Step 1: Ensure login session exists
if (!isset($_SESSION['username']) || !isset($_SESSION['role'])) {
    header("Location: ../Admin_login.php");
    exit;
}

// 🚫 Step 2: Allow only admins
if (strtolower($_SESSION['role']) !== 'admin') {
    echo "<h2 style='color: red; text-align: center; margin-top: 100px;'>
        ⛔ Access Denied<br>Only administrators can access this page.
    </h2>";
    exit;
}

// ✅ Step 3: Fetch admin profile details safely
$username = $_SESSION['username'];

// First try to fetch by username
$query = "SELECT * FROM login_Users WHERE LOWER(username) = LOWER(?) LIMIT 1";
$stmt = $conn->prepare($query);
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

// 🧩 If no match found, fallback to Admin role
if (!$user) {
    $query = "SELECT * FROM login_Users WHERE LOWER(role) = 'admin' LIMIT 1";
    $stmt = $conn->prepare($query);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();
}

// 🧱 Final check
if (!$user) {
    echo "<div class='alert alert-danger text-center mt-5'>
        Admin profile not found for username: <strong>" . htmlspecialchars($username) . "</strong>
    </div>";
    exit;
}

// ✅ Admin found — continue
?>


<!-- ✅ Admin Profile UI -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

<div class="container my-5">
    <div class="row">
        <div class="col-lg-8 mx-auto">

            <!-- Profile Card -->
            <div class="card mb-4 shadow-sm border-0">
                <div class="card-header bg-white">
                    <h5 class="mb-0">
                        <i class="bi bi-person-badge-fill text-primary"></i> Profile Information
                    </h5>
                </div>

                <ul class="list-group list-group-flush">
                    <li class="list-group-item py-3">
                        <div class="row">
                            <div class="col-sm-4 text-muted">
                                <i class="bi bi-person-fill text-primary me-2"></i>
                                <strong>Full Name</strong>
                            </div>
                            <div class="col-sm-8"><?php echo htmlspecialchars($user['fullname']); ?></div>
                        </div>
                    </li>

                    <li class="list-group-item py-3">
                        <div class="row">
                            <div class="col-sm-4 text-muted">
                                <i class="bi bi-person-badge-fill text-primary me-2"></i>
                                <strong>Username</strong>
                            </div>
                            <div class="col-sm-8"><?php echo htmlspecialchars($user['username']); ?></div>
                        </div>
                    </li>

                    <li class="list-group-item py-3">
                        <div class="row">
                            <div class="col-sm-4 text-muted">
                                <i class="bi bi-envelope text-primary me-2"></i>
                                <strong>Email</strong>
                            </div>
                            <div class="col-sm-8">
                                <?php echo htmlspecialchars($user['email'] ?? 'Not provided'); ?>
                            </div>
                        </div>
                    </li>

                    <li class="list-group-item py-3">
                        <div class="row">
                            <div class="col-sm-4 text-muted">
                                <i class="bi bi-droplet text-primary me-2"></i>
                                <strong>Blood Group</strong>
                            </div>
                            <div class="col-sm-8">
                                <span class="badge bg-danger">
                                    <?php echo htmlspecialchars($user['blood_group'] ?? 'Unknown'); ?>
                                </span>
                            </div>
                        </div>
                    </li>


                    <li class="list-group-item py-3 border-bottom-0">
                        <div class="row">
                            <div class="col-sm-4 text-muted">
                                <i class="bi bi-calendar-event text-primary me-2"></i>
                                <strong>Member Since</strong>
                            </div>
                            <div class="col-sm-8">
                                <?php
                                $date = isset($user['created_at']) ? date("F d, Y", strtotime($user['created_at'])) : 'Unknown';
                                echo $date;
                                ?>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>

            <!-- Buttons -->
            <div class="card text-center p-3 shadow-sm border-0">
                <div class="d-flex justify-content-center flex-wrap gap-3">
                    <a href="#" class="btn btn-primary btn-lg">
                        <i class="bi bi-pencil-fill"></i> Edit Profile
                    </a>
                    <a href="#" class="btn btn-outline-secondary btn-lg">
                        <i class="bi bi-key-fill"></i> Change Password
                    </a>
                    <a href="../logout.php"
                        class="btn btn-lg text-white"
                        style="background-color:#dc3545; border:none;"
                        onmouseover="this.style.backgroundColor='#b71c1c'"
                        onmouseout="this.style.backgroundColor='#dc3545'">
                        <i class="bi bi-box-arrow-right"></i> Logout
                    </a>
                </div>
            </div>

        </div>
    </div>
</div>