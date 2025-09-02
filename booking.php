<?php
// Start session
session_start();

// Include config.php to connect to database
include("config.php");

// Check if user is logged in
if (!isset($_SESSION['customer_id'])) {
    header("Location: login.php"); // Redirect to login page if not logged in
    exit();
}

// Get user id from session
$user_id = $_SESSION['customer_id'];

// Initialize variables for booking
$room_types_data = [];
$room_services_data = [];
$food_services_data = [];
$food_service_ids = [];
$total_amount = 0;

// Fetch room types, room services, and food services from the database
$room_types = $conn->query("SELECT id, room_name, price FROM room_type ORDER BY room_name ASC");
while ($row = $room_types->fetch_assoc()) {
    $room_types_data[] = $row;
}

$room_services = $conn->query("SELECT id, service_name, price FROM room_service ORDER BY service_name ASC");
while ($row = $room_services->fetch_assoc()) {
    $room_services_data[] = $row;
}

$food_services = $conn->query("SELECT id, meal_period, price FROM food_service ORDER BY FIELD(meal_period, 'Breakfast', 'Lunch', 'Dinner') ASC");
while ($row = $food_services->fetch_assoc()) {
    $food_services_data[] = $row;
}

if (isset($_POST['submit'])) {
    // Get booking details from form
    $room_type_id = mysqli_real_escape_string($conn, $_POST['room_type_id']);
    $room_service_id = isset($_POST['room_service_id']) ? mysqli_real_escape_string($conn, $_POST['room_service_id']) : NULL;
    $food_service_ids = isset($_POST['food_service_id']) ? $_POST['food_service_id'] : [];
    $checkin_date = mysqli_real_escape_string($conn, $_POST['checkin_date']);
    $checkout_date = mysqli_real_escape_string($conn, $_POST['checkout_date']);

    // Calculate the total amount (price of room + room service + food services)
    $room_price = 0;
    $room_service_price = 0;
    $food_service_price = 0;

    // Get room price
    foreach ($room_types_data as $room) {
        if ($room['id'] == $room_type_id) {
            $room_price = $room['price'];
        }
    }

    // Get room service price
    if ($room_service_id) {
        foreach ($room_services_data as $service) {
            if ($service['id'] == $room_service_id) {
                $room_service_price = $service['price'];
            }
        }
    }

    // Get food service prices
    foreach ($food_service_ids as $food_service_id) {
        foreach ($food_services_data as $food_service) {
            if ($food_service['id'] == $food_service_id) {
                $food_service_price += $food_service['price'];
            }
        }
    }

    // Calculate total amount
    $total_amount = $room_price + $room_service_price + $food_service_price;

    // Insert booking data into database
    $booking_date = date("Y-m-d H:i:s");
    $stmt = $conn->prepare("INSERT INTO booking (users_id, room_type_id, room_service_id, food_service_id, booking_date, checkin_date, checkout_date, total_amount) 
                            VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("iiisssss", $user_id, $room_type_id, $room_service_id, implode(',', $food_service_ids), $booking_date, $checkin_date, $checkout_date, $total_amount);

    if ($stmt->execute()) {
        $r = "<div class='alert alert-success'>Booking added successfully.</div>";
    } else {
        $r = "<div class='alert alert-danger'>Error: " . $stmt->error . "</div>";
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking - Hotel Horizon</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <style>
        .card-room-selection.active {
            border: 2px solid #007bff;
            box-shadow: 0 0 10px rgba(0, 123, 255, 0.5);
        }
    </style>
</head>
<body>
<?php
require_once("include/header.php");
require_once("include/navbar.php");
?>

<div class="container py-5">
    <h1 class="text-center mb-4">Make a Booking</h1>
    <div class="row justify-content-center">
        <div class="col-md-9">
            <div class="card p-4 shadow-sm">
                <div class="card-body">
                    <?php echo isset($r) ? $r : ''; ?>
                    <form action="" method="post">
                        
                        <div class="mb-4">
                            <h4>1. Select Your Room Type</h4>
                            <div class="row" id="room-selection-container">
                                <?php foreach ($room_types_data as $row): ?>
                                    <div class="col-md-6 mb-3">
                                        <div class="card card-room-selection" data-price="<?php echo htmlspecialchars($row['price']); ?>">
                                            <div class="card-body">
                                                <h5 class="card-title"><?php echo htmlspecialchars($row['room_name']); ?></h5>
                                                <p class="card-text text-primary">৳ <?php echo htmlspecialchars($row['price']); ?> / Night</p>
                                                <input type="radio" name="room_type_id" value="<?php echo htmlspecialchars($row['id']); ?>" class="form-check-input mt-0" required>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>

                        <div class="mb-4">
                            <h4>2. Choose Your Dates</h4>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="checkin_date">Check-in Date</label>
                                        <input type="date" class="form-control" name="checkin_date" id="checkin_date" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="checkout_date">Check-out Date</label>
                                        <input type="date" class="form-control" name="checkout_date" id="checkout_date" required>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="mb-4">
                            <h4>3. Add Services & Meals (Optional)</h4>
                            <div class="form-group">
                                <label for="room_service_id">Room Service</label>
                                <select class="form-control" name="room_service_id" id="room_service_id">
                                    <option value="">Select Room Service (Optional)</option>
                                    <?php foreach ($room_services_data as $row): ?>
                                        <option value="<?php echo htmlspecialchars($row['id']); ?>" data-price="<?php echo htmlspecialchars($row['price']); ?>">
                                            <?php echo htmlspecialchars($row['service_name']); ?> (৳<?php echo htmlspecialchars($row['price']); ?>)
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label for="food_service_id">Food Service</label>
                            <div class="row">
                                <?php foreach ($food_services_data as $row): ?>
                                    <div class="col-md-4">
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input" name="food_service_id[]" value="<?php echo htmlspecialchars($row['id']); ?>" id="food_service_<?php echo htmlspecialchars($row['id']); ?>" data-price="<?php echo htmlspecialchars($row['price']); ?>">
                                            <label class="form-check-label" for="food_service_<?php echo htmlspecialchars($row['id']); ?>">
                                                <?php echo htmlspecialchars($row['meal_period']); ?> (৳<?php echo htmlspecialchars($row['price']); ?>)
                                            </label>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>

                        <div class="mb-4">
                            <h4>4. Booking Summary</h4>
                            <div class="card bg-light">
                                <div class="card-body">
                                    <p>Selected Room: <strong id="summary-room-name">N/A</strong></p>
                                    <p>Room Price: ৳<strong id="summary-room-price">0.00</strong></p>
                                    <p>Services Price: ৳<strong id="summary-services-price">0.00</strong></p>
                                    <h5 class="mt-3">Total Amount: ৳<strong id="summary-total-amount">0.00</strong></h5>
                                </div>
                            </div>
                        </div>
                        
                        <div class="d-grid gap-2">
                            <input type="hidden" name="total_amount" id="total_amount">
                            <button type="submit" name="submit" class="btn btn-primary btn-lg">Confirm Booking</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once("include/footer.php"); ?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const roomRadios = document.querySelectorAll('input[name="room_type_id"]');
        const roomServiceSelect = document.getElementById('room_service_id');
        const foodServiceInputs = document.querySelectorAll('input[name="food_service_id[]"]');
        const checkinDateInput = document.getElementById('checkin_date');
        const checkoutDateInput = document.getElementById('checkout_date');
        const totalAmountInput = document.getElementById('total_amount');

        // Summary elements
        const summaryRoomName = document.getElementById('summary-room-name');
        const summaryRoomPrice = document.getElementById('summary-room-price');
        const summaryServicesPrice = document.getElementById('summary-services-price');
        const summaryTotalAmount = document.getElementById('summary-total-amount');

        function calculateTotalAmount() {
            let roomPrice = 0;
            let roomServiceName = "N/A";
            let roomServicePrice = 0;
            let foodServicePrice = 0;
            let roomName = "N/A";

            // Get room price and name
            roomRadios.forEach(radio => {
                if (radio.checked) {
                    const card = radio.closest('.card-room-selection');
                    roomPrice = parseFloat(card.dataset.price);
                    roomName = card.querySelector('.card-title').textContent;
                }
            });

            // Get room service price
            const selectedRoomServiceOption = roomServiceSelect.options[roomServiceSelect.selectedIndex];
            if (selectedRoomServiceOption && selectedRoomServiceOption.dataset.price) {
                roomServicePrice = parseFloat(selectedRoomServiceOption.dataset.price);
            }

            // Get food service prices
            foodServiceInputs.forEach(input => {
                if (input.checked && input.dataset.price) {
                    foodServicePrice += parseFloat(input.dataset.price);
                }
            });

            // Calculate number of nights
            let numberOfNights = 1;
            const checkinDate = new Date(checkinDateInput.value);
            const checkoutDate = new Date(checkoutDateInput.value);
            if (checkinDateInput.value && checkoutDateInput.value) {
                const timeDiff = checkoutDate.getTime() - checkinDate.getTime();
                numberOfNights = Math.max(1, Math.ceil(timeDiff / (1000 * 3600 * 24)));
            }
            
            const finalRoomPrice = roomPrice * numberOfNights;
            const totalServicePrice = roomServicePrice + foodServicePrice;
            const totalAmount = finalRoomPrice + totalServicePrice;

            // Update summary
            summaryRoomName.textContent = roomName;
            summaryRoomPrice.textContent = finalRoomPrice.toFixed(2);
            summaryServicesPrice.textContent = totalServicePrice.toFixed(2);
            summaryTotalAmount.textContent = totalAmount.toFixed(2);
            
            totalAmountInput.value = totalAmount.toFixed(2);
        }

        roomRadios.forEach(radio => {
            radio.addEventListener('change', function() {
                document.querySelectorAll('.card-room-selection').forEach(card => card.classList.remove('active'));
                this.closest('.card-room-selection').classList.add('active');
                calculateTotalAmount();
            });
        });

        roomServiceSelect.addEventListener('change', calculateTotalAmount);
        foodServiceInputs.forEach(input => input.addEventListener('change', calculateTotalAmount));
        checkinDateInput.addEventListener('change', calculateTotalAmount);
        checkoutDateInput.addEventListener('change', calculateTotalAmount);

        calculateTotalAmount();
    });
</script>
</body>
</html>