<?php
// config.php ফাইলটি অন্তর্ভুক্ত করা হচ্ছে।
include("config.php");
if (!isset($conn)) {
    header("location:login.php");
    exit();
}

// ফলাফল বার্তা এবং ডেটা সংরক্ষণের জন্য ভেরিয়েবল।
$r = "";
$users_id = "";
$room_id = "";
$booking_date = "";
$checkin_date = "";
$checkout_date = "";
$payment_status = "";
$total_amount_val = "";
$id = 0;

// যদি id থাকে, তাহলে ডেটা লোড করুন।
if (isset($_GET['id'])) {
    $id = mysqli_real_escape_string($conn, $_GET['id']);
    $sql_fetch = "SELECT `users_id`, `room_id`, `booking_date`, `checkin_date`, `checkout_date`, `payment_status`, `total_amount` FROM `booking` WHERE `id` = '$id'";
    $result_fetch = $conn->query($sql_fetch);
    if ($result_fetch->num_rows > 0) {
        $row = $result_fetch->fetch_assoc();
        $users_id = $row['users_id'];
        $room_id = $row['room_id'];
        $booking_date = $row['booking_date'];
        $checkin_date = $row['checkin_date'];
        $checkout_date = $row['checkout_date'];
        $payment_status = $row['payment_status'];
        $total_amount_val = $row['total_amount'];
    } else {
        $r = "<div class='alert alert-danger'>Record not found.</div>";
    }
}

// যদি ফর্ম সাবমিট করা হয়, তাহলে ডেটা আপডেট করুন।
if (isset($_POST['submit'])) {
    $id_update = mysqli_real_escape_string($conn, $_POST['id']);
    $users_id_update = mysqli_real_escape_string($conn, $_POST['users_id']);
    $room_id_update = mysqli_real_escape_string($conn, $_POST['room_id']);
    $booking_date_update = mysqli_real_escape_string($conn, $_POST['booking_date']);
    $checkin_date_update = mysqli_real_escape_string($conn, $_POST['checkin_date']);
    $checkout_date_update = mysqli_real_escape_string($conn, $_POST['checkout_date']);
    $payment_status_update = mysqli_real_escape_string($conn, $_POST['payment_status']);
    $total_amount_update = mysqli_real_escape_string($conn, $_POST['total_amount']);

    $sql_update = "UPDATE `booking` SET `users_id` = '$users_id_update', `room_id` = '$room_id_update', `booking_date` = '$booking_date_update', `checkin_date` = '$checkin_date_update', `checkout_date` = '$checkout_date_update', `payment_status` = '$payment_status_update', `total_amount` = '$total_amount_update' WHERE `id` = '$id_update'";
    if ($conn->query($sql_update) === TRUE) {
        $r = "<div class='alert alert-success'>Booking updated successfully.</div>";
    } else {
        $r = "<div class='alert alert-danger'>Error updating record: " . $conn->error . "</div>";
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
        <h1>Edit Booking</h1>
    </section>
    <section class="content">
        <div class="card">
            <div class="card-body">
                <?php echo $r; ?>
                <form action="" method="post">
                    <input type="hidden" name="id" value="<?php echo htmlspecialchars($id); ?>">
                    <div class="form-group">
                        <label for="users_id">User</label>
                        <select class="form-control" name="users_id" id="users_id" required>
                            <option value="">Select User</option>
                            <?php foreach ($users_data as $row): ?>
                                <option value="<?php echo htmlspecialchars($row['id']); ?>" <?php if ($row['id'] == $users_id) echo 'selected'; ?>>
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
                                <option value="<?php echo htmlspecialchars($row['id']); ?>" data-price="<?php echo htmlspecialchars($row['total_price']); ?>" <?php if ($row['id'] == $room_id) echo 'selected'; ?>>
                                    <?php echo htmlspecialchars('Room ' . $row['room_number'] . ' - $' . $row['total_price']); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="booking_date">Booking Date</label>
                        <input type="datetime-local" class="form-control" name="booking_date" value="<?php echo date('Y-m-d\TH:i:s', strtotime($booking_date)); ?>" readonly>
                    </div>
                    <div class="form-group">
                        <label for="checkin_date">Check-in Date</label>
                        <input type="date" class="form-control" name="checkin_date" id="checkin_date" value="<?php echo htmlspecialchars($checkin_date); ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="checkout_date">Check-out Date</label>
                        <input type="date" class="form-control" name="checkout_date" id="checkout_date" value="<?php echo htmlspecialchars($checkout_date); ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="payment_status">Payment Status</label>
                        <select class="form-control" name="payment_status" required>
                            <option value="Paid" <?php if ($payment_status == 'Paid') echo 'selected'; ?>>Paid</option>
                            <option value="Unpaid" <?php if ($payment_status == 'Unpaid') echo 'selected'; ?>>Unpaid</option>
                            <option value="Pending" <?php if ($payment_status == 'Pending') echo 'selected'; ?>>Pending</option>
                            <option value="Cash-on" <?php if ($payment_status == 'Cash-on') echo 'selected'; ?>>Cash-on</option>
                            <option value="Online-paid" <?php if ($payment_status == 'Online-paid') echo 'selected'; ?>>Online-paid</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="total_amount">Total Amount</label>
                        <input type="number" step="0.01" class="form-control" name="total_amount" id="total_amount" value="<?php echo htmlspecialchars($total_amount_val); ?>" readonly required>
                    </div>
                    <button type="submit" class="btn btn-primary" name="submit">Update</button>
                    <a href="home.php?page=26" class="btn btn-secondary">Cancel</a>
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
