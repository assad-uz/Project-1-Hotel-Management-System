<?php
// Start the session to handle user login status
session_start();
require_once("include/header.php"); // Include header for consistency across pages
require_once("include/navbar.php"); // Include navbar
?>

<!-- Inline CSS -->
<style>
  /* Banner image CSS */
  img.service-banner {
    width: 100%;
    height: 300px;
    object-fit: cover;
  }

  /* Service Image CSS */
  img.service-img {
    width: 100%;
    height: auto;
    border-radius: 8px;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
  }

  /* Add additional styles if needed */
</style>

<!-- Banner Section -->
<div class="container-fluid p-0">
  <img src="dist/images/service-banner.jpg" alt="Hotel Services" class="img-fluid w-100" style="height: 300px; object-fit: cover;">
</div>

<!-- Services Section -->
<section id="services" class="py-5 bg-light">
  <div class="container">
    <h2 class="text-center mb-5">Our Services</h2>
    
    <!-- Service 1: Spa & Wellness -->
    <div class="row mb-5 align-items-center">
      <div class="col-md-6">
        <img src="dist/images/spa-service.jpg" alt="Spa & Wellness" class="img-fluid rounded shadow">
      </div>
      <div class="col-md-6">
        <h3>Spa & Wellness</h3>
        <p>Indulge in a relaxing experience with our spa and wellness treatments. Our professional therapists will help you unwind and rejuvenate.</p>
        <ul>
          <li><i class="bi bi-check-circle"></i> Full body massages</li>
          <li><i class="bi bi-check-circle"></i> Facial treatments</li>
          <li><i class="bi bi-check-circle"></i> Aromatherapy</li>
          <li><i class="bi bi-check-circle"></i> Private wellness sessions</li>
        </ul>
      </div>
    </div>

    <!-- Service 2: Fine Dining -->
    <div class="row mb-5 align-items-center flex-md-row-reverse">
      <div class="col-md-6">
        <img src="dist/images/dining-service.jpg" alt="Fine Dining" class="img-fluid rounded shadow">
      </div>
      <div class="col-md-6">
        <h3>Fine Dining</h3>
        <p>Enjoy a selection of gourmet meals prepared by our talented chefs. From local delicacies to international cuisine, we have something to satisfy every palate.</p>
        <ul>
          <li><i class="bi bi-check-circle"></i> Breakfast, lunch, and dinner</li>
          <li><i class="bi bi-check-circle"></i> Vegetarian & Vegan options</li>
          <li><i class="bi bi-check-circle"></i> 24/7 room service</li>
          <li><i class="bi bi-check-circle"></i> Special events and private dining</li>
        </ul>
      </div>
    </div>

    <!-- Service 3: Conference & Event Hosting -->
    <div class="row mb-5 align-items-center">
      <div class="col-md-6">
        <img src="dist/images/conference-service.jpg" alt="Conference & Event Hosting" class="img-fluid rounded shadow">
      </div>
      <div class="col-md-6">
        <h3>Conference & Event Hosting</h3>
        <p>Host your next corporate event or private function with us. We offer fully equipped conference rooms, along with catering and technical support.</p>
        <ul>
          <li><i class="bi bi-check-circle"></i> State-of-the-art conference facilities</li>
          <li><i class="bi bi-check-circle"></i> Audio-visual equipment</li>
          <li><i class="bi bi-check-circle"></i> Event planning and management</li>
          <li><i class="bi bi-check-circle"></i> Customizable catering options</li>
        </ul>
      </div>
    </div>

    <!-- Service 4: Pool & Fitness Center -->
    <div class="row mb-5 align-items-center flex-md-row-reverse">
      <div class="col-md-6">
        <img src="dist/images/pool-service.jpg" alt="Pool" class="img-fluid rounded shadow">
      </div>
      <div class="col-md-6">
        <h3>Swimming Pool</h3>
        <p>Enjoy during your stay with access to our luxurious swimming pool.</p>
        <ul>
          <li><i class="bi bi-check-circle"></i> Outdoor & indoor swimming pools</li>
          <li><i class="bi bi-check-circle"></i> Sauna and steam room</li>
        </ul>
      </div>
    </div>
  </div>
</section>

<!-- Footer -->
<?php require_once("include/footer.php"); ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
