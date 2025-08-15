<?php
  require_once("config.php");

?>
<?php 
 include("include/home/header.php");
 include("include/home/nav.php");
 ?>
<form action="service_insert.php" method="POST">
    <label>Room Service:</label>
    <select name="room_service_id">
        <?php
        $result = $conn->query("SELECT id, service_name FROM room_service");
        while ($row = $result->fetch_assoc()) {
            echo "<option value='{$row['id']}'>{$row['service_name']}</option>";
        }
        ?>
    </select><br>

    <label>Food Service:</label>
    <select name="food_service">
        <?php
        $result = $conn->query("SELECT id FROM food_service");
        while ($row = $result->fetch_assoc()) {
            echo "<option value='{$row['id']}'>Food Service ID {$row['id']}</option>";
        }
        ?>
    </select><br>

    <label>Service Price:</label>
    <input type="number" step="0.01" name="service_price" required><br>

    <button type="submit">Save</button>
</form>
  <?php 
 include("include/home/footer.php");
 ?>
