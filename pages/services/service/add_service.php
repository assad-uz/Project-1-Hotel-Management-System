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
    $service_price = mysqli_real_escape_string($conn, $_POST['service_price']);

    // ডেটাবেজে নতুন ডেটা ইনসার্ট করার জন্য SQL কোয়েরি।
    $sql = "INSERT INTO `service` (room_service_id, food_service_id, service_price) VALUES ('$room_service_id', '$food_service_id', '$service_price')";

    if ($conn->query($sql) === TRUE) {
        $r = "<div class='alert alert-success'>Service added successfully.</div>";
    } else {
        $r = "<div class='alert alert-danger'>Error: " . $conn->error . "</div>";
    }
}

// ড্রপডাউনের জন্য room_service ডেটা লোড করা হচ্ছে।
$room_services = $conn->query("SELECT id, service_name, price FROM `room_service` ORDER BY service_name ASC");

// ড্রপডাউনের জন্য food_service ডেটা লোড করা হচ্ছে।
// আমরা এখানে meal_type এবং meal_period টেবিলের সাথে JOIN করে ডেটা লোড করব।
$sql_food_services = "SELECT fs.id, mt.type_name, mp.period_name, fs.price FROM `food_service` AS fs
                      INNER JOIN `meal_type` AS mt ON fs.meal_type_id = mt.id
                      INNER JOIN `meal_period` AS mp ON fs.meal_period_id = mp.id
                      ORDER BY mt.type_name, mp.period_name ASC";
$food_services = $conn->query($sql_food_services);

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
                        <select class="form-control" name="room_service_id">
                            <option value="">Select Room Service</option>
                            <?php while ($row = $room_services->fetch_assoc()): ?>
                                <option value="<?php echo htmlspecialchars($row['id']); ?>">
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
                                <option value="<?php echo htmlspecialchars($row['id']); ?>">
                                    <?php echo htmlspecialchars($row['type_name'] . ' (' . $row['period_name'] . ') - $' . $row['price']); ?>
                                </option>
                            <?php endwhile; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="service_price">Service Price</label>
                        <input type="number" step="0.01" class="form-control" name="service_price" required>
                    </div>
                    <button type="submit" name="submit" class="btn btn-primary">Save</button>
                    <a href="home.php?page=13" class="btn btn-secondary">Cancel</a>
                </form>
            </div>
        </div>
    </section>
</div>
