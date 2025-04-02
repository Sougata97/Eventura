<?php
// Start session and check if the admin is logged in
session_start();
if (!isset($_SESSION['admin_id'])) {
    header('Location: login.php');
    exit();
}

// Include database connection
include '../includes/db.php';

// Fetch all events from the database
$stmt = $pdo->prepare("SELECT * FROM events");
$stmt->execute();
$events = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Events</title>
     <!-- Include Flatpickr CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <link rel="stylesheet" href="style.css"> <!-- Keeping your existing styles -->
</head>
<body>

<?php include 'navigation.php'; ?> <!-- Keeping your navigation -->
<div class="container">
<h1>Manage Events</h1>

<!-- Table to display events -->
<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Event Name</th>
            <th>Event Date</th>
            <th>Status</th>
            <th>Images</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($events as $event): ?>
            <tr>
                <td><?php echo $event['id']; ?></td>
                <td><?php echo htmlspecialchars($event['name']); ?></td>
                <td><?php echo htmlspecialchars($event['event_date']); ?></td>
                <td><?php echo htmlspecialchars($event['status']); ?></td>
                <td>
                    <?php
                    // Deserialize the event_images column
                    $event_images = unserialize($event['event_images']);
                    if ($event_images) {
                        foreach ($event_images as $image) {
                            echo '<img src="../uploads/events/' . htmlspecialchars($image) . '" alt="Event Image" style="width: 100px; height: 100px; margin-right: 10px;">';
                        }
                    } else {
                        echo 'No images available';
                    }
                    ?>
                </td>
                <td>
                    <a href="edit_event.php?id=<?php echo $event['id']; ?>">Edit</a> | 
                    <a href="delete_event.php?id=<?php echo $event['id']; ?>" onclick="return confirm('Are you sure you want to delete this event?')">Delete</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
</div>

<!-- Include Flatpickr JS -->
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

<script>
    // Initialize Flatpickr for event_date
    flatpickr("#event_date", {
        dateFormat: "Y-m-d",
        defaultDate: "<?php echo $event['event_date']; ?>",
        minDate: "today", // Prevent selecting past dates
        altInput: true, // Display a more readable date format
        altFormat: "F j, Y", // Customize displayed date format
        disableMobile: "true" // Use desktop version on mobile
    });
</script>
</body>
</html>
