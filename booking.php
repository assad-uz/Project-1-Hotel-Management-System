<?php
// PHP সেশন শুরু করুন
session_start();

// ব্যবহারকারী লগইন করেছেন কিনা তা যাচাই করুন
// যদি সেশনে user_id না থাকে, তবে তাকে লগইন পেজে রিডাইরেক্ট করুন
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// লগইন করা ব্যবহারকারীর আইডি এবং ইউজারনেম সেশন থেকে নিন
$user_id = $_SESSION['user_id'];
$user_name = $_SESSION['user_name'];

// আপনার ডেটাবেস সংযোগের তথ্য
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "your_database_name"; // আপনার ডেটাবেসের নাম এখানে দিন

// ডেটাবেস সংযোগ স্থাপন
$conn = new mysqli($servername, $username, $password, $dbname);

// সংযোগ সফল হয়েছে কিনা পরীক্ষা করুন
if ($conn->connect_error) {
    die("সংযোগ ব্যর্থ হয়েছে: " . $conn->connect_error);
}

// বুকিং স্ট্যাটাস মেসেজ
$booking_status_message = '';

// --- ড্রপ-ডাউন এবং চেকবক্সের জন্য ডেটাবেস থেকে তথ্য আনুন ---
// ধরে নেওয়া হচ্ছে আপনার 'rooms' এবং 'services' নামে টেবিল আছে

// রুম টাইপ ডেটা
$room_types = [];
$sql_rooms = "SELECT id, room_name FROM rooms ORDER BY room_name ASC";
$result_rooms = $conn->query($sql_rooms);
if ($result_rooms->num_rows > 0) {
    while($row = $result_rooms->fetch_assoc()) {
        $room_types[] = $row;
    }
}

// পরিষেবা (Services) ডেটা
$services = [];
$sql_services = "SELECT id, service_name FROM services ORDER BY service_name ASC";
$result_services = $conn->query($sql_services);
if ($result_services->num_rows > 0) {
    while($row = $result_services->fetch_assoc()) {
        $services[] = $row;
    }
}

// --- ফর্ম সাবমিশন হ্যান্ডেল করুন ---
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $room_id = $conn->real_escape_string($_POST['room_id']);
    $check_in_date = $conn->real_escape_string($_POST['check_in_date']);
    $check_out_date = $conn->real_escape_string($_POST['check_out_date']);

    // যদি রুম ID এবং তারিখ বৈধ হয় তবে বুকিং টেবিলে ডেটা ঢোকান
    if (!empty($room_id) && !empty($check_in_date) && !empty($check_out_date)) {
        // SQL ইনসার্ট কোয়েরি
        // বুকিং টেবিলের কলামগুলো আপনার ডেটাবেস অনুযায়ী পরিবর্তন করুন
        $sql_insert_booking = "INSERT INTO booking (users_id, room_id, booking_date, checkin_date, checkout_date)
                               VALUES ('$user_id', '$room_id', NOW(), '$check_in_date', '$check_out_date')";

        if ($conn->query($sql_insert_booking) === TRUE) {
            $booking_status_message = "<div class='alert alert-success mt-3' role='alert'>বুকিং সফল হয়েছে, " . htmlspecialchars($user_name) . "!</div>";
        } else {
            $booking_status_message = "<div class='alert alert-danger mt-3' role='alert'>বুকিং ব্যর্থ হয়েছে: " . $conn->error . "</div>";
        }
    } else {
        $booking_status_message = "<div class='alert alert-warning mt-3' role='alert'>অনুগ্রহ করে সমস্ত প্রয়োজনীয় ফিল্ড পূরণ করুন।</div>";
    }
}

// লগআউট হ্যান্ডেল করুন
if (isset($_GET['logout'])) {
    session_destroy();
    header("Location: login.php");
    exit();
}

?>

