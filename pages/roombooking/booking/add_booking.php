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
    $users_id = mysqli_real_escape_string($conn, $_POST['users_id']);
    $room_id = mysqli_real_escape_string($conn, $_POST['room_id']);
    $booking_date = date("Y-m-d H:i:s");
    $checkin_date = mysqli_real_escape_string($conn, $_POST['checkin_date']);
    $checkout_date = mysqli_real_escape_string($conn, $_POST['checkout_date']);
    $payment_status = mysqli_real_escape_string($conn, $_POST['payment_status']);
    $total_amount = mysqli_real_escape_string($conn, $_POST['total_amount']);

    // ডেটাবেজে নতুন ডেটা ইনসার্ট করার জন্য SQL কোয়েরি।
    $sql = "INSERT INTO `booking` (users_id, room_id, booking_date, checkin_date, checkout_date, payment_status, total_amount) VALUES ('$users_id', '$room_id', '$booking_date', '$checkin_date', '$checkout_date', '$payment_status', '$total_amount')";

    if ($conn->query($sql) === TRUE) {
        $r = "<div class='alert alert-success'>Booking added successfully.</div>";
    } else {
        $r = "<div class='alert alert-danger'>Error: " . $conn->error . "</div>";
    }
}

// ড্রপডাউনের জন্য users ডেটা লোড করা হচ্ছে।
// 'firstname' এবং 'lastname' ব্যবহার করে পুরো নাম তৈরি করা হয়েছে।
$users = $conn->query("SELECT id, CONCAT(firstname, ' ', lastname) AS full_name FROM `users` ORDER BY full_name ASC");
$users_data = [];
while ($row = $users->fetch_assoc()) {
    $users_data[] = $row;
}

// ড্রপডাউনের জন্য room ডেটা লোড করা হচ্ছে।
$rooms = $conn->query("SELECT id, room_number, total_price FROM `room` ORDER BY room_number ASC");
$rooms_data = [];
while ($row = $rooms->fetch_assoc()) {
    $rooms_data[] = $row;
}
?>

<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Add Booking</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Add Booking</li>
                    </ol>
                </div>
            </div>
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
                        <label for="room_id">Room</label>
                        <select class="form-control" name="room_id" id="room_id" required>
                            <option value="">Select Room</option>
                            <?php foreach ($rooms_data as $row): ?>
                                <option value="<?php echo htmlspecialchars($row['id']); ?>" data-price="<?php echo htmlspecialchars($row['total_price']); ?>">
                                    <?php echo htmlspecialchars('Room ' . $row['room_number'] . ' - $' . $row['total_price']); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
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
                        <label for="payment_status">Payment Status</label>
                        <select class="form-control" name="payment_status" required>
                            <option value="Paid">Paid</option>
                            <option value="Unpaid">Unpaid</option>
                            <option value="Pending">Pending</option>
                            <option value="Cash-on">Cash-on</option>
                            <option value="Online-paid">Online-paid</option>
                        </select>
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
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const roomSelect = document.getElementById('room_id');
        const checkinDateInput = document.getElementById('checkin_date');
        const checkoutDateInput = document.getElementById('checkout_date');
        const totalAmountInput = document.getElementById('total_amount');

        function calculateTotalAmount() {
            const selectedRoomOption = roomSelect.options[roomSelect.selectedIndex];
            let roomPricePerNight = 0;
            if (selectedRoomOption.dataset.price) {
                roomPricePerNight = parseFloat(selectedRoomOption.dataset.price);
            }

            const checkinDate = new Date(checkinDateInput.value);
            const checkoutDate = new Date(checkoutDateInput.value);

            if (checkinDate && checkoutDate && checkinDate < checkoutDate) {
                const timeDiff = Math.abs(checkoutDate.getTime() - checkinDate.getTime());
                const diffDays = Math.ceil(timeDiff / (1000 * 3600 * 24));
                const totalAmount = roomPricePerNight * diffDays;
                totalAmountInput.value = totalAmount.toFixed(2);
            } else {
                totalAmountInput.value = 0.00;
            }
        }

        roomSelect.addEventListener('change', calculateTotalAmount);
        checkinDateInput.addEventListener('change', calculateTotalAmount);
        checkoutDateInput.addEventListener('change', calculateTotalAmount);

        calculateTotalAmount();
    });
</script>
