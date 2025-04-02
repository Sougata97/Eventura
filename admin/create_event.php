<?php
session_start();
if (!isset($_SESSION['admin_id'])) { 
    header('Location: login.php'); 
    exit(); 
}
include '../includes/db.php';

// Handle event creation
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $event_name = $_POST['event_name'];
    $event_date = $_POST['event_date'];
    $event_description = $_POST['event_description'];
    $event_status = $_POST['event_status'];

    // Handle image uploads
    $uploaded_images = [];
    $upload_dir = '../uploads/events/';
    
    for ($i = 1; $i <= 5; $i++) {
        $image_key = 'event_image_' . $i;
        if (isset($_FILES[$image_key]) && $_FILES[$image_key]['error'] === 0) {
            $image_name = $_FILES[$image_key]['name'];
            $image_tmp = $_FILES[$image_key]['tmp_name'];

            // Generate a unique filename with a timestamp to avoid duplicates
            $new_image_name = time() . '_' . $image_name;
            $upload_path = $upload_dir . $new_image_name;

            if (move_uploaded_file($image_tmp, $upload_path)) {
                $uploaded_images[] = $new_image_name;
            }
        }
    }

    // Check if at least one image was uploaded
    if (empty($uploaded_images)) {
        echo "<script>alert('You must upload at least one image.');</script>";
    } else {
        // Serialize the uploaded images array
        $serialized_images = serialize($uploaded_images);

        // Insert event into the database
        $stmt = $pdo->prepare("INSERT INTO events (name, event_date, description, status, event_images) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([$event_name, $event_date, $event_description, $event_status, $serialized_images]);

        // Redirect to the manage events page after successful creation
        header('Location: manage_events.php');
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Event</title>
     <!-- Include Flatpickr CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <link rel="stylesheet" href="style.css">
   


</head>
<body>

<?php include 'navigation.php'; ?>
<div class="container">
    <h1>Create New Event</h1>

    <form method="POST" enctype="multipart/form-data" onsubmit="return validateForm()">
        <div>
            <label for="event_name">Event Name</label>
            <input type="text" name="event_name" id="event_name" required>
        </div>
        <div>
            <label for="event_date">Event Date</label>
            <input type="date" name="event_date" id="event_date" required>
        </div>
        <div>
            <label for="event_description">Event Description</label>
            <textarea name="event_description" id="event_description" rows="5" required></textarea>
        </div>
        <div>
            <label for="event_status">Event Status</label>
            <select name="event_status" id="event_status">
                <option value="Upcoming">Upcoming</option>
                <option value="Ongoing">Ongoing</option>
                <option value="Completed">Completed</option>
            </select>
        </div>
        <div>
            <label for="event_image_1">Event Image 1 (Mandatory)</label>
            <input type="file" name="event_image_1" id="event_image_1" accept="image/*" required>
        </div>
        <div>
            <label for="event_image_2">Event Image 2 (Optional)</label>
            <input type="file" name="event_image_2" id="event_image_2" accept="image/*">
        </div>
        <div>
            <label for="event_image_3">Event Image 3 (Optional)</label>
            <input type="file" name="event_image_3" id="event_image_3" accept="image/*">
        </div>
        <div>
            <label for="event_image_4">Event Image 4 (Optional)</label>
            <input type="file" name="event_image_4" id="event_image_4" accept="image/*">
        </div>
        <div>
            <label for="event_image_5">Event Image 5 (Optional)</label>
            <input type="file" name="event_image_5" id="event_image_5" accept="image/*">
        </div>
        <button type="submit">Create Event</button>
    </form>
</div>
<!-- Include Flatpickr JS -->
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

<script>
    // Initialize Flatpickr for event_date
    flatpickr("#event_date", {
        dateFormat: "Y-m-d",
        defaultDate: new Date(),
        minDate: "today", // Prevent selecting past dates
        altInput: true, // Display a more readable date format
        altFormat: "F j, Y", // Customize displayed date format
        disableMobile: "true" // Use desktop version on mobile
    });
</script>
<script>
    function validateForm() {
        const image1 = document.getElementById('event_image_1').files;
        if (image1.length === 0) {
            alert('You must upload at least one image.');
            return false;
        }
        return true;
    }
</script>


</body>
</html>
