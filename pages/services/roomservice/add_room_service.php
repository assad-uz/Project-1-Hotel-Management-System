<?php
include("config.php");
if (!isset($conn)) {
    header("location:login.php");
    exit();
}

$r = "";

if (isset($_POST["submit"])) {
    $service_name = mysqli_real_escape_string($conn, $_POST['service_name']);
    $price = mysqli_real_escape_string($conn, $_POST['price']);

    $sql = "INSERT INTO `room_service` (service_name, price) VALUES ('$service_name', '$price')";

    if ($conn->query($sql) === TRUE) {
        $r = "<div class='alert alert-success'>Room Service added successfully.</div>";
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
                    <h1>Add Room Service</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Add Room Service</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Add New Room Service</h3>
            </div>
            <div class="card-body">
                <div class="p-3">
                    <?php echo $r; ?>
                </div>
                <form action="" method="post">
                    <div class="form-group">
                        <label for="service_name">Service Name</label>
                        <input type="text" class="form-control" name="service_name" required>
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
