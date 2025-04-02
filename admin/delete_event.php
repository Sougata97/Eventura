<?php
session_start();
if (!isset($_SESSION['admin_id'])) { header('Location: login.php'); exit(); }
include '../includes/db.php';

$id = $_GET['id'];
$stmt = $pdo->prepare("SELECT * FROM events WHERE id = ?");
$stmt->execute([$id]);
$event = $stmt->fetch();

if ($event) {
    // Delete associated images
    $images = explode(',', $event['eventimage']);
    foreach ($images as $image) {
        unlink("../uploads/events/$image");
    }

    // Delete event record
    $stmt = $pdo->prepare("DELETE FROM events WHERE id = ?");
    $stmt->execute([$id]);

    header('Location: manage_events.php');
    exit();
} else {
    echo "Event not found.";
}
?>
