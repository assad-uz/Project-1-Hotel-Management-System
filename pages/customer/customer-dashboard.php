<?php
// Start session
session_start();

// Include config.php to connect to database
include("config.php");

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php"); // Redirect to login page if not logged in
    exit();
}

$user_id = $_SESSION['user_id']; // Get user id from session

// Use prepared statements to prevent SQL injection
$user_query = "SELECT * FROM users WHERE id = ?";
$stmt = $conn->prepare($user_query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$user_result = $stmt->get_result();
$user = $user_result->fetch_assoc();

// Fetch the bookings of the logged-in customer using JOIN to get room names
$bookings_query = "SELECT b.id, b.room_type_id, b.checkin_date, b.checkout_date, b.total_amount, b.status, rt.room_name 
                   FROM booking b
                   JOIN room_type rt ON b.room_type_id = rt.id
                   WHERE b.users_id = ?
                   ORDER BY b.booking_date DESC";
$stmt2 = $conn->prepare($bookings_query);
$stmt2->bind_param("i", $user_id);
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
                    <li><strong>Address:</strong> <?php echo htmlspecialchars($user['address']); ?></li>
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
                                <th>Status</th>
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
                                    <td><?php echo $booking['status'] ? 'Confirmed' : 'Pending'; ?></td>
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
