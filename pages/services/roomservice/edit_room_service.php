<?php
// config.php ফাইলটি অন্তর্ভুক্ত করা হচ্ছে।
include("config.php");
// যদি ডেটাবেজ সংযোগ না থাকে, তবে login.php তে পুনঃনির্দেশ করা হচ্ছে।
if (!isset($conn)) {
    header("location:login.php");
    exit();
}

// ফলাফল বার্তা এবং ডেটা সংরক্ষণের জন্য ভেরিয়েবল।
$r = "";
$service_name = "";
$price = "";
$id = 0;

// যদি id থাকে, তাহলে ডেটা লোড করুন।
if (isset($_GET['id'])) {
    $id = mysqli_real_escape_string($conn, $_GET['id']);
    $sql_fetch = "SELECT `service_name`, `price` FROM `room_service` WHERE `id` = '$id'";
    $result_fetch = $conn->query($sql_fetch);
    if ($result_fetch->num_rows > 0) {
        $row = $result_fetch->fetch_assoc();
        $service_name = $row['service_name'];
        $price = $row['price'];
    } else {
        $r = "<div class='alert alert-danger'>Record not found.</div>";
    }
}

// যদি ফর্ম সাবমিট করা হয়, তাহলে ডেটা আপডেট করুন।
if (isset($_POST['submit'])) {
    $id_update = mysqli_real_escape_string($conn, $_POST['id']);
    $service_name_update = mysqli_real_escape_string($conn, $_POST['service_name']);
    $price_update = mysqli_real_escape_string($conn, $_POST['price']);

    $sql_update = "UPDATE `room_service` SET `service_name` = '$service_name_update', `price` = '$price_update' WHERE `id` = '$id_update'";
    if ($conn->query($sql_update) === TRUE) {
        $r = "<div class='alert alert-success'>Room Service updated successfully.</div>";
    } else {
        $r = "<div class='alert alert-danger'>Error updating record: " . $conn->error . "</div>";
    }
}
?>

<div class="content-wrapper">
    <section class="content-header">
        <h1>Edit Room Service</h1>
    </section>
    <section class="content">
        <div class="card">
            <div class="card-body">
                <?php echo $r; ?>
                <form action="" method="post">
                    <input type="hidden" name="id" value="<?php echo htmlspecialchars($id); ?>">
                    <div class="form-group">
                        <label for="service_name">Service Name</label>
                        <input type="text" class="form-control" name="service_name" value="<?php echo htmlspecialchars($service_name); ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="price">Price</label>
                        <input type="number" step="0.01" class="form-control" name="price" value="<?php echo htmlspecialchars($price); ?>" required>
                    </div>
                    <button type="submit" class="btn btn-primary" name="submit">Update</button>
                    <a href="home.php?page=9" class="btn btn-secondary">Cancel</a>
                </form>
            </div>
        </div>
    </section>
</div>
