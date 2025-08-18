<?php
include("config.php");
if (!isset($conn)) {
    header("location:login.php");
    exit();
}

$r = "";
if (isset($_POST["btnDelete"])) {
    $u_id = $_POST["txtId"];
    
    // ডেটাবেজ থেকে meal_period ডিলিট করার কোয়েরি
    $sql = "DELETE FROM `meal_period` WHERE id = '$u_id'";
    $result = $conn->query($sql);

    if ($result === TRUE) {
        $r = "<div class='alert alert-success'>Meal Period deleted successfully.</div>";
    } else {
        $r = "<div class='alert alert-danger'>Error deleting record: " . $conn->error . "</div>";
    }
}
?>

<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Manage Meal Periods</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Manage Meal Periods</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Manage Meal Periods</h3>
            </div>

            <div class="p-3">
                <?php echo $r; ?>
            </div>

            <div class="card-body">
                <div class="card">
                    <div class="card-body">
                        <table class="table table-striped table-bordered">
                            <thead class="bg-primary text-white">
                                <tr>
                                    <th>#ID</th>
                                    <th>Period Name</th>
                                    <th>Price</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $meal_periods = $conn->query("SELECT id, period_name, price FROM `meal_period` ORDER BY id DESC");
                                while (list($id, $period_name, $price) = $meal_periods->fetch_row()) {
                                    echo "<tr> 
                                            <td>$id</td>
                                            <td>$period_name</td>
                                            <td>$price</td>
                                            <td> 
                                                <div class='d-flex align-items-center'>
                                                    <form action='' method='post' onsubmit='return confirm(\"Are you sure you want to delete this meal period?\");' style='margin-right: 15px;'>
                                                        <input type='hidden' name='txtId' value='$id' />
                                                        <button type='submit' name='btnDelete' class='btn btn-danger btn-sm' title='Delete'>
                                                            <i class='fas fa-trash'></i>
                                                        </button>
                                                    </form>
                                                    <a href='home.php?page=9&id=$id' class='btn btn-primary btn-sm' title='Edit'>
                                                        <i class='fas fa-edit'></i>
                                                    </a>
                                                </div>
                                            </td>
                                          </tr>";
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
