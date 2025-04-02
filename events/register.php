<?php
include '../includes/db.php';
include '../includes/header.php';

$error = ''; // Variable to store any error message
$success = false; // Flag to indicate successful registration

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $name = $_POST['name'];
    $gender = $_POST['gender'];
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirm_password'];

    // Check if the passwords match
    if ($password !== $confirmPassword) {
        $error = "Passwords do not match. Please try again.";
    } else {
        // Hash the password if they match
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        // Handle profile image upload
        $profileImage = null;
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

        // Check if the username already exists
        $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->execute([$username]);
        $userByUsername = $stmt->fetch();

        // Check if the email already exists
        $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);
        $userByEmail = $stmt->fetch();

        // If user already exists by username or email
        if ($userByUsername) {
            $error = "Username already taken. Please choose another one.";
        } elseif ($userByEmail) {
            $error = "Email already registered. Please use a different email.";
        } else {
            // If both username and email are unique, insert the new user
            $stmt = $pdo->prepare("INSERT INTO users (username, email, password, name, gender, profile_image) VALUES (?, ?, ?, ?, ?, ?)");
            $stmt->execute([$username, $email, $hashedPassword, $name, $gender, $profileImage]);

            $success = true; // Set success flag
            if($success==true)
            {
            header('Location: ../user/dashboard.php');

            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="styles_login.css">
</head>
<style>
    /* Reset some default styles */
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

form {
    justify-content: center;
    /* display: flex; */
    margin: 30px 0;
}

.registration-page {
    background-color: white;
    border-radius: 8px;
    padding: 30px;
    width: 100%;
    max-width: 400px;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    text-align: center;
}

h3 {
    margin-bottom: 20px;
    color: #333;
    font-size: 24px;
}

label {
    display: block;
    text-align: left;
    margin-bottom: 8px;
    color: #555;
    font-size: 14px;
}

input[type="text"],
input[type="password"] {
    width: 100%;
    padding: 12px;
    margin: 10px 0 20px;
    border: 1px solid #ccc;
    border-radius: 6px;
    font-size: 16px;
    outline: none;
    transition: border-color 0.3s ease;
}

input[type="text"]:focus,
input[type="password"]:focus {
    border-color: #4e79ff;
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

button a {
    text-decoration: none;
    color: white;
}

.forgot-password,
.create-account {
    margin-top: 15px;
}

.forgot-password a,
.create-account a {
    color: #4e79ff;
    text-decoration: none;
    font-size: 14px;
}

.forgot-password a:hover,
.create-account a:hover {
    text-decoration: underline;
}

.create-account {
    width: 100%;
    padding: 2px;
    border: none;
    border-radius: 6px;
    background-color: #4e79ff;
    color: white;
    font-size: 16px;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

</style>
<body>
    <center>
<div class="registration-page">
        <h2>Register</h2>

        <?php if ($error): ?>
            <p style="color: red;"><?= $error; ?></p>
        <?php endif; ?>

        <form method="POST" action="" enctype="multipart/form-data">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required>

            <label for="name">Full Name:</label>
            <input type="text" id="name" name="name" value="<?= isset($name) ? $name : ''; ?>" required>

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" value="<?= isset($email) ? $email : ''; ?>" required>

            <label for="gender">Gender:</label>
            <select name="gender" required>
                <option value="male" <?= (isset($gender) && $gender === 'male') ? 'selected' : ''; ?>>Male</option>
                <option value="female" <?= (isset($gender) && $gender === 'female') ? 'selected' : ''; ?>>Female</option>
                <option value="other" <?= (isset($gender) && $gender === 'other') ? 'selected' : ''; ?>>Other</option>
            </select>

            <label for="profile_image">Profile Image:</label>
            <input type="file" id="profile_image" name="profile_image">

            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>

            <label for="confirm_password">Confirm Password:</label>
            <input type="password" id="confirm_password" name="confirm_password" required>

            <button type="submit">SIGN UP</button>
            <div class="create-account">
                <button type="button">
                    <a href="login.php" style="color: white !important;">ALREADY HAVE AN ACCOUNT</a>
                </button>
            </div>
        </form>
    </div>
    </center>
    

    
</body>
</html>

<?php include '../includes/footer.php'; ?>
