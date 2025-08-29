<?php
// config.php ফাইলটি অন্তর্ভুক্ত করা হচ্ছে।
include("config.php");
if (!isset($conn)) {
    header("location:login.php");
    exit();
}

// ফলাফল বার্তা সংরক্ষণের জন্য একটি ভেরিয়েবল।
$r = "";

// যদি ফর্মটি জমা দেওয়া হয়।
if (isset($_POST["submit"])) {
    // ব্যবহারকারীর ইনপুট স্যানিটাইজ করা হচ্ছে।
    $room_number = mysqli_real_escape_string($conn, $_POST['room_number']);
    $room_type_id = mysqli_real_escape_string($conn, $_POST['room_type_id']);
    $room_type_price = mysqli_real_escape_string($conn, $_POST['room_type_price']);
    $service_id = mysqli_real_escape_string($conn, $_POST['service_id']);
    $service_price = mysqli_real_escape_string($conn, $_POST['service_price']);
    $total_price = mysqli_real_escape_string($conn, $_POST['total_price']);
    $room_status = mysqli_real_escape_string($conn, $_POST['room_status']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);

    // ডেটাবেজে নতুন ডেটা ইনসার্ট করার জন্য SQL কোয়েরি।
    $sql = "INSERT INTO `room` (room_number, room_type_id, room_type_price, service_id, service_price, total_price, room_status, description) VALUES ('$room_number', '$room_type_id', '$room_type_price', '$service_id', '$service_price', '$total_price', '$room_status', '$description')";

    if ($conn->query($sql) === TRUE) {
        $r = "<div class='alert alert-success'>Room added successfully.</div>";
    } else {
        $r = "<div class='alert alert-danger'>Error: " . $conn->error . "</div>";
    }
}

// ড্রপডাউনের জন্য room_type ডেটা লোড করা হচ্ছে।
$room_types = $conn->query("SELECT id, room_name, price FROM `room_type` ORDER BY room_name ASC");
$room_types_data = [];
while ($row = $room_types->fetch_assoc()) {
    $room_types_data[] = $row;
}

// ড্রপডাউনের জন্য service ডেটা লোড করা হচ্ছে।
$sql_services = "SELECT id, total_service_price FROM `service` ORDER BY id ASC";
$services = $conn->query($sql_services);
$services_data = [];
while ($row = $services->fetch_assoc()) {
    $services_data[] = $row;
}
?>

<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Add Room</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Add Room</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Add New Room</h3>
            </div>
            <div class="card-body">
                <div class="p-3">
                    <?php echo $r; ?>
                </div>
                <form action="" method="post">
                    <div class="form-group">
                        <label for="room_number">Room Number</label>
                        <input type="text" class="form-control" name="room_number" required>
                    </div>
                    <div class="form-group">
                        <label for="room_type_id">Room Type</label>
                        <select class="form-control" name="room_type_id" id="room_type_id" required>
                            <option value="">Select Room Type</option>
                            <?php foreach ($room_types_data as $row): ?>
                                <option value="<?php echo htmlspecialchars($row['id']); ?>" data-price="<?php echo htmlspecialchars($row['price']); ?>">
                                    <?php echo htmlspecialchars($row['room_name'] . ' - $' . $row['price']); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="room_type_price">Room Type Price</label>
                        <input type="number" step="0.01" class="form-control" name="room_type_price" id="room_type_price" readonly required>
                    </div>
                    <div class="form-group">
                        <label for="service_id">Service</label>
                        <select class="form-control" name="service_id" id="service_id">
                            <option value="">Select Service (Optional)</option>
                            <?php foreach ($services_data as $row): ?>
                                <option value="<?php echo htmlspecialchars($row['id']); ?>" data-price="<?php echo htmlspecialchars($row['total_service_price']); ?>">
                                    <?php echo htmlspecialchars('Service ID: ' . $row['id'] . ' - $' . $row['total_service_price']); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="service_price">Service Price</label>
                        <input type="number" step="0.01" class="form-control" name="service_price" id="service_price" readonly required>
                    </div>
                    <div class="form-group">
                        <label for="total_price">Total Price</label>
                        <input type="number" step="0.01" class="form-control" name="total_price" id="total_price" readonly required>
                    </div>
                    <div class="form-group">
                        <label for="room_status">Room Status</label>
                        <select class="form-control" name="room_status" required>
                            <option value="Available">Available</option>
                            <option value="Not Available">Not Available</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="description">Description</label>
                        <textarea class="form-control" name="description"></textarea>
                    </div>
                    <button type="submit" name="submit" class="btn btn-primary">Save</button>
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
