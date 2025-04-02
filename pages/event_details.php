<?php
// Start the session only if it's not already started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Include database connection and header
include '../includes/db.php';  
include '../includes/header.php';  

// Check if the event ID is provided in the URL
if (!isset($_GET['id']) || empty($_GET['id'])) {
    die('Event ID is missing.');
}

// Sanitize and fetch event details from the database
$event_id = intval($_GET['id']);
$stmt = $pdo->prepare("SELECT * FROM events WHERE id = :id");
$stmt->bindParam(':id', $event_id, PDO::PARAM_INT);
$stmt->execute();
$event = $stmt->fetch();

if (!$event) {
    die('Event not found.');
}

// Deserialize the images
$event_images = unserialize($event['event_images']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eventura - <?php echo htmlspecialchars($event['name']); ?></title>
    <!-- Include Owl Carousel Styles -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css">

    <link rel="stylesheet" href="styles/style.css">
    <style>
        /* Banner Section */
        .banner {
            
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
        /* Event Details Section */
        .event-details {
            max-width: 800px;
            margin: 50px auto;
            padding: 20px;
            background: white;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .event-details img {
            width: 100%;
            height: auto;
            border-radius: 10px;
            margin-bottom: 15px;
        }
        .event-details h2 {
            margin: 20px 0;
            font-size: 2rem;
            color: #333;
        }
        .event-details p {
            font-size: 1.2rem;
            color: #555;
        }
        .event-details .image-gallery {
            display: flex;
            gap: 10px;
            overflow-x: auto;
        }
        .event-details .image-gallery img {
            width: 100%;
            /* height: 100px; */
            border-radius: 5px;
        }
        .event-details a {
            display: inline-block;
            padding: 10px 20px;
            margin-top: 20px;
            background: #ff007f;
            color: white;
            border-radius: 5px;
            text-decoration: none;
        }
        .event-details a:hover {
            background: #e60072;
        }
    </style>
</head>
<body>
    <!-- Banner Section -->
    <div class="banner">
        <h1><?php echo htmlspecialchars($event['name']); ?></h1>
    </div>

    <!-- Event Details Section -->
    <div class="event-details">

    <!-- Image Gallery as Owl Carousel -->
<div class="image-gallery owl-carousel">
    <?php
    if ($event_images) {
        foreach ($event_images as $image) {
            echo '<div class="item"><img src="../uploads/events/' . htmlspecialchars($image) . '" alt="Event Image"></div>';
        }
    } else {
        echo '<p>No additional images available.</p>';
    }
    ?>
</div>
<br><br>
        <h2><?php echo htmlspecialchars($event['name']); ?></h2>
        <p><?php echo nl2br(htmlspecialchars($event['description'])); ?></p>

        

        <!-- Book Now Button -->
        <a href="../events/booking.php?id=<?php echo $event_id; ?>">Book Now</a>
        <!-- Include Owl Carousel Scripts -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>

<!-- Initialize Owl Carousel -->
<script>
    $(document).ready(function() {
        $(".owl-carousel").owlCarousel({
            loop: true,
            margin: 10,
            nav: true,
            autoplay: true,
            autoplayTimeout: 3000,
            autoplayHoverPause: true,
            responsive: {
                0: {
                    items: 1
                },
                600: {
                    items: 1
                },
                1000: {
                    items: 1
                }
            }
        });
    });
</script>
    </div>
</body>
</html>
