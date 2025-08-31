<?php
include("config.php");

$r = "";
$id = $room_name = $price = "";

// Update Room Type
if (isset($_POST["btnUpdate"])) {
    $id = $_POST["id"];
    $room_name = $_POST["room_name"];
    $price = $_POST["price"];

    $sql = "UPDATE room_type SET room_name=?, price=? WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssd", $room_name, $price, $id);

    if ($stmt->execute()) {
        $r = "<div class='alert alert-success'>Room Type updated successfully.</div>";
    } else {
        $r = "<div class='alert alert-danger'>Error to update. " . $conn->error . "</div>";
    }
}

// Fetch Room Type to Edit
if (isset($_GET['id'])) {
    $id_to_edit = $_GET['id'];
    $sql = "SELECT id, room_name, price FROM room_type WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id_to_edit);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $id = $row['id'];
        $room_name = $row['room_name'];
        $price = $row['price'];
    }
}
?>

<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <h1>Edit Room Type</h1>
        </div>
    </section>

    <section class="content">
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">Edit Room Type Info</h3>
            </div>
            <div class="card-body">
                <div class="p-3">
                    <?php echo $r; ?>
                </div>

                <form action="" method="post">
                    <div class="card-body">
                        <input type="hidden" name="id" value="<?php echo $id; ?>">

                        <div class="form-group">
                            <label>Room Name</label>
                            <input type="text" class="form-control" name="room_name" value="<?php echo $room_name; ?>" required>
                        </div>

                        <div class="form-group">
                            <label>Price</label>
                            <input type="text" class="form-control" name="price" value="<?php echo $price; ?>" required>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary" name="btnUpdate">Update</button>
                        <a href="home.php?page=11" class="btn btn-secondary" style="margin-left: 10px;">Back to Manage Room Types</a>
                    </div>
                </form>
            </div>
        </div>
    </section>
</div>
