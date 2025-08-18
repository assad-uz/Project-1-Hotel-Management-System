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
    
    // ডেটাবেজ থেকে food_service ডিলিট করার কোয়েরি।
    $sql = "DELETE FROM `food_service` WHERE id = '$u_id'";
    $result = $conn->query($sql);

    // কোয়েরি সফল হয়েছে কিনা যাচাই করা হচ্ছে।
    if ($result === TRUE) {
        $r = "<div class='alert alert-success'>Food Service deleted successfully.</div>";
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
                    <h1>Manage Food Services</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Manage Food Services</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Manage Food Services</h3>
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
                                    <th>Meal Type</th>
                                    <th>Meal Period</th>
                                    <th>Price</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                // ডেটাবেজ থেকে সমস্ত ফুড সার্ভিস ডেটা লোড করার কোয়েরি।
                                $sql = "SELECT fs.id, mt.type_name, mp.period_name, fs.price FROM `food_service` AS fs
                                        INNER JOIN `meal_type` AS mt ON fs.meal_type_id = mt.id
                                        INNER JOIN `meal_period` AS mp ON fs.meal_period_id = mp.id
                                        ORDER BY fs.id DESC";

                                $food_services = $conn->query($sql);
                                while ($row = $food_services->fetch_assoc()) {
                                    echo "<tr> 
                                            <td>" . htmlspecialchars($row['id']) . "</td>
                                            <td>" . htmlspecialchars($row['type_name']) . "</td>
                                            <td>" . htmlspecialchars($row['period_name']) . "</td>
                                            <td>" . htmlspecialchars($row['price']) . "</td>
                                            <td> 
                                                <div class='d-flex align-items-center'>
                                                    <form action='' method='post' onsubmit='return confirm(\"Are you sure you want to delete this food service?\");' style='margin-right: 15px;'>
                                                        <input type='hidden' name='txtId' value='" . htmlspecialchars($row['id']) . "' />
                                                        <button type='submit' name='btnDelete' class='btn btn-danger btn-sm' title='Delete'>
                                                            <i class='fas fa-trash'></i>
                                                        </button>
                                                    </form>
                                                    <a href='home.php?page=12&id=" . htmlspecialchars($row['id']) . "' class='btn btn-primary btn-sm' title='Edit'>
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
