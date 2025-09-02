<?php
// config.php ফাইলটি অন্তর্ভুক্ত করা হচ্ছে।
include("config.php");

if (!isset($_GET['booking_id'])) {
    header("Location: booking.php");
    exit();
}

// বুকিং আইডি পেয়ে ডেটা ফেচ করা হচ্ছে।
$booking_id = mysqli_real_escape_string($conn, $_GET['booking_id']);

$query = "SELECT * FROM booking WHERE id = $booking_id";
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
    <title>Payment Success</title>
    <link rel="stylesheet" href="dist/css/styles.css">
</head>
<body>

    <div class="payment-success-container">
        <h1>Payment Successful</h1>
        <p>Your payment for Booking ID: <?php echo htmlspecialchars($booking['id']); ?> has been successfully processed.</p>
        <p><strong>Total Amount Paid:</strong> ৳<?php echo number_format($booking['total_amount'], 2); ?></p>

        <a href="index.php" class="btn btn-primary">Back to Home</a>
    </div>

</body>
</html>
