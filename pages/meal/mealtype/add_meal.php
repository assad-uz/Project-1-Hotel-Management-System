<?php
include("config.php");
if (!isset($conn)) {
    header("location:login.php");
    exit();
}

$r = "";

if (isset($_POST['submit'])) {
    $type_name  = $_POST['meal_type'];
    $sql = "INSERT INTO `meal_type`(`type_name`) 
            VALUES ('$type_name')";
    $result = $conn->query($sql);

    if ($result === TRUE) {
        $r = "<div class='alert alert-success'>Meal Type Added Successfully</div>";
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
                    <h1>Add users</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active"></li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Add Meal Type</h3>
            </div>
            <div class="card-body">
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Meal Type Form</h3>
                    </div>

                    <div class="ftitle text-center mt-3">
                        <?php echo $r; ?>
                    </div>

                    <form action="#" method="post">
                         <div class="form-group">
                            <label for="type_name">Meal Type</label>
                            <input type="text" class="form-control" name="meal_type" id="meal_type" required>
                        </div>
                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary" name="submit">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
</div>