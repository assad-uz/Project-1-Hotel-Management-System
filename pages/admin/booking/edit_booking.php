<?php
// PHP-এর জন্য ডিফল্ট টাইমজোন সেট করা হচ্ছে।
date_default_timezone_set('Asia/Dhaka');

// config.php ফাইলটি অন্তর্ভুক্ত করা হচ্ছে।
include("config.php");

if (!isset($conn)) {
    header("location:login.php");
    exit();
}

$r = "";

// Check if an id is provided in the URL to fetch the booking details
if (isset($_GET['id'])) {
    $booking_id = mysqli_real_escape_string($conn, $_GET['id']);
    
    // Fetch the existing booking data based on the provided ID
    $booking_query = "SELECT * FROM booking WHERE id = '$booking_id'";
    $result = $conn->query($booking_query);
    
    if ($result->num_rows > 0) {
        $booking = $result->fetch_assoc();
    } else {
        $r = "<div class='alert alert-danger'>Booking not found!</div>";
    }
} else {
    header("location:manage_booking.php");
    exit();
}

// Process the form submission to update the booking
if (isset($_POST['submit'])) {
    // Get the updated data from the form
    $users_id = mysqli_real_escape_string($conn, $_POST['users_id']);
    $room_type_id = mysqli_real_escape_string($conn, $_POST['room_type_id']);
    
    // Check if room_service_id is set
    $room_service_id = isset($_POST['room_service_id']) && $_POST['room_service_id'] != "" ? mysqli_real_escape_string($conn, $_POST['room_service_id']) : NULL;
    
    // Check if food_service_id is set and is an array
    $food_service_ids = isset($_POST['food_service_id']) ? $_POST['food_service_id'] : [];
    $food_service_id = !empty($food_service_ids) ? implode(',', $food_service_ids) : NULL;  // Join multiple food service IDs if selected
    
    $checkin_date = mysqli_real_escape_string($conn, $_POST['checkin_date']);
    $checkout_date = mysqli_real_escape_string($conn, $_POST['checkout_date']);
    $total_amount = mysqli_real_escape_string($conn, $_POST['total_amount']);
    
    // Update query for the booking
    $stmt = $conn->prepare("UPDATE booking SET users_id = ?, room_type_id = ?, room_service_id = ?, food_service_id = ?, checkin_date = ?, checkout_date = ?, total_amount = ? WHERE id = ?");
    $stmt->bind_param("iiisssdi", $users_id, $room_type_id, $room_service_id, $food_service_id, $checkin_date, $checkout_date, $total_amount, $booking_id);
    
    if ($stmt->execute()) {
        $r = "<div class='alert alert-success'>Booking updated successfully.</div>";
    } else {
        $r = "<div class='alert alert-danger'>Error: " . $stmt->error . "</div>";
    }
}

// Fetch necessary data for dropdowns (users, room types, services)
$users = $conn->query("SELECT id, CONCAT(firstname, ' ', lastname) AS full_name FROM users ORDER BY full_name ASC");
$room_types = $conn->query("SELECT id, room_name, price FROM room_type ORDER BY room_name ASC");
$room_services = $conn->query("SELECT id, service_name, price FROM room_service ORDER BY service_name ASC");
$food_services = $conn->query("SELECT id, meal_period, price FROM food_service ORDER BY FIELD(meal_period, 'Breakfast', 'Launch', 'Dinner') ASC");

$users_data = [];
while ($row = $users->fetch_assoc()) {
    $users_data[] = $row;
}

$room_types_data = [];
while ($row = $room_types->fetch_assoc()) {
    $room_types_data[] = $row;
}

$room_services_data = [];
while ($row = $room_services->fetch_assoc()) {
    $room_services_data[] = $row;
}

$food_services_data = [];
while ($row = $food_services->fetch_assoc()) {
    $food_services_data[] = $row;
}
?>

