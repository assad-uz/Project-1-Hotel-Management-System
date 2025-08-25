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

  <!-- About Section -->
  <!--
    এই section ট্যাগটি মূল কন্টেন্ট হিসেবে কাজ করবে।
    - flex-grow-1: এটি বাকি vertical জায়গা পূরণ করে, যা ফুটারকে নিচে ঠেলে দেয়।
    - d-flex: এই সেকশনটিকে flex container বানায়।
    - align-items-center: এই সেকশনের ভিতরের কন্টেন্টকে vertical ভাবে মাঝখানে নিয়ে আসে।
  -->
  <section id="about" class="py-5 bg-light flex-grow-1 d-flex align-items-center">
    <div class="container">
      <div class="row align-items-center">
        
        <!-- About Text -->
        <div class="col-md-6">
          <h2 class="mb-4">About Our Hotel</h2>
          <hr>
          <p>
            Welcome to our HOTEL HORIZON. We provide the best 
            services to make your stay comfortable and memorable. 
            Our system helps you to easily manage room booking, 
            restaurant orders, and other facilities.
          </p>
          <p>
            Our goal is to ensure a hassle-free experience for 
            both guests and hotel staff with user-friendly 
            features and efficient management.
          </p>
        </div>

        <!-- About Image Placeholder -->
        <div class="col-md-6 text-center">
          <img src="dist/images/about1.webp" alt="Hotel Image" class="img-fluid rounded shadow">
          <!-- এখানে আপনি নিজের ইমেজ path বসাবেন -->
        </div>

      </div>
    </div>
  </section>
  
  <?php
  require_once("include/footer.php");
  ?>
</div>
