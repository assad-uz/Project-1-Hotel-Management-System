<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact & Location</title>
    <!-- Bootstrap 5 CSS CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons CDN -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    
    <style>
        /* ফন্টের জন্য Google Fonts ব্যবহার করুন */
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;700&display=swap');
        
        body {
            font-family: 'Inter', sans-serif;
        }

        /* ফুটারকে নিচে রাখার জন্য মূল কন্টেইনারের স্টাইল */
        .page-container {
            display: flex;
            flex-direction: column;
            min-height: 100vh; /* ন্যূনতম স্ক্রিন উচ্চতা নিশ্চিত করে */
            background-color: #f8f9fa; /* Bootstrap's bg-light color */
        }
        
        /* কন্টেন্টকে ফুটারের উপরে ঠেলে দেওয়ার জন্য */
        .content-wrap {
            flex-grow: 1;
            display: flex; /* ফ্ল্যাক্সবক্স ব্যবহার করে কন্টেন্টকে মাঝখানে আনা হয়েছে */
            align-items: center; /* উল্লম্বভাবে মাঝ বরাবর */
            justify-content: center; /* অনুভূমিকভাবে মাঝ বরাবর */
            padding-top: 3rem;
            padding-bottom: 3rem;
        }
    </style>
</head>
<body>

    <div class="page-container">
        
        <!-- Header -->
        <header>
            <?php require_once("include/header.php"); ?>
            <?php require_once("include/navbar.php"); ?>
        </header>

        <!-- Main Content Section -->
        <main class="content-wrap">
            <section id="contact">
                <div class="container">
                    <div class="row align-items-center">

                        <!-- Contact Image -->
                        <div class="col-md-6 text-center mb-4 mb-md-0">
                            <img src="dist/images/contact1.jpg" alt="Hotel Image" class="img-fluid rounded shadow">
                            <!-- এখানে তোমার হোটেলের আসল ইমেজ path দাও -->
                        </div>

                        <!-- Contact Details -->
                        <div class="col-md-6">
                            <h2 class="mb-4">Contact Us</h2>
                            <hr>
                            <p class="mb-2"><strong>Hotel Horizon</strong></p>
                            <p class="mb-2"><i class="bi bi-geo-alt-fill text-primary"></i> 123 Main Street, Dhaka, Bangladesh</p>
                            <p class="mb-2"><i class="bi bi-telephone-fill text-primary"></i> +880 1234-567890</p>
                            <p class="mb-2"><i class="bi bi-envelope-fill text-primary"></i> info@hotelhorizon.com</p>
                            <p>
                                We are always here to help you. Feel free to reach out 
                                for reservations, support, or any queries.
                            </p>
                        </div>
                    </div>
                </div>
            </section>
        </main>

        <!-- Footer -->
        <?php require_once("include/footer.php"); ?>
        
    </div>
</body>
</html>
