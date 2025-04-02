<?php
session_start();
if (!isset($_SESSION['admin_id'])) { header('Location: login.php'); exit(); }
include '../includes/db.php';

$id = $_GET['id'];  // Get the admin ID from the URL

// Ensure that the admin deleting another admin is not trying to delete themselves
if ($id == $_SESSION['admin_id']) {
    echo "You cannot delete your own account.";
    exit();
}

// Delete the admin record from the database
$stmt = $pdo->prepare("DELETE FROM admins WHERE id = ?");
$stmt->execute([$id]);

header('Location: manage_users.php');  // Redirect to the manage users page
exit();
?>
