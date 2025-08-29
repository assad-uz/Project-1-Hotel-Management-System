<?php 
session_start();
require_once("config.php");

if (isset($_POST["btnRegister"])) {
  $firstname = trim($_POST["firstname"]);
  $lastname = trim($_POST["lastname"]);
  $username = trim($_POST["username"]);
  $email = trim($_POST["email"]);
  $phone = trim($_POST["phone"]);
  $password = trim($_POST["password"]);
  $confirm_password = trim($_POST["confirm_password"]);
  
  // Check if password and confirm password match
  if ($password !== $confirm_password) {
    $error = "<span style='color:red;'>Password and Confirm Password do not match.</span>";
  } else {
    // Check if username or email already exists
    $user_check = $conn->query("SELECT * FROM users WHERE email='$email' OR username='$username'");
    
    if ($user_check->num_rows > 0) {
      $error = "<span style='color:red;'>Email or Username already exists.</span>";
    } else {
      // Hash the password
      $hashed_password = password_hash($password, PASSWORD_DEFAULT);
      
      // Insert the user into the database
      $role_id = 2; // Assuming 2 is for 'customer' role
      $query = "INSERT INTO users (role_id, firstname, lastname, username, email, phone, password) 
                VALUES ('$role_id', '$firstname', '$lastname', '$username', '$email', '$phone', '$hashed_password')";
      
      if ($conn->query($query) === TRUE) {
        $_SESSION["s_email"] = $email;
        header("location:login.php"); // Redirect to login page after successful registration
      } else {
        $error = "<span style='color:red;'>Error: " . $conn->error . "</span>";
      }
    }
  }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Customer Registration</title>
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/font-awesome/css/font-awesome.min.css">
  <style>
    /* Same styling as before */
    body {
      display: flex;
      min-height: 100vh;
      margin: 0;
      font-family: 'Source Sans Pro', sans-serif;
    }
    .registration-box {
      display: flex;
      flex: 1;
      justify-content: center;
      align-items: center;
    }
    .form-container {
      width: 350px;
      padding: 30px;
      background-color: #fff;
      box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
      border-radius: 8px;
    }
    .form-container h4 {
      text-align: center;
      margin-bottom: 15px;
      font-weight: bold;
    }
    .form-container p {
      text-align: center;
      margin-bottom: 20px;
      color: #555;
    }
    .form-group {
      margin-bottom: 20px;
    }
    .form-group input {
      width: 100%;
      padding: 10px;
      font-size: 14px;
      border: 1px solid #ddd;
      border-radius: 4px;
    }
    .btn-primary {
      background-color: #007bff;
      color: white;
      padding: 10px;
      border: none;
      border-radius: 4px;
      width: 100%;
      cursor: pointer;
      font-size: 16px;
    }
    .btn-primary:hover {
      background-color: #0056b3;
    }
    .error {
      color: red;
      text-align: center;
    }
    .image-container {
      flex: 1;
      background-image: url('your-image-path.jpg');
      background-size: cover;
      background-position: center;
      height: 100vh;
      border-radius: 0 15px 15px 0;
    }
    @media (max-width: 768px) {
      body {
        flex-direction: column;
      }
      .image-container {
        height: 50vh;
        border-radius: 0;
      }
      .registration-box {
        flex-direction: column;
      }
    }
  </style>
</head>

<body>
  <div class="registration-box">
    <div class="image-container"></div>
    <div class="form-container">
      <h4>Register for Hotel Horizon!</h4>
      <p>Please fill in the details to create your account</p>
      <div class="error"><?php echo isset($error) ? $error : ""; ?></div>
      
      <form action="#" method="post">
        <div class="form-group">
          <input type="text" class="form-control" name="firstname" placeholder="First Name" required>
        </div>
        <div class="form-group">
          <input type="text" class="form-control" name="lastname" placeholder="Last Name" required>
        </div>
        <div class="form-group">
          <input type="text" class="form-control" name="username" placeholder="Username" required>
        </div>
        <div class="form-group">
          <input type="email" class="form-control" name="email" placeholder="Email" required>
        </div>
        <div class="form-group">
          <input type="text" class="form-control" name="phone" placeholder="Phone" required>
        </div>
        <div class="form-group">
          <input type="password" class="form-control" name="password" placeholder="Password" required>
        </div>
        <div class="form-group">
          <input type="password" class="form-control" name="confirm_password" placeholder="Re-type Password" required>
        </div>
        <button type="submit" name="btnRegister" class="btn-primary">Register</button>
      </form>

      <p class="text-center mb-0">
        <span>Already have an account?</span>
        <a href="login.php"><span>Login here</span></a>
      </p>
    </div>
  </div>
</body>
</html>
