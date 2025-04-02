<link rel="stylesheet" href="../admin/style.css">
<header>
    <img src="../assets/images/e2.png" alt="" style="width: 100px;">
    <nav class="navbar">

    <img src="" alt="">
    <a href="index.php" class="logo">Home</a>
    
    <?php if (isset($_SESSION['user_id'])): ?>
        <a href="../user/dashboard.php">Dashboard</a>
        <a href="../auth/logout.php">Logout</a>
    <?php else: ?>
        <a href="../auth/login.php">Login</a>
    <?php endif; ?>
</nav>
</header>