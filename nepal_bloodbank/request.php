<?php
require_once 'db.php'; // Make sure this connects correctly

$districts = $conn->query("SELECT DISTINCT district FROM hospitals ORDER BY district ASC");
$cities = $conn->query("SELECT DISTINCT city FROM hospitals ORDER BY city ASC");

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nepalbloodbank - Request Blood</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="request.css">
    
</head>
<body>
    <!-- Navigation Bar -->
    <header>
        <nav>
            <div class="logo">Nepalbloodbank</div>
            <ul class="nav-links" style="text-align: center;">
                <li><a href="index.php">Home</a></li>
                <li><a href="find_donors.php">Find Donors</a></li>
                <li><a href="Admin_login.php">Admin</a></li>
                 <li><a href="donation_centres.html">Donation Centres</a></li>
                <li><a href="#service">Services
                    <ul class="menu">
                    <li><a href="donate_now.php">Donate Now</a></li>
                    <li><a href="request.php">Request Blood</a></li>
                    <li><a href="available.php">Available Blood</a></li>
                    <li><a href="compatibility.php" class="active">Compatibility</a></li>
                    </ul>
                </a></li>
               <li><a href="index.php #contact">Contact</a></li>
               
                <li><a href="emergency.php" class="emergency-btn">Emergency</a></li>
            </ul>
            <div class="menu-toggle">
                <span></span>
                <span></span>
                <span></span>
            </div>
        </nav>
    </header>
    
    <!-- Animated background elements -->
    <div class="blood-drop" style="width: 30px; height: 45px; top: 10%; left: 5%; animation-delay: 0s;"></div>
    <div class="blood-drop" style="width: 20px; height: 30px; top: 20%; left: 15%; animation-delay: 2s;"></div>
    <div class="blood-drop" style="width: 40px; height: 60px; top: 5%; left: 25%; animation-delay: 4s;"></div>
    <div class="blood-drop" style="width: 25px; height: 38px; top: 15%; left: 35%; animation-delay: 6s;"></div>
    <div class="blood-drop" style="width: 35px; height: 52px; top: 8%; left: 45%; animation-delay: 8s;"></div>
    <div class="blood-drop" style="width: 15px; height: 22px; top: 25%; left: 55%; animation-delay: 10s;"></div>
    <div class="blood-drop" style="width: 28px; height: 42px; top: 12%; left: 65%; animation-delay: 12s;"></div>
    <div class="blood-drop" style="width: 22px; height: 33px; top: 18%; left: 75%; animation-delay: 14s;"></div>
    <div class="blood-drop" style="width: 32px; height: 48px; top: 7%; left: 85%; animation-delay: 16s;"></div>
    <div class="blood-drop" style="width: 18px; height: 27px; top: 22%; left: 95%; animation-delay: 18s;"></div>
    
    <!-- Right side blood drops -->
    <div class="blood-drop" style="width: 22px; height: 33px; top: 5%; right: 5%; animation-delay: 1s;"></div>
    <div class="blood-drop" style="width: 18px; height: 27px; top: 15%; right: 15%; animation-delay: 3s;"></div>
    <div class="blood-drop" style="width: 30px; height: 45px; top: 8%; right: 25%; animation-delay: 5s;"></div>
    <div class="blood-drop" style="width: 25px; height: 38px; top: 20%; right: 35%; animation-delay: 7s;"></div>
    <div class="blood-drop" style="width: 15px; height: 22px; top: 12%; right: 45%; animation-delay: 9s;"></div>
    <div class="blood-drop" style="width: 35px; height: 52px; top: 25%; right: 55%; animation-delay: 11s;"></div>
    <div class="blood-drop" style="width: 20px; height: 30px; top: 18%; right: 65%; animation-delay: 13s;"></div>
    <div class="blood-drop" style="width: 28px; height: 42px; top: 10%; right: 75%; animation-delay: 15s;"></div>
    <div class="blood-drop" style="width: 32px; height: 48px; top: 22%; right: 85%; animation-delay: 17s;"></div>
    <div class="blood-drop" style="width: 40px; height: 60px; top: 15%; right: 95%; animation-delay: 19s;"></div>
    
    <!-- Blood cells for additional animation -->
    <div class="blood-cell" style="width: 60px; height: 60px; top: 30%; left: 10%; animation-delay: 0s;"></div>
    <div class="blood-cell" style="width: 40px; height: 40px; top: 60%; left: 20%; animation-delay: 2s;"></div>
    <div class="blood-cell" style="width: 70px; height: 70px; top: 40%; right: 15%; animation-delay: 4s;"></div>
    <div class="blood-cell" style="width: 50px; height: 50px; top: 70%; right: 25%; animation-delay: 6s;"></div>
    
    <div class="container">
        <div class="header">
            <h1>Nepalbloodbank</h1>
            <p>Your Drop. Their Hope. Our Future</p>
        </div>
        
        <div class="form-container">
            <h2 class="section-title">Request Blood</h2>
            <form id="blood-request-form" action="submit_request.php" method="POST">
                <div class="form-group">
                    <label for="fullname">Full Name *</label>
                    <input type="text" id="fullname" name="fullname" class="form-control" placeholder="Enter your full name" required>
                    <div class="error-message" id="fullname-error">Please enter your full name</div>
                </div>
                
                <div class="form-group">
                    <label for="phone">Phone Number *</label>
                    <input type="tel" id="phone" name="phone" class="form-control" placeholder="Enter your phone number" required>
                    <div class="error-message" id="phone-error">Please enter a valid phone number</div>
                </div>
                
                <div class="form-group">
                    <label for="blood-group">Blood Group Needed *</label>
                    <select id="blood-group" name="blood-group" class="form-control" required>
                        <option value="">Select blood group</option>
                        <option value="A+">A+</option>
                        <option value="A-">A-</option>
                        <option value="B+">B+</option>
                        <option value="B-">B-</option>
                        <option value="AB+">AB+</option>
                        <option value="AB-">AB-</option>
                        <option value="O+">O+</option>
                        <option value="O-">O-</option>
                    </select>
                    <div class="error-message" id="blood-group-error">Please select blood group</div>
                </div>
                
                <div class="form-group">
                    <label>Number of Blood Bags Needed *</label>
                    <div class="blood-bags">
                        <div class="blood-bag" data-bags="1" onclick="selectBags(1)">
                            <i class="fas fa-tint"></i>
                            <div>1 Bag</div>
                        </div>
                        <div class="blood-bag" data-bags="2" onclick="selectBags(2)">
                            <i class="fas fa-tint"></i>
                            <i class="fas fa-tint"></i>
                            <div>2 Bags</div>
                        </div>
                        <div class="blood-bag" data-bags="3" onclick="selectBags(3)">
                            <i class="fas fa-tint"></i>
                            <i class="fas fa-tint"></i>
                            <i class="fas fa-tint"></i>
                            <div>3 Bags</div>
                        </div>
                        <div class="blood-bag" data-bags="4" onclick="selectBags(4)">
                            <i class="fas fa-tint"></i>
                            <i class="fas fa-tint"></i>
                            <i class="fas fa-tint"></i>
                            <i class="fas fa-tint"></i>
                            <div>4 Bags</div>
                        </div>
                        <div class="blood-bag" data-bags="5" onclick="selectBags(5)">
                            <i class="fas fa-tint"></i>
                            <i class="fas fa-tint"></i>
                            <i class="fas fa-tint"></i>
                            <i class="fas fa-tint"></i>
                            <i class="fas fa-tint"></i>
                            <div>5 Bags</div>
                        </div>
                    </div>
                    <input type="hidden" id="blood-bags" name="blood-bags" value="">
                    <div class="error-message" id="bags-error">Please select number of blood bags needed</div>
                </div>
                
                    <!-- District -->
                    <div class="form-group">
                    <label for="district">District *</label>
                    <select id="district" name="district" class="form-control" required onchange="loadCities()">
                        <option value="">Select District</option>
                        <?php while ($row = $districts->fetch_assoc()): ?>
                        <option value="<?= htmlspecialchars($row['district']) ?>"><?= htmlspecialchars($row['district']) ?></option>
                        <?php endwhile; ?>
                    </select>
                    </div>
                    
                    <!-- City -->
                     <!-- id="city" -->
                    <div class="form-group">
                    <label for="city">City *</label>
                    <select  name="area" class="form-control" required>
                        <option value="">Select City</option>
                          <?php while ($row = $cities->fetch_assoc()): ?>
                                <option value="<?= htmlspecialchars($row['city']) ?>"><?= htmlspecialchars($row['city']) ?></option>
                        <?php endwhile; ?>
                    </select>
                    </div>
                    


                
                <div class="form-group">
                    <label for="urgency">Urgency Level *</label>
                    <select id="urgency" name="urgency" class="form-control" required>
                        <option value="">Select urgency level</option>
                        <option value="normal">Normal (Within 2-3 days)</option>
                        <option value="urgent">Urgent (Within 24 hours)</option>
                        <option value="emergency">Emergency (Immediately)</option>
                    </select>
                    <div class="error-message" id="urgency-error">Please select urgency level</div>
                </div>
                
                <div class="form-group">
                    <label for="details">Additional Details</label>
                    <textarea id="details" name="details" class="form-control" rows="3" placeholder="Any additional information about the request"></textarea>
                </div>
                
                <button type="button" class="btn-review" onclick="showReview()">
                    <i class="fas fa-eye"></i> Review Information
                </button>
                
                <div class="review-container" id="review-container">
                    <div class="review-header">
                        <h3 class="review-title">Your Information</h3>
                        <button type="button" class="btn-close" onclick="closeReview()">
                            <i class="fas fa-times"></i> Close
                        </button>
                    </div>
                    
                    <div class="review-item">
                        <span class="review-label">Full Name:</span>
                        <span class="review-value" id="review-fullname"></span>
                    </div>
                    
                    <div class="review-item">
                        <span class="review-label">Phone Number:</span>
                        <span class="review-value" id="review-phone"></span>
                    </div>
                    
                    <div class="review-item">
                        <span class="review-label">Blood Group:</span>
                        <span class="review-value" id="review-blood-group"></span>
                    </div>
                    
                    <div class="review-item">
                        <span class="review-label">Bags Needed:</span>
                        <span class="review-value" id="review-bags"></span>
                    </div>
                    
                    <div class="review-item">
                        <span class="review-label">District:</span>
                        <span class="review-value" id="review-district"></span>
                    </div>
                    
                    <div class="review-item">
                        <span class="review-label">City:</span>
                        <span class="review-value" id="review-area"></span>
                    </div>
                    
                    <div class="review-item">
                        <span class="review-label">Urgency:</span>
                        <span class="review-value" id="review-urgency"></span>
                    </div>
                </div>
                
                <div class="form-group">
                    <div class="terms">
                        <input type="checkbox" id="terms" name="terms" required>
                        <label for="terms">I agree to the terms and conditions *</label>
                    </div>
                    <div class="error-message" id="terms-error">You must agree to the terms and conditions</div>
                </div>
                
                <button type="submit" class="btn-submit">Submit Blood Request</button>
            </form>
        </div>
    </div>


