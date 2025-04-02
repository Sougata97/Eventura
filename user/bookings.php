<?php
// Start session
session_start();

// Check if the user is logged in, otherwise redirect to login page
if (!isset($_SESSION['user_id'])) {
    header('Location: ../auth/login.php');
    exit();
}

// Include the database connection
include '../includes/db.php';
include '../includes/header.php'; 

// Fetch user details from the database
$user_id = $_SESSION['user_id'];
$stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
$stmt->execute([$user_id]);
$user = $stmt->fetch();

// Fetch booked events for the user
$stmt = $pdo->prepare("
    SELECT events.name, events.event_date, bookings.booking_date, bookings.status 
    FROM bookings 
    JOIN events ON bookings.event_id = events.id
    WHERE bookings.user_id = ?
    ORDER BY bookings.booking_date DESC
");
$stmt->execute([$user_id]);
$booked_events = $stmt->fetchAll();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>User Dashboard</title>
    <link rel="stylesheet" href="/assets/css/style.css">
</head>
<style>
    .main-section
    {
        display: flex;
    }
    .main-column-1
    {
    width: 100%;

    }
    .main-column-2
    {
        width: 100%;
    }
    .user-profile {
    padding: 20px;
    background-color: #f8f9fa;
    margin-bottom: 30px;
    border-radius: 8px;
}

.profile-header {
    display: flex;
    align-items: center;
    gap: 20px;
}

.profile-img img {
    border-radius: 50%;
    width: 100px;
    height: 100px;
}

.profile-details p {
    margin: 5px 0;
    font-size: 16px;
}

.booked-events table {
    width: 100%;
    margin-top: 20px;
    border-collapse: collapse;
}

.booked-events table th, .booked-events table td {
    padding: 10px;
    border: 1px solid #ddd;
    text-align: left;
}

.booked-events table th {
    background-color: #f2f2f2;
}

.actions {
    margin-top: 20px;
}

.actions a {
    text-decoration: none;
    color: #007bff;
    margin-right: 15px;
}

.actions a:hover {
    text-decoration: underline;
}

</style>
<body>
    <header>
        <h1>Welcome, <?php echo htmlspecialchars($user['name']); ?>!</h1>
    </header>
<div class="main-section">
   
    
    <div class="main-column main-column-2">
<!-- Booked Events Section -->
    <section class="booked-events">
        <h2>Your Booked Events</h2>
        <?php if (count($booked_events) > 0): ?>
            <table>
                <thead>
                    <tr>
                        <th>Event Name</th>
                        <th>Event Date</th>
                        <th>Booking Date</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($booked_events as $event): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($event['name']); ?></td>
                            <td><?php echo htmlspecialchars($event['event_date']); ?></td>
                            <td><?php echo htmlspecialchars($event['booking_date']); ?></td>
                            <td><?php echo ucfirst($event['status']); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <b><i><p>You have not booked any events yet.</p></i></b>
        <?php endif; ?>
    </section>

    <!-- Actions Section -->
    <section class="actions">
        <a href="../user/profile.php">Edit Profile</a> | <a href="../auth/logout.php">Logout</a>
    </section>
    </div>
    
</div>
 
</body>
</html>

<?php include '../includes/footer.php'; ?>
