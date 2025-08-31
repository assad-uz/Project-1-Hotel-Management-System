<?php
include("config.php");

$r = "";
$users = $conn->query("SELECT id, firstname, lastname FROM users");
$room_types = $conn->query("SELECT id, room_name FROM room_type");
$room_services = $conn->query("SELECT id, service_name FROM room_service");
$food_services = $conn->query("SELECT id, meal_period FROM food_service");

if (isset($_POST['submit'])) {
    $users_id = $_POST['users_id'];
    $room_type_id = $_POST['room_type_id'];
    $room_service_id = $_POST['room_service_id'];
    $food_service_id = $_POST['food_service_id'];
    $booking_date = $_POST['booking_date'];
    $checkin_date = $_POST['checkin_date'];
    $checkout_date = $_POST['checkout_date'];
    $total_amount = $_POST['total_amount'];

    // Insert new booking
    $sql = "INSERT INTO booking (users_id, room_type_id, room_service_id, food_service_id, booking_date, checkin_date, checkout_date, total_amount)
            VALUES ('$users_id', '$room_type_id', '$room_service_id', '$food_service_id', '$booking_date', '$checkin_date', '$checkout_date', '$total_amount')";
    if ($conn->query($sql) === TRUE) {
        $r = "<div class='alert alert-success'>Booking added successfully.</div>";
    } else {
        $r = "<div class='alert alert-danger'>Error: " . $conn->error . "</div>";
    }
}
?>

<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <h1>Add Booking</h1>
        </div>
    </section>

    <section class="content">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Add Booking</h3>
            </div>
            <div class="card-body">
                <div class="ftitle text-center mt-3">
                    <?php echo $r; ?>
                </div>
                <form action="" method="post">
                    <div class="card-body">
                        <div class="form-group">
                            <label>Customer</label>
                            <select class="form-control" name="users_id" required>
                                <option value="">Select User</option>
                                <?php while ($user = $users->fetch_assoc()) { ?>
                                    <option value="<?php echo $user['id']; ?>"><?php echo $user['firstname'] . ' ' . $user['lastname']; ?></option>
                                <?php } ?>
                            </select>
                        </div>

                        <div class="form-group">
                            <label>Room Type</label>
                            <select class="form-control" name="room_type_id" required>
                                <option value="">Select Room Type</option>
                                <?php while ($room = $room_types->fetch_assoc()) { ?>
                                    <option value="<?php echo $room['id']; ?>"><?php echo $room['room_name']; ?></option>
                                <?php } ?>
                            </select>
                        </div>

                        <div class="form-group">
                            <label>Room Service</label>
                            <select class="form-control" name="room_service_id">
                                <option value="">Select Room Service</option>
                                <?php while ($service = $room_services->fetch_assoc()) { ?>
                                    <option value="<?php echo $service['id']; ?>"><?php echo $service['service_name']; ?></option>
                                <?php } ?>
                            </select>
                        </div>

                        <div class="form-group">
                            <label>Food Service</label>
                            <select class="form-control" name="food_service_id">
                                <option value="">Select Food Service</option>
                                <?php while ($food = $food_services->fetch_assoc()) { ?>
                                    <option value="<?php echo $food['id']; ?>"><?php echo $food['meal_period']; ?></option>
                                <?php } ?>
                            </select>
                        </div>

                        <div class="form-group">
                            <label>Booking Date</label>
                            <input type="datetime-local" class="form-control" name="booking_date" required>
                        </div>

                        <div class="form-group">
                            <label>Check-in Date</label>
                            <input type="date" class="form-control" name="checkin_date" required>
                        </div>

                        <div class="form-group">
                            <label>Check-out Date</label>
                            <input type="date" class="form-control" name="checkout_date" required>
                        </div>

                        <div class="form-group">
                            <label>Total Amount</label>
                            <input type="number" class="form-control" name="total_amount" required>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary" name="submit">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </section>
</div>