<!DOCTYPE html>
<html lang="bn">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>রুম বুকিং</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #f8f9fa; }
        .container { max-width: 900px; }
        .card { border-radius: 15px; }
    </style>
</head>
<body>

<div class="container my-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="text-center">স্বাগতম, <?php echo htmlspecialchars($user_name); ?>!</h2>
        <a href="?logout" class="btn btn-outline-danger">লগআউট</a>
    </div>

    <h3 class="text-center mb-4">আপনার রুম বুক করুন</h3>
    <?php echo $booking_status_message; ?>

    <!-- বুকিং ফর্ম -->
    <form method="post" action="booking.php">
        <div class="card p-4 shadow-sm">
            <!-- রুম টাইপ ড্রপ-ডাউন -->
            <div class="mb-3">
                <label for="room_id" class="form-label">রুমের ধরন</label>
                <select class="form-select" id="room_id" name="room_id" required>
                    <option value="">একটি রুম নির্বাচন করুন</option>
                    <?php foreach ($room_types as $room): ?>
                        <option value="<?php echo $room['id']; ?>"><?php echo htmlspecialchars($room['room_name']); ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <!-- পরিষেবা (Services) চেকবক্স -->
            <div class="mb-3">
                <p class="form-label">অতিরিক্ত পরিষেবা:</p>
                <?php foreach ($services as $service): ?>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="service_<?php echo $service['id']; ?>" name="services[]" value="<?php echo $service['id']; ?>">
                    <label class="form-check-label" for="service_<?php echo $service['id']; ?>">
                        <?php echo htmlspecialchars($service['service_name']); ?>
                    </label>
                </div>
                <?php endforeach; ?>
            </div>
            
            <!-- চেক-ইন এবং চেক-আউট তারিখ -->
            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="check_in_date" class="form-label">চেক-ইন তারিখ</label>
                    <input type="date" class="form-control" id="check_in_date" name="check_in_date" required>
                </div>
                <div class="col-md-6">
                    <label for="check_out_date" class="form-label">চেক-আউট তারিখ</label>
                    <input type="date" class="form-control" id="check_out_date" name="check_out_date" required>
                </div>
            </div>

            <!-- সাবমিট বাটন -->
            <button type="submit" class="btn btn-primary btn-lg w-100">বুকিং নিশ্চিত করুন</button>
        </div>
    </form>

    <hr class="my-5">

    <!-- ব্যবহারকারীর বুকিংয়ের তালিকা -->
    <h3 class="text-center mb-3">আপনার বুকিংয়ের তালিকা</h3>
    <div class="table-responsive">
        <?php
        // লগইন করা ব্যবহারকারীর বুকিং দেখান
        $sql_select = "SELECT b.id, r.room_name, b.checkin_date, b.checkout_date, b.booking_date
                       FROM booking b
                       INNER JOIN rooms r ON b.room_id = r.id
                       WHERE b.users_id = '$user_id'
                       ORDER BY b.id DESC";
        $result = $conn->query($sql_select);

        if ($result->num_rows > 0) {
            echo "<table class='table table-striped table-bordered'>";
            echo "<thead class='table-dark'><tr><th>বুকিং আইডি</th><th>রুম</th><th>চেক-ইন</th><th>চেক-আউট</th><th>বুকিং সময়</th></tr></thead><tbody>";
            while($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row['id'] . "</td>";
                echo "<td>" . htmlspecialchars($row['room_name']) . "</td>";
                echo "<td>" . htmlspecialchars($row['checkin_date']) . "</td>";
                echo "<td>" . htmlspecialchars($row['checkout_date']) . "</td>";
                echo "<td>" . htmlspecialchars($row['booking_date']) . "</td>";
                echo "</tr>";
            }
            echo "</tbody></table>";
        } else {
            echo "<p class='text-muted text-center'>আপনার কোনো বুকিং নেই।</p>";
        }
        ?>
    </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
<?php
// সংযোগ বন্ধ করুন
$conn->close();
?>
