<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

include '../includes/db.php';

if (!isset($_GET['id'])) {
    header('Location: index.php');
    exit();
}

$event_id = $_GET['id'];

$stmt = $pdo->prepare("SELECT * FROM events WHERE id = ?");
$stmt->execute([$event_id]);
$event = $stmt->fetch();

if (!$event) {
    echo 'Event not found.';
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_id = $_SESSION['user_id'];
    $stmt = $pdo->prepare("INSERT INTO bookings (user_id, event_id) VALUES (?, ?)");
    $stmt->execute([$user_id, $event_id]);

    header('Location: booking_confirmation.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Event</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <?php include 'navigation.php'; ?>

    <div class="container">
        <h1>Book Event: <?php echo htmlspecialchars($event['name']); ?></h1>
        <form method="POST">
            <p>Are you sure you want to book this event?</p>
            <button type="submit">Confirm Booking</button>
        </form>
    </div>
</body>
</html>
