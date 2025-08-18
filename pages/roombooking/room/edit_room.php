<?php
// config.php ফাইলটি অন্তর্ভুক্ত করা হচ্ছে।
include("config.php");
if (!isset($conn)) {
    header("location:login.php");
    exit();
}

// ফলাফল বার্তা এবং ডেটা সংরক্ষণের জন্য ভেরিয়েবল।
$r = "";
$room_number = "";
$room_type_id = "";
$room_type_price_val = "";
$service_id = "";
$service_price_val = "";
$total_price_val = "";
$room_status = "";
$description = "";
$id = 0;

// যদি id থাকে, তাহলে ডেটা লোড করুন।
if (isset($_GET['id'])) {
    $id = mysqli_real_escape_string($conn, $_GET['id']);
    $sql_fetch = "SELECT `room_number`, `room_type_id`, `room_type_price`, `service_id`, `service_price`, `total_price`, `room_status`, `description` FROM `room` WHERE `id` = '$id'";
    $result_fetch = $conn->query($sql_fetch);
    if ($result_fetch->num_rows > 0) {
        $row = $result_fetch->fetch_assoc();
        $room_number = $row['room_number'];
        $room_type_id = $row['room_type_id'];
        $room_type_price_val = $row['room_type_price'];
        $service_id = $row['service_id'];
        $service_price_val = $row['service_price'];
        $total_price_val = $row['total_price'];
        $room_status = $row['room_status'];
        $description = $row['description'];
    } else {
        $r = "<div class='alert alert-danger'>Record not found.</div>";
    }
}

// যদি ফর্ম সাবমিট করা হয়, তাহলে ডেটা আপডেট করুন।
if (isset($_POST['submit'])) {
    $id_update = mysqli_real_escape_string($conn, $_POST['id']);
    $room_number_update = mysqli_real_escape_string($conn, $_POST['room_number']);
    $room_type_id_update = mysqli_real_escape_string($conn, $_POST['room_type_id']);
    $room_type_price_update = mysqli_real_escape_string($conn, $_POST['room_type_price']);
    $service_id_update = mysqli_real_escape_string($conn, $_POST['service_id']);
    $service_price_update = mysqli_real_escape_string($conn, $_POST['service_price']);
    $total_price_update = mysqli_real_escape_string($conn, $_POST['total_price']);
    $room_status_update = mysqli_real_escape_string($conn, $_POST['room_status']);
    $description_update = mysqli_real_escape_string($conn, $_POST['description']);

    $sql_update = "UPDATE `room` SET `room_number` = '$room_number_update', `room_type_id` = '$room_type_id_update', `room_type_price` = '$room_type_price_update', `service_id` = '$service_id_update', `service_price` = '$service_price_update', `total_price` = '$total_price_update', `room_status` = '$room_status_update', `description` = '$description_update' WHERE `id` = '$id_update'";
    if ($conn->query($sql_update) === TRUE) {
        $r = "<div class='alert alert-success'>Room updated successfully.</div>";
    } else {
        $r = "<div class='alert alert-danger'>Error updating record: " . $conn->error . "</div>";
    }
}

// ড্রপডাউনের জন্য room_type ডেটা লোড করা হচ্ছে।
$room_types = $conn->query("SELECT id, room_name, price FROM `room_type` ORDER BY room_name ASC");
$room_types_data = [];
while ($row = $room_types->fetch_assoc()) {
    $room_types_data[] = $row;
}
$room_types->data_seek(0);

// ড্রপডাউনের জন্য service ডেটা লোড করা হচ্ছে।
$sql_services = "SELECT id, total_service_price FROM `service` ORDER BY id ASC";
$services = $conn->query($sql_services);
$services_data = [];
while ($row = $services->fetch_assoc()) {
    $services_data[] = $row;
}
$services->data_seek(0);

?>

