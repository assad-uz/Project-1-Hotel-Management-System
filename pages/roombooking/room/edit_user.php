<?php
include("config.php");
if (!isset($conn)) {
    header("location:login.php");
    exit();
}

$r = "";
$id = $fname = $lname = $email = $password = $phone = $role_id = '';

if (isset($_POST["btnUpdate"])) {
    $id = $_POST["id"];
    $fname = $_POST["fname"];
    $lname = $_POST["lname"];
    $phone = $_POST["phone"];
    $email = $_POST["email"];
    $password = $_POST["password"];
    $role_id = $_POST["role_id"];
    
    $sql = "UPDATE users SET firstname='$fname', lastname='$lname', phone='$phone', email='$email', password='$password', role_id='$role_id' WHERE id='$id'";
    
    if ($conn->query($sql) === TRUE) {
        $r = "<div class='alert alert-success'>User updated successfully.</div>";
    } else {
        $r = "<div class='alert alert-danger'>Error to update. " . $conn->error . "</div>";
    }
}

if (isset($_GET['id'])) {
    $id_to_edit = $_GET['id'];
    
    $sql = "SELECT id, firstname, lastname, phone, email, password, role_id FROM users WHERE id = '$id_to_edit'";
    $result = $conn->query($sql);
    
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $id = $row['id'];
        $fname = $row['firstname'];
        $lname = $row['lastname'];
        $phone = $row['phone'];
        $email = $row['email'];
        $password = $row['password'];
        $role_id = $row['role_id'];
    }
}
?>

<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <h1>Update User</h1>
        </div>
    </section>

    <section class="content">
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">Update User Info Form</h3>
            </div>
            <div class="card-body">
                <div class="p-3">
                    <?php echo $r; ?>
                </div>

                <form action="" method="post">
                    <div class="card-body">
                        <input type="hidden" name="id" value="<?php echo $id; ?>">
                        
                        <div class="form-group">
                            <label>First Name</label>
                            <input type="text" class="form-control" name="fname" value="<?php echo $fname; ?>">
                        </div>
                        
                        <div class="form-group">
                            <label>Last Name</label>
                            <input type="text" class="form-control" name="lname" value="<?php echo $lname; ?>">
                        </div>

                        <div class="form-group">
                            <label>Contact</label>
                            <input type="text" class="form-control" name="phone" value="<?php echo $phone; ?>">
                        </div>

                        <div class="form-group">
                            <label>Email</label>
                            <input type="email" class="form-control" name="email" value="<?php echo $email; ?>">
                        </div>
                        
                        <div class="form-group">
                            <label>Password</label>
                            <input type="password" class="form-control" name="password" value="<?php echo $password; ?>">
                        </div>
                        
                        <div class="form-group">
                            <label>Role</label>
                            <select name="role_id" class="form-control">
                                <?php
                                $roles = $conn->query("SELECT id, role_type FROM role");
                                while ($row_role = $roles->fetch_assoc()) {
                                    $selected = ($row_role['id'] == $role_id) ? 'selected' : '';
                                    echo "<option value='{$row_role['id']}' {$selected}>{$row_role['role_type']}</option>";
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary" name="btnUpdate">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </section>
</div>