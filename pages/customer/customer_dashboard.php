<?php
// Start session
session_start();

// Include config.php to connect to database
// Assuming config.php is located two directories up from the current file.
// Adjust the path as per your file structure.
include("../../config.php"); 

// Check if user is logged in
// This line checks for 'customer_id' as per your original code's variable.
if (!isset($_SESSION['customer_id'])) {
    header("Location: login.php"); // Redirect to login page if not logged in
    exit();
}

// Get user ID from session.
$customer_id = $_SESSION['customer_id'];

// Use prepared statements to prevent SQL injection.
$user_query = "SELECT * FROM users WHERE id = ?";
$stmt = $conn->prepare($user_query);

// Check if the first query preparation was successful.
if ($stmt === false) {
    die("Error preparing user query: " . $conn->error);
}

// Bind parameter and execute.
$stmt->bind_param("i", $customer_id);
$stmt->execute();
$user_result = $stmt->get_result();
$user = $user_result->fetch_assoc();

// Check if user data was found.
if (!$user) {
    // If user not found, redirect to login as a security measure.
    header("Location: login.php");
    exit();
}

// Fetch the bookings of the logged-in customer using JOIN.
// Ensure the column name 'users_id' in your booking table is correct.
// If it's 'user_id', you'll need to change the query.
$bookings_query = "SELECT b.id, b.room_type_id, b.checkin_date, b.checkout_date, b.total_amount, rt.room_name 
                    FROM booking b
                    JOIN room_type rt ON b.room_type_id = rt.id
                    WHERE b.users_id = ?
                    ORDER BY b.booking_date DESC";
$stmt2 = $conn->prepare($bookings_query);

// Check for errors in the second query preparation.
if ($stmt2 === false) {
    die("Error preparing bookings query: " . $conn->error);
}

// Bind parameter and execute.
$stmt2->bind_param("i", $customer_id);
$stmt2->execute();
$bookings_result = $stmt2->get_result();
?>

<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <h1>Customer Dashboard</h1>
        </div>
    </section>

    <section class="content">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Welcome, <?php echo htmlspecialchars($user['firstname']) . ' ' . htmlspecialchars($user['lastname']); ?>!</h3>
            </div>
            <div class="card-body">
                <h4>Your Information</h4>
                <ul>
                    <li><strong>Email:</strong> <?php echo htmlspecialchars($user['email']); ?></li>
                    <li><strong>Phone:</strong> <?php echo htmlspecialchars($user['phone']); ?></li>
                </ul>

                <hr>

                <h4>Your Bookings</h4>
                <?php if ($bookings_result->num_rows > 0): ?>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>#ID</th>
                                <th>Room Type</th>
                                <th>Check-in Date</th>
                                <th>Check-out Date</th>
                                <th>Total Amount</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($booking = $bookings_result->fetch_assoc()): ?>
                                <tr>
                                    <td><?php echo $booking['id']; ?></td>
                                    <td><?php echo htmlspecialchars($booking['room_name']); ?></td>
                                    <td><?php echo htmlspecialchars($booking['checkin_date']); ?></td>
                                    <td><?php echo htmlspecialchars($booking['checkout_date']); ?></td>
                                    <td><?php echo htmlspecialchars($booking['total_amount']); ?></td>
                                </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                <?php else: ?>
                    <p>You have not made any bookings yet.</p>
                <?php endif; ?>
            </div>
        </div>
    </section>
</div>