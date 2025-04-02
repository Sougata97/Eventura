<?php
// session_start(); // Start the session to check login status
?>
<style>
    /* Footer styling */
footer {
    background-color: #333; /* Dark background */
    color: white; /* Text color */
    padding: 40px 20px;
    font-family: Arial, sans-serif;
}

.footer-container {
    display: flex;
    justify-content: space-between;
    flex-wrap: wrap;
}

.footer-column {
    width: 23%;
    padding: 20px;
}

.footer-column h3 {
    color: #f2f2f2; /* Light grey color for headings */
    margin-bottom: 15px;
}

.footer-column ul {
    list-style: none;
    padding-left: 0;
}

.footer-column ul li {
    margin-bottom: 10px;
}

.footer-column ul li a {
    text-decoration: none;
    color: #f2f2f2;
    transition: .5s;
}

.footer-column ul li a:hover {
    color: #FC036B; /* Green color on hover */
}

.social-buttons {
    margin-top: 20px;
}

.social-icon {
    display: inline-block;
    background-color: #555;
    color: white;
    padding: 10px;
    margin-right: 10px;
    border-radius: 50%;
    width: 40px;
    height: 40px;
    line-height: 25px;
    text-align: center;
    transition: background-color 0.3s ease;
}

.social-icon:hover {
    background-color: #28a745; /* Green on hover */
}

/* Styling for Font Awesome icons */
.social-icon i {
    font-size: 18px; /* Adjust size */
}

/* Social icon colors for each network */
.social-icon.facebook {
    background-color: #3b5998; /* Facebook blue */
}

.social-icon.twitter {
    background-color: #1da1f2; /* Twitter blue */
}

.social-icon.instagram {
    background-color: #e1306c; /* Instagram pink */
}

.social-icon.linkedin {
    background-color: #0077b5; /* LinkedIn blue */
}

.footer-bottom {
    text-align: center;
    background-color: #222;
    padding: 10px 0;
}

.footer-bottom p {
    margin: 0;
    font-size: 14px;
}

@media (max-width: 768px) {
    .footer-column {
        width: 48%; /* Make columns take up more space on mobile */
        margin-bottom: 20px;
    }

    .social-icon {
        width: 35px;
        height: 35px;
        line-height: 35px;
    }
}

</style>

<footer>
    <div class="footer-container">

    <div class="footer-column">
            <h3>About Eventura</h3>
            <p>At Eventura, we are passionate about creating unforgettable experiences through expertly organized events. Whether you're planning a small intimate gathering, a corporate conference, or a grand celebration, our team is here to bring your vision to life.</p>
        </div>

        <div class="footer-column">
            <h3>Quick Links</h3>
            <ul>
                <li><a href="../pages/index.php">Home</a></li>
                <li><a href="../pages/about.php">About Us</a></li>
                <li><a href="../pages/contact.php">Contact</a></li>
                <li><a href="../pages/faq.php">FAQ</a></li>
                <?php if (isset($_SESSION['user_id'])): ?>
                <!-- If the user is logged in, show profile and logout options -->
                <li><a href="../user/dashboard.php" >Dashboard</a></li>
                <li><a href="../auth/logout.php" >Logout</a></li>
            <?php else: ?>
            <!-- If the user is not logged in, show login and register options -->
           <li> <a href="../auth/login.php">Login</a></li>
           <li> <a href="../auth/register.php">Register</a></li>
            <?php endif; ?>
            </ul>
        </div>
        
        <div class="footer-column">
            <h3>Map</h3>
            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3687.6191877399447!2d88.41285357475343!3d22.443354637696046!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3a0272166e4cb263%3A0x27f12170efd9ddee!2sFuture%20Institute%20of%20Engineering%20and%20Management!5e0!3m2!1sen!2sin!4v1731876682474!5m2!1sen!2sin" width="100%" height="300" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
        </div>

        

        <div class="footer-column">
            <h3>Contact & Social</h3>
            <p>Phone: +1 (234) 567-890</p>
            <p>Email: info@eventura.com</p>
            
            <!-- Social Media Links -->
            <div class="social-buttons">
                <a href="#" class="social-icon facebook"><i class="fab fa-facebook-f"></i></a>
                <a href="#" class="social-icon twitter"><i class="fab fa-twitter"></i></a>
                <a href="#" class="social-icon instagram"><i class="fab fa-instagram"></i></a>
                <a href="#" class="social-icon linkedin"><i class="fab fa-linkedin-in"></i></a>
            </div>
        </div>
    </div>
    
    <div class="footer-bottom">
        <p>&copy; <?php echo date("Y"); ?> Eventura - All rights reserved.</p>

        <!-- Display login/logout links based on user role -->
        <?php if (isset($_SESSION['user_id'])): ?>
            <!-- If the user is logged in -->
            <p>
                Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?> 
                | <a href="../auth/logout.php">Logout</a>
            </p>
            <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
                <!-- If logged-in user is an admin, display admin-specific link -->
                <p><a href="../admin/dashboard.php">Admin Dashboard</a></p>
            <?php endif; ?>
        <?php else: ?>
            <!-- If no user is logged in -->
            <p><a href="../auth/login.php" style="color: #fff">User Login</a> | <a href="../admin/login.php" style="color: #fff">Admin Login</a></p>
        <?php endif; ?>
    </div>
</footer>

<!-- Font Awesome CDN for CSS -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">