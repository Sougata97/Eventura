<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: user_login.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking Confirmation</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <?php include 'navigation.php'; ?>

    <div class="container">
        <h1>Booking Confirmed</h1>
        <p>Thank you for booking! We look forward to seeing you at the event.</p>
        <a href="index.php">Go Back to Home</a>
    </div>
</body>
</html>
