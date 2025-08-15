<?php
  require_once("config.php");

?>
<?php 
 include("include/home/header.php");
 include("include/home/nav.php");
 ?>
<form action="food_service_insert.php" method="POST">
    <label>Meal Type:</label>
    <select name="meal_type_id" required>
        <?php
        $result = $conn->query("SELECT id, type_name FROM meal_type");
        while ($row = $result->fetch_assoc()) {
            echo "<option value='{$row['id']}'>{$row['type_name']}</option>";
        }
        ?>
    </select><br>

    <label>Meal Period:</label>
    <select name="meal_period_id" required>
        <?php
        $result = $conn->query("SELECT id, period_name FROM meal_period");
        while ($row = $result->fetch_assoc()) {
            echo "<option value='{$row['id']}'>{$row['period_name']}</option>";
        }
        ?>
    </select><br>

    <label>Price:</label>
    <input type="number" step="0.01" name="price" required><br>

    <button type="submit">Save</button>
</form>
  <?php 
 include("include/home/footer.php");
 ?>
