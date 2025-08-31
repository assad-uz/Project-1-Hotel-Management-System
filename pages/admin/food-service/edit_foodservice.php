<?php
include("config.php");

$r = "";
$id = $meal_period = $price = "";

// ===== Update Logic =====
if (isset($_POST["btnUpdate"])) {
    $id = $_POST["id"];
    $meal_period = $_POST["meal_period"];
    $price = $_POST["price"];

    $sql = "UPDATE food_service SET meal_period=?, price=? WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssd", $meal_period, $price, $id);

    if ($stmt->execute()) {
        $r = "<div class='alert alert-success'>Food Service updated successfully.</div>";
    } else {
        $r = "<div class='alert alert-danger'>Error to update. " . $conn->error . "</div>";
    }
}

// ===== Fetch Food Service to Edit =====
if (isset($_GET['id'])) {
    $id_to_edit = $_GET['id'];
    $sql = "SELECT id, meal_period, price FROM food_service WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id_to_edit);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $id = $row['id'];
        $meal_period = $row['meal_period'];
        $price = $row['price'];
    }
}
?>

<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <h1>Edit Food Service</h1>
        </div>
    </section>

    <section class="content">
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">Edit Food Service Info</h3>
            </div>
            <div class="card-body">
                <div class="p-3">
                    <?php echo $r; ?>
                </div>

                <form action="" method="post">
                    <div class="card-body">
                        <input type="hidden" name="id" value="<?php echo $id; ?>">

                        <div class="form-group">
                            <label>Meal Period</label>
                            <input type="text" class="form-control" name="meal_period" value="<?php echo $meal_period; ?>" required>
                        </div>

                        <div class="form-group">
                            <label>Price (Per Person)</label>
                            <input type="text" class="form-control" name="price" value="<?php echo $price; ?>" required>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary" name="btnUpdate">Update</button>
                      <!-- Back Button to Manage Food Services -->
                        <a href="home.php?page=8" class="btn btn-secondary" style="margin-left: 10px;">Back to Manage Food Services</a>
                    </div>
                </form>
            </div>
        </div>
    </section>
</div>
