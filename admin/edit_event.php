<?php
session_start();
if (!isset($_SESSION['admin_id'])) { header('Location: login.php'); exit(); }
include '../includes/db.php';

// Fetch event details
if (isset($_GET['id'])) {
    $event_id = $_GET['id'];

    $stmt = $pdo->prepare("SELECT * FROM events WHERE id = ?");
    $stmt->execute([$event_id]);
    $event = $stmt->fetch();

    if (!$event) {
        echo 'Event not found.';
        exit();
    }

    $existing_images = unserialize($event['event_images']);
}

// Handle event update
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $event_name = $_POST['event_name'];
    $event_date = $_POST['event_date'];
    $event_description = $_POST['event_description'];
    $event_status = $_POST['event_status'];

    // Handle image uploads
    $uploaded_images = $existing_images ?? [];
    $max_files = 5;

    for ($i = 0; $i < $max_files; $i++) {
        $file_key = "event_images[$i]";
        if (isset($_FILES['event_images']['name'][$i]) && $_FILES['event_images']['error'][$i] === 0) {
            $image_name = $_FILES['event_images']['name'][$i];
            $image_tmp = $_FILES['event_images']['tmp_name'][$i];

            // Generate a unique filename
            $new_image_name = time() . '_' . $image_name;
            $upload_dir = '../uploads/events/';
            $upload_path = $upload_dir . $new_image_name;

            if (move_uploaded_file($image_tmp, $upload_path)) {
                $uploaded_images[$i] = $new_image_name; // Replace the existing image at this index
            }
        }
    }

    // Serialize the uploaded images array
    $serialized_images = serialize($uploaded_images);

    // Update event in the database
    $stmt = $pdo->prepare("UPDATE events SET name = ?, event_date = ?, description = ?, status = ?, event_images = ? WHERE id = ?");
    $stmt->execute([$event_name, $event_date, $event_description, $event_status, $serialized_images, $event_id]);

    // Redirect to the manage events page after successful update
    header('Location: manage_events.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Event</title>
    <!-- Include Flatpickr CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <link rel="stylesheet" href="style.css">
</head>
<body>

<?php include 'navigation.php'; ?>

<div class="container">

<h1>Edit Event</h1>

<form method="POST" enctype="multipart/form-data">
    <div>
        <label for="event_name">Event Name</label>
        <input type="text" name="event_name" id="event_name" value="<?php echo htmlspecialchars($event['name']); ?>" required>
    </div>
    <div>
        <label for="event_date">Event Date</label>
        <input type="text" name="event_date" id="event_date" value="<?php echo $event['event_date']; ?>" required>
    </div>
    <div>
        <label for="event_description">Event Description</label>
        <textarea name="event_description" id="event_description" rows="5" required><?php echo htmlspecialchars($event['description']); ?></textarea>
    </div>
    <div>
        <label for="event_status">Event Status</label>
        <select name="event_status" id="event_status">
            <option value="Upcoming" <?php echo ($event['status'] == 'Upcoming') ? 'selected' : ''; ?>>Upcoming</option>
            <option value="Ongoing" <?php echo ($event['status'] == 'Ongoing') ? 'selected' : ''; ?>>Ongoing</option>
            <option value="Completed" <?php echo ($event['status'] == 'Completed') ? 'selected' : ''; ?>>Completed</option>
        </select>
    </div>
    <div>
        <label for="event_images">Event Images (5 individual uploads)</label>
        <?php if ($existing_images): ?>
            <div>
                <strong>Current Images:</strong>
                <?php foreach ($existing_images as $image): ?>
                    <img src="../uploads/events/<?php echo htmlspecialchars($image); ?>" alt="Event Image" style="width: 100px; height: 100px;">
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
        <div>
            <label for="image1">Image 1:</label>
            <input type="file" name="event_images[]" id="image1" accept="image/*">
        </div>
        <div>
            <label for="image2">Image 2:</label>
            <input type="file" name="event_images[]" id="image2" accept="image/*">
        </div>
        <div>
            <label for="image3">Image 3:</label>
            <input type="file" name="event_images[]" id="image3" accept="image/*">
        </div>
        <div>
            <label for="image4">Image 4:</label>
            <input type="file" name="event_images[]" id="image4" accept="image/*">
        </div>
        <div>
            <label for="image5">Image 5:</label>
            <input type="file" name="event_images[]" id="image5" accept="image/*">
        </div>
    </div>
    <button type="submit">Update Event</button>
</form>
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
