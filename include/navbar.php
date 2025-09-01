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
