<?php
// PHP-এর জন্য ডিফল্ট টাইমজোন সেট করা হচ্ছে।
date_default_timezone_set('Asia/Dhaka');

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
    $users_id = mysqli_real_escape_string($conn, $_POST['users_id']);
    $room_type_id = mysqli_real_escape_string($conn, $_POST['room_type_id']);
    // রুম সার্ভিস এবং ফুড সার্ভিস অপশনাল, যদি কিছু না দেওয়া হয় তবে NULL
    $room_service_id = isset($_POST['room_service_id']) && $_POST['room_service_id'] != "" ? mysqli_real_escape_string($conn, $_POST['room_service_id']) : NULL;
    $food_service_ids = isset($_POST['food_service_id']) ? $_POST['food_service_id'] : [];
    $food_service_id = !empty($food_service_ids) ? implode(',', $food_service_ids) : NULL;  // মাল্টিপল ফুড সার্ভিস আইডি কমা দিয়ে সংযুক্ত

    $booking_date = date("Y-m-d H:i:s");
    $checkin_date = mysqli_real_escape_string($conn, $_POST['checkin_date']);
    $checkout_date = mysqli_real_escape_string($conn, $_POST['checkout_date']);
    $total_amount = mysqli_real_escape_string($conn, $_POST['total_amount']);

    // ডেটাবেজে নতুন ডেটা ইনসার্ট করার জন্য SQL কোয়েরি।
    $stmt = $conn->prepare("INSERT INTO booking (users_id, room_type_id, room_service_id, food_service_id, booking_date, checkin_date, checkout_date, total_amount) 
                            VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("iiisssss", $users_id, $room_type_id, $room_service_id, $food_service_id, $booking_date, $checkin_date, $checkout_date, $total_amount);
    
    if ($stmt->execute()) {
        $r = "<div class='alert alert-success'>Booking added successfully.</div>";
    } else {
        $r = "<div class='alert alert-danger'>Error: " . $stmt->error . "</div>";
    }
}

// ড্রপডাউনের জন্য users ডেটা লোড করা হচ্ছে।
$users = $conn->query("SELECT id, CONCAT(firstname, ' ', lastname) AS full_name FROM users ORDER BY full_name ASC");
$users_data = [];
while ($row = $users->fetch_assoc()) {
    $users_data[] = $row;
}

// ড্রপডাউনের জন্য room_type ডেটা লোড করা হচ্ছে।
$room_types = $conn->query("SELECT id, room_name, price FROM room_type ORDER BY room_name ASC");
$room_types_data = [];
while ($row = $room_types->fetch_assoc()) {
    $room_types_data[] = $row;
}

// ড্রপডাউনের জন্য room_service ডেটা লোড করা হচ্ছে।
$room_services = $conn->query("SELECT id, service_name, price FROM room_service ORDER BY service_name ASC");
$room_services_data = [];
while ($row = $room_services->fetch_assoc()) {
    $room_services_data[] = $row;
}

