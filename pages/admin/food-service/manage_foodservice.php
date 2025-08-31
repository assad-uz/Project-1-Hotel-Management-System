<?php
include("config.php");

$r = "";

// Delete food service
if (isset($_POST["btnDelete"])) {
    $service_id = $_POST["txtId"];
    $sql = "DELETE FROM food_service WHERE id = '$service_id'";
    if ($conn->query($sql) === TRUE) {
        $r = "<div class='alert alert-success'>Food service deleted successfully.</div>";
    } else {
        $r = "<div class='alert alert-danger'>Error deleting record: " . $conn->error . "</div>";
    }
}
?>

<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <h1>Manage Food Services</h1>
        </div>
    </section>

    <section class="content">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h3 class="card-title">Food Service List</h3>
            </div>

            <div class="p-3">
                <?php echo $r; ?>
            </div>

            <div class="card-body">
                <table class="table table-striped table-bordered">
                    <thead class="bg-primary text-white">
                        <tr>
                            <th>#ID</th>
                            <th>Meal Period</th>
                            <th>Price (Per Person)</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $services = $conn->query("SELECT id, meal_period, price FROM food_service");
                        while ($service = $services->fetch_assoc()) {
                            echo "<tr>
                                <td>{$service['id']}</td>
                                <td>{$service['meal_period']}</td>
                                <td>{$service['price']}</td>
                                <td>
                                    <div class='d-flex align-items-center'>
                                        <form action='' method='post' onsubmit='return confirm(\"Are you sure you want to delete this food service?\");' style='margin-right: 10px;'>
                                            <input type='hidden' name='txtId' value='{$service['id']}' />
                                            <button type='submit' name='btnDelete' class='btn btn-danger btn-sm' title='Delete'>
                                                <i class='fas fa-trash'></i>
                                            </button>
                                        </form>
                                        <a href='home.php?page=9&id={$service['id']}' class='btn btn-primary btn-sm' title='Edit'>
                                            <i class='fas fa-edit'></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>";
                        }
                        ?>
                    </tbody>
                </table>
                    <div class="card-footer">
                  <!-- Back Button to Manage Food Services -->
                        <a href="home.php?page=7" class="btn btn-secondary" style="margin-left: 10px;">Add Food Services</a>
                    </div>
            </div>
        </div>
    </section>
</div>
