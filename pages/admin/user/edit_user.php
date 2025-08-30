<?php
include("config.php");
if (!isset($conn)) {
    header("location:login.php");
    exit();
}

$r = "";
$id = $fname = $lname = $email = $phone = $role_id = "";

// ===== Update Logic =====
if (isset($_POST["btnUpdate"])) {
    $id     = $_POST["id"];
    $fname  = $_POST["fname"];
    $lname  = $_POST["lname"];
    $phone  = $_POST["phone"];
    $email  = $_POST["email"];
    $role_id= $_POST["role_id"];
    $password = $_POST["password"];

    if (!empty($password)) {
        // new password hash
        $hashed = password_hash($password, PASSWORD_DEFAULT);
        $sql = "UPDATE users SET firstname=?, lastname=?, phone=?, email=?, password=?, role_id=? WHERE id=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssssssi", $fname, $lname, $phone, $email, $hashed, $role_id, $id);
    } else {
        // keep old password
        $sql = "UPDATE users SET firstname=?, lastname=?, phone=?, email=?, role_id=? WHERE id=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssssii", $fname, $lname, $phone, $email, $role_id, $id);
    }

    if ($stmt->execute()) {
        $r = "<div class='alert alert-success'>User updated successfully.</div>";
    } else {
        $r = "<div class='alert alert-danger'>Error to update. " . $conn->error . "</div>";
    }
}

// ===== Fetch User to Edit =====
if (isset($_GET['id'])) {
    $id_to_edit = $_GET['id'];
    $sql = "SELECT id, firstname, lastname, phone, email, role_id FROM users WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id_to_edit);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $id = $row['id'];
        $fname = $row['firstname'];
        $lname = $row['lastname'];
        $phone = $row['phone'];
        $email = $row['email'];
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
                            <input type="text" class="form-control" name="fname" value="<?php echo $fname; ?>" required>
                        </div>
                        
                        <div class="form-group">
                            <label>Last Name</label>
                            <input type="text" class="form-control" name="lname" value="<?php echo $lname; ?>" required>
                        </div>

                        <div class="form-group">
                            <label>Contact</label>
                            <input type="text" class="form-control" name="phone" value="<?php echo $phone; ?>" required>
                        </div>

                        <div class="form-group">
                            <label>Email</label>
                            <input type="email" class="form-control" name="email" value="<?php echo $email; ?>" required>
                        </div>
                        
                        <div class="form-group">
                            <label>New Password (leave blank to keep old)</label>
                            <input type="password" class="form-control" name="password" placeholder="Enter new password if you want to change">
                        </div>
                        
                        <div class="form-group">
                            <label>Role</label>
                            <select name="role_id" class="form-control" required>
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
