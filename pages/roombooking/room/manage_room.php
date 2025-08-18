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
    
    // ডেটাবেজ থেকে room ডিলিট করার কোয়েরি।
    $sql = "DELETE FROM `room` WHERE id = '$u_id'";
    $result = $conn->query($sql);

    // কোয়েরি সফল হয়েছে কিনা যাচাই করা হচ্ছে।
    if ($result === TRUE) {
        $r = "<div class='alert alert-success'>Room deleted successfully.</div>";
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
                    <h1>Manage Rooms</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Manage Rooms</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Manage Rooms</h3>
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
                                    <th>Room Number</th>
                                    <th>Room Type</th>
                                    <th>Room Type Price</th>
                                    <th>Service</th>
                                    <th>Service Price</th>
                                    <th>Total Price</th>
                                    <th>Status</th>
                                    <th>Description</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                // ডেটাবেজ থেকে সমস্ত room ডেটা লোড করার কোয়েরি।
                                $sql = "SELECT r.id, r.room_number, r.room_type_price, r.service_price, r.total_price, r.room_status, r.description,
                                        rt.room_name, s.total_service_price
                                        FROM `room` AS r
                                        LEFT JOIN `room_type` AS rt ON r.room_type_id = rt.id
                                        LEFT JOIN `service` AS s ON r.service_id = s.id
                                        ORDER BY r.id DESC";

                                $rooms = $conn->query($sql);
                                while ($row = $rooms->fetch_assoc()) {
                                    $room_type_name = $row['room_name'] ? htmlspecialchars($row['room_name']) : 'N/A';
                                    $service_name = $row['total_service_price'] ? 'Service ID ' . htmlspecialchars($row['service_id']) : 'N/A';
                                    $service_price = $row['service_price'] ? '$' . htmlspecialchars($row['service_price']) : 'N/A';
                                    
                                    echo "<tr> 
                                            <td>" . htmlspecialchars($row['id']) . "</td>
                                            <td>" . htmlspecialchars($row['room_number']) . "</td>
                                            <td>" . $room_type_name . "</td>
                                            <td>$" . htmlspecialchars($row['room_type_price']) . "</td>
                                            <td>" . $service_name . "</td>
                                            <td>" . $service_price . "</td>
                                            <td>$" . htmlspecialchars($row['total_price']) . "</td>
                                            <td>" . htmlspecialchars($row['room_status']) . "</td>
                                            <td>" . htmlspecialchars($row['description']) . "</td>
                                            <td> 
                                                <div class='d-flex align-items-center'>
                                                    <form action='' method='post' onsubmit='return confirm(\"Are you sure you want to delete this room?\");' style='margin-right: 15px;'>
                                                        <input type='hidden' name='txtId' value='" . htmlspecialchars($row['id']) . "' />
                                                        <button type='submit' name='btnDelete' class='btn btn-danger btn-sm' title='Delete'>
                                                            <i class='fas fa-trash'></i>
                                                        </button>
                                                    </form>
                                                    <a href='home.php?page=20&id=" . htmlspecialchars($row['id']) . "' class='btn btn-primary btn-sm' title='Edit'>
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
