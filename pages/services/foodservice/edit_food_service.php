<?php
// config.php ফাইলটি অন্তর্ভুক্ত করা হচ্ছে।
include("config.php");
if (!isset($conn)) {
    header("location:login.php");
    exit();
}

// ফলাফল বার্তা এবং ডেটা সংরক্ষণের জন্য ভেরিয়েবল।
$r = "";
$meal_type_id = "";
$meal_period_id = "";
$price = "";
$id = 0;

// যদি id থাকে, তাহলে ডেটা লোড করুন।
if (isset($_GET['id'])) {
    $id = mysqli_real_escape_string($conn, $_GET['id']);
    $sql_fetch = "SELECT `meal_type_id`, `meal_period_id`, `price` FROM `food_service` WHERE `id` = '$id'";
    $result_fetch = $conn->query($sql_fetch);
    if ($result_fetch->num_rows > 0) {
        $row = $result_fetch->fetch_assoc();
        $meal_type_id = $row['meal_type_id'];
        $meal_period_id = $row['meal_period_id'];
        $price = $row['price'];
    } else {
        $r = "<div class='alert alert-danger'>Record not found.</div>";
    }
}

// যদি ফর্ম সাবমিট করা হয়, তাহলে ডেটা আপডেট করুন।
if (isset($_POST['submit'])) {
    $id_update = mysqli_real_escape_string($conn, $_POST['id']);
    $meal_type_id_update = mysqli_real_escape_string($conn, $_POST['meal_type_id']);
    $meal_period_id_update = mysqli_real_escape_string($conn, $_POST['meal_period_id']);
    $price_update = mysqli_real_escape_string($conn, $_POST['price']);

    $sql_update = "UPDATE `food_service` SET `meal_type_id` = '$meal_type_id_update', `meal_period_id` = '$meal_period_id_update', `price` = '$price_update' WHERE `id` = '$id_update'";
    if ($conn->query($sql_update) === TRUE) {
        $r = "<div class='alert alert-success'>Food Service updated successfully.</div>";
    } else {
        $r = "<div class='alert alert-danger'>Error updating record: " . $conn->error . "</div>";
    }
}

// ড্রপডাউনের জন্য meal_type ডেটা লোড করা হচ্ছে।
$meal_types = $conn->query("SELECT id, type_name FROM `meal_type` ORDER BY type_name ASC");

// ড্রপডাউনের জন্য meal_period ডেটা লোড করা হচ্ছে।
$meal_periods = $conn->query("SELECT id, period_name, price FROM `meal_period` ORDER BY period_name ASC");
?>

<div class="content-wrapper">
    <section class="content-header">
        <h1>Edit Food Service</h1>
    </section>
    <section class="content">
        <div class="card">
            <div class="card-body">
                <?php echo $r; ?>
                <form action="" method="post">
                    <input type="hidden" name="id" value="<?php echo htmlspecialchars($id); ?>">
                    <div class="form-group">
                        <label for="meal_type_id">Meal Type</label>
                        <select class="form-control" name="meal_type_id" required>
                            <option value="">Select Meal Type</option>
                            <?php while ($row = $meal_types->fetch_assoc()): ?>
                                <option value="<?php echo htmlspecialchars($row['id']); ?>" <?php if ($row['id'] == $meal_type_id) echo 'selected'; ?>>
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
                                <option value="<?php echo htmlspecialchars($row['id']); ?>" <?php if ($row['id'] == $meal_period_id) echo 'selected'; ?>>
                                    <?php echo htmlspecialchars($row['period_name'] . ' - $' . $row['price']); ?>
                                </option>
                            <?php endwhile; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="price">Price</label>
                        <input type="number" step="0.01" class="form-control" name="price" value="<?php echo htmlspecialchars($price); ?>" required>
                    </div>
                    <button type="submit" class="btn btn-primary" name="submit">Update</button>
                    <a href="home.php?page=11" class="btn btn-secondary">Cancel</a>
                </form>
            </div>
        </div>
    </section>
</div>
