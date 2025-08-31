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
                            <select class="form-control" name="room_type_id" required>
                                <option value="">Select Room Type</option>
                                <?php
                                $room_types = $conn->query("SELECT id, room_name FROM room_type");
                                while ($room = $room_types->fetch_assoc()) {
                                    $selected = ($room['id'] == $room_type_id) ? 'selected' : '';
                                    echo "<option value='{$room['id']}' {$selected}>{$room['room_name']}</option>";
                                }
                                ?>
                            </select>
                        </div>

                        <!-- Similar selects for room_service_id and food_service_id -->
                        
                        <div class="form-group">
                            <label>Total Amount</label>
                            <input type="number" class="form-control" name="total_amount" value="<?php echo $total_amount; ?>" required>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary" name="btnUpdate">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </section>
</div>
