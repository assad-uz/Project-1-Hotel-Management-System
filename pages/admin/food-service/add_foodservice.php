<?php
include("config.php");

$r = "";

if (isset($_POST['submit'])) {
    $meal_period = mysqli_real_escape_string($conn, $_POST['meal_period']);
    $price = mysqli_real_escape_string($conn, $_POST['price']);

    // Check duplicate meal_period
    $check = $conn->query("SELECT id FROM food_service WHERE meal_period='$meal_period'");
    if ($check->num_rows > 0) {
        $r = "<div class='alert alert-warning'>This meal period already exists!</div>";
    } else {
        // Insert new food service
        $sql = "INSERT INTO food_service (meal_period, price) VALUES ('$meal_period', '$price')";
        if ($conn->query($sql) === TRUE) {
            $r = "<div class='alert alert-success'>Food Service Added Successfully</div>";
        } else {
            $r = "<div class='alert alert-danger'>Error: " . $conn->error . "</div>";
        }
    }
}
?>

<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <h1>Add Food Service</h1>
        </div>
    </section>

    <section class="content">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Add Food Service</h3>
            </div>
            <div class="card-body">
                <div class="ftitle text-center mt-3">
                    <?php echo $r; ?>
                </div>
                <form action="" method="post">
                    <div class="form-group">
                        <label>Meal Period</label>
                        <input type="text" class="form-control" name="meal_period" required>
                    </div>
                    <div class="form-group">
                        <label>Price (Per Person)</label>
                        <input type="text" class="form-control" name="price" required>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary" name="submit">Submit</button>
                    </div>
                </form>

            </div>
        </div>
    </section>
</div>