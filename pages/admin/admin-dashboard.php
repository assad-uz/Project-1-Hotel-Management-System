<?php
// Today's Booking
$booking_query = "SELECT COUNT(*) FROM booking WHERE DATE(booking_date) = CURDATE()";
$booking_result = $conn->query($booking_query);
$today_booking = $booking_result->fetch_row()[0];

// Today's Total Checkin
$checkin_query = "SELECT COUNT(*) FROM checkin WHERE DATE(checkin_date) = CURDATE()";
$checkin_result = $conn->query($checkin_query);
$today_checkin = $checkin_result->fetch_row()[0];

// Today's Total Checkout
$checkout_query = "SELECT COUNT(*) FROM checkout WHERE DATE(checkout_date) = CURDATE()";
$checkout_result = $conn->query($checkout_query);
$today_checkout = $checkout_result->fetch_row()[0];

// Today's Total Payment
$payment_query = "SELECT SUM(amount) FROM payment WHERE DATE(paid_at) = CURDATE()";
$payment_result = $conn->query($payment_query);
$today_payment = $payment_result->fetch_row()[0];
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Admin Dashboard</title>

  <!-- Add Bootstrap CSS for styling -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

  <style>
    .card {
      transition: transform 0.3s ease-in-out, box-shadow 0.3s ease-in-out;
    }

    .card:hover {
      transform: translateY(-10px);
      box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
    }

    .dashboard-card {
      margin: 20px 0;
    }

    .card-title {
      font-size: 18px;
      font-weight: bold;
    }

    .card-text {
      font-size: 24px;
      font-weight: bold;
    }
  </style>
</head>
<body>

<div class="container mt-4">
  <h1 class="text-center">Admin Dashboard</h1>

  <!-- Dashboard content -->
  <div class="row">

    <!-- Today's Booking Card -->
    <div class="col-md-3">
      <div class="card bg-success text-white dashboard-card">
        <div class="card-body">
          <h5 class="card-title">Today's Booking</h5>
          <p class="card-text"><?php echo $today_booking; ?></p>
        </div>
      </div>
    </div>

    <!-- Today's Total Checkin Card -->
    <div class="col-md-3">
      <div class="card bg-info text-white dashboard-card">
        <div class="card-body">
          <h5 class="card-title">Today's Total Checkin</h5>
          <p class="card-text"><?php echo $today_checkin; ?></p>
        </div>
      </div>
    </div>

    <!-- Today's Total Checkout Card -->
    <div class="col-md-3">
      <div class="card bg-warning text-white dashboard-card">
        <div class="card-body">
          <h5 class="card-title">Today's Total Checkout</h5>
          <p class="card-text"><?php echo $today_checkout; ?></p>
        </div>
      </div>
    </div>

    <!-- Today's Total Payment Card -->
    <div class="col-md-3">
      <div class="card bg-danger text-white dashboard-card">
        <div class="card-body">
          <h5 class="card-title">Today's Total Payment</h5>
          <p class="card-text"><?php echo "$" . number_format($today_payment, 2); ?></p>
        </div>
      </div>
    </div>

  </div>
  <!-- End of dashboard content -->
</div>

<!-- Add Bootstrap JS and dependencies -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>
</html>
