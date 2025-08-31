<?php
include("config.php");

$r = "";

// Add new room type
if (isset($_POST['submit'])) {
    $room_name = mysqli_real_escape_string($conn, $_POST['room_name']);
    $price = mysqli_real_escape_string($conn, $_POST['price']);

    // Check for duplicate room name
    $check = $conn->query("SELECT id FROM room_type WHERE room_name='$room_name'");
    if ($check->num_rows > 0) {
        $r = "<div class='alert alert-warning'>This room type already exists!</div>";
    } else {
        // Insert new room type
        $sql = "INSERT INTO room_type (room_name, price) VALUES ('$room_name', '$price')";
        if ($conn->query($sql) === TRUE) {
            $r = "<div class='alert alert-success'>Room type added successfully.</div>";
        } else {
            $r = "<div class='alert alert-danger'>Error: " . $conn->error . "</div>";
        }
    }
}
?>

<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <h1>Add Room Type</h1>
        </div>
    </section>

    <section class="content">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Add Room Type</h3>
            </div>
            <div class="card-body">
                <div class="ftitle text-center mt-3">
                    <?php echo $r; ?>
                </div>
                <form action="" method="post">
                    <div class="card-body">
                        <div class="form-group">
                            <label>Room Name</label>
                            <input type="text" class="form-control" name="room_name" required>
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
