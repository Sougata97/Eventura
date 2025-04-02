<?php


session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

include '../includes/db.php';
include '../includes/header.php';

$user_id = $_SESSION['user_id'];

// Fetch user details from the database
$stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
$stmt->execute([$user_id]);
$user = $stmt->fetch();

if (!$user) {
    echo "User not found!";
    exit();
}

$success = false;
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $gender = $_POST['gender'];
    $profileImage = $user['profile_image'];

    // Handle profile image upload
    if ($_FILES['profile_image']['name']) {
        $targetDir = "../user/uploads/"; // Define upload directory
        $targetFile = $targetDir . basename($_FILES['profile_image']['name']);
        $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

        // Check if image file is a valid image type (you can add more validations)
        if (in_array($imageFileType, ['jpg', 'jpeg', 'png', 'gif'])) {
            if (move_uploaded_file($_FILES['profile_image']['tmp_name'], $targetFile)) {
                $profileImage = basename($_FILES['profile_image']['name']); // Store the file name in the database
            } else {
                $error = "Sorry, there was an error uploading your file.";
            }
        } else {
            $error = "Only JPG, JPEG, PNG & GIF files are allowed.";
        }
    }

    // Update user details in the database
    if (empty($error)) {
        $stmt = $pdo->prepare("UPDATE users SET name = ?, email = ?, gender = ?, profile_image = ? WHERE id = ?");
        $stmt->execute([$name, $email, $gender, $profileImage, $user_id]);

        $success = true;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
    <link rel="stylesheet" href="styles_login.css">
</head>
<style>
    .profile-page {
        background-color: white;
        border-radius: 8px;
        padding: 30px;
        width: 100%;
        max-width: 400px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        text-align: center;
        position: relative;
        left: 50%;
        transform: translateX(-50%);
        margin: 30px 0;
    }

    h3 {
        margin-bottom: 20px;
        color: #333;
        font-size: 24px;
    }

    .profile-image {
        width: 150px;
        height: 150px;
        border-radius: 50%;
        object-fit: cover;
        margin-bottom: 20px;
    }

    .form-field {
        margin: 10px 0;
        display: flex;
        flex-direction: column;
        align-items: flex-start;
    }

    label {
        font-size: 14px;
        color: #555;
    }

    input, select {
        width: 100%;
        padding: 12px;
        margin-top: 8px;
        border: 1px solid #ccc;
        border-radius: 6px;
        font-size: 14px;
    }

    button {
        width: 100%;
        padding: 14px;
        border: none;
        border-radius: 6px;
        background-color: #4e79ff;
        color: white;
        font-size: 16px;
        cursor: pointer;
        transition: background-color 0.3s ease;
    }

    button:hover {
        background-color: #3560d7;
    }

    .error {
        color: red;
        font-size: 14px;
    }

    .success {
        color: green;
        font-size: 14px;
    }
</style>

<body>
    <div class="profile-page">
        <h2>Your Profile</h2>

        <?php if ($error): ?>
            <p class="error"><?= $error; ?></p>
        <?php endif; ?>

        <?php if ($success): ?>
            <p class="success">Profile updated successfully!</p>
        <?php endif; ?>

        <img src="../user/uploads/<?= $user['profile_image'] ?>" alt="Profile Image" class="profile-image">

        <form method="POST" action="" enctype="multipart/form-data">
            <div class="form-field">
                <label for="name">Full Name:</label>
                <input type="text" id="name" name="name" value="<?= $user['name']; ?>" required>
            </div>

            <div class="form-field">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" value="<?= $user['email']; ?>" required>
            </div>

            <div class="form-field">
                <label for="gender">Gender:</label>
                <select name="gender" id="gender" required>
                    <option value="male" <?= $user['gender'] == 'male' ? 'selected' : ''; ?>>Male</option>
                    <option value="female" <?= $user['gender'] == 'female' ? 'selected' : ''; ?>>Female</option>
                    <option value="other" <?= $user['gender'] == 'other' ? 'selected' : ''; ?>>Other</option>
                </select>
            </div>

            <div class="form-field">
                <label for="profile_image">Change Profile Image:</label>
                <input type="file" id="profile_image" name="profile_image">
            </div>

            <button type="submit">Update Profile</button>
            <br><br>
           <button><a href="dashboard.php" style="color: white; text-decoration: none;">Back to Dashboard</a></button>
        </form>
    </div>
</body>
</html>

<?php include '../includes/footer.php'; ?>
