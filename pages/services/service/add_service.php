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
    $room_service_id = mysqli_real_escape_string($conn, $_POST['room_service_id']);
    $food_service_id = mysqli_real_escape_string($conn, $_POST['food_service_id']);
    $room_service_price = mysqli_real_escape_string($conn, $_POST['room_service_price']);
    $food_service_price = mysqli_real_escape_string($conn, $_POST['food_service_price']);
    $total_service_price = mysqli_real_escape_string($conn, $_POST['total_service_price']);

    // ডেটাবেজে নতুন ডেটা ইনসার্ট করার জন্য SQL কোয়েরি।
    $sql = "INSERT INTO `service` (room_service_id, food_service_id, room_service_price, food_service_price, total_service_price) VALUES ('$room_service_id', '$food_service_id', '$room_service_price', '$food_service_price', '$total_service_price')";

    if ($conn->query($sql) === TRUE) {
        $r = "<div class='alert alert-success'>Service added successfully.</div>";
    } else {
        $r = "<div class='alert alert-danger'>Error: " . $conn->error . "</div>";
    }
}

// ড্রপডাউনের জন্য room_service ডেটা লোড করা হচ্ছে।
$room_services = $conn->query("SELECT id, service_name, price FROM `room_service` ORDER BY service_name ASC");
$room_services_data = [];
while ($row = $room_services->fetch_assoc()) {
    $room_services_data[] = $row;
}
$room_services->data_seek(0); // আবার প্রথম সারিতে ফিরে যাওয়া

// ড্রপডাউনের জন্য food_service ডেটা লোড করা হচ্ছে।
$sql_food_services = "SELECT fs.id, mt.type_name, mp.period_name, fs.price FROM `food_service` AS fs
                      INNER JOIN `meal_type` AS mt ON fs.meal_type_id = mt.id
                      INNER JOIN `meal_period` AS mp ON fs.meal_period_id = mp.id
                      ORDER BY mt.type_name, mp.period_name ASC";
$food_services = $conn->query($sql_food_services);
$food_services_data = [];
while ($row = $food_services->fetch_assoc()) {
    $food_services_data[] = $row;
}
$food_services->data_seek(0); // আবার প্রথম সারিতে ফিরে যাওয়া

?>

<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Add Service</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Add Service</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Add New Service</h3>
            </div>
            <div class="card-body">
                <div class="p-3">
                    <?php echo $r; ?>
                </div>
                <form action="" method="post">
                    <div class="form-group">
                        <label for="room_service_id">Room Service</label>
                        <select class="form-control" name="room_service_id" id="room_service_id">
                            <option value="">Select Room Service</option>
                            <?php foreach ($room_services_data as $row): ?>
                                <option value="<?php echo htmlspecialchars($row['id']); ?>" data-price="<?php echo htmlspecialchars($row['price']); ?>">
                                    <?php echo htmlspecialchars($row['service_name'] . ' - $' . $row['price']); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="room_service_price">Room Service Price</label>
                        <input type="number" step="0.01" class="form-control" name="room_service_price" id="room_service_price" readonly required>
                    </div>
                    <div class="form-group">
                        <label for="food_service_id">Food Service</label>
                        <select class="form-control" name="food_service_id" id="food_service_id">
                            <option value="">Select Food Service</option>
                            <?php foreach ($food_services_data as $row): ?>
                                <option value="<?php echo htmlspecialchars($row['id']); ?>" data-price="<?php echo htmlspecialchars($row['price']); ?>">
                                    <?php echo htmlspecialchars($row['type_name'] . ' (' . $row['period_name'] . ') - $' . $row['price']); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="food_service_price">Food Service Price</label>
                        <input type="number" step="0.01" class="form-control" name="food_service_price" id="food_service_price" readonly required>
                    </div>
                    <div class="form-group">
                        <label for="total_service_price">Total Service Price</label>
                        <input type="number" step="0.01" class="form-control" name="total_service_price" id="total_service_price" readonly required>
                    </div>
                    <button type="submit" name="submit" class="btn btn-primary">Save</button>
                    <a href="home.php?page=13" class="btn btn-secondary">Cancel</a>
                </form>
            </div>
        </div>
    </section>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const roomServiceSelect = document.getElementById('room_service_id');
        const foodServiceSelect = document.getElementById('food_service_id');
        const roomServicePriceInput = document.getElementById('room_service_price');
        const foodServicePriceInput = document.getElementById('food_service_price');
        const totalServicePriceInput = document.getElementById('total_service_price');

        function updatePricesAndTotal() {
            let roomPrice = 0;
            let foodPrice = 0;

            const selectedRoomOption = roomServiceSelect.options[roomServiceSelect.selectedIndex];
            if (selectedRoomOption.dataset.price) {
                roomPrice = parseFloat(selectedRoomOption.dataset.price);
            }
            roomServicePriceInput.value = roomPrice.toFixed(2);

            const selectedFoodOption = foodServiceSelect.options[foodServiceSelect.selectedIndex];
            if (selectedFoodOption.dataset.price) {
                foodPrice = parseFloat(selectedFoodOption.dataset.price);
            }
            foodServicePriceInput.value = foodPrice.toFixed(2);

            const total = roomPrice + foodPrice;
            totalServicePriceInput.value = total.toFixed(2);
        }

        roomServiceSelect.addEventListener('change', updatePricesAndTotal);
        foodServiceSelect.addEventListener('change', updatePricesAndTotal);

        updatePricesAndTotal();
    });
</script>
