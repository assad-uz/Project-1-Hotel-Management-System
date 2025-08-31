<?php 
session_start();
require_once("config.php");

// Check if the user is logged in, if not redirect to login page
if (!isset($_SESSION["s_email"])) {
    header("location:login.php");
    exit();
}

// Fetch available rooms, services, and food items from the database
$room_query = $conn->query("SELECT id, room_name, price FROM room_type");
$rooms = $room_query->fetch_all(MYSQLI_ASSOC);

$room_service_query = $conn->query("SELECT id, service_name, price FROM room_service");
$room_services = $room_service_query->fetch_all(MYSQLI_ASSOC);

$food_service_query = $conn->query("SELECT id, meal_period, price FROM food_service");
$food_services = $food_service_query->fetch_all(MYSQLI_ASSOC);

// Process booking request
if (isset($_POST["btnBook"])) {
    $user_id = $_SESSION["user_id"];  // Assuming user_id is stored in session
    $room_type_id = $_POST["room_type_id"];
    $room_service_id = $_POST["room_service_id"];
    $food_service_id = $_POST["food_service_id"];
    $checkin_date = $_POST["checkin_date"];
    $checkout_date = $_POST["checkout_date"];
    
    // Adjust the checkin and checkout dates to start at 10:00 AM and end at 9:59 AM respectively
    $checkin_datetime = new DateTime($checkin_date);
    $checkin_datetime->setTime(10, 0);  // Set check-in time to 10:00 AM

    $checkout_datetime = new DateTime($checkout_date);
    $checkout_datetime->setTime(9, 59);  // Set checkout time to 9:59 AM (next day)

    // Calculate the number of nights (days between checkin and checkout)
    $interval = $checkin_datetime->diff($checkout_datetime);
    $total_nights = $interval->days;

    // Fetch room price from the database
    $room_price_query = $conn->query("SELECT price FROM room_type WHERE id='$room_type_id'");
    $room_price = $room_price_query->fetch_row()[0];

    // Calculate total room price
    $room_total_price = $room_price * $total_nights;

    // Calculate room service price
    $room_service_price = 0;
    if ($room_service_id) {
        $room_service_query = $conn->query("SELECT price FROM room_service WHERE id='$room_service_id'");
        $room_service_price = $room_service_query->fetch_row()[0];
    }

    // Calculate food service price
    $food_service_price = 0;
    if ($food_service_id) {
        $food_service_query = $conn->query("SELECT price FROM food_service WHERE id='$food_service_id'");
        $food_service_price = $food_service_query->fetch_row()[0];
    }

    // Total amount calculation
    $total_amount = $room_total_price + $room_service_price + $food_service_price;

    // Insert booking into the database
    $book_query = "INSERT INTO booking (users_id, room_type_id, room_service_id, food_service_id, booking_date, checkin_date, checkout_date, total_amount) 
                   VALUES ('$user_id', '$room_type_id', '$room_service_id', '$food_service_id', NOW(), '$checkin_datetime', '$checkout_datetime', '$total_amount')";
    
    if ($conn->query($book_query) === TRUE) {
        $success_msg = "Room booked successfully!";
    } else {
        $error_msg = "Error: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Book Room</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/font-awesome/css/font-awesome.min.css">
    <style>
        body {
            font-family: 'Source Sans Pro', sans-serif;
        }
        .container {
            width: 70%;
            margin: auto;
            padding: 20px;
        }
        .form-container {
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
        .form-group {
            margin-bottom: 15px;
        }
        .form-group input, .form-group select {
            width: 100%;
            padding: 10px;
            font-size: 14px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        .btn-primary {
            background-color: #007bff;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        .btn-primary:hover {
            background-color: #0056b3;
        }
        .error, .success {
            text-align: center;
            color: red;
        }
    </style>
</head>

<body>
<div class="container">
    <div class="form-container">
        <h4>Book Your Room</h4>
        <p>Please select the room and services to complete your booking.</p>

        <?php 
        if (isset($success_msg)) {
            echo "<div class='success'>$success_msg</div>";
        }
        if (isset($error_msg)) {
            echo "<div class='error'>$error_msg</div>";
        }
        ?>

        <form action="book-room.php" method="POST">
            <!-- Room Selection -->
            <div class="form-group">
                <label for="room_type_id">Select Room</label>
                <select name="room_type_id" required>
                    <?php foreach ($rooms as $room) { ?>
                        <option value="<?php echo $room['id']; ?>"><?php echo $room['room_name']; ?> - $<?php echo $room['price']; ?></option>
                    <?php } ?>
                </select>
            </div>

            <!-- Room Service Selection -->
            <div class="form-group">
                <label for="room_service_id">Select Room Service</label>
                <select name="room_service_id">
                    <option value="">None</option>
                    <?php foreach ($room_services as $service) { ?>
                        <option value="<?php echo $service['id']; ?>"><?php echo $service['service_name']; ?> - $<?php echo $service['price']; ?></option>
                    <?php } ?>
                </select>
            </div>

            <!-- Food Service Selection -->
            <div class="form-group">
                <label for="food_service_id">Select Food Service</label>
                <select name="food_service_id">
                    <option value="">None</option>
                    <?php foreach ($food_services as $food) { ?>
                        <option value="<?php echo $food['id']; ?>"><?php echo $food['meal_period']; ?> - $<?php echo $food['price']; ?></option>
                    <?php } ?>
                </select>
            </div>

            <!-- Dates -->
            <div class="form-group">
                <label for="checkin_date">Check-in Date</label>
                <input type="date" name="checkin_date" required>
            </div>

            <div class="form-group">
                <label for="checkout_date">Check-out Date</label>
                <input type="date" name="checkout_date" required>
            </div>

            <!-- Fixed Booking Date and Total Amount -->
            <div class="form-group">
                <label for="booking_date">Booking Date</label>
                <input type="text" name="booking_date" value="<?php echo date('Y-m-d H:i:s'); ?>" readonly>
            </div>

            <div class="form-group">
                <label for="total_amount">Total Amount</label>
                <input type="text" name="total_amount" value="$<?php echo number_format($total_amount, 2); ?>" readonly>
            </div>

            <!-- Submit Button -->
            <button type="submit" name="btnBook" class="btn-primary">Book Now</button>
        </form>
    </div>
</div>
</body>
</html>
