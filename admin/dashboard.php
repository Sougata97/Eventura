<?php
session_start();
if (!isset($_SESSION['admin_id'])) { header('Location: login.php'); exit(); }
include '../includes/db.php';

// Fetch data for the dashboard
$stmt = $pdo->query("SELECT COUNT(*) FROM admins");
$admin_count = $stmt->fetchColumn();

$stmt = $pdo->query("SELECT COUNT(*) FROM events");
$event_count = $stmt->fetchColumn();

$stmt = $pdo->query("SELECT COUNT(*) FROM users");
$user_count = $stmt->fetchColumn();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <style>
        .dashboard-container {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            justify-content: space-around;
        }

        .dashboard-box {
            width: 250px;
            padding: 20px;
            background-color: #f4f4f4;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            text-align: center;
            transition: all 0.3s ease;
        }

        .dashboard-box:hover {
            transform: translateY(-5px);
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.1);
        }

        .dashboard-box h2 {
            font-size: 24px;
            margin-bottom: 10px;
        }

        .dashboard-box .count {
            font-size: 30px;
            font-weight: bold;
            color: #007bff;
        }

        .dashboard-box i {
            font-size: 40px;
            color: #007bff;
            margin-bottom: 15px;
        }

        .dashboard-links {
            margin-top: 20px;
            display: flex;
            justify-content: space-between;
        }

        .dashboard-links a {
            padding: 10px 20px;
            background-color: #007bff;
            color: white;
            border-radius: 5px;
            text-decoration: none;
            transition: background-color 0.3s ease;
        }

        .dashboard-links a:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>

<?php include 'navigation.php'; ?>

<div class="container">
    <h1>Welcome to the Admin Dashboard</h1>

    <div class="dashboard-container">
        <!-- Admins Box -->
        <div class="dashboard-box">
            <i class="fas fa-user-tie"></i>
            <h2>Admins</h2>
            <div class="count"><?php echo $admin_count; ?></div>
        </div>

        <!-- Events Box -->
        <div class="dashboard-box">
            <i class="fas fa-calendar-check"></i>
            <h2>Events</h2>
            <div class="count"><?php echo $event_count; ?></div>
        </div>

        <!-- Users Box -->
        <div class="dashboard-box">
            <i class="fas fa-users"></i>
            <h2>Users</h2>
            <div class="count"><?php echo $user_count; ?></div>
        </div>

        <!-- Logout Box -->
        <div class="dashboard-box">
            <i class="fas fa-sign-out-alt"></i>
            <h2>Logout</h2>
            <a href="admin_logout.php" style="display: inline-block; margin-top: 10px; padding: 10px 20px; background-color: #dc3545; color: white; border-radius: 5px; text-decoration: none;">Logout</a>
        </div>
    </div>

    <!-- Navigation Links -->
    <div class="dashboard-links">
        <a href="manage_users.php">Manage Users</a>
        <a href="manage_events.php">Manage Events</a>
        <a href="create_event.php">Create Event</a>
    </div>
</div>

</body>
</html>
