<?php
// Start the session
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Hotel Horizon</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

  <!-- Google Fonts for better typography -->
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&family=Raleway:wght@400;500&display=swap" rel="stylesheet">
  
  <style>
    /* Apply Google Fonts */
    body {
      font-family: 'Poppins', sans-serif;
    }

    /* Navbar color change (lighter shade) */
    .navbar {
      background: #005f73; /* Deep teal color */
      transition: all 0.4s ease-in-out;
    }
    .navbar.scrolled {
      background: #003d47; /* Darker teal when scrolled */
      box-shadow: 0 4px 10px rgba(0,0,0,0.3);
    }

    /* Navbar brand style */
    .navbar-brand {
      font-family: 'Raleway', sans-serif;
      font-weight: 700;
      letter-spacing: 2px;
      font-size: 1.8rem;
      color: #fff;
    }

    /* Navbar link hover underline slide */
    .nav-link {
      position: relative;
      color: #f1f1f1 !important;
      margin: 0 6px;
      font-size: 1.1rem;
      font-weight: 500;
      transition: color 0.3s ease, transform 0.3s ease;
    }
    .nav-link::after {
      content: '';
      position: absolute;
      width: 0%;
      height: 2px;
      left: 0;
      bottom: 0;
      background: #00ff22;
      transition: width 0.3s ease-in-out;
    }
    .nav-link:hover::after {
      width: 100%;
      transform: scaleX(1.1);
    }

    /* Active link glowing effect */
    .nav-link.active {
      color: #00ff22 !important;
      text-shadow: 0 0 8px #00ff22, 0 0 12px #00ff22;
    }

    /* Dropdown style */
    .dropdown-menu {
      background: rgba(0,0,0,0.9);
      border-radius: 10px;
    }
    .dropdown-item {
      color: #f1f1f1;
    }
    .dropdown-item:hover {
      background: #00ff22;
      color: #000;
    }

    /* Toggler button style */
    .navbar-toggler-icon {
      background-color: #00ff22;
    }
  </style>
</head>
<body>
  <!-- Navbar -->
  <nav class="navbar navbar-expand-lg navbar-dark fixed-top">
    <div class="container">
      <a class="navbar-brand" href="index.php">HOTEL HORIZON</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ms-auto">
          <li class="nav-item"><a class="nav-link" href="index.php">Home</a></li>
          <li class="nav-item"><a class="nav-link" href="rooms.php">Rooms</a></li>
          <li class="nav-item"><a class="nav-link" href="dining.php">Dining</a></li>
          <li class="nav-item"><a class="nav-link" href="services.php">Services</a></li>
          <li class="nav-item"><a class="nav-link" href="gallery.php">Gallery</a></li>
          <li class="nav-item"><a class="nav-link" href="bookings.php">Bookings</a></li>
          <li class="nav-item"><a class="nav-link" href="blog.php">Blog</a></li>
          <li class="nav-item"><a class="nav-link" href="about.php">About</a></li>
          <li class="nav-item"><a class="nav-link" href="contact.php">Contact</a></li>
          <li class="nav-item"><a class="nav-link" href="admin/login.php">Admin Login</a></li>

          <?php if (isset($_SESSION['customer_id'])): ?>
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                <?= $_SESSION['customer_name']; ?>
              </a>
              <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="profile.php">Profile</a></li>
                <li><a class="dropdown-item" href="logout.php">Logout</a></li>
              </ul>
            </li>
          <?php else: ?>
            <li class="nav-item"><a class="nav-link" href="login.php">Login</a></li>
            <li class="nav-item"><a class="nav-link" href="register.php">Register</a></li>
          <?php endif; ?>
        </ul>
      </div>
    </div>
  </nav>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    // Navbar scroll effect
    window.addEventListener("scroll", function() {
      const navbar = document.querySelector(".navbar");
      if (window.scrollY > 50) {
        navbar.classList.add("scrolled");
      } else {
        navbar.classList.remove("scrolled");
      }
    });

    // Add active class to current page's nav link
    const currentLocation = window.location.href;
    const menuItem = document.querySelectorAll('.nav-link');

    menuItem.forEach(item => {
      if (currentLocation.includes(item.href)) {
        item.classList.add('active');
      }
    });
  </script>
</body>
</html>
