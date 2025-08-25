<?php
// ফলাফল বার্তা সংরক্ষণের জন্য একটি ভেরিয়েবল।
$response_message = "";

// যদি ফর্মটি POST মেথড ব্যবহার করে জমা দেওয়া হয়।
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // ফর্ম ডেটা স্যানিটাইজ করা হচ্ছে।
    $name = strip_tags(trim($_POST["name"]));
    $name = str_replace(array("\r","\n"),array(" "," "),$name);
    $email = filter_var(trim($_POST["email"]), FILTER_SANITIZE_EMAIL);
    $subject = strip_tags(trim($_POST["subject"]));
    $message = trim($_POST["message"]);

    // যাচাই করা হচ্ছে যে ডেটা খালি নয়।
    if (empty($name) OR empty($subject) OR empty($message) OR !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $response_message = "<div class='alert alert-danger'>Please fill out the form completely.</div>";
    } else {

        // আপনার ইমেল ঠিকানা এখানে দিন।
        $recipient = "your-email@example.com";

        // ইমেলের বিষয়।
        $email_subject = "New Contact Message: $subject";

        // ইমেলের কন্টেন্ট।
        $email_content = "Name: $name\n";
        $email_content .= "Email: $email\n\n";
        $email_content .= "Message:\n$message\n";

        // ইমেলের হেডার।
        $email_headers = "From: $name <$email>";

        // ইমেল পাঠানো হচ্ছে।
        if (mail($recipient, $email_subject, $email_content, $email_headers)) {
            $response_message = "<div class='alert alert-success'>Your message has been sent successfully!</div>";
        } else {
            $response_message = "<div class='alert alert-danger'>There was an issue sending your message. Please try again later.</div>";
        }
    }
}
?>

<!-- Contact Section -->
<section class="contact-section">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="contact-form">
                    <h2 class="text-center mb-4">Contact Us</h2>
                    <div id="form-message">
                        <?php echo $response_message; ?>
                    </div>
                    <form action="" method="POST">
                        <div class="form-group">
                            <label for="name">Your Name:</label>
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>
                        <div class="form-group">
                            <label for="email">Your Email:</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>
                        <div class="form-group">
                            <label for="subject">Subject:</label>
                            <input type="text" class="form-control" id="subject" name="subject" required>
                        </div>
                        <div class="form-group">
                            <label for="message">Your Message:</label>
                            <textarea class="form-control" id="message" name="message" rows="5" required></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary btn-block">Send Message</button>
                    </form>
                </div>
            </div>
            <div class="col-lg-4 mt-4 mt-lg-0">
                <div class="contact-info">
                    <h3>Contact Information</h3>
                    <p><i class="fas fa-map-marker-alt icon"></i> 19/B Road, Dhanmondi, Dhaka, Bangladesh</p>
                    <p><i class="fas fa-envelope icon"></i> info@hotelhorizon.com</p>
                    <p><i class="fas fa-phone-alt icon"></i> +880 1234 567890</p>
                </div>
            </div>
        </div>
    </div>
</section>
