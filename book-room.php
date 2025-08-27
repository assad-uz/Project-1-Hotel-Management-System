<?php
$conn = new mysqli("localhost", "root", "", "hotel_db");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch Room Types
$room_types = $conn->query("SELECT id, room_name, price FROM room_type");

// Fetch Meal Types
$meal_types = $conn->query("SELECT id, type_name FROM meal_type");

// Fetch Meal Periods
$meal_periods = $conn->query("SELECT id, period_name, price FROM meal_period");

// Fetch Food Services
$food_services = $conn->query("SELECT id, service_name, price FROM food_service");

// Fetch Room Services
$room_services = $conn->query("SELECT id, service_name, price FROM room_service");

// Fetch Payments
$payments = $conn->query("SELECT id, payment_method FROM payment_method");
?>

<!DOCTYPE html>
<html>

<head>
    <title>Book Room</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <script>
        function calculateTotal() {
            let total = 0;

            // Room Type
            let room = document.querySelector("select[name='room_type']");
            if (room.value) {
                total += parseFloat(room.options[room.selectedIndex].getAttribute("data-price"));
            }

            // Meal Type
            let meal = document.querySelector("select[name='meal_type']");
            if (meal.value) {
                total += parseFloat(meal.options[meal.selectedIndex].getAttribute("data-price"));
            }

            // Meal Period
            let period = document.querySelector("select[name='meal_period']");
            if (period.value) {
                total += parseFloat(period.options[period.selectedIndex].getAttribute("data-price"));
            }

            // Food Service
            let food = document.querySelector("select[name='food_service']");
            if (food.value) {
                total += parseFloat(food.options[food.selectedIndex].getAttribute("data-price"));
            }

            // Room Service
            let rservice = document.querySelector("select[name='room_service']");
            if (rservice.value) {
                total += parseFloat(rservice.options[rservice.selectedIndex].getAttribute("data-price"));
            }

            // Show Total
            document.getElementById("total_amount").value = total.toFixed(2);
        }
    </script>
</head>

<body class="bg-light">
    <div class="container mt-5">
        <div class="card shadow p-4">
            <h3 class="mb-4">Book a Room</h3>
            <form action="save-booking.php" method="POST">

                <!-- Room Type -->
                <div class="mb-3">
                    <label class="form-label">Room Type</label>
                    <select name="room_type" class="form-select" onchange="calculateTotal()" required>
                        <option value="">-- Select Room Type --</option>
                        <?php while ($row = $room_types->fetch_assoc()) { ?>
                            <option value="<?= $row['id'] ?>" data-price="<?= $row['price'] ?>">
                                <?= $row['room_type'] ?> (৳<?= $row['price'] ?>)
                            </option>
                        <?php } ?>
                    </select>
                </div>

                <!-- Meal Type -->
                <div class="mb-3">
                    <label class="form-label">Meal Type (Optional)</label>
                    <select name="meal_type" class="form-select" onchange="calculateTotal()">
                        <option value="">-- None --</option>
                        <?php while ($row = $meal_types->fetch_assoc()) { ?>
                            <option value="<?= $row['id'] ?>" data-price="<?= $row['price'] ?>">
                                <?= $row['meal_type'] ?> (৳<?= $row['price'] ?>)
                            </option>
                        <?php } ?>
                    </select>
                </div>

                <!-- Meal Period -->
                <div class="mb-3">
                    <label class="form-label">Meal Period (Optional)</label>
                    <select name="meal_period" class="form-select" onchange="calculateTotal()">
                        <option value="">-- None --</option>
                        <?php while ($row = $meal_periods->fetch_assoc()) { ?>
                            <option value="<?= $row['id'] ?>" data-price="<?= $row['price'] ?>">
                                <?= $row['meal_period'] ?> (৳<?= $row['price'] ?>)
                            </option>
                        <?php } ?>
                    </select>
                </div>

                <!-- Food Service -->
                <div class="mb-3">
                    <label class="form-label">Food Service (Optional)</label>
                    <select name="food_service" class="form-select" onchange="calculateTotal()">
                        <option value="">-- None --</option>
                        <?php while ($row = $food_services->fetch_assoc()) { ?>
                            <option value="<?= $row['id'] ?>" data-price="<?= $row['price'] ?>">
                                <?= $row['service_name'] ?> (৳<?= $row['price'] ?>)
                            </option>
                        <?php } ?>
                    </select>
                </div>

                <!-- Room Service -->
                <div class="mb-3">
                    <label class="form-label">Room Service (Optional)</label>
                    <select name="room_service" class="form-select" onchange="calculateTotal()">
                        <option value="">-- None --</option>
                        <?php while ($row = $room_services->fetch_assoc()) { ?>
                            <option value="<?= $row['id'] ?>" data-price="<?= $row['price'] ?>">
                                <?= $row['service_name'] ?> (৳<?= $row['price'] ?>)
                            </option>
                        <?php } ?>
                    </select>
                </div>

                <!-- Total Amount (Auto) -->
                <div class="mb-3">
                    <label class="form-label">Total Amount</label>
                    <input type="text" id="total_amount" name="total_amount" class="form-control" readonly>
                </div>

                <!-- Payment -->
                <div class="mb-3">
                    <label class="form-label">Payment Method</label>
                    <select name="payment" class="form-select" required>
                        <option value="">-- Select Payment Method --</option>
                        <?php while ($row = $payments->fetch_assoc()) { ?>
                            <option value="<?= $row['id'] ?>"><?= $row['payment_method'] ?></option>
                        <?php } ?>
                    </select>
                </div>

                <button type="submit" class="btn btn-primary">Book Now</button>
            </form>
        </div>
    </div>
</body>

</html>