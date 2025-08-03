<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Welcome to Hotel Management System</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="assets/css/style.css" />

</head>
<body>

  <!-- Navbar -->
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
      <a class="navbar-brand" href="#">HotelSys</a>
      <div class="collapse navbar-collapse">
        <ul class="navbar-nav ms-auto">
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
    <div class="overlay">
      <h1 class="display-4 mb-3">Welcome to Our Hotel</h1>
      <p class="lead mb-4">Book your stay with ease and comfort</p>
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
          <p>Admins can easily manage rooms, users, and bookings.</p>
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
  </footer>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
