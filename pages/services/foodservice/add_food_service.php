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
    $meal_type_id = mysqli_real_escape_string($conn, $_POST['meal_type_id']);
    $meal_period_id = mysqli_real_escape_string($conn, $_POST['meal_period_id']);
    $price = mysqli_real_escape_string($conn, $_POST['price']);

    // ডেটাবেজে নতুন ডেটা ইনসার্ট করার জন্য SQL কোয়েরি।
    $sql = "INSERT INTO `food_service` (meal_type_id, meal_period_id, price) VALUES ('$meal_type_id', '$meal_period_id', '$price')";

    if ($conn->query($sql) === TRUE) {
        $r = "<div class='alert alert-success'>Food Service added successfully.</div>";
    } else {
        $r = "<div class='alert alert-danger'>Error: " . $conn->error . "</div>";
    }
}

// ড্রপডাউনের জন্য meal_type ডেটা লোড করা হচ্ছে।
$meal_types = $conn->query("SELECT id, type_name FROM `meal_type` ORDER BY type_name ASC");

// ড্রপডাউনের জন্য meal_period ডেটা লোড করা হচ্ছে।
$meal_periods = $conn->query("SELECT id, period_name, price FROM `meal_period` ORDER BY period_name ASC");
?>

<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Add Food Service</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Add Food Service</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Add New Food Service</h3>
            </div>
            <div class="card-body">
                <div class="p-3">
                    <?php echo $r; ?>
                </div>
                <form action="" method="post">
                    <div class="form-group">
                        <label for="meal_type_id">Meal Type</label>
                        <select class="form-control" name="meal_type_id" required>
                            <option value="">Select Meal Type</option>
                            <?php while ($row = $meal_types->fetch_assoc()): ?>
                                <option value="<?php echo htmlspecialchars($row['id']); ?>">
                                    <?php echo htmlspecialchars($row['type_name']); ?>
                                </option>
                            <?php endwhile; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="meal_period_id">Meal Period</label>
                        <select class="form-control" name="meal_period_id" required>
                            <option value="">Select Meal Period</option>
                            <?php while ($row = $meal_periods->fetch_assoc()): ?>
                                <option value="<?php echo htmlspecialchars($row['id']); ?>">
                                    <?php echo htmlspecialchars($row['period_name'] . ' - $' . $row['price']); ?>
                                </option>
                            <?php endwhile; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="price">Price</label>
                        <input type="number" step="0.01" class="form-control" name="price" required>
                    </div>
                    <button type="submit" name="submit" class="btn btn-primary">Save</button>
                </form>
            </div>
        </div>
    </section>
</div>