<div class="content-wrapper">
    <section class="content-header">
        <h1>Edit Room</h1>
    </section>
    <section class="content">
        <div class="card">
            <div class="card-body">
                <?php echo $r; ?>
                <form action="" method="post">
                    <input type="hidden" name="id" value="<?php echo htmlspecialchars($id); ?>">
                    <div class="form-group">
                        <label for="room_number">Room Number</label>
                        <input type="text" class="form-control" name="room_number" value="<?php echo htmlspecialchars($room_number); ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="room_type_id">Room Type</label>
                        <select class="form-control" name="room_type_id" id="room_type_id" required>
                            <option value="">Select Room Type</option>
                            <?php foreach ($room_types_data as $row): ?>
                                <option value="<?php echo htmlspecialchars($row['id']); ?>" data-price="<?php echo htmlspecialchars($row['price']); ?>" <?php if ($row['id'] == $room_type_id) echo 'selected'; ?>>
                                    <?php echo htmlspecialchars($row['room_name'] . ' - $' . $row['price']); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="room_type_price">Room Type Price</label>
                        <input type="number" step="0.01" class="form-control" name="room_type_price" id="room_type_price" value="<?php echo htmlspecialchars($room_type_price_val); ?>" readonly required>
                    </div>
                    <div class="form-group">
                        <label for="service_id">Service</label>
                        <select class="form-control" name="service_id" id="service_id">
                            <option value="">Select Service (Optional)</option>
                            <?php foreach ($services_data as $row): ?>
                                <option value="<?php echo htmlspecialchars($row['id']); ?>" data-price="<?php echo htmlspecialchars($row['total_service_price']); ?>" <?php if ($row['id'] == $service_id) echo 'selected'; ?>>
                                    <?php echo htmlspecialchars('Service ID: ' . $row['id'] . ' - $' . $row['total_service_price']); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="service_price">Service Price</label>
                        <input type="number" step="0.01" class="form-control" name="service_price" id="service_price" value="<?php echo htmlspecialchars($service_price_val); ?>" readonly required>
                    </div>
                    <div class="form-group">
                        <label for="total_price">Total Price</label>
                        <input type="number" step="0.01" class="form-control" name="total_price" id="total_price" value="<?php echo htmlspecialchars($total_price_val); ?>" readonly required>
                    </div>
                    <div class="form-group">
                        <label for="room_status">Room Status</label>
                        <select class="form-control" name="room_status" required>
                            <option value="Available" <?php if ($room_status == 'Available') echo 'selected'; ?>>Available</option>
                            <option value="Not Available" <?php if ($room_status == 'Not Available') echo 'selected'; ?>>Not Available</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="description">Description</label>
                        <textarea class="form-control" name="description"><?php echo htmlspecialchars($description); ?></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary" name="submit">Update</button>
                    <a href="home.php?page=19" class="btn btn-secondary">Cancel</a>
                </form>
            </div>
        </div>
    </section>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const roomTypeSelect = document.getElementById('room_type_id');
        const serviceSelect = document.getElementById('service_id');
        const roomTypePriceInput = document.getElementById('room_type_price');
        const servicePriceInput = document.getElementById('service_price');
        const totalPriceInput = document.getElementById('total_price');

        function updatePricesAndTotal() {
            let roomPrice = 0;
            let servicePrice = 0;

            const selectedRoomTypeOption = roomTypeSelect.options[roomTypeSelect.selectedIndex];
            if (selectedRoomTypeOption.dataset.price) {
                roomPrice = parseFloat(selectedRoomTypeOption.dataset.price);
            }
            roomTypePriceInput.value = roomPrice.toFixed(2);

            const selectedServiceOption = serviceSelect.options[serviceSelect.selectedIndex];
            if (selectedServiceOption.dataset.price) {
                servicePrice = parseFloat(selectedServiceOption.dataset.price);
            }
            servicePriceInput.value = servicePrice.toFixed(2);

            const total = roomPrice + servicePrice;
            totalPriceInput.value = total.toFixed(2);
        }

        roomTypeSelect.addEventListener('change', updatePricesAndTotal);
        serviceSelect.addEventListener('change', updatePricesAndTotal);
        
        updatePricesAndTotal();
    });
</script>
