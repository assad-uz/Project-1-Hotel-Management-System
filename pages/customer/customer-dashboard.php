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

// Fetch user information from the database
$user_query = "SELECT * FROM users WHERE id = '$user_id'";
$user_result = $conn->query($user_query);
$user = $user_result->fetch_assoc();

// Fetch the bookings of the logged-in customer
$bookings_query = "SELECT * FROM booking WHERE users_id = '$user_id' ORDER BY booking_date DESC";
$bookings_result = $conn->query($bookings_query);
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
                                    <td>
                                        <?php
                                        $room_query = "SELECT room_name FROM room_type WHERE id = " . $booking['room_type_id'];
                                        $room_result = $conn->query($room_query);
                                        $room = $room_result->fetch_assoc();
                                        echo htmlspecialchars($room['room_name']);
                                        ?>
                                    </td>
                                    <td><?php echo $booking['checkin_date']; ?></td>
                                    <td><?php echo $booking['checkout_date']; ?></td>
                                    <td><?php echo $booking['total_amount']; ?></td>
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
