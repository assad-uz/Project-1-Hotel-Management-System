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

// যদি পেমেন্ট সফল হয়, তাহলে ইউজারকে কনফার্মেশন পেজে রিডিরেক্ট করা হবে।
if (isset($_POST['pay'])) {
    $payment_method = mysqli_real_escape_string($conn, $_POST['payment_method']);
    $payment_status = 'Success';  // সিম্পল স্টেটাস, আপনার প্রয়োজনে আরও পরিবর্তন করতে পারেন।

    // পেমেন্ট ডেটাবেজে আপডেট করা হচ্ছে।
    $stmt = $conn->prepare("UPDATE booking SET payment_method = ?, payment_status = ? WHERE id = ?");
    $stmt->bind_param("ssi", $payment_method, $payment_status, $booking_id);

    if ($stmt->execute()) {
        header("Location: payment_success.php?booking_id=$booking_id");
        exit();
    } else {
        echo "<div class='alert alert-danger'>Error processing payment. Please try again.</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment</title>
    <link rel="stylesheet" href="dist/css/styles.css">
</head>
<body>

    <div class="payment-container">
        <h1>Payment</h1>
        <h2>Booking ID: <?php echo htmlspecialchars($booking['id']); ?></h2>

        <h3>Booking Details</h3>
        <p><strong>Room Type:</strong> <?php echo htmlspecialchars($booking['room_name']); ?></p>
        <p><strong>Total Amount:</strong> ৳<?php echo number_format($booking['total_amount'], 2); ?></p>

        <form action="payment.php?booking_id=<?php echo $booking['id']; ?>" method="post">
            <div class="form-group">
                <label for="payment_method">Select Payment Method</label>
                <select name="payment_method" id="payment_method" class="form-control" required>
                    <option value="">Select Payment Method</option>
                    <option value="Credit Card">Credit Card</option>
                    <option value="Debit Card">Debit Card</option>
                    <option value="PayPal">PayPal</option>
                    <option value="Bank Transfer">Bank Transfer</option>
                </select>
            </div>

            <div class="form-group">
                <label for="payment_amount">Amount to Pay</label>
                <input type="number" class="form-control" name="payment_amount" value="<?php echo number_format($booking['total_amount'], 2); ?>" readonly required>
            </div>

            <button type="submit" name="pay" class="btn btn-primary">Pay Now</button>
        </form>
    </div>

</body>
</html>
