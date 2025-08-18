<?php
// config.php ফাইলটি অন্তর্ভুক্ত করা হচ্ছে যেখানে ডেটাবেজ সংযোগ আছে।
include("config.php");
// যদি ডেটাবেজ সংযোগ না থাকে, তবে ব্যবহারকারীকে login.php তে পুনঃনির্দেশ করা হচ্ছে।
if (!isset($conn)) {
    header("location:login.php");
    exit();
}

// ফলাফল বার্তা সংরক্ষণের জন্য একটি ভেরিয়েবল।
$r = "";

// যদি ফর্মটি জমা দেওয়া হয় (সাবমিট বাটনে ক্লিক করা হয়)।
if (isset($_POST["submit"])) {
    // ব্যবহারকারীর ইনপুট SQL ইনজেকশন থেকে সুরক্ষার জন্য স্যানিটাইজ করা হচ্ছে।
    $service_name = mysqli_real_escape_string($conn, $_POST['service_name']);
    $price = mysqli_real_escape_string($conn, $_POST['price']);

    // ডেটাবেজে নতুন ডেটা ইনসার্ট করার জন্য SQL কোয়েরি।
    $sql = "INSERT INTO `room_service` (service_name, price) VALUES ('$service_name', '$price')";

    // কোয়েরিটি চালানো হচ্ছে এবং সফল কিনা তা যাচাই করা হচ্ছে।
    if ($conn->query($sql) === TRUE) {
        $r = "<div class='alert alert-success'>Room Service added successfully.</div>";
    } else {
        $r = "<div class='alert alert-danger'>Error: " . $conn->error . "</div>";
    }
}
?>

<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Add Room Service</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Add Room Service</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Add New Room Service</h3>
            </div>
            <div class="card-body">
                <div class="p-3">
                    <?php echo $r; ?>
                </div>
                <form action="" method="post">
                    <div class="form-group">
                        <label for="service_name">Service Name</label>
                        <input type="text" class="form-control" name="service_name" required>
                    </div>
                    <div class="form-group">
                        <label for="price">Price</label>
                        <input type="number" step="0.01" class="form-control" name="price" required>
                    </div>
                    <button type="submit" name="submit" class="btn btn-primary">Save</button>
                    <a href="home.php?page=9" class="btn btn-secondary">Cancel</a>
                </form>
            </div>
        </div>
    </section>
</div>
