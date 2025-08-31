<?php
include("config.php");

$r = "";
$id = $service_name = $price = "";

// Update Room Service
if (isset($_POST["btnUpdate"])) {
    $id = $_POST["id"];
    $service_name = $_POST["service_name"];
    $price = $_POST["price"];

    $sql = "UPDATE room_service SET service_name=?, price=? WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssd", $service_name, $price, $id);

    if ($stmt->execute()) {
        $r = "<div class='alert alert-success'>Room Service updated successfully.</div>";
    } else {
        $r = "<div class='alert alert-danger'>Error to update. " . $conn->error . "</div>";
    }
}

// Fetch Room Service to Edit
if (isset($_GET['id'])) {
    $id_to_edit = $_GET['id'];
    $sql = "SELECT id, service_name, price FROM room_service WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id_to_edit);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $id = $row['id'];
        $service_name = $row['service_name'];
        $price = $row['price'];
    }
}
?>

<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <h1>Edit Room Service</h1>
        </div>
    </section>

    <section class="content">
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">Edit Room Service Info</h3>
            </div>
            <div class="card-body">
                <div class="p-3">
                    <?php echo $r; ?>
                </div>

                <form action="" method="post">
                    <div class="card-body">
                        <input type="hidden" name="id" value="<?php echo $id; ?>">

                        <div class="form-group">
                            <label>Service Name</label>
                            <input type="text" class="form-control" name="service_name" value="<?php echo $service_name; ?>" required>
                        </div>

                        <div class="form-group">
                            <label>Price</label>
                            <input type="text" class="form-control" name="price" value="<?php echo $price; ?>" required>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary" name="btnUpdate">Update</button>
                        <a href="home.php?page=5" class="btn btn-secondary" style="margin-left: 10px;">Back to Manage Room Services</a>
                    </div>
                </form>
            </div>
        </div>
    </section>
</div>
