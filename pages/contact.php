<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
// Include PHPMailer for SMTP
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../vendor/autoload.php'; // Path to PHPMailer autoload file

include '../includes/header.php';

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name = htmlspecialchars($_POST['name'] ?? '');
    $email = htmlspecialchars($_POST['email'] ?? '');
    $mobile = htmlspecialchars($_POST['mobile'] ?? '');
    $message = htmlspecialchars($_POST['message'] ?? '');
    $captcha = $_POST['g-recaptcha-response'] ?? ''; // Captcha response

    // Verify reCAPTCHA
    $secretKey = '6LcXH4IqAAAAAMF19-sKs_lFbnx_cTwYGsaArafr'; // Your reCAPTCHA Secret Key
    $response = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=$secretKey&response=$captcha");
    $responseKeys = json_decode($response, true);

    if ($responseKeys['success']) {
        // Create a new PHPMailer instance
        $mail = new PHPMailer(true);

        try {
            // SMTP configuration
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com'; // Your SMTP server
            $mail->SMTPAuth = true;
            $mail->Username = 'sougatamukherjee504@gmail.com'; // Your SMTP email
            $mail->Password = 'xqdz hobn titd sgio'; // Your SMTP email password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;

            // Email details
            $mail->setFrom($email, $name); // Sender's email and name
            $mail->addAddress('sougatamukherjee504@gmail.com', 'Eventura Contact Form'); // Your email
            $mail->Subject = 'Eventura New Contact Form Submission';
            $mail->isHTML(true);
            $mail->Body = "
                <h2>Contact Form Submission</h2>
                <p><strong>Name:</strong> $name</p>
                <p><strong>Email:</strong> $email</p>
                <p><strong>Mobile:</strong> $mobile</p>
                <p><strong>Message:</strong></p>
                <p>$message</p>
            ";

            // Send the email
            if ($mail->send()) {
                $successMessage = "Your message has been sent successfully!";
            } else {
                $errorMessage = "Failed to send your message. Please try again.";
            }
        } catch (Exception $e) {
            $errorMessage = "Message could not be sent. Error: {$mail->ErrorInfo}";
        }
    } else {
        $errorMessage = "Please verify that you are not a robot.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us</title>
    <link rel="stylesheet" href="../styles/style.css">
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    <style>
        .contact-banner {
            color: white;
            padding: 100px 20px;
            text-align: center;
        }

        .contact-banner h1 {
            font-size: 3em;
            margin: 0;
        }

        .contact-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            margin: 50px auto;
            width: 90%;
            max-width: 1200px;
        }

        .contact-form {
            flex: 1;
            max-width: 600px;
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            margin-right: 20px;
        }

        .contact-form h2 {
            margin-bottom: 20px;
            font-size: 24px;
            color: #333;
        }

        .contact-form input,
        .contact-form textarea {
            width: 100%;
            padding: 15px;
            margin-bottom: 15px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 16px;
            outline: none;
        }

        .contact-form textarea {
            resize: none;
            height: 120px;
        }

        .contact-form button {
            background: #ff007f;
            color: white;
            border: none;
            padding: 15px 20px;
            font-size: 16px;
            border-radius: 5px;
            cursor: pointer;
            transition: background 0.3s;
        }

        .contact-form button:hover {
            background: #e60072;
        }

        .contact-details {
            flex: 1;
            max-width: 400px;
            padding: 30px;
            background: white;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        .contact-details h3 {
            margin-bottom: 15px;
            font-size: 20px;
            color: #333;
        }

        .contact-details p {
            margin-bottom: 10px;
            font-size: 16px;
            color: #555;
        }

        .contact-details .social-icons {
            display: flex;
            margin-top: 20px;
        }

        .contact-details .social-icons a {
            display: inline-block;
            margin-right: 15px;
            font-size: 24px;
            color: #333;
            transition: color 0.3s;
        }

        .contact-details .social-icons a:hover {
            color: #4a90e2;
        }
    </style>
</head>
<body>
    <div class="contact-banner">
        <h1>Contact Us</h1>
    </div>

    <div class="contact-container">
        <!-- Contact Form -->
        <div class="contact-form">
            <h2>Get in Touch</h2>
            <?php if (isset($successMessage)): ?>
                <p style="color: green;"><?php echo $successMessage; ?></p>
            <?php elseif (isset($errorMessage)): ?>
                <p style="color: red;"><?php echo $errorMessage; ?></p>
            <?php endif; ?>

            <form method="post">
                <input type="text" name="name" placeholder="Your Name" required>
                <input type="email" name="email" placeholder="Your Email" required>
                <input type="text" name="mobile" placeholder="Your Mobile Number" required>
                <textarea name="message" placeholder="Your Message" required></textarea>
                <div class="g-recaptcha" data-sitekey="6LcXH4IqAAAAAOIOMjyJhRCm5OEQLrKlzhebs4aF"></div>
                <button type="submit">Send Message</button>
            </form>
        </div>

        <!-- Contact Details -->
        <div class="contact-details">
            <h3>Contact Information</h3>
            <p><strong>Email:</strong> info@eventura.com</p>
            <p><strong>Phone:</strong> +123 456 7890</p>
            <p><strong>Address:</strong> 123 Eventura Street, City, Country</p>
            <h3>Map</h3>
            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3687.6191877399447!2d88.41285357475343!3d22.443354637696046!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3a0272166e4cb263%3A0x27f12170efd9ddee!2sFuture%20Institute%20of%20Engineering%20and%20Management!5e0!3m2!1sen!2sin!4v1731876682474!5m2!1sen!2sin" width="100%" height="300" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
        </div>
    </div>
</body>
</html>

<?php include '../includes/footer.php'; ?>
