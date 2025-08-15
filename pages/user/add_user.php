<?php 
include("config.php");
if (!isset($conn)) {
    header("location:login.php");
    exit();
}

$r = "";

if (isset($_POST['submit'])) {
    $first_name = mysqli_real_escape_string($conn, $_POST['firstname']);
    $last_name = mysqli_real_escape_string($conn, $_POST['lastname']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $role_id = mysqli_real_escape_string($conn, $_POST['role_id']);

    $sql = "INSERT INTO `users`(`firstname`, `lastname`, `phone`, `email`, `password`, `role_id`) 
            VALUES ('$first_name','$last_name','$phone','$email','$password', '$role_id')";
    $result = $conn->query($sql);

    if ($result === TRUE) {
        $r = "<div class='alert alert-success'>User Added Successfully</div>";
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
                    
                    <form action="#" method="post">
                        <div class="card-body">
                            <div class="form-group">
                                <label for="fname">First Name</label>
                                <input type="text" class="form-control" id="fname" placeholder="Enter first name" name="firstname">
                            </div>
                            <div class="form-group">
                                <label for="lname">Last Name</label>
                                <input type="text" class="form-control" id="lname" placeholder="Enter last name" name="lastname">
                            </div>
                            <div class="form-group">
                                <label for="pNo">Contact</label>
                                <input type="text" class="form-control" id="pNo" placeholder="Enter phone number" name="phone">
                            </div>
                            <div class="form-group">
                                <label for="email">Email address</label>
                                <input type="email" class="form-control" id="email" placeholder="Enter email" name="email">
                            </div>
                            <div class="form-group">
                                <label for="password">Password</label>
                                <input type="password" class="form-control" id="password" placeholder="Password" name="password">
                            </div>
                            <div class="form-group">
                                <label for="role_id">Role:</label>
                                <select name="role_id" id="role_id" class="form-control">
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