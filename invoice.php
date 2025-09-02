<?php
// PHP-এর জন্য ডিফল্ট টাইমজোন সেট করা হচ্ছে।
date_default_timezone_set('Asia/Dhaka');

// config.php ফাইলটি অন্তর্ভুক্ত করা হচ্ছে।
include("config.php");

if (!isset($_GET['booking_id'])) {
    header("Location: booking.php");
    exit();
}

// বুকিং আইডি পেয়ে ডেটা ফেচ করা হচ্ছে।
$booking_id = mysqli_real_escape_string($conn, $_GET['booking_id']);

// বুকিংয়ের ডেটা খোঁজা হচ্ছে।
$query = "SELECT b.*, u.firstname, u.lastname, rt.room_name, rt.price AS room_price, rs.service_name, rs.price AS service_price, fs.meal_period, fs.price AS food_service_price
          FROM booking b
          LEFT JOIN users u ON b.users_id = u.id
          LEFT JOIN room_type rt ON b.room_type_id = rt.id
          LEFT JOIN room_service rs ON b.room_service_id = rs.id
          LEFT JOIN food_service fs ON FIND_IN_SET(fs.id, b.food_service_id)
          WHERE b.id = $booking_id";
$result = $conn->query($query);

if ($result->num_rows > 0) {
    $booking = $result->fetch_assoc();
} else {
    echo "Booking not found.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice</title>
    <link rel="stylesheet" href="dist/css/styles.css">
</head>
<body>

    <div class="invoice-container">
        <h1>Invoice</h1>
        <div class="invoice-header">
            <h2>Booking Details</h2>
            <p><strong>Invoice Date:</strong> <?php echo date("Y-m-d H:i:s"); ?></p>
            <p><strong>Booking ID:</strong> <?php echo htmlspecialchars($booking['id']); ?></p>
        </div>

        <div class="customer-details">
            <h3>Customer Details</h3>
            <p><strong>Name:</strong> <?php echo htmlspecialchars($booking['firstname']) . " " . htmlspecialchars($booking['lastname']); ?></p>
            <p><strong>Email:</strong> <?php echo htmlspecialchars($booking['email']); ?></p>
            <p><strong>Phone:</strong> <?php echo htmlspecialchars($booking['phone']); ?></p>
        </div>

        <div class="room-details">
            <h3>Room Details</h3>
            <p><strong>Room Type:</strong> <?php echo htmlspecialchars($booking['room_name']); ?></p>
            <p><strong>Room Price:</strong> ৳<?php echo number_format($booking['room_price'], 2); ?></p>
            <p><strong>Check-in Date:</strong> <?php echo date("Y-m-d", strtotime($booking['checkin_date'])); ?></p>
            <p><strong>Check-out Date:</strong> <?php echo date("Y-m-d", strtotime($booking['checkout_date'])); ?></p>
        </div>

        <div class="services-details">
            <h3>Services</h3>
            <p><strong>Room Service:</strong> <?php echo htmlspecialchars($booking['service_name']); ?> - ৳<?php echo number_format($booking['service_price'], 2); ?></p>

            <h4>Food Services:</h4>
            <ul>
                <?php
                $food_services = explode(',', $booking['food_service_id']);
                foreach ($food_services as $food_service_id) {
                    $food_query = "SELECT meal_period, price FROM food_service WHERE id = $food_service_id";
                    $food_result = $conn->query($food_query);
                    if ($food_result->num_rows > 0) {
                        $food_service = $food_result->fetch_assoc();
                        echo "<li>{$food_service['meal_period']} - ৳" . number_format($food_service['price'], 2) . "</li>";
                    }
                }
                ?>
            </ul>
        </div>

        <div class="total-amount">
            <h3>Total Amount</h3>
            <p><strong>Total:</strong> ৳<?php echo number_format($booking['total_amount'], 2); ?></p>
        </div>

        <!-- Payment Button -->
        <div class="payment-button">
            <a href="payment.php?booking_id=<?php echo $booking['id']; ?>" class="btn btn-success">Pay Now</a>
        </div>

        <div class="footer">
            <p>Thank you for choosing our services!</p>
        </div>
    </div>

</body>
</html>
