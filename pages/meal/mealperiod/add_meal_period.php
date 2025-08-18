<?php
include("config.php");
if (!isset($conn)) {
    header("location:login.php");
    exit();
}

$r = "";
if (isset($_POST["submit"])) {
    // ডেটা স্যানিটাইজ করা
    $period_name = mysqli_real_escape_string($conn, $_POST['period_name']);
    $price = mysqli_real_escape_string($conn, $_POST['price']);

    // ডেটাবেজে ডেটা ইনসার্ট করার কোয়েরি
    $sql = "INSERT INTO `meal_period` (period_name, price) VALUES ('$period_name', '$price')";

    if ($conn->query($sql) === TRUE) {
        $r = "<div class='alert alert-success'>Meal Period added successfully.</div>";
    } else {
        $r = "<div class='alert alert-danger'>Error: " . $conn->error . "</div>";
    }
}
?>

<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Add Meal Period</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Add Meal Period</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Add New Meal Period</h3>
            </div>
            <div class="card-body">
                <div class="p-3">
                    <?php echo $r; ?>
                </div>
                <form action="" method="post">
                    <div class="form-group">
                        <label for="period_name">Period Name</label>
                        <input type="text" class="form-control" name="period_name" required>
                    </div>
                    <div class="form-group">
                        <label for="price">Price</label>
                        <input type="number" step="0.01" class="form-control" name="price" required>
                    </div>
                    <button type="submit" name="submit" class="btn btn-primary">Save</button>
                    <a href="home.php?page=7" class="btn btn-secondary">Cancel</a>
                </form>
            </div>
        </div>
    </section>
</div>
