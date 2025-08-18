<?php
include("config.php");
if (!isset($conn)) {
    header("location:login.php");
    exit();
}

$r = "";
$period_name = "";
$price = "";
$id = 0;

// যদি id থাকে, তাহলে ডেটা লোড করুন
if (isset($_GET['id'])) {
    $id = mysqli_real_escape_string($conn, $_GET['id']);
    $sql_fetch = "SELECT `period_name`, `price` FROM `meal_period` WHERE `id` = '$id'";
    $result_fetch = $conn->query($sql_fetch);
    if ($result_fetch->num_rows > 0) {
        $row = $result_fetch->fetch_assoc();
        $period_name = $row['period_name'];
        $price = $row['price'];
    } else {
        $r = "<div class='alert alert-danger'>Record not found.</div>";
    }
}

// যদি ফর্ম সাবমিট করা হয়, তাহলে ডেটা আপডেট করুন
if (isset($_POST['submit'])) {
    $id_update = mysqli_real_escape_string($conn, $_POST['id']);
    $period_name_update = mysqli_real_escape_string($conn, $_POST['period_name']);
    $price_update = mysqli_real_escape_string($conn, $_POST['price']);

    $sql_update = "UPDATE `meal_period` SET `period_name` = '$period_name_update', `price` = '$price_update' WHERE `id` = '$id_update'";
    if ($conn->query($sql_update) === TRUE) {
        $r = "<div class='alert alert-success'>Meal Period updated successfully.</div>";
    } else {
        $r = "<div class='alert alert-danger'>Error updating record: " . $conn->error . "</div>";
    }
}
?>

<div class="content-wrapper">
    <section class="content-header">
        <h1>Edit Meal Period</h1>
    </section>
    <section class="content">
        <div class="card">
            <div class="card-body">
                <?php echo $r; ?>
                <form action="" method="post">
                    <input type="hidden" name="id" value="<?php echo htmlspecialchars($id); ?>">
                    <div class="form-group">
                        <label for="period_name">Period Name</label>
                        <input type="text" class="form-control" name="period_name" value="<?php echo htmlspecialchars($period_name); ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="price">Price</label>
                        <input type="number" step="0.01" class="form-control" name="price" value="<?php echo htmlspecialchars($price); ?>" required>
                    </div>
                    <button type="submit" class="btn btn-primary" name="submit">Update</button>
                    <a href="home.php?page=7" class="btn btn-secondary">Cancel</a>
                </form>
            </div>
        </div>
    </section>
</div>
