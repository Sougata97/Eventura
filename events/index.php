<?php
// Start the session only if it's not already started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Include database connection and header
include '../includes/db.php';  
include '../includes/header.php';  // Ensure header.php does not contain session_start()
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
    <title>Eventura - Events</title>
    <link rel="stylesheet" href="styles/style.css">
    <style>
        /* Banner Section */
        .banner {
            background: url('path/to/banner-image.jpg') no-repeat center center/cover;
            height: 300px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            text-align: center;
        }
        .banner h1 {
            font-size: 3rem;
        }
        /* Slider Section */
        .event-slider {
            display: flex;
            overflow: auto;
            gap: 15px;
            padding: 20px;
        }
        .event-card {
            flex: 0 0 300px;
            background: white;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            text-align: center;
            padding: 15px;
        }
        .event-card img {
            width: 100%;
            height: 200px;
            border-radius: 10px;
        }
        .event-card h2 {
            margin: 10px 0;
            font-size: 1.5rem;
        }
        .event-card a {
            display: inline-block;
            padding: 10px 20px;
            margin-top: 10px;
            background: #ff007f;
            color: white;
            border-radius: 5px;
            text-decoration: none;
        }
        .event-card a:hover {
            background: #e60072;
        }
    </style>
</head>
<body>
    <!-- Banner Section -->
    <div class="banner">
        <h1>Upcoming Events</h1>
    </div>

    <!-- Slider Section -->
    <div class="event-slider">
        <?php foreach ($events as $event): ?>
            <div class="event-card">
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
                
                <h2><?php echo $event['name']; ?></h2>
                <a href="event_details.php?id=<?php echo $event['id']; ?>">Book Now</a>
            </div>
        <?php endforeach; ?>
    </div>
</body>
</html>
