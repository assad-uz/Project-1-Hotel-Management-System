<?php
include("config.php");

$r = "";

// Add new room service
if (isset($_POST['submit'])) {
    $service_name = mysqli_real_escape_string($conn, $_POST['service_name']);
    $price = mysqli_real_escape_string($conn, $_POST['price']);

    // Check for duplicate service name
    $check = $conn->query("SELECT id FROM room_service WHERE service_name='$service_name'");
    if ($check->num_rows > 0) {
        $r = "<div class='alert alert-warning'>This room service already exists!</div>";
    } else {
        // Insert new room service
        $sql = "INSERT INTO room_service (service_name, price) VALUES ('$service_name', '$price')";
        if ($conn->query($sql) === TRUE) {
            $r = "<div class='alert alert-success'>Room service added successfully.</div>";
        } else {
            $r = "<div class='alert alert-danger'>Error: " . $conn->error . "</div>";
        }
    }
}
?>

<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <h1>Add Room Service</h1>
        </div>
    </section>

    <section class="content">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Add Room Service</h3>
            </div>
            <div class="card-body">
                <div class="ftitle text-center mt-3">
                    <?php echo $r; ?>
                </div>
                <form action="" method="post">
                    <div class="card-body">
                        <div class="form-group">
                            <label>Service Name</label>
                            <input type="text" class="form-control" name="service_name" required>
                        </div>
                        <div class="form-group">
                            <label>Price</label>
                            <input type="text" class="form-control" name="price" required>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary" name="submit">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </section>
</div>
