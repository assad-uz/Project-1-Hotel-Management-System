<?php
  require_once("config.php");
?>

<?php
// ফরেন কী ডেটা আনা
$roomTypes = $conn->query("SELECT id, room_name FROM room_type");
$rooms = $conn->query("SELECT id, room_number FROM room");
$paymentMethods = ["Cash", "Credit Card", "Mobile Banking"];

// সাবমিট হ্যান্ডলিং
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    echo "<pre>";
    print_r($_POST);
    echo "</pre>";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Reservation Form</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body class="bg-light">

<div class="container mt-5">
    <div class="card shadow">
        <div class="card-header bg-primary text-white">
            <h4 class="mb-0">Reservation Form</h4>
        </div>
        <div class="card-body">
            <form method="POST">

                <!-- Customer Info -->
                <h5>Customer Info</h5>
                <div class="form-group">
                    <label>Name</label>
                    <input type="text" name="name" class="form-control" required>
                </div>

                <div class="form-group">
                    <label>Email</label>
                    <input type="email" name="email" class="form-control" required>
                </div>

                <div class="form-group">
                    <label>Phone</label>
                    <input type="text" name="phone" class="form-control">
                </div>

                <input type="hidden" name="role_id" value="2"> <!-- Customer -->

                <hr>

                <!-- Room Selection -->
                <h5>Room Selection</h5>
                <div class="form-group">
                    <label>Room Type</label>
                    <select name="room_type_id" class="form-control" required>
                        <option value="">Select Room Type</option>
                        <?php while ($row = $roomTypes->fetch_assoc()) { ?>
                            <option value="<?= $row['id'] ?>"><?= $row['room_name'] ?></option>
                        <?php } ?>
                    </select>
                </div>

                <div class="form-group">
                    <label>Room Number</label>
                    <select name="room_id" class="form-control" required>
                        <option value="">Select Room</option>
                        <?php while ($row = $rooms->fetch_assoc()) { ?>
                            <option value="<?= $row['id'] ?>"><?= $row['room_number'] ?></option>
                        <?php } ?>
                    </select>
                </div>

                <hr>

                <!-- Booking Dates -->
                <h5>Booking Dates</h5>
                <div class="form-group">
                    <label>Booking Date</label>
                    <input type="datetime-local" name="booking_date" class="form-control" required>
                </div>

                <div class="form-group">
                    <label>Check-in Date</label>
                    <input type="date" name="checkin_date" class="form-control" required>
                </div>

                <div class="form-group">
                    <label>Check-out Date</label>
                    <input type="date" name="checkout_date" class="form-control" required>
                </div>

                <hr>

                <!-- Payment -->
                <h5>Payment</h5>
                <div class="form-group">
                    <label>Payment Method</label>
                    <select name="payment_method" class="form-control" required>
                        <option value="">Select Payment Method</option>
                        <?php foreach ($paymentMethods as $method) { ?>
                            <option value="<?= $method ?>"><?= $method ?></option>
                        <?php } ?>
                    </select>
                </div>

                <button type="submit" class="btn btn-success">Submit Reservation</button>
            </form>
        </div>
    </div>
</div>

</body>
</html>