<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <h1>Edit Booking</h1>
        </div>
    </section>

    <section class="content">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Edit Booking</h3>
            </div>
            <div class="card-body">
                <div class="p-3">
                    <?php echo $r; ?>
                </div>
                <form action="" method="post">
                    <div class="form-group">
                        <label for="users_id">User</label>
                        <select class="form-control" name="users_id" id="users_id" required>
                            <option value="">Select User</option>
                            <?php foreach ($users_data as $row): ?>
                                <option value="<?php echo htmlspecialchars($row['id']); ?>" <?php echo ($row['id'] == $booking['users_id']) ? 'selected' : ''; ?>>
                                    <?php echo htmlspecialchars($row['full_name']); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="room_type_id">Room Type</label>
                        <select class="form-control" name="room_type_id" id="room_type_id" required>
                            <option value="">Select Room Type</option>
                            <?php foreach ($room_types_data as $row): ?>
                                <option value="<?php echo htmlspecialchars($row['id']); ?>" data-price="<?php echo htmlspecialchars($row['price']); ?>" 
                                    <?php echo ($row['id'] == $booking['room_type_id']) ? 'selected' : ''; ?>>
                                    <?php echo htmlspecialchars($row['room_name']); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <!-- Room Price (Check if room_type_price exists, if not, set default value) -->
                        <input type="text" class="form-control mt-2" id="room_price" 
                               placeholder="Room Price" value="<?php echo isset($booking['room_type_price']) ? htmlspecialchars($booking['room_type_price']) : '0.00'; ?>" readonly>
                    </div>

                    <div class="form-group">
                        <label for="room_service_id">Room Service</label>
                        <select class="form-control" name="room_service_id" id="room_service_id">
                            <option value="">Select Room Service (Optional)</option>
                            <?php foreach ($room_services_data as $row): ?>
                                <option value="<?php echo htmlspecialchars($row['id']); ?>" data-price="<?php echo htmlspecialchars($row['price']); ?>" 
                                    <?php echo ($row['id'] == $booking['room_service_id']) ? 'selected' : ''; ?>>
                                    <?php echo htmlspecialchars($row['service_name']); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <!-- Room Service Price (Check if room_service_price exists, if not, set default value) -->
                        <input type="text" class="form-control mt-2" id="room_service_price" 
                               placeholder="Room Service Price" value="<?php echo isset($booking['room_service_price']) ? htmlspecialchars($booking['room_service_price']) : '0.00'; ?>" readonly>
                    </div>

                    <div class="form-group">
                        <label for="food_service_id">Food Service</label>
                        <div class="food-service-checkboxes">
                            <?php foreach ($food_services_data as $row): ?>
                                <div class="form-check form-check-inline">
                                    <input type="checkbox" class="form-check-input" name="food_service_id[]" value="<?php echo htmlspecialchars($row['id']); ?>" 
                                        id="food_service_<?php echo htmlspecialchars($row['id']); ?>" 
                                        data-price="<?php echo htmlspecialchars($row['price']); ?>"
                                        <?php echo (in_array($row['id'], explode(",", $booking['food_service_id']))) ? 'checked' : ''; ?>>
                                    <label class="form-check-label" for="food_service_<?php echo htmlspecialchars($row['id']); ?>">
                                        <?php echo htmlspecialchars($row['meal_period']); ?>
                                    </label>
                                </div>
                            <?php endforeach; ?>
                        </div>
                        <!-- Food Service Price (Check if food_service_price exists, if not, set default value) -->
                        <input type="text" class="form-control mt-2" id="food_service_price" 
                               placeholder="Food Service Price" value="<?php echo isset($booking['food_service_price']) ? htmlspecialchars($booking['food_service_price']) : '0.00'; ?>" readonly>
                    </div>

                    <div class="form-group">
                        <label for="checkin_date">Check-in Date</label>
                        <input type="date" class="form-control" name="checkin_date" id="checkin_date" value="<?php echo $booking['checkin_date']; ?>" required>
                    </div>

                    <div class="form-group">
                        <label for="checkout_date">Check-out Date</label>
                        <input type="date" class="form-control" name="checkout_date" id="checkout_date" value="<?php echo $booking['checkout_date']; ?>" required>
                    </div>

                    <div class="form-group">
                        <label for="total_amount">Total Amount</label>
                        <input type="number" step="0.01" class="form-control" name="total_amount" id="total_amount" value="<?php echo $booking['total_amount']; ?>" readonly required>
                    </div>

                    <button type="submit" name="submit" class="btn btn-primary">Update</button>
                </form>
            </div>
        </div>
    </section>
</div>

<script>
    // Add JavaScript code to recalculate total amount and prices
</script>
