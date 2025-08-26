<?php
// booking.php
include 'db_connect.php'; // তোমার ডেটাবেজ কানেকশন ফাইল

// ডাটাবেজ থেকে রুম লিস্ট আনা
$sql = "SELECT id, room_name, price FROM room_type";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Room Booking - Hotel Horizon</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container my-5">
  <div class="row justify-content-center">
    <div class="col-md-8">
      <div class="card shadow">
        <div class="card-header bg-primary text-white text-center">
          <h3>Book Your Room</h3>
        </div>
        <div class="card-body">

          <form action="booking_submit.php" method="POST">

            <!-- User ID (hidden) -->
            <input type="hidden" name="user_id" value="1"> 
            <!-- 👉 এখানে তুমি সেশনের লগইন করা ইউজারের আইডি বসাবে -->

            <!-- Select Room -->
            <div class="mb-3">
              <label class="form-label">Select Room</label>
              <select name="room_id" class="form-select" required>
                <option value="">-- Choose Room --</option>
                <?php while($row = $result->fetch_assoc()): ?>
                  <option value="<?php echo $row['id']; ?>">
                    <?php echo $row['room_name']; ?> - ৳<?php echo $row['price']; ?>/Night
                  </option>
                <?php endwhile; ?>
              </select>
            </div>

            <div class="mb-3">
              <label class="form-label">Select Room</label>
              <select name="room_id" class="form-select" required>
                <option value="">-- Choose Room --</option>
                <?php while($row = $result->fetch_assoc()): ?>
                  <option value="<?php echo $row['id']; ?>">
                    <?php echo $row['room_name']; ?> - ৳<?php echo $row['price']; ?>/Night
                  </option>
                <?php endwhile; ?>
              </select>
            </div>

            <!-- Check-in -->
            <div class="mb-3">
              <label class="form-label">Check-in Date</label>
              <input type="date" name="checkin_date" class="form-control" required>
            </div>

            <div class="mb-3">
              <label class="form-label">Check-in Date</label>
              <input type="date" name="checkin_date" class="form-control" required>
            </div>

            <!-- Check-out -->
            <div class="mb-3">
              <label class="form-label">Check-out Date</label>
              <input type="date" name="checkout_date" class="form-control" required>
            </div>

            <!-- Payment Method -->
            <div class="mb-3">
              <label class="form-label">Payment Method</label>
              <select name="payment_method" class="form-select" required>
                <option value="Cash">Cash</option>
                <option value="Card">Card</option>
                <option value="Bkash">Bkash</option>
              </select>
            </div>

            <!-- Submit -->
            <div class="text-center">
              <button type="submit" class="btn btn-success px-5">Confirm Booking</button>
            </div>

          </form>

        </div>
      </div>
    </div>
  </div>
</div>

</body>
</html>
