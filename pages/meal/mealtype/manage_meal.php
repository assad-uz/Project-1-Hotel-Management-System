<?php
include("config.php");
if (!isset($conn)) {
    header("location:login.php");
    exit();
}

$r = "";
if (isset($_POST["btnDelete"])) {
    $u_id = $_POST["txtId"];
    
    $sql = "DELETE FROM `meal_type` WHERE id = '$u_id'";
    $result = $conn->query($sql);

    if ($result === TRUE) {
        $r = "<div class='alert alert-success'>Meal Type deleted successfully.</div>";
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
                    <h1>Manage Meal Types</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Manage Meal Types</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Manage Meal Types</h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                        <i class="fas fa-minus"></i>
                    </button>
                    <button type="button" class="btn btn-tool" data-card-widget="remove" title="Remove">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
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
                                    <th>Meal Type Name</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $meal_types = $conn->query("SELECT id, type_name FROM `meal_type` ORDER BY id DESC");
                                while (list($id, $type_name) = $meal_types->fetch_row()) {
                                    echo "<tr> 
                                            <td>$id</td>
                                            <td>$type_name</td>
                                            <td> 
                                                <div class='d-flex align-items-center'>
    <form action='' method='post' onsubmit='return confirm(\"Are you sure you want to delete this meal type?\");' style='margin-right: 15px;'>
        <input type='hidden' name='txtId' value='$id' />
        <button type='submit' name='btnDelete' class='btn btn-danger btn-sm' title='Delete'>
            <i class='fas fa-trash'></i>
        </button>
    </form>
    <a href='edit_meal_type.php?id=$id' class='btn btn-primary btn-sm' title='Edit'>
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