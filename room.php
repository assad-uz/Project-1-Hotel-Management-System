<?php
require_once("include/header.php");
?>

<!--
  এই div ট্যাগটি সম্পূর্ণ পেজটিকে একটি flex container হিসেবে সেট করে।
  - d-flex: display: flex;
  - flex-column: কন্টেন্টগুলো vertical ভাবে সাজায় (উপর থেকে নিচে)।
  - min-vh-100: viewport-এর ন্যূনতম উচ্চতার 100% জায়গা নেয়, যা ফুটারকে নিচে রাখতে সাহায্য করে।
-->
<div class="d-flex flex-column min-vh-100">
  <?php
  require_once("include/navbar.php");
  ?>

  <!-- Rooms Section -->
  <!--
    এই section ট্যাগটি মূল কন্টেন্ট হিসেবে কাজ করবে।
    - flex-grow-1: এটি বাকি vertical জায়গা পূরণ করে, যা ফুটারকে নিচে ঠেলে দেয়।
    - d-flex: এই সেকশনটিকে flex container বানায়।
    - align-items-center: এই সেকশনের ভিতরের কন্টেন্টকে vertical ভাবে মাঝখানে নিয়ে আসে।
    - py-5: উপরে এবং নিচে padding যোগ করে।
  -->
  <section id="rooms" class="flex-grow-1 d-flex align-items-center py-5">
    <div class="container my-5">
      <h2 class="text-center mb-5">Our Rooms</h2>
      <div class="row g-4 justify-content-center">
        
        <!-- Room Card 1: Single Room -->
        <div class="col-md-6 col-lg-4">
          <div class="card shadow rounded">
            <img src="dist/images/room1.webp" class="card-img-top rounded-top" alt="Single Room">
            <!-- উপরের 'src' অ্যাট্রিবিউটে আপনার নিজের ছবির Path বসাবেন -->
            <div class="card-body">
              <h5 class="card-title">Single Room</h5>
              <hr>
              <p class="card-text text-muted">A comfortable room for solo travelers.</p>
              <ul class="list-unstyled">
                <li><i class="fas fa-bed text-primary me-2"></i> 1 Single Bed</li>
                <li><i class="fas fa-wifi text-primary me-2"></i> Free Wi-Fi</li>
                <li><i class="fas fa-shower text-primary me-2"></i> Private Bathroom</li>
                <li><i class="fas fa-tv text-primary me-2"></i> TV with Cable</li>
              </ul>
              <div class="d-flex justify-content-between align-items-center mt-3">
                <span class="h4 text-success">$100<small>/night</small></span>
                <a href="#" class="btn btn-primary">Book Now</a>
              </div>
            </div>
          </div>
        </div>
        
        <!-- Room Card 2: Double Room -->
        <div class="col-md-6 col-lg-4">
          <div class="card shadow rounded">
            <img src="dist/images/room2.webp" class="card-img-top rounded-top" alt="Double Room">
            <!-- উপরের 'src' অ্যাট্রিবিউটে আপনার নিজের ছবির Path বসাবেন -->
            <div class="card-body">
              <h5 class="card-title">Double Room</h5>
              <hr>
              <p class="card-text text-muted">Spacious and elegant room for two.</p>
              <ul class="list-unstyled">
                <li><i class="fas fa-bed text-primary me-2"></i> 1 Double Bed</li>
                <li><i class="fas fa-wifi text-primary me-2"></i> Free Wi-Fi</li>
                <li><i class="fas fa-bath text-primary me-2"></i> En-suite Bathroom</li>
                <li><i class="fas fa-tv text-primary me-2"></i> Flat-screen TV</li>
              </ul>
              <div class="d-flex justify-content-between align-items-center mt-3">
                <span class="h4 text-success">$150<small>/night</small></span>
                <a href="#" class="btn btn-primary">Book Now</a>
              </div>
            </div>
          </div>
        </div>
        
        <!-- Room Card 3: Deluxe Room -->
        <div class="col-md-6 col-lg-4">
          <div class="card shadow rounded">
            <img src="dist/images/room3.webp" class="card-img-top rounded-top" alt="Deluxe Room">
            <!-- উপরের 'src' অ্যাট্রিবিউটে আপনার নিজের ছবির Path বসাবেন -->
            <div class="card-body">
              <h5 class="card-title">Deluxe Room</h5>
              <hr>
              <p class="card-text text-muted">Experience luxury and comfort.</p>
              <ul class="list-unstyled">
                <li><i class="fas fa-bed text-primary me-2"></i> 1 King Bed</li>
                <li><i class="fas fa-wifi text-primary me-2"></i> Free High-speed Wi-Fi</li>
                <li><i class="fas fa-coffee text-primary me-2"></i> Coffee Machine</li>
                <li><i class="fas fa-snowflake text-primary me-2"></i> Air Conditioning</li>
              </ul>
              <div class="d-flex justify-content-between align-items-center mt-3">
                <span class="h4 text-success">$200<small>/night</small></span>
                <a href="#" class="btn btn-primary">Book Now</a>
              </div>
            </div>
          </div>
        </div>
        
        <!-- Room Card 4: Family Suite -->
        <div class="col-md-6 col-lg-4 mt-4">
          <div class="card shadow rounded">
            <img src="dist/images/room4.webp" class="card-img-top rounded-top" alt="Family Suite">
            <!-- উপরের 'src' অ্যাট্রিবিউটে আপনার নিজের ছবির Path বসাবেন -->
            <div class="card-body">
              <h5 class="card-title">Family Suite</h5>
              <hr>
              <p class="card-text text-muted">Perfect for families or groups.</p>
              <ul class="list-unstyled">
                <li><i class="fas fa-bed text-primary me-2"></i> 2 Queen Beds</li>
                <li><i class="fas fa-wifi text-primary me-2"></i> Free Wi-Fi</li>
                <li><i class="fas fa-couch text-primary me-2"></i> Separate Living Area</li>
                <li><i class="fas fa-door-closed text-primary me-2"></i> Connecting Room Option</li>
              </ul>
              <div class="d-flex justify-content-between align-items-center mt-3">
                <span class="h4 text-success">$280<small>/night</small></span>
                <a href="#" class="btn btn-primary">Book Now</a>
              </div>
            </div>
          </div>
        </div>

      </div>
    </div>
  </section>
  
  <?php
  require_once("include/footer.php");
  ?>
</div>
