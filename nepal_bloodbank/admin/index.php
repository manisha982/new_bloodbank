<?php include("auth.php"); ?>
<?php
$page = $_GET['page'] ?? 'dashboard';
$allowed_pages = [
  'dashboard',
  'donors',
  'hospitals',
  'emergency_request',
  'donate_requests',
  'profile',
  'patient_request',
  'message',
];
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title>Blood Bank Admin Dashboard</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Bootstrap Icons -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
  <!-- Custom CSS -->
  <link rel="stylesheet" href="assets/style.css">
</head>

<body>

  <div class="d-flex" id="wrapper">
    <!-- Sidebar -->
    <nav id="sidebar" class="bg-danger text-white">
      <div class="sidebar-header text-center py-4">
        <h4 class="fw-bold">🩸 Blood Bank</h4>
      </div>

      <ul class="nav flex-column px-3">

        <li class="nav-item mb-2">
          <a href="index.php?page=dashboard" class="nav-link text-white">
            <i class="bi bi-speedometer2 me-2"></i> Dashboard
          </a>
        </li>

        <li class="nav-item mb-2">
          <a href="index.php?page=hospitals" class="nav-link text-white">
            <i class="bi bi-hospital-fill me-2"></i> Hospitals
          </a>
        </li>

        <li class="nav-item mb-2">
          <a href="index.php?page=donate_requests" class="nav-link text-white">
            <i class="bi bi-arrow-up-square-fill me-2"></i> Donate Requests
          </a>
        </li>

        <li class="nav-item mb-2">
          <a href="index.php?page=emergency_request" class="nav-link text-white">
            <i class="bi bi-exclamation-triangle-fill me-2"></i> Emergency Requests
          </a>
        </li>

        <li class="nav-item mb-2">
          <a href="index.php?page=patient_request" class="nav-link text-white">
            <i class="bi bi-people-fill me-2"></i> Patient Request
          </a>
        </li>

        <li class="nav-item mb-2">
          <a href="index.php?page=message" class="nav-link text-white">
            <i class="bi bi-chat-dots-fill me-2"></i> Messages
          </a>
        </li>

        <li class="nav-item mb-2">
          <a href="index.php?page=profile" class="nav-link text-white">
            <i class="bi bi-person-circle me-2"></i> Profile
          </a>
        </li>

      </ul>
    </nav>


    <!-- Main Content -->
    <div id="main-content" class="flex-grow-1">
      <!-- Top Navbar -->
      <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm px-4">
        <div class="container-fluid">
          <!-- Toggle Button: Always Visible -->
          <button class="btn btn-outline-danger" id="menu-toggle">
            <i class="bi bi-list"></i>
          </button>

          <div class="ms-auto">
            <div class="dropdown">
              <a href="#" class="d-flex align-items-center text-decoration-none text-dark dropdown-toggle" id="profileDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                <img src="assets/user.png" class="rounded-circle me-2" width="40" height="40" alt="profile">
                <strong>Admin</strong>
              </a>
              <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="profileDropdown">
                <li><a class="dropdown-item" href="index.php?page=profile"><i class="bi bi-gear me-2"></i> Settings</a></li>
                <li>
                  <hr class="dropdown-divider">
                </li>
                <li><a class="dropdown-item text-danger" href="../logout.php"><i class="bi bi-box-arrow-right me-2"></i> Logout</a></li>
              </ul>
            </div>
          </div>
        </div>
      </nav>

      <!-- Dynamic Page Content -->
      <div class="container-fluid p-4">
        <?php
        if (in_array($page, $allowed_pages) && file_exists("pages/$page.php")) {
          include("pages/$page.php");
        } else {
          echo "<h4 class='text-danger'>404 - Page Not Found</h4>";
        }
        ?>
      </div>
    </div>
  </div>

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

  <!-- Sidebar Toggle Script -->
  <script>
    const toggleBtn = document.getElementById("menu-toggle");
    const sidebar = document.getElementById("sidebar");

    toggleBtn.addEventListener("click", () => {
      sidebar.classList.toggle("collapsed");
    });
  </script>

</body>

</html>