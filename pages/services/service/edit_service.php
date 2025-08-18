<?php
// config.php ফাইলটি অন্তর্ভুক্ত করা হচ্ছে।
include("config.php");
if (!isset($conn)) {
    header("location:login.php");
    exit();
}

// ফলাফল বার্তা এবং ডেটা সংরক্ষণের জন্য ভেরিয়েবল।
$r = "";
$room_service_id = "";
$food_service_id = "";
$service_price = "";
$id = 0;

// যদি id থাকে, তাহলে ডেটা লোড করুন।
if (isset($_GET['id'])) {
    $id = mysqli_real_escape_string($conn, $_GET['id']);
    $sql_fetch = "SELECT `room_service_id`, `food_service_id`, `service_price` FROM `service` WHERE `id` = '$id'";
    $result_fetch = $conn->query($sql_fetch);
    if ($result_fetch->num_rows > 0) {
        $row = $result_fetch->fetch_assoc();
        $room_service_id = $row['room_service_id'];
        $food_service_id = $row['food_service_id'];
        $service_price = $row['service_price'];
    } else {
        $r = "<div class='alert alert-danger'>Record not found.</div>";
    }
}

// যদি ফর্ম সাবমিট করা হয়, তাহলে ডেটা আপডেট করুন।
if (isset($_POST['submit'])) {
    $id_update = mysqli_real_escape_string($conn, $_POST['id']);
    $room_service_id_update = mysqli_real_escape_string($conn, $_POST['room_service_id']);
    $food_service_id_update = mysqli_real_escape_string($conn, $_POST['food_service_id']);
    $service_price_update = mysqli_real_escape_string($conn, $_POST['service_price']);

    $sql_update = "UPDATE `service` SET `room_service_id` = '$room_service_id_update', `food_service_id` = '$food_service_id_update', `service_price` = '$service_price_update' WHERE `id` = '$id_update'";
    if ($conn->query($sql_update) === TRUE) {
        $r = "<div class='alert alert-success'>Service updated successfully.</div>";
    } else {
        $r = "<div class='alert alert-danger'>Error updating record: " . $conn->error . "</div>";
    }
}

// ড্রপডাউনের জন্য room_service ডেটা লোড করা হচ্ছে।
$room_services = $conn->query("SELECT id, service_name, price FROM `room_service` ORDER BY service_name ASC");

// ড্রপডাউনের জন্য food_service ডেটা লোড করা হচ্ছে।
$sql_food_services = "SELECT fs.id, mt.type_name, mp.period_name, fs.price FROM `food_service` AS fs
                      INNER JOIN `meal_type` AS mt ON fs.meal_type_id = mt.id
                      INNER JOIN `meal_period` AS mp ON fs.meal_period_id = mp.id
                      ORDER BY mt.type_name, mp.period_name ASC";
$food_services = $conn->query($sql_food_services);
?>

<div class="content-wrapper">
    <section class="content-header">
        <h1>Edit Service</h1>
    </section>
    <section class="content">
        <div class="card">
            <div class="card-body">
                <?php echo $r; ?>
                <form action="" method="post">
                    <input type="hidden" name="id" value="<?php echo htmlspecialchars($id); ?>">
                    <div class="form-group">
                        <label for="room_service_id">Room Service</label>
                        <select class="form-control" name="room_service_id">
                            <option value="">Select Room Service</option>
                            <?php while ($row = $room_services->fetch_assoc()): ?>
                                <option value="<?php echo htmlspecialchars($row['id']); ?>" <?php if ($row['id'] == $room_service_id) echo 'selected'; ?>>
                                    <?php echo htmlspecialchars($row['service_name'] . ' - $' . $row['price']); ?>
                                </option>
                            <?php endwhile; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="food_service_id">Food Service</label>
                        <select class="form-control" name="food_service_id">
                            <option value="">Select Food Service</option>
                            <?php while ($row = $food_services->fetch_assoc()): ?>
                                <option value="<?php echo htmlspecialchars($row['id']); ?>" <?php if ($row['id'] == $food_service_id) echo 'selected'; ?>>
                                    <?php echo htmlspecialchars($row['type_name'] . ' (' . $row['period_name'] . ') - $' . $row['price']); ?>
                                </option>
                            <?php endwhile; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="service_price">Service Price</label>
                        <input type="number" step="0.01" class="form-control" name="service_price" value="<?php echo htmlspecialchars($service_price); ?>" required>
                    </div>
                    <button type="submit" class="btn btn-primary" name="submit">Update</button>
                    <a href="home.php?page=13" class="btn btn-secondary">Cancel</a>
                </form>
            </div>
        </div>
    </section>
</div>
