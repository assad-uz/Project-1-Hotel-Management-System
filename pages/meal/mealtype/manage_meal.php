<?php
include("config.php");

if (!isset($conn)) {
    header("location:login.php");
    exit();
}

$r = "";

// ডেটা যোগ করার জন্য
if (isset($_POST['submit'])) {
    $period_name = mysqli_real_escape_string($conn, $_POST['period_name']);
    $price = mysqli_real_escape_string($conn, $_POST['price']);

    $sql = "INSERT INTO `meal_period`(`period_name`, `price`) VALUES ('$period_name', '$price')";
    $result = $conn->query($sql);

    if ($result === TRUE) {
        $r = "<div class='alert alert-success'>Meal Period Added Successfully</div>";
    } else {
        $r = "<div class='alert alert-danger'>Error: " . $conn->error . "</div>";
    }
}

// ডেটা ডিলিট করার জন্য
if (isset($_GET['delete_id'])) {
    $delete_id = mysqli_real_escape_string($conn, $_GET['delete_id']);
    $sql_delete = "DELETE FROM `meal_period` WHERE id = '$delete_id'";
    
    if ($conn->query($sql_delete) === TRUE) {
        $r = "<div class='alert alert-success'>Record Deleted Successfully</div>";
        header("location: add_meal_period.php");
        exit();
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
                    <h1>Add Meal Period & Price</h1>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Add Meal Period</h3>
            </div>
            <div class="card-body">
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Meal Period Form</h3>
                    </div>
                    <div class="ftitle text-center mt-3">
                        <?php echo $r; ?>
                    </div>
                    <form action="#" method="post">
                        <div class="form-group">
                            <label for="period_name">Meal Period Name</label>
                            <input type="text" class="form-control" name="period_name" required>
                        </div>
                        <div class="form-group">
                            <label for="price">Price</label>
                            <input type="number" step="0.01" class="form-control" name="price" required>
                        </div>
                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary" name="submit">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="card mt-4">
            <div class="card-header">
                <h3 class="card-title">All Meal Periods</h3>
            </div>
            <div class="card-body">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Meal Period</th>
                            <th>Price</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $query = "SELECT * FROM `meal_period`";
                        $result = $conn->query($query);

                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                echo "<tr>";
                                echo "<td>" . $row['id'] . "</td>";
                                echo "<td>" . $row['period_name'] . "</td>";
                                echo "<td>" . $row['price'] . "</td>";
                                echo "<td><a href='add_meal_period.php?delete_id=" . $row['id'] . "' class='btn btn-danger btn-sm'>Delete</a></td>";
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='4'>No records found</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </section>
</div>