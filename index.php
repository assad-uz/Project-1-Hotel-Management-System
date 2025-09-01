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
  <title>Hotel Horizon - Home</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&family=Raleway:wght@400;500&display=swap" rel="stylesheet">

  <style>
    body {
      font-family: 'Poppins', sans-serif;
    }

    .navbar {
      background-color: #005f73;
      transition: all 0.4s ease-in-out;
    }

    .navbar.scrolled {
      background-color: #003d47;
      box-shadow: 0 4px 10px rgba(0, 0, 0, 0.3);
    }

    .hero-section {
      background: url('dist/images/index.jpg') no-repeat center center;
      background-size: cover;
      height: 100vh;
      color: #fff;
      display: flex;
      justify-content: center;
      align-items: center;
      text-align: center;
    }

    .hero-section h1 {
      font-size: 3.5rem;
      font-weight: 700;
    }

    .service-card {
      border: none;
      box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
      transition: transform 0.3s ease;
    }

    .service-card:hover {
      transform: scale(1.05);
    }

    .room-card img {
      width: 100%;
      height: auto;
    }

    .testimonial-section {
      background-color: #f1f1f1;
      padding: 60px 0;
    }

    .testimonial-card {
      background: #fff;
      box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
      padding: 20px;
      text-align: center;
    }

    footer {
      background-color: #003d47;
      color: white;
      padding: 30px 0;
      text-align: center;
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
          <li class="nav-item"><a class="nav-link" href="services.php">Services</a></li>
          <li class="nav-item"><a class="nav-link" href="contact.php">Contact</a></li>
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

  <!-- Hero Section -->
  <!-- Hero Section -->
  <div class="hero-section" style="position: relative;">
    <div style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(0, 0, 0, 0.5);"></div>
    <div style="position: relative; z-index: 1; color: #fff; text-align: center; padding: 50px;">
      <h1 style="font-size: 3.5rem; font-weight: 700;">Welcome to Hotel Horizon</h1>
      <p style="font-size: 1.2rem;">Your comfort is our priority</p>
      <a href="rooms.php" class="btn btn-success btn-lg">Book a Room</a>
    </div>
  </div>


  <!-- Services Section -->
  <section class="container py-5">
    <h2 class="text-center mb-5">Our Services</h2>
    <div class="row">
      <div class="col-md-4 mb-4">
        <div class="card service-card">
          <img src="dist/images/rooms.jpg" class="card-img-top" alt="Service">
          <div class="card-body">
            <h5 class="card-title">Luxury Rooms</h5>
            <p class="card-text">Enjoy a luxurious stay with world-class amenities.</p>
          </div>
        </div>
      </div>
      <div class="col-md-4 mb-4">
        <div class="card service-card">
          <img src="dist/images/dining.jpg" class="card-img-top" alt="Service">
          <div class="card-body">
            <h5 class="card-title">Fine Dining</h5>
            <p class="card-text">Relish delicious dishes from our multi-cuisine restaurant.</p>
          </div>
        </div>
      </div>
      <div class="col-md-4 mb-4">
        <div class="card service-card">
          <img src="dist/images/spa.jpg" class="card-img-top" alt="Service">
          <!-- <img src="https://via.placeholder.com/400x300" class="card-img-top" alt="Service"> -->
          <div class="card-body">
            <h5 class="card-title">Spa & Wellness</h5>
            <p class="card-text">Relax and rejuvenate with our spa and wellness treatments.</p>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Rooms Section -->
  <section class="container py-5">
    <h2 class="text-center mb-5">Our Rooms</h2>
    <div class="row">
      <div class="col-md-4 mb-4">
        <div class="card room-card">
          <img src="dist/images/front-room-1.jpg" class="card-img-top" alt="Room">
          <div class="card-body">
            <h5 class="card-title">Deluxe Room</h5>
            <p class="card-text">A spacious and elegantly designed room with all modern facilities.</p>
          </div>
        </div>
      </div>
      <div class="col-md-4 mb-4">
        <div class="card room-card">
          <img src="dist/images/front-room-2.jpg" class="card-img-top" alt="Room">
          <div class="card-body">
            <h5 class="card-title">Executive Suite</h5>
            <p class="card-text">A luxury suite with an amazing view and exclusive amenities.</p>
          </div>
        </div>
      </div>
      <div class="col-md-4 mb-4">
        <div class="card room-card">
          <img src="dist/images/front-room-3.jpg" class="card-img-top" alt="Room">
          <div class="card-body">
            <h5 class="card-title">Presidential Suite</h5>
            <p class="card-text">The most luxurious room in the hotel with private services and more.</p>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Testimonials Section -->
  <section class="testimonial-section">
    <div class="container">
      <h2 class="text-center mb-5">What Our Guests Say</h2>
      <div class="row">
        <div class="col-md-4">
          <div class="testimonial-card">
            <p>"A wonderful experience. The staff were extremely friendly, and the room was perfect!"</p>
            <h5>Akib Hussain</h5>
            <p>Guest</p>
          </div>
        </div>
        <div class="col-md-4">
          <div class="testimonial-card">
            <p>"I loved the luxury and comfort of the room. Highly recommend this hotel!"</p>
            <h5>Nazmus Sakib</h5>
            <p>Guest</p>
          </div>
        </div>
        <div class="col-md-4">
          <div class="testimonial-card">
            <p>"Fantastic service, delicious food, and relaxing ambiance. I’ll definitely be back!"</p>
            <h5>Rafia Akter</h5>
            <p>Guest</p>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Footer -->
  <footer>
    <p>&copy; 2025 Hotel Horizon. All Rights Reserved.</p>
    <p>Follow us on: <a href="#" class="text-white">Facebook</a> | <a href="#" class="text-white">Instagram</a> | <a href="#" class="text-white">Twitter</a></p>
  </footer>

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
  </script>
</body>

</html>