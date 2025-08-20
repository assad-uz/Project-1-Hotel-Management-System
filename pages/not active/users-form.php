<?php
  require_once("config.php");

?>
<?php 
 include("include/home/header.php");
 include("include/home/nav.php");
 ?>
<form action="users_insert.php" method="POST">
    <label>Name:</label>
    <input type="text" name="name" required><br>

    <label>Email:</label>
    <input type="email" name="email" required><br>

    <label>Phone:</label>
    <input type="text" name="phone"><br>

    <label>Password:</label>
    <input type="password" name="password" required><br>

    <label>Role:</label>
    <select name="role_id" required>
        <?php
        include 'db_connect.php';
        $result = $conn->query("SELECT id, role_type FROM role");
        while ($row = $result->fetch_assoc()) {
            echo "<option value='{$row['id']}'>{$row['role_type']}</option>";
        }
        ?>
    </select><br>

    <button type="submit">Save</button>
</form>
  <?php 
 include("include/home/footer.php");
 ?>
   <?php 
 include("include/home/footer.php");
 ?>