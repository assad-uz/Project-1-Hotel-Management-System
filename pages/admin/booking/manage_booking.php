<?php
include("config.php");

$r = "";

// Delete booking
if (isset($_POST["btnDelete"])) {
    $booking_id = $_POST["txtId"];
    $sql = "DELETE FROM booking WHERE id = '$booking_id'";
    if ($conn->query($sql) === TRUE) {
        $r = "<div class='alert alert-success'>Booking deleted successfully.</div>";
    } else {
        $r = "<div class='alert alert-danger'>Error deleting record: " . $conn->error . "</div>";
    }
}
?>

<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <h1>Manage Bookings</h1>
        </div>
    </section>

    <section class="content">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h3 class="card-title">Booking List</h3>
            </div>

            <div class="p-3">
                <?php echo $r; ?>
            </div>

            <div class="card-body">
                <table class="table table-striped table-bordered">
                    <thead class="bg-primary text-white">
                        <tr>
                            <th>#ID</th>
                            <th>User</th>
                            <th>Room Type</th>
                            <th>Booking Date</th>
                            <th>Total Amount</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $bookings = $conn->query("SELECT b.id, u.firstname, u.lastname, r.room_name, b.booking_date, b.total_amount FROM booking b
                                                  JOIN users u ON b.users_id = u.id
                                                  JOIN room_type r ON b.room_type_id = r.id");
                        while ($booking = $bookings->fetch_assoc()) {
                            echo "<tr>
                                <td>{$booking['id']}</td>
                                <td>{$booking['firstname']} {$booking['lastname']}</td>
                                <td>{$booking['room_name']}</td>
                                <td>{$booking['booking_date']}</td>
                                <td>{$booking['total_amount']}</td>
                                <td>
                                    <div class='d-flex align-items-center'>
                                        <form action='' method='post' onsubmit='return confirm(\"Are you sure you want to delete this booking?\");' style='margin-right: 10px;'>
                                            <input type='hidden' name='txtId' value='{$booking['id']}' />
                                            <button type='submit' name='btnDelete' class='btn btn-danger btn-sm' title='Delete'>
                                                <i class='fas fa-trash'></i>
                                            </button>
                                        </form>
                                        <a href='home.php?page=6&id={$booking['id']}' class='btn btn-primary btn-sm' title='Edit'>
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
    </section>
</div>
