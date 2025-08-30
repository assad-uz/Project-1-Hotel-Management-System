<?php
include("config.php");
if (!isset($conn)) {
    header("location:login.php");
    exit();
}

$r = "";

// Delete user
if (isset($_POST["btnDelete"])) {
    $u_id = $_POST["txtId"];
    $sql = "DELETE FROM users WHERE id = '$u_id'";
    if ($conn->query($sql) === TRUE) {
        $r = "<div class='alert alert-success'>User deleted successfully.</div>";
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
                    <h1>Manage Users</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Manage Users</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h3 class="card-title">Users List</h3>
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
                <table class="table table-striped table-bordered">
                    <thead class="bg-primary text-white">
                        <tr>
                            <th>#ID</th>
                            <th>First Name</th>
                            <th>Last Name</th>
                            <th>Username</th>
                            <th>Email</th>
                            <th>Contact</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $users = $conn->query("SELECT id, firstname, lastname, username, email, phone FROM users");
                        while ($user = $users->fetch_assoc()) {
                            echo "<tr>
                                <td>{$user['id']}</td>
                                <td>{$user['firstname']}</td>
                                <td>{$user['lastname']}</td>
                                <td>{$user['username']}</td>
                                <td>{$user['email']}</td>
                                <td>{$user['phone']}</td>
                                <td>
                                    <div class='d-flex align-items-center'>
                                        <form action='' method='post' onsubmit='return confirm(\"Are you sure you want to delete this user?\");' style='margin-right: 10px;'>
                                            <input type='hidden' name='txtId' value='{$user['id']}' />
                                            <button type='submit' name='btnDelete' class='btn btn-danger btn-sm' title='Delete'>
                                                <i class='fas fa-trash'></i>
                                            </button>
                                        </form>
                                        <a href='home.php?page=3&id={$user['id']}' class='btn btn-primary btn-sm' title='Edit'>
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
    </section>
</div>