<script>


// Mobile menu toggle
document.addEventListener('DOMContentLoaded', function() {
    const menuToggle = document.querySelector('.menu-toggle');
    const navLinks = document.querySelector('.nav-links');
    
    menuToggle.addEventListener('click', function() {
        navLinks.classList.toggle('active');
    });
    
    // Make submenus work on mobile
    const menuItems = document.querySelectorAll('nav li:has(.menu)');
    menuItems.forEach(item => {
        const link = item.querySelector('a');
        link.addEventListener('click', function(e) {
            if (window.innerWidth <= 768) {
                e.preventDefault();
                const menu = item.querySelector('.menu');
                menu.classList.toggle('active');
            }
        });
    });
});

// Blood bag selection
function selectBags(num) {
    const bags = document.querySelectorAll('.blood-bag');
    bags.forEach(bag => {
        bag.classList.remove('selected');
    });
    
    const selectedBag = document.querySelector(`.blood-bag[data-bags="${num}"]`);
    selectedBag.classList.add('selected');
    
    document.getElementById('blood-bags').value = num;
    document.getElementById('bags-error').style.display = 'none';
}

// Show review information
function showReview() {
    // Validate form first
    let isValid = true;
    
    const fullname = document.getElementById('fullname').value;
    const phone = document.getElementById('phone').value;
    const bloodGroup = document.getElementById('blood-group').value;
    const bloodBags = document.getElementById('blood-bags').value;
    const district = document.getElementById('district').value;
    const area = document.getElementById('city').value;
    const urgency = document.getElementById('urgency').value;
    
    if (!fullname) {
        document.getElementById('fullname-error').style.display = 'block';
        isValid = false;
    }
    
    if (!phone) {
        document.getElementById('phone-error').style.display = 'block';
        isValid = false;
    }
    
    if (!bloodGroup) {
        document.getElementById('blood-group-error').style.display = 'block';
        isValid = false;
    }
    
    if (!bloodBags) {
        document.getElementById('bags-error').style.display = 'block';
        isValid = false;
    }
    
    if (!district) {
        document.getElementById('district-error').style.display = 'block';
        isValid = false;
    }
    
    if (!area) {
        document.getElementById('area-error').style.display = 'block';
        isValid = false;
    }
    
    if (!urgency) {
        document.getElementById('urgency-error').style.display = 'block';
        isValid = false;
    }
    
    if (!isValid) {
        alert('Please fill all required fields correctly.');
        return;
    }
    
    // Populate review fields
    document.getElementById('review-fullname').textContent = fullname;
    document.getElementById('review-phone').textContent = phone;
    document.getElementById('review-blood-group').textContent = bloodGroup;
    document.getElementById('review-bags').textContent = bloodBags + ' bag(s)';
    document.getElementById('review-district').textContent = district;
    document.getElementById('review-area').textContent = area;
    document.getElementById('review-urgency').textContent = document.getElementById('urgency').options[document.getElementById('urgency').selectedIndex].text;
    
    // Show review container
    document.getElementById('review-container').classList.add('active');
}

// Close review information
function closeReview() {
    document.getElementById('review-container').classList.remove('active');
}

// Form submission validation
document.getElementById('blood-request-form').addEventListener('submit', function(e) {
    // Validate terms
    if (!document.getElementById('terms').checked) {
        e.preventDefault();
        document.getElementById('terms-error').style.display = 'block';
        alert('Please agree to the terms and conditions.');
        return;
    }
    
    // The form will submit to PHP script
});













function loadCities() {
  const district = document.getElementById('district').value;
  const citySelect = document.getElementById('city');

  citySelect.innerHTML = '<option value="">Loading...</option>';
  citySelect.disabled = true;

  if (district) {
    fetch('get_cities_by_district_request.php', {
      method: 'POST',
      headers: {'Content-Type': 'application/x-www-form-urlencoded'},
      body: 'district=' + encodeURIComponent(district)
    })
    .then(res => res.text())
    .then(data => {
      citySelect.innerHTML = data;
      citySelect.disabled = false;
    });
  }
}
</script>
</body>
</html>