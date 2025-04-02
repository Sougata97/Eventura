<?php
// Start the session only if it's not already started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

include '../includes/header.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Frequently Asked Questions (FAQ)</title>
    <link rel="stylesheet" href="../styles/style.css">
    <style>
        

        .faq-banner {
            /* background: linear-gradient(to right, #4a90e2, #003366); */
            color: white;
            padding: 50px 20px;
            text-align: center;
        }

        .faq-banner h1 {
            font-size: 3rem;
            margin: 0;
        }

        .faq-container {
            max-width: 800px;
            margin: 50px auto;
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        .accordion {
            margin-bottom: 15px;
            border: 1px solid #ddd;
            border-radius: 5px;
            overflow: hidden;
        }

        .accordion h2 {
            background: #f1f1f1;
            margin: 0;
            padding: 15px;
            font-size: 18px;
            cursor: pointer;
            transition: background 0.3s;
        }

        .accordion h2:hover {
            background: #e6e6e6;
        }

        .accordion h2.active {
            background: #FC036B;
            color: white;
        }

        .accordion p {
            margin: 0;
            padding: 15px;
            display: none;
            background: white;
            border-top: 1px solid #ddd;
        }

        .accordion p.show {
            display: block;
        }
    </style>
</head>
<body>
    <div class="faq-banner">
        <h1>Frequently Asked Questions (FAQ)</h1>
    </div>

    <div class="faq-container">
        <div class="accordion">
            <h2>How can I book an event?</h2>
            <p>To book an event, browse our events list and click the "Book Now" button. You’ll be redirected to a simple booking form to finalize your booking.</p>
        </div>

        <div class="accordion">
            <h2>Can I cancel a booking?</h2>
            <p>Currently, cancellations require manual processing. Please contact our support team at support@eventura.com for assistance.</p>
        </div>

        <div class="accordion">
            <h2>Do you provide customized event services?</h2>
            <p>Yes, we provide customizable event packages tailored to your needs. Contact our team to discuss your requirements.</p>
        </div>

        <div class="accordion">
            <h2>What payment methods do you accept?</h2>
            <p>We accept credit/debit cards, PayPal, and bank transfers. For more details, visit our Payment Information section.</p>
        </div>

        <div class="accordion">
            <h2>How do I contact support?</h2>
            <p>You can reach our support team at support@eventura.com or call us at +123 456 7890.</p>
        </div>

        <div class="accordion">
            <h2>Are there any discounts for bulk bookings?</h2>
            <p>Yes, we offer discounts for bulk bookings. Please contact us for special rates and more information.</p>
        </div>
    </div>

    <script>
        // JavaScript to handle accordion functionality
        const accordions = document.querySelectorAll('.accordion h2');

        accordions.forEach((accordion) => {
            accordion.addEventListener('click', () => {
                // Toggle active class for the clicked question
                accordion.classList.toggle('active');

                // Toggle visibility of the corresponding answer
                const answer = accordion.nextElementSibling;
                answer.classList.toggle('show');

                // Close other opened accordions
                accordions.forEach((otherAccordion) => {
                    if (otherAccordion !== accordion) {
                        otherAccordion.classList.remove('active');
                        otherAccordion.nextElementSibling.classList.remove('show');
                    }
                });
            });
        });
    </script>
</body>
</html>

<?php include '../includes/footer.php'; ?>