// ফুড সার্ভিস মাল্টিপল সিলেকশন হলে তার আইডি গুলি অ্যারে আকারে পাবেন।
// ফুড সার্ভিসের অর্ডার ঠিক রাখার জন্য ORDER BY FIELD ব্যবহার করা হচ্ছে।
$food_services = $conn->query("SELECT id, meal_period, price FROM food_service ORDER BY FIELD(meal_period, 'Breakfast', 'Launch', 'Dinner') ASC");
$food_services_data = [];
while ($row = $food_services->fetch_assoc()) {
    $food_services_data[] = $row;
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
                <h3 class="card-title">Add New Booking</h3>
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
                                <option value="<?php echo htmlspecialchars($row['id']); ?>">
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
                                <option value="<?php echo htmlspecialchars($row['id']); ?>" data-price="<?php echo htmlspecialchars($row['price']); ?>">
                                    <?php echo htmlspecialchars($row['room_name']); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <input type="text" class="form-control mt-2" id="room_price" placeholder="Room Price" readonly>
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
                        <input type="text" class="form-control mt-2" id="room_service_price" placeholder="Room Service Price" readonly>
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
                        <input type="text" class="form-control mt-2" id="food_service_price" placeholder="Food Service Price" readonly>
                    </div>

                    <div class="form-group">
                        <label for="booking_date">Booking Date</label>
                        <input type="datetime-local" class="form-control" name="booking_date" value="<?php echo date('Y-m-d\TH:i:s'); ?>" readonly>
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

                    <button type="submit" name="submit" class="btn btn-primary">Save</button>
                </form>
            </div>
        </div>
    </section>
</div>

<style>
    .food-service-checkboxes {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
    }

    .form-check-inline {
        display: flex;
        align-items: center;
    }

    .form-check-input {
        margin-right: 5px;
        width: 18px;
        height: 18px;
    }

    .form-check-label {
        font-size: 14px;
        margin-bottom: 0;
    }

    @media (max-width: 576px) {
        .food-service-checkboxes {
            flex-direction: column;
        }
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const roomSelect = document.getElementById('room_type_id');
        const roomServiceSelect = document.getElementById('room_service_id');
        const foodServiceInputs = document.querySelectorAll('input[name="food_service_id[]"]');
        const checkinDateInput = document.getElementById('checkin_date');
        const checkoutDateInput = document.getElementById('checkout_date');
        const totalAmountInput = document.getElementById('total_amount');

        const roomPriceInput = document.getElementById('room_price');
        const roomServicePriceInput = document.getElementById('room_service_price');
        const foodServicePriceInput = document.getElementById('food_service_price');

        function calculateTotalAmount() {
            let roomPrice = 0;
            let roomServicePrice = 0;
            let foodServicePrice = 0;

            const selectedRoomOption = roomSelect.options[roomSelect.selectedIndex];
            if (selectedRoomOption && selectedRoomOption.dataset.price) {
                roomPrice = parseFloat(selectedRoomOption.dataset.price);
                roomPriceInput.value = roomPrice.toFixed(2);
            } else {
                roomPriceInput.value = "0.00";
            }

            const selectedRoomServiceOption = roomServiceSelect.options[roomServiceSelect.selectedIndex];
            if (selectedRoomServiceOption && selectedRoomServiceOption.dataset.price) {
                roomServicePrice = parseFloat(selectedRoomServiceOption.dataset.price);
                roomServicePriceInput.value = roomServicePrice.toFixed(2);
            } else {
                roomServicePriceInput.value = "0.00";
            }

            foodServicePrice = 0;
            foodServiceInputs.forEach(input => {
                if (input.checked && input.dataset.price) {
                    foodServicePrice += parseFloat(input.dataset.price);
                }
            });

            foodServicePriceInput.value = foodServicePrice.toFixed(2);

            const checkinDate = new Date(checkinDateInput.value);
            const checkoutDate = new Date(checkoutDateInput.value);

            if (checkinDate && checkoutDate && checkinDate < checkoutDate) {
                const timeDiff = Math.abs(checkoutDate.getTime() - checkinDate.getTime());
                const diffDays = Math.ceil(timeDiff / (1000 * 3600 * 24));
                const totalAmount = (roomPrice + roomServicePrice + foodServicePrice) * diffDays;
                totalAmountInput.value = totalAmount.toFixed(2);
            } else {
                totalAmountInput.value = "0.00";
            }
        }

        roomSelect.addEventListener('change', calculateTotalAmount);
        roomServiceSelect.addEventListener('change', calculateTotalAmount);
        foodServiceInputs.forEach(input => input.addEventListener('change', calculateTotalAmount));
        checkinDateInput.addEventListener('change', calculateTotalAmount);
        checkoutDateInput.addEventListener('change', calculateTotalAmount);

        calculateTotalAmount();
    });
</script>
