<?php
include("config.php");

$r = "";
$id = $users_id = $room_type_id = $room_service_id = $food_service_id = $booking_date = $checkin_date = $checkout_date = $total_amount = "";

// Update Booking
if (isset($_POST["btnUpdate"])) {
    $id = $_POST["id"];
    $users_id = $_POST["users_id"];
    $room_type_id = $_POST["room_type_id"];
    $room_service_id = $_POST["room_service_id"];
    $food_service_id = $_POST["food_service_id"];
    $booking_date = $_POST["booking_date"];
    $checkin_date = $_POST["checkin_date"];
    $checkout_date = $_POST["checkout_date"];
    $total_amount = $_POST["total_amount"];

    $sql = "UPDATE booking SET users_id=?, room_type_id=?, room_service_id=?, food_service_id=?, booking_date=?, checkin_date=?, checkout_date=?, total_amount=? WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iiiiiisdi", $users_id, $room_type_id, $room_service_id, $food_service_id, $booking_date, $checkin_date, $checkout_date, $total_amount, $id);

    if ($stmt->execute()) {
        $r = "<div class='alert alert-success'>Booking updated successfully.</div>";
    } else {
        $r = "<div class='alert alert-danger'>Error to update. " . $conn->error . "</div>";
    }
}

// Fetch Booking to Edit
if (isset($_GET['id'])) {
    $id_to_edit = $_GET['id'];
    $sql = "SELECT id, users_id, room_type_id, room_service_id, food_service_id, booking_date, checkin_date, checkout_date, total_amount FROM booking WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id_to_edit);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $id = $row['id'];
        $users_id = $row['users_id'];
        $room_type_id = $row['room_type_id'];
        $room_service_id = $row['room_service_id'];
        $food_service_id = $row['food_service_id'];
        $booking_date = $row['booking_date'];
        $checkin_date = $row['checkin_date'];
        $checkout_date = $row['checkout_date'];
        $total_amount = $row['total_amount'];
    }
}

// Fetch Room Type Price
$room_type_price = 0;
if ($room_type_id) {
    $room_type_query = $conn->query("SELECT price FROM room_type WHERE id = '$room_type_id'");
    $room_type_data = $room_type_query->fetch_assoc();
    $room_type_price = $room_type_data['price'];
}

// Fetch Room Service Price
$room_service_price = 0;
if ($room_service_id) {
    $room_service_query = $conn->query("SELECT price FROM room_service WHERE id = '$room_service_id'");
    $room_service_data = $room_service_query->fetch_assoc();
    $room_service_price = $room_service_data['price'];
}

// Fetch Food Service Price
$food_service_price = 0;
if ($food_service_id) {
    $food_service_query = $conn->query("SELECT price FROM food_service WHERE id = '$food_service_id'");
    $food_service_data = $food_service_query->fetch_assoc();
    $food_service_price = $food_service_data['price'];
}

// Calculate Total Amount
$total_amount_calculated = $room_type_price + $room_service_price + $food_service_price;
?>

<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <h1>Edit Booking</h1>
        </div>
    </section>

    <section class="content">
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">Edit Booking Info</h3>
            </div>
            <div class="card-body">
                <div class="p-3">
                    <?php echo $r; ?>
                </div>

                <form action="" method="post">
                    <div class="card-body">
                        <input type="hidden" name="id" value="<?php echo $id; ?>">

                        <div class="form-group">
                            <label>User</label>
                            <select class="form-control" name="users_id" required>
                                <option value="">Select User</option>
                                <?php
                                $users = $conn->query("SELECT id, firstname, lastname FROM users");
                                while ($user = $users->fetch_assoc()) {
                                    $selected = ($user['id'] == $users_id) ? 'selected' : '';
                                    echo "<option value='{$user['id']}' {$selected}>{$user['firstname']} {$user['lastname']}</option>";
                                }
                                ?>
                            </select>
                        </div>

                        <div class="form-group">
                            <label>Room Type</label>
                            <select class="form-control" name="room_type_id" id="room_type_id" required>
                                <option value="">Select Room Type</option>
                                <?php
                                $room_types = $conn->query("SELECT id, room_name FROM room_type");
                                while ($room = $room_types->fetch_assoc()) {
                                    $selected = ($room['id'] == $room_type_id) ? 'selected' : '';
                                    echo "<option value='{$room['id']}' {$selected} data-price='{$room['price']}'>{$room['room_name']}</option>";
                                }
                                ?>
                            </select>
                        </div>

                        <div class="form-group">
                            <label>Room Service</label>
                            <select class="form-control" name="room_service_id" id="room_service_id">
                                <option value="">Select Room Service</option>
                                <?php
                                $room_services = $conn->query("SELECT id, service_name FROM room_service");
                                while ($service = $room_services->fetch_assoc()) {
                                    $selected = ($service['id'] == $room_service_id) ? 'selected' : '';
                                    echo "<option value='{$service['id']}' {$selected}>{$service['service_name']}</option>";
                                }
                                ?>
                            </select>
                        </div>

                        <div class="form-group">
                            <label>Food Service</label>
                            <select class="form-control" name="food_service_id" id="food_service_id">
                                <option value="">Select Food Service</option>
                                <?php
                                $food_services = $conn->query("SELECT id, meal_period FROM food_service");
                                while ($food = $food_services->fetch_assoc()) {
                                    $selected = ($food['id'] == $food_service_id) ? 'selected' : '';
                                    echo "<option value='{$food['id']}' {$selected}>{$food['meal_period']}</option>";
                                }
                                ?>
                            </select>
                        </div>

                        <div class="form-group">
                            <label>Check-in Date</label>
                            <input type="date" class="form-control" name="checkin_date" id="checkin_date" value="<?php echo $checkin_date; ?>" required>
                        </div>

                        <div class="form-group">
                            <label>Check-out Date</label>
                            <input type="date" class="form-control" name="checkout_date" id="checkout_date" value="<?php echo $checkout_date; ?>" required>
                        </div>

                        <div class="form-group">
                            <label>Total Amount</label>
                            <input type="number" class="form-control" name="total_amount" id="total_amount" value="<?php echo $total_amount_calculated; ?>" readonly>
                        </div>
                    </div>

                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary" name="btnUpdate">Update</button>
                        <a href="home.php?page=14" class="btn btn-secondary" style="margin-left: 10px;">Back to Manage Bookings</a>
                    </div>
                </form>
            </div>
        </div>
    </section>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const roomSelect = document.getElementById('room_type_id');
        const roomPriceInput = document.getElementById('total_amount');

        function updateRoomPrice() {
            const selectedRoomOption = roomSelect.options[roomSelect.selectedIndex];
            let roomPrice = 0;
            if (selectedRoomOption && selectedRoomOption.dataset.price) {
                roomPrice = parseFloat(selectedRoomOption.dataset.price);
            }

            roomPriceInput.value = roomPrice.toFixed(2); // Show price in Total Amount
        }

        roomSelect.addEventListener('change', updateRoomPrice);

        updateRoomPrice(); // Initially set the value when page loads
    });
</script>
