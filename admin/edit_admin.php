<?php
session_start();
if (!isset($_SESSION['admin_id'])) { header('Location: login.php'); exit(); }
include '../includes/db.php';

$id = $_GET['id'];  // Get the admin ID from the URL
$stmt = $pdo->prepare("SELECT * FROM admins WHERE id = ?");
$stmt->execute([$id]);
$admin = $stmt->fetch();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    // If the password is provided, hash it
    if (!empty($password)) {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    } else {
        // Keep the existing password if no new password is provided
        $hashed_password = $admin['password'];
    }

    // Update admin details
    $stmt = $pdo->prepare("UPDATE admins SET username = ?, email = ?, password = ? WHERE id = ?");
    $stmt->execute([$username, $email, $hashed_password, $id]);

    header('Location: manage_users.php');  // Redirect to the manage users page
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Edit Admin</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<?php include 'navigation.php'; ?>
<div class="container">
    <h2>Edit Admin</h2>
    <form method="POST">
        <input type="text" name="username" value="<?php echo htmlspecialchars($admin['username']); ?>" required>
        <input type="email" name="email" value="<?php echo htmlspecialchars($admin['email']); ?>" required>
        <input type="password" name="password" placeholder="New Password (leave blank to keep current)">
        <button type="submit">Update Admin</button>
    </form>
</div>
</body>
</html>
