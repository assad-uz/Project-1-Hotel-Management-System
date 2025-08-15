<?php
  require_once("config.php");

?>
<?php 
 include("include/home/header.php");
 include("include/home/nav.php");
 ?>
<form action="room_insert.php" method="POST">
    <label>Service:</label>
    <select name="service_id">
        <?php
        $result = $conn->query("SELECT id FROM service");
        while ($row = $result->fetch_assoc()) {
            echo "<option value='{$row['id']}'>Service ID {$row['id']}</option>";
        }
        ?>
    </select><br>

    <label>Room Type:</label>
    <select name="room_type_id" required>
        <?php
        $result = $conn->query("SELECT id, room_name FROM room_type");
        while ($row = $result->fetch_assoc()) {
            echo "<option value='{$row['id']}'>{$row['room_name']}</option>";
        }
        ?>
    </select><br>

    <label>Room ID:</label>
    <input type="text" name="room_id" required><br>

    <label>Room Number:</label>
    <input type="text" name="room_number" required><br>

    <label>Room Price:</label>
    <input type="number" step="0.01" name="room_price" required><br>

    <label>Status:</label>
    <input type="text" name="room_status"><br>

    <label>Description:</label>
    <textarea name="description"></textarea><br>

    <button type="submit">Save</button>
</form>
  <?php 
 include("include/home/footer.php");
 ?>
