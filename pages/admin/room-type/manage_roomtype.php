<?php
include("config.php");

$r = "";

// Delete room type
if (isset($_POST["btnDelete"])) {
    $room_id = $_POST["txtId"];
    $sql = "DELETE FROM room_type WHERE id = '$room_id'";
    if ($conn->query($sql) === TRUE) {
        $r = "<div class='alert alert-success'>Room type deleted successfully.</div>";
    } else {
        $r = "<div class='alert alert-danger'>Error deleting record: " . $conn->error . "</div>";
    }
}
?>

<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <h1>Manage Room Types</h1>
        </div>
    </section>

    <section class="content">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h3 class="card-title">Room Type List</h3>
            </div>

            <div class="p-3">
                <?php echo $r; ?>
            </div>

            <div class="card-body">
                <table class="table table-striped table-bordered">
                    <thead class="bg-primary text-white">
                        <tr>
                            <th>#ID</th>
                            <th>Room Name</th>
                            <th>Price</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $room_types = $conn->query("SELECT id, room_name, price FROM room_type");
                        while ($room = $room_types->fetch_assoc()) {
                            echo "<tr>
                                <td>{$room['id']}</td>
                                <td>{$room['room_name']}</td>
                                <td>{$room['price']}</td>
                                <td>
                                    <div class='d-flex align-items-center'>
                                        <form action='' method='post' onsubmit='return confirm(\"Are you sure you want to delete this room type?\");' style='margin-right: 10px;'>
                                            <input type='hidden' name='txtId' value='{$room['id']}' />
                                            <button type='submit' name='btnDelete' class='btn btn-danger btn-sm' title='Delete'>
                                                <i class='fas fa-trash'></i>
                                            </button>
                                        </form>
                                        <a href='home.php?page=12&id={$room['id']}' class='btn btn-primary btn-sm' title='Edit'>
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
