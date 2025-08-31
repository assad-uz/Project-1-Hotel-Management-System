<?php
include("config.php");

$r = "";

// Delete booking
if (isset($_POST["btnDelete"])) {
    $booking_id = $_POST["txtId"];
    $sql = "DELETE FROM booking WHERE id = '$booking_id'";
    if ($conn->query($sql) === TRUE) {
        $r = "<div class='alert alert-success'>Booking deleted successfully.</div>";
    } else {
        $r = "<div class='alert alert-danger'>Error deleting record: " . $conn->error . "</div>";
    }
}
?>

<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <h1>Manage Bookings</h1>
        </div>
    </section>

    <section class="content">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h3 class="card-title">Booking List</h3>
            </div>

            <div class="p-3">
                <?php echo $r; ?>
            </div>

            <div class="card-body">
                <table class="table table-striped table-bordered">
                    <thead class="bg-primary text-white">
                        <tr>
                            <th>#ID</th>
                            <th>User</th>
                            <th>Room Type</th>
                            <th>Room Type Price</th>
                            <th>Room Service</th>
                            <th>Room Service Price</th>
                            <th>Food Service</th>
                            <th>Food Service Price</th>
                            <th>Booking Date</th>
                            <th>Check-in Date</th>
                            <th>Check-out Date</th>
                            <th>Total Amount</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        // SQL Query to fetch all booking details along with room service, food service, and their prices
                        $bookings = $conn->query("
                            SELECT 
                                b.id, 
                                u.firstname, 
                                u.lastname, 
                                r.room_name, 
                                rs.service_name AS room_service_name, 
                                fs.meal_period AS food_service_name,  -- Changed to meal_period instead of service_name
                                r.price AS room_type_price,  -- Room Price from room_type table
                                rs.price AS room_service_price,  -- Room Service Price from room_service table
                                fs.price AS food_service_price,  -- Food Service Price from food_service table
                                b.booking_date, 
                                b.checkin_date, 
                                b.checkout_date, 
                                b.total_amount
                            FROM booking b
                            JOIN users u ON b.users_id = u.id
                            JOIN room_type r ON b.room_type_id = r.id
                            LEFT JOIN room_service rs ON b.room_service_id = rs.id
                            LEFT JOIN food_service fs ON b.food_service_id = fs.id
                        ");

                        while ($booking = $bookings->fetch_assoc()) {
                            // If there is no room service, show "None"
                            $room_service_name = isset($booking['room_service_name']) ? $booking['room_service_name'] : 'None';
                            // If there is no food service, show "None"
                            $food_service_name = isset($booking['food_service_name']) ? $booking['food_service_name'] : 'None';

                            // Room Type Price, Room Service Price, Food Service Price
                            $room_price = isset($booking['room_type_price']) ? $booking['room_type_price'] : 0;
                            $room_service_price = isset($booking['room_service_price']) ? $booking['room_service_price'] : 0;
                            $food_service_price = isset($booking['food_service_price']) ? $booking['food_service_price'] : 0;

                            echo "<tr>
                                <td>{$booking['id']}</td>
                                <td>{$booking['firstname']} {$booking['lastname']}</td>
                                <td>{$booking['room_name']}</td>
                                <td>{$room_price}</td>
                                <td>{$room_service_name}</td>
                                <td>{$room_service_price}</td>
                                <td>{$food_service_name}</td>
                                <td>{$food_service_price}</td>
                                <td>{$booking['booking_date']}</td>
                                <td>{$booking['checkin_date']}</td>
                                <td>{$booking['checkout_date']}</td>
                                <td>{$booking['total_amount']}</td>
                                <td>
                                    <div class='d-flex align-items-center'>
                                        <form action='' method='post' onsubmit='return confirm(\"Are you sure you want to delete this booking?\");' style='margin-right: 10px;'>
                                            <input type='hidden' name='txtId' value='{$booking['id']}' />
                                            <button type='submit' name='btnDelete' class='btn btn-danger btn-sm' title='Delete'>
                                                <i class='fas fa-trash'></i>
                                            </button>
                                        </form>
                                        <a href='home.php?page=15&id={$booking['id']}' class='btn btn-primary btn-sm' title='Edit'>
                                            <i class='fas fa-edit'></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </section>
</div>
