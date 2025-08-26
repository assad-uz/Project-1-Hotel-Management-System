<?php
// room.php
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Our Rooms - Hotel Horizon</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
</head>
<body>
<?php 
require_once("include/header.php");
require_once("include/navbar.php"); 
?>

<!-- Banner -->
<div class="container-fluid p-0">
  <img src="dist/images/hotel-banner.jpg" alt="Hotel Banner" class="img-fluid w-100" style="height:300px; object-fit:cover;">
</div>

<!-- Rooms Section -->
<section id="rooms" class="py-5 bg-light">
  <div class="container">
    <h2 class="text-center mb-5">Our Rooms</h2>

    <!-- King Size Room -->
    <div class="row mb-5 align-items-center">
      <div class="col-md-6">
        <img src="dist/images/king-room.jpg" alt="King Size Room" class="img-fluid rounded shadow">
      </div>
      <div class="col-md-6">
        <h3>King Size Room</h3>
        <p>
          Spacious and luxurious with modern facilities. Perfect for a premium stay.
        </p>
        <ul>
          <li><i class="bi bi-wifi"></i> Free WiFi</li>
          <li><i class="bi bi-snow"></i> Air Conditioning</li>
          <li><i class="bi bi-tv"></i> Smart TV</li>
          <li><i class="bi bi-cup-hot"></i> Complimentary Breakfast</li>
        </ul>
        <h5 class="text-primary">৳ 10,000 / Night</h5>
        <a href="booking.php" class="btn btn-primary mt-2">Book Now</a>
      </div>
    </div>

    <!-- Queen Size Room -->
    <div class="row mb-5 align-items-center flex-md-row-reverse">
      <div class="col-md-6">
        <img src="dist/images/queen-room.jpg" alt="Queen Size Room" class="img-fluid rounded shadow">
      </div>
      <div class="col-md-6">
        <h3>Queen Size Room</h3>
        <p>
          Comfortable and elegant room, ideal for couples seeking relaxation.
        </p>
        <ul>
          <li><i class="bi bi-wifi"></i> Free WiFi</li>
          <li><i class="bi bi-tv"></i> Flat-screen TV</li>
          <li><i class="bi bi-snow"></i> Air Conditioning</li>
          <li><i class="bi bi-cup-hot"></i> Breakfast Included</li>
        </ul>
        <h5 class="text-primary">৳ 7,500 / Night</h5>
        <a href="booking.php" class="btn btn-primary mt-2">Book Now</a>
      </div>
    </div>

    <!-- Standard Room -->
    <div class="row mb-5 align-items-center">
      <div class="col-md-6">
        <img src="dist/images/standard-room.jpg" alt="Standard Room" class="img-fluid rounded shadow">
      </div>
      <div class="col-md-6">
        <h3>Standard Room</h3>
        <p>
          Affordable and well-equipped room for a convenient stay.
        </p>
        <ul>
          <li><i class="bi bi-wifi"></i> Free WiFi</li>
          <li><i class="bi bi-tv"></i> LED TV</li>
          <li><i class="bi bi-fan"></i> Ceiling Fan</li>
          <li><i class="bi bi-cup-hot"></i> Tea & Coffee</li>
        </ul>
        <h5 class="text-primary">৳ 4,000 / Night</h5>
        <a href="booking.php" class="btn btn-primary mt-2">Book Now</a>
      </div>
    </div>

    <!-- Single Size Room -->
    <div class="row mb-5 align-items-center flex-md-row-reverse">
      <div class="col-md-6">
        <img src="dist/images/single-room.jpg" alt="Single Size Room" class="img-fluid rounded shadow">
      </div>
      <div class="col-md-6">
        <h3>Single Size Room</h3>
        <p>
          Perfect for solo travelers with all essential facilities.
        </p>
        <ul>
          <li><i class="bi bi-wifi"></i> Free WiFi</li>
          <li><i class="bi bi-tv"></i> TV</li>
          <li><i class="bi bi-fan"></i> Ceiling Fan</li>
        </ul>
        <h5 class="text-primary">৳ 2,500 / Night</h5>
        <a href="booking.php" class="btn btn-primary mt-2">Book Now</a>
      </div>
    </div>

  </div>
</section>

<!-- Footer -->
<?php require_once("include/footer.php");
?>


</body>
</html>
