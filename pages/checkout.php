
<?php
// Start the session only if it's not already started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Include database connection and header
include '../includes/db.php';  
include '../includes/header.php';  // Ensure header.php does not contain session_start()

$stmt = $pdo->prepare("SELECT * FROM events");
$stmt->execute();
$events = $stmt->fetchAll();
?>
<link href="https://cdn.jsdelivr.net/npm/flowbite@2.5.2/dist/flowbite.min.css"  rel="stylesheet" />

<style>
    /* Banner Section */
        .banner-section {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 60px 100px;
            background: transparent;
            color: white;
        }

        /* Left Column */
        .banner-section .left-column {
            max-width: 55%;
            animation: fadeInLeft 1.5s ease-in-out;
        }

        .banner-section .left-column h1 {
            font-size: 3rem;
            margin-bottom: 20px;
            font-weight: bold;
            line-height: 1.2;
        }

        .banner-section .left-column p {
            font-size: 1.2rem;
            margin-bottom: 30px;
        }

        .benefits-list {
            margin: 20px 0;
        }

        .benefits-list li {
            list-style: none;
            font-size: 1rem;
            margin-bottom: 10px;
            display: flex;
            align-items: center;
        }

        .benefits-list li span {
            display: inline-block;
            width: 30px;
            height: 30px;
            background: #fff;
            color: #007bff;
            font-weight: bold;
            border-radius: 50%;
            text-align: center;
            line-height: 30px;
            margin-right: 15px;
        }

        /* Right Column */
        .banner-section .right-column {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 20px;
            animation: fadeInRight 1.5s ease-in-out;
        }

        .banner-section .right-column a {
            text-decoration: none;
            padding: 15px 30px;
            color: white;
            font-size: 1.2rem;
            font-weight: bold;
            border-radius: 8px;
            background: #fc036b;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.3);
            transition: all 0.3s ease-in-out;
        }

        .banner-section .right-column a:hover {
            transform: scale(1.1);
            background: #b3024c;
        }

        /* Animation Effects */
        @keyframes fadeInLeft {
            0% {
                opacity: 0;
                transform: translateX(-50px);
            }
            100% {
                opacity: 1;
                transform: translateX(0);
            }
        }

        @keyframes fadeInRight {
            0% {
                opacity: 0;
                transform: translateX(50px);
            }
            100% {
                opacity: 1;
                transform: translateX(0);
            }
        }

        /* Responsive Design */
        @media screen and (max-width: 768px) {
            .banner-section {
                flex-direction: column;
                text-align: center;
                padding: 40px;
            }

            .banner-section .left-column {
                max-width: 100%;
            }

            .banner-section .right-column {
                width: 100%;
            }
        }
    .header-content
    {
        display: flex;
    flex-direction: column;
    align-items: center;
    width: 100%;
    height: 100vh;
    /* background-image: url('../assets/images/bg.jpg'); */
    background-position: bottom;
    background-size: cover;
    display: flex;
    /* align-items: flex-end; */
    justify-content: center;
    color: #fff;
    position: relative;
    top: -94px;
    /* z-index: -1; */
    }
    h2{
        color: #333;
    }
    /* Team Slider Section */
.team-slider {
    padding: 50px 0;
    background-color: #ffffff;
}

.team-slider .container {
    text-align: center;
}

.team-slider h2 {
    font-size: 2.5rem;
    margin-bottom: 30px;
}

.about-section h2 {
    text-align: center;
    font-size: 2rem;
    margin-bottom: 20px;
}
/* Team Cards */
.team-card {
    background-color: #ffffff;
    border: 1px solid #ddd;
    border-radius: 10px;
    padding: 20px;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    text-align: center;
    transition: transform 0.3s ease-in-out;
}

.team-card img {
    width: 150px;
    height: 150px;
    border-radius: 50%;
    object-fit: cover;
    margin-bottom: 20px;
}

.team-card h3 {
    font-size: 1.6rem;
    margin-bottom: 10px;
}

.team-card p {
    font-size: 1rem;
    color: #555;
}

/* Hover effect */
.team-card:hover {
    transform: scale(1.05);
}

/* Splide Slider */
.splide__list {
    display: flex;
    justify-content: center;
    gap: 20px;
}

.splide__slide {
    flex: 0 0 30%;
    display: flex;
    justify-content: center;
}

/* Adjust for smaller screens */
@media (max-width: 768px) {
    .splide__slide {
        flex: 0 0 45%;
    }
}

@media (max-width: 480px) {
    .splide__slide {
        flex: 0 0 80%;
    }
}

    /* Team Slider Section */
.team-slider {
    padding: 50px 0;
    background-color: #ffffff;
}

.team-slider .container {
    text-align: center;
}

.team-slider h2 {
    font-size: 2.5rem;
    margin-bottom: 30px;
}

/* Team Cards */
.team-card {
    background-color: #ffffff;
    border: 1px solid #ddd;
    border-radius: 10px;
    padding: 20px;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    text-align: center;
    transition: transform 0.3s ease-in-out;
}

.team-card img {
    width: 150px;
    height: 150px;
    border-radius: 50%;
    object-fit: cover;
    margin-bottom: 20px;
}

.team-card h3 {
    font-size: 1.6rem;
    margin-bottom: 10px;
}

.team-card p {
    font-size: 1rem;
    color: #555;
}

/* Hover effect */
.team-card:hover {
    transform: scale(1.05);
}

/* Splide Slider */
.splide__list {
    display: flex;
    justify-content: center;
    gap: 20px;
}

.splide__slide {
    flex: 0 0 30%;
    display: flex;
    justify-content: center;
}

/* Adjust for smaller screens */
@media (max-width: 768px) {
    .splide__slide {
        flex: 0 0 45%;
    }
}

@media (max-width: 480px) {
    .splide__slide {
        flex: 0 0 80%;
    }
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
    
        <section class="banner-section">
        <!-- Left Column -->
        <div class="left-column">
            <h1>Experience the Power of Eventura</h1>
            <p>
                Whether you're hosting a wedding, corporate event, or a community gathering, Eventura is here 
                to make your planning seamless and your experience unforgettable. Here's why you'll love us:
            </p>
            <ul class="benefits-list">
                <li><span>✓</span> Easy event booking and management</li>
                <li><span>✓</span> Tailored services for your unique needs</li>
                <li><span>✓</span> Expert support at every step</li>
                <li><span>✓</span> Affordable pricing with premium quality</li>
            </ul>
        </div>
        
        <!-- Right Column -->
        <div class="right-column">
            <a href="tel:+1234567890" class="ctn">Call Us Now</a>
            <a href="contact.php" class="ctn">Contact Us</a>
        </div>
    </section>
    
<h2>Checkout for <?php echo $events['name']; ?></h2>
<p>Price: ₹<?php echo $events['price']; ?></p>

<form action="process-payment.php" method="POST">
    <input type="hidden" name="event_id" value="<?php echo $events_id; ?>">
    <label>Name on Card:</label>
    <input type="text" name="card_name" required>
    
    <label>Card Number:</label>
    <input type="text" name="card_number" required>
    
    <label>Expiry Date:</label>
    <input type="text" name="expiry_date" required>

    <label>CVV:</label>
    <input type="text" name="cvv" required>

    <button type="submit">Pay ₹<?php echo $events['price']; ?></button>
</form>

<script src="https://cdn.jsdelivr.net/npm/flowbite@2.5.2/dist/flowbite.min.js"></script>

<?php include '../includes/footer.php'; ?>
