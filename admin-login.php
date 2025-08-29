<?php 
session_start();
require_once("config.php");

if (isset($_POST["btnLogin"])) {
  $username_or_email = trim($_POST["username_or_email"]);
  $password = trim($_POST["password"]);

  // Query to check if username or email exists
  $user_table = $conn->query("SELECT id, username, email, password, role FROM users WHERE (email='$username_or_email' OR username='$username_or_email')");

  list($id, $username, $email, $db_password, $role) = $user_table->fetch_row();

  // Check if user exists and password is correct, and role is 'admin'
  if (isset($id) && password_verify($password, $db_password) && $role == 'admin') {
    $_SESSION["s_email"] = $email;
    $_SESSION["role"] = $role;
    header("location:admin-dashboard.php"); // Redirect to admin dashboard
  } else {
    $error = "<span style='color:red;'>Incorrect username, email or password</span>";
  }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Admin Login</title>
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/font-awesome/css/font-awesome.min.css">
  <style>
    body {
      display: flex;
      min-height: 100vh;
      margin: 0;
      font-family: 'Source Sans Pro', sans-serif;
    }
    .login-box {
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
      background-image: url('dist/images/login1.jpg');
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
      .login-box {
        flex-direction: column;
      }
    }
  </style>
</head>

<body>
  <div class="login-box">
    <div class="image-container"></div>
    <div class="form-container">
      <h4>Welcome to Hotel Horizon (Admin)!</h4>
      <p>Please sign-in to manage the system</p>
      <div class="error"><?php echo isset($error) ? $error : ""; ?></div>

      <!-- Admin Login Form -->
      <form action="#" method="post">
        <div class="form-group">
          <input type="text" class="form-control" name="username_or_email" placeholder="Email or Username">
        </div>
        <div class="form-group">
          <input type="password" class="form-control" name="password" placeholder="Password">
        </div>
        
        <button type="submit" name="btnLogin" class="btn-primary">Sign In</button>
      </form>

      <p class="text-center mb-0">
        <a href="login.php"><span>Back to Customer Login</span></a>
      </p>
    </div>
  </div>
</body>
</html>
