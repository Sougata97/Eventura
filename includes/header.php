
<?php
// Remove session_start() from header.php
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Eventura - Event Management System</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
    <style>
    .line{
    width: 150px;
    height: 4px;
    background: #fc036b;
    margin: 10px auto;
    border-radius: 5px;
}
.ctn{
    padding: 8px 15px;
    background: #fc036b;
    border-radius: 30px;
    color: #fff;
    text-decoration: none;

}
header
{
    background-color: transparent;
    z-index: 1;
    position: relative;
}

</style>
<header>
    <div class="logo">
       <a href="../pages/index.php"><img src="../assets/images/e2.png" alt="Eventura Logo" ></a> 
    </div>
    <nav >
        <a href="../pages/index.php">Home</a>
        <a href="../pages/about.php">About Us</a>
        <a href="../pages/event.php">Events</a>
        <a href="../pages/contact.php">Contact Us</a>
        <a href="../pages/faq.php">FAQ</a>

        <?php if (isset($_SESSION['user_id'])): ?>
            <!-- If the user is logged in, show profile and logout options -->
            <a href="../user/dashboard.php" >Dashboard</a>
            <a href="../auth/logout.php" class="ctn">Logout</a>
        <?php else: ?>
            <!-- If the user is not logged in, show login and register options -->
            <a href="../auth/login.php">Login</a>
            <a href="../auth/register.php" class="ctn">Register</a>
        <?php endif; ?>
    </nav>
</header>
