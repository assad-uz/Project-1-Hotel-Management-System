<!-- index.php -->
<?php include('header.php'); ?>
<?php include('navbar.php'); ?>

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
<?php include('footer.php'); ?>



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