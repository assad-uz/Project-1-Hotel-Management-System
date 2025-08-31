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

// Initialize variables for booking
$room_types_data = [];
$room_services_data = [];
$food_services_data = [];
$food_service_ids = [];
$total_amount = 0;

// Fetch room types, room services, and food services from the database
$room_types = $conn->query("SELECT id, room_name, price FROM room_type ORDER BY room_name ASC");
while ($row = $room_types->fetch_assoc()) {
    $room_types_data[] = $row;
}

$room_services = $conn->query("SELECT id, service_name, price FROM room_service ORDER BY service_name ASC");
while ($row = $room_services->fetch_assoc()) {
    $room_services_data[] = $row;
}

$food_services = $conn->query("SELECT id, meal_period, price FROM food_service ORDER BY FIELD(meal_period, 'Breakfast', 'Launch', 'Dinner') ASC");
while ($row = $food_services->fetch_assoc()) {
    $food_services_data[] = $row;
}

if (isset($_POST['submit'])) {
    // Get booking details from form
    $room_type_id = mysqli_real_escape_string($conn, $_POST['room_type_id']);
    $room_service_id = isset($_POST['room_service_id']) ? mysqli_real_escape_string($conn, $_POST['room_service_id']) : NULL;
    $food_service_ids = isset($_POST['food_service_id']) ? $_POST['food_service_id'] : [];
    $checkin_date = mysqli_real_escape_string($conn, $_POST['checkin_date']);
    $checkout_date = mysqli_real_escape_string($conn, $_POST['checkout_date']);

    // Calculate the total amount (price of room + room service + food services)
    $room_price = 0;
    $room_service_price = 0;
    $food_service_price = 0;

    // Get room price
    foreach ($room_types_data as $room) {
        if ($room['id'] == $room_type_id) {
            $room_price = $room['price'];
        }
    }

    // Get room service price
    if ($room_service_id) {
        foreach ($room_services_data as $service) {
            if ($service['id'] == $room_service_id) {
                $room_service_price = $service['price'];
            }
        }
    }

    // Get food service prices
    foreach ($food_service_ids as $food_service_id) {
        foreach ($food_services_data as $food_service) {
            if ($food_service['id'] == $food_service_id) {
                $food_service_price += $food_service['price'];
            }
        }
    }

    // Calculate total amount
    $total_amount = $room_price + $room_service_price + $food_service_price;

    // Insert booking data into database
    $booking_date = date("Y-m-d H:i:s");
    $stmt = $conn->prepare("INSERT INTO booking (users_id, room_type_id, room_service_id, food_service_id, booking_date, checkin_date, checkout_date, total_amount) 
                            VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("iiisssss", $user_id, $room_type_id, $room_service_id, implode(',', $food_service_ids), $booking_date, $checkin_date, $checkout_date, $total_amount);

    if ($stmt->execute()) {
        $r = "<div class='alert alert-success'>Booking added successfully.</div>";
    } else {
        $r = "<div class='alert alert-danger'>Error: " . $stmt->error . "</div>";
    }
}

?>

<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <h1>Make a Booking</h1>
        </div>
    </section>

    <section class="content">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Fill Out Booking Information</h3>
            </div>
            <div class="card-body">
                <div class="p-3">
                    <?php echo isset($r) ? $r : ''; ?>
                </div>
                <form action="" method="post">
                    <div class="form-group">
                        <label for="room_type_id">Room Type</label>
                        <select class="form-control" name="room_type_id" id="room_type_id" required>
                            <option value="">Select Room Type</option>
                            <?php foreach ($room_types_data as $row): ?>
                                <option value="<?php echo htmlspecialchars($row['id']); ?>" data-price="<?php echo htmlspecialchars($row['price']); ?>">
                                    <?php echo htmlspecialchars($row['room_name']); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="room_service_id">Room Service</label>
                        <select class="form-control" name="room_service_id" id="room_service_id">
                            <option value="">Select Room Service (Optional)</option>
                            <?php foreach ($room_services_data as $row): ?>
                                <option value="<?php echo htmlspecialchars($row['id']); ?>" data-price="<?php echo htmlspecialchars($row['price']); ?>">
                                    <?php echo htmlspecialchars($row['service_name']); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="food_service_id">Food Service</label>
                        <div class="food-service-checkboxes">
                            <?php foreach ($food_services_data as $row): ?>
                                <div class="form-check form-check-inline">
                                    <input type="checkbox" class="form-check-input" name="food_service_id[]" value="<?php echo htmlspecialchars($row['id']); ?>" id="food_service_<?php echo htmlspecialchars($row['id']); ?>" data-price="<?php echo htmlspecialchars($row['price']); ?>">
                                    <label class="form-check-label" for="food_service_<?php echo htmlspecialchars($row['id']); ?>">
                                        <?php echo htmlspecialchars($row['meal_period']); ?>
                                    </label>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="checkin_date">Check-in Date</label>
                        <input type="date" class="form-control" name="checkin_date" id="checkin_date" required>
                    </div>

                    <div class="form-group">
                        <label for="checkout_date">Check-out Date</label>
                        <input type="date" class="form-control" name="checkout_date" id="checkout_date" required>
                    </div>

                    <div class="form-group">
                        <label for="total_amount">Total Amount</label>
                        <input type="number" step="0.01" class="form-control" name="total_amount" id="total_amount" readonly required>
                    </div>

                    <button type="submit" name="submit" class="btn btn-primary">Confirm Booking</button>
                </form>
            </div>
        </div>
    </section>
</div>

<script>
    // Add JavaScript code to recalculate total amount and prices
    document.addEventListener('DOMContentLoaded', function() {
        const roomSelect = document.getElementById('room_type_id');
        const roomServiceSelect = document.getElementById('room_service_id');
        const foodServiceInputs = document.querySelectorAll('input[name="food_service_id[]"]');
        const checkinDateInput = document.getElementById('checkin_date');
        const checkoutDateInput = document.getElementById('checkout_date');
        const totalAmountInput = document.getElementById('total_amount');

        function calculateTotalAmount() {
            let roomPrice = 0;
            let roomServicePrice = 0;
            let foodServicePrice = 0;

            const selectedRoomOption = roomSelect.options[roomSelect.selectedIndex];
            if (selectedRoomOption && selectedRoomOption.dataset.price) {
                roomPrice = parseFloat(selectedRoomOption.dataset.price);
            }

            const selectedRoomServiceOption = roomServiceSelect.options[roomServiceSelect.selectedIndex];
            if (selectedRoomServiceOption && selectedRoomServiceOption.dataset.price) {
                roomServicePrice = parseFloat(selectedRoomServiceOption.dataset.price);
            }

            foodServicePrice = 0;
            foodServiceInputs.forEach(input => {
                if (input.checked && input.dataset.price) {
                    foodServicePrice += parseFloat(input.dataset.price);
                }
            });

            totalAmountInput.value = (roomPrice + roomServicePrice + foodServicePrice).toFixed(2);
        }

        roomSelect.addEventListener('change', calculateTotalAmount);
        roomServiceSelect.addEventListener('change', calculateTotalAmount);
        foodServiceInputs.forEach(input => input.addEventListener('change', calculateTotalAmount));
        checkinDateInput.addEventListener('change', calculateTotalAmount);
        checkoutDateInput.addEventListener('change', calculateTotalAmount);

        calculateTotalAmount();
    });
</script>
