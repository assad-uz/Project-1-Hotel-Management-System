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
    
    // ডেটাবেজ থেকে service ডিলিট করার কোয়েরি।
    $sql = "DELETE FROM `service` WHERE id = '$u_id'";
    $result = $conn->query($sql);

    // কোয়েরি সফল হয়েছে কিনা যাচাই করা হচ্ছে।
    if ($result === TRUE) {
        $r = "<div class='alert alert-success'>Service deleted successfully.</div>";
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
                    <h1>Manage Services</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Manage Services</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Manage Services</h3>
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
                                    <th>Room Service</th>
                                    <th>Room Service Price</th>
                                    <th>Food Service</th>
                                    <th>Food Service Price</th>
                                    <th>Total Price</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                // ডেটাবেজ থেকে সমস্ত সার্ভিস ডেটা লোড করার কোয়েরি।
                                $sql = "SELECT s.id, rs.service_name AS room_service_name, s.room_service_price, 
                                        mt.type_name, mp.period_name, s.food_service_price, s.total_service_price
                                        FROM `service` AS s
                                        LEFT JOIN `room_service` AS rs ON s.room_service_id = rs.id
                                        LEFT JOIN `food_service` AS fs ON s.food_service_id = fs.id
                                        LEFT JOIN `meal_type` AS mt ON fs.meal_type_id = mt.id
                                        LEFT JOIN `meal_period` AS mp ON fs.meal_period_id = mp.id
                                        ORDER BY s.id DESC";

                                $services = $conn->query($sql);
                                while ($row = $services->fetch_assoc()) {
                                    $room_service_name = $row['room_service_name'] ? htmlspecialchars($row['room_service_name']) : 'N/A';
                                    $room_service_price = $row['room_service_price'] ? '$' . htmlspecialchars($row['room_service_price']) : 'N/A';
                                    $food_service_name = ($row['type_name'] && $row['period_name']) ? htmlspecialchars($row['type_name'] . ' (' . $row['period_name'] . ')') : 'N/A';
                                    $food_service_price = $row['food_service_price'] ? '$' . htmlspecialchars($row['food_service_price']) : 'N/A';
                                    $total_price_formatted = $row['total_service_price'] ? '$' . htmlspecialchars($row['total_service_price']) : 'N/A';

                                    echo "<tr> 
                                            <td>" . htmlspecialchars($row['id']) . "</td>
                                            <td>" . $room_service_name . "</td>
                                            <td>" . $room_service_price . "</td>
                                            <td>" . $food_service_name . "</td>
                                            <td>" . $food_service_price . "</td>
                                            <td>" . $total_price_formatted . "</td>
                                            <td> 
                                                <div class='d-flex align-items-center'>
                                                    <form action='' method='post' onsubmit='return confirm(\"Are you sure you want to delete this service?\");' style='margin-right: 15px;'>
                                                        <input type='hidden' name='txtId' value='" . htmlspecialchars($row['id']) . "' />
                                                        <button type='submit' name='btnDelete' class='btn btn-danger btn-sm' title='Delete'>
                                                            <i class='fas fa-trash'></i>
                                                        </button>
                                                    </form>
                                                    <a href='home.php?page=14&id=" . htmlspecialchars($row['id']) . "' class='btn btn-primary btn-sm' title='Edit'>
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
