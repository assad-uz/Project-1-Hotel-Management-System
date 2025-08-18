<?php
include("config.php");
if (!isset($conn)) {
    header("location:login.php");
    exit();
}

$r = "";
$type_name = "";
$id = 0;

// যদি id থাকে, তাহলে ডেটা লোড করুন
if (isset($_GET['id'])) {
    $id = mysqli_real_escape_string($conn, $_GET['id']);
    $sql_fetch = "SELECT `type_name` FROM `meal_type` WHERE `id` = '$id'";
    $result_fetch = $conn->query($sql_fetch);
    if ($result_fetch->num_rows > 0) {
        $row = $result_fetch->fetch_assoc();
        $type_name = $row['type_name'];
    } else {
        $r = "<div class='alert alert-danger'>Record not found.</div>";
    }
}

// যদি ফর্ম সাবমিট করা হয়, তাহলে ডেটা আপডেট করুন
if (isset($_POST['submit'])) {
    $id_update = mysqli_real_escape_string($conn, $_POST['id']);
    $type_name_update = mysqli_real_escape_string($conn, $_POST['type_name']);

    $sql_update = "UPDATE `meal_type` SET `type_name` = '$type_name_update' WHERE `id` = '$id_update'";
    if ($conn->query($sql_update) === TRUE) {
        $r = "<div class='alert alert-success'>Meal Type updated successfully.</div>";
    } else {
        $r = "<div class='alert alert-danger'>Error updating record: " . $conn->error . "</div>";
    }
}
?>

<div class="content-wrapper">
    <section class="content-header">
        <h1>Edit Meal Type</h1>
    </section>
    <section class="content">
        <div class="card">
            <div class="card-body">
                <?php echo $r; ?>
                <form action="" method="post">
                    <input type="hidden" name="id" value="<?php echo htmlspecialchars($id); ?>">
                    <div class="form-group">
                        <label for="type_name">Meal Type Name</label>
                        <input type="text" class="form-control" name="type_name" value="<?php echo htmlspecialchars($type_name); ?>" required>
                    </div>
                    <button type="submit" class="btn btn-primary" name="submit">Update</button>
                    <a href="manage_meal.php" class="btn btn-secondary">Cancel</a>
                </form>
            </div>
        </div>
    </section>
</div>