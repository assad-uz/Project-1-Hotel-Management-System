<?php 
include("config.php");
if (!isset($conn)) {
    header("location:login.php");
    exit();
}

$r = "";

if (isset($_POST['submit'])) {
    $first_name = mysqli_real_escape_string($conn, $_POST['firstname']);
    $last_name  = mysqli_real_escape_string($conn, $_POST['lastname']);
    $username   = mysqli_real_escape_string($conn, $_POST['username']);
    $email      = mysqli_real_escape_string($conn, $_POST['email']);
    $phone      = mysqli_real_escape_string($conn, $_POST['phone']);
    $password   = mysqli_real_escape_string($conn, $_POST['password']);
    $repassword = mysqli_real_escape_string($conn, $_POST['repassword']);
    $role_id    = mysqli_real_escape_string($conn, $_POST['role_id']);

    // Password match check
    if ($password !== $repassword) {
        $r = "<div class='alert alert-danger'>Passwords do not match!</div>";
    } else {
        // Check duplicate email or username
        $check = $conn->query("SELECT id FROM users WHERE email='$email' OR username='$username'");
        if ($check->num_rows > 0) {
            $r = "<div class='alert alert-warning'>This email or username already exists!</div>";
        } else {
            // Hash password
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            // Insert user
            $sql = "INSERT INTO users (firstname, lastname, username, email, phone, password, role_id)
                    VALUES ('$first_name','$last_name','$username','$email','$phone','$hashed_password','$role_id')";
            
            if ($conn->query($sql) === TRUE) {
                $r = "<div class='alert alert-success'>User Added Successfully</div>";
            } else {
                $r = "<div class='alert alert-danger'>Error: " . $conn->error . "</div>"; 
            }
        }
    }
}
?> 

<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <h1>Add users</h1>
        </div>
    </section>

    <section class="content">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Add User</h3>
            </div>
            <div class="card-body">
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">User Registration Form</h3>
                    </div>
                    
                    <div class="ftitle text-center mt-3"> 
                        <?php echo $r; ?>
                    </div>
                    
                    <form action="" method="post">
                        <div class="card-body">
                            <div class="form-group">
                                <label>First Name</label>
                                <input type="text" class="form-control" name="firstname" required>
                            </div>
                            <div class="form-group">
                                <label>Last Name</label>
                                <input type="text" class="form-control" name="lastname" required>
                            </div>
                            <div class="form-group">
                                <label>Username</label>
                                <input type="text" class="form-control" name="username" required>
                            </div>
                            <div class="form-group">
                                <label>Email</label>
                                <input type="email" class="form-control" name="email" required>
                            </div>
                            <div class="form-group">
                                <label>Phone</label>
                                <input type="text" class="form-control" name="phone" required>
                            </div>
                            <div class="form-group">
                                <label>Password</label>
                                <input type="password" class="form-control" name="password" required>
                            </div>
                            <div class="form-group">
                                <label>Re-type Password</label>
                                <input type="password" class="form-control" name="repassword" required>
                            </div>
                            <div class="form-group">
                                <label>Role</label>
                                <select name="role_id" class="form-control" required>
                                    <?php
                                    $roles = $conn->query("SELECT id, role_type FROM role");
                                    while ($row = $roles->fetch_assoc()) {
                                        echo "<option value='{$row['id']}'>{$row['role_type']}</option>";
                                    }
                                    ?>
                                </select>
                            </div>
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
