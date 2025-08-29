<?php
// config.php ফাইলটি অন্তর্ভুক্ত করা হচ্ছে।
include("config.php");
if (!isset($conn)) {
    header("location:login.php");
    exit();
}

// ফলাফল বার্তা সংরক্ষণের জন্য একটি ভেরিয়েবল।
$r = "";

// যদি ডিলিট বাটন ক্লিক করা হয়।
if (isset($_POST["btnDelete"])) {
    $u_id = $_POST["txtId"];
    
    // ডেটাবেজ থেকে booking ডিলিট করার কোয়েরি।
    $sql = "DELETE FROM `booking` WHERE id = '$u_id'";
    $result = $conn->query($sql);

    // কোয়েরি সফল হয়েছে কিনা যাচাই করা হচ্ছে।
    if ($result === TRUE) {
        $r = "<div class='alert alert-success'>Booking deleted successfully.</div>";
    } else {
        $r = "<div class='alert alert-danger'>Error deleting record: " . $conn->error . "</div>";
    }
}
?>

<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Manage Bookings</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Manage Bookings</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Manage Bookings</h3>
            </div>

            <div class="p-3">
                <?php echo $r; ?>
            </div>

            <div class="card-body">
                <div class="card">
                    <div class="card-body">
                        <table class="table table-striped table-bordered">
                            <thead class="bg-primary text-white">
                                <tr>
                                    <th>#ID</th>
                                    <th>User</th>
                                    <th>Room</th>
                                    <th>Booking Date</th>
                                    <th>Check-in Date</th>
                                    <th>Check-out Date</th>
                                    <th>Payment Status</th>
                                    <th>Total Amount</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                // ডেটাবেজ থেকে সমস্ত booking ডেটা লোড করার কোয়েরি।
                                // 'firstname' এবং 'lastname' ব্যবহার করে পুরো নাম তৈরি করা হয়েছে।
                                $sql = "SELECT b.id, b.booking_date, b.checkin_date, b.checkout_date, b.payment_status, b.total_amount,
                                        CONCAT(u.firstname, ' ', u.lastname) AS user_name, r.room_number
                                        FROM `booking` AS b
                                        LEFT JOIN `users` AS u ON b.users_id = u.id
                                        LEFT JOIN `room` AS r ON b.room_id = r.id
                                        ORDER BY b.id DESC";

                                $bookings = $conn->query($sql);
                                while ($row = $bookings->fetch_assoc()) {
                                    $user_name = $row['user_name'] ? htmlspecialchars($row['user_name']) : 'N/A';
                                    $room_number = $row['room_number'] ? htmlspecialchars($row['room_number']) : 'N/A';

                                    echo "<tr> 
                                            <td>" . htmlspecialchars($row['id']) . "</td>
                                            <td>" . $user_name . "</td>
                                            <td>" . $room_number . "</td>
                                            <td>" . htmlspecialchars($row['booking_date']) . "</td>
                                            <td>" . htmlspecialchars($row['checkin_date']) . "</td>
                                            <td>" . htmlspecialchars($row['checkout_date']) . "</td>
                                            <td>" . htmlspecialchars($row['payment_status']) . "</td>
                                            <td>$" . htmlspecialchars($row['total_amount']) . "</td>
                                            <td> 
                                                <div class='d-flex align-items-center'>
                                                    <form action='' method='post' onsubmit='return confirm(\"Are you sure you want to delete this booking?\");' style='margin-right: 15px;'>
                                                        <input type='hidden' name='txtId' value='" . htmlspecialchars($row['id']) . "' />
                                                        <button type='submit' name='btnDelete' class='btn btn-danger btn-sm' title='Delete'>
                                                            <i class='fas fa-trash'></i>
                                                        </button>
                                                    </form>
                                                    <a href='home.php?page=27&id=" . htmlspecialchars($row['id']) . "' class='btn btn-primary btn-sm' title='Edit'>
                                                        <i class='fas fa-edit'></i>
                                                    </a>
                                                </div>
                                            </td>
                                          </tr>";
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
