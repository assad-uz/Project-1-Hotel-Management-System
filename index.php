<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Welcome Hotel Horizon </title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="assets/css/style.css" />

</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container">
    <a class="navbar-brand" href="#">HOTEL HORIZON</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" 
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav ms-5 me-auto mb-2 mb-lg-0"> <!-- Left side nav items -->
        <li class="nav-item">
          <a class="nav-link fs-6" href="rooms.php">Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link fs-6" href="about.php">About</a>
        </li>
        <li class="nav-item">
          <a class="nav-link fs-6" href="contact.php">Rooms</a>
        </li>
        <li class="nav-item">
          <a class="nav-link fs-6" href="contact.php">Dining</a>
        </li>
        <li class="nav-item">
          <a class="nav-link fs-6" href="contact.php">Services</a>
        </li>
        <li class="nav-item">
          <a class="nav-link fs-6" href="contact.php">Gallary</a>
        </li>
        <li class="nav-item">
          <a class="nav-link fs-6" href="contact.php">Bookings</a>
        </li>
        <li class="nav-item">
          <a class="nav-link fs-6" href="contact.php">Blog</a>
        </li>
        <li class="nav-item">
          <a class="nav-link fs-6" href="contact.php">Contact</a>
        </li>
      </ul>

      <ul class="navbar-nav ms-auto"> <!-- Right side buttons -->
        <li class="nav-item">
          <a class="btn btn-outline-light me-2" href="auth/login.php">Login</a>
        </li>
        <li class="nav-item">
          <a class="btn btn-outline-light" href="auth/register.php">Register</a>
        </li>
      </ul>
    </div>
  </div>
</nav>

  <!-- Full screen background with overlay content -->
<div class="bg-cover">
  <div class="overlay text-center">
    <h1 class="display-7 fw-bold mb-3">Welcome to HOTEL HORIZON</h1>
    <!-- <h1 class="display-4 fw-bold mb-3">Welcome to <span class="text-warning">HOTEL HORIZON</span></h1> -->
    <p class="lead fw-semibold mb-4">Book your stay with ease and comfort</p>
    <a href="book_room.php" class="btn btn-yellow btn-lg fw-semibold">Book Now</a>
  </div>
</div>


  <!-- Features Section -->
  <section class="py-5">
    <div class="container">
      <div class="row text-center">
        <div class="col-md-4">
          <h4>Room Booking</h4>
          <p>Find and book available rooms quickly with just a few clicks.</p>
        </div>
        <div class="col-md-4">
          <h4>Easy Management</h4>
          <p>Manage your bookings and rooms effortlessly.</p>
        </div>
        <div class="col-md-4">
          <h4>User Dashboard</h4>
          <p>Track your bookings, payments, and check-in/check-out schedule.</p>
        </div>
      </div>
    </div>
  </section>

  <!-- Footer -->
  <footer class="bg-dark text-white text-center py-3">
    &copy; <?= date('Y') ?> Hotel Management System. All Rights Reserved.
    <p class="mb-0">Developed by <a href="https://www.linkedin.com/in/assad-uz/">ASSADUZZAMAN SHAON</a></p>
  </footer>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
