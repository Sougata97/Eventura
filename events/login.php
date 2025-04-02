<?php
include '../includes/db.php'; 
include '../includes/header.php'; 
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['username']; // Updated to match input field name 'username'
    $password = $_POST['pass']; // Updated to match input field name 'pass'

    // Query to check if user exists
    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch();

    // Verify password
    if ($user && password_verify($password, $user['password'])) {
        // Start session and store user data
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['role'] = $user['role'];
        
        // Redirect to user dashboard on successful login
        header('Location: details.php');
        exit();
    } else {
        $error = "Invalid email or password";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LOGIN PAGE</title>
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
    display: flex;
    margin: 30px 0;
}

#loginpage {
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
    <form method="POST" action="">
        <div id="loginpage" class="loginpage">
            <h3>LOGIN ACCOUNT</h3>
            <div>
                <label for="username">Email Address</label>
                <input type="text" placeholder="Enter email address" name="username" id="username" required>
            </div>
            <div>
                <label for="pass">Password</label>
                <input type="password" placeholder="Enter your password" name="pass" id="pass" required>
            </div>
            <div>
                <button type="submit">LOGIN</button>
            </div>
            <?php if (isset($error)) echo "<p style='color:red;'>$error</p>"; ?>
            <div class="create-account">
                <button type="button">
                    <a href="register.php" style="color: white !important;">CREATE AN ACCOUNT</a>
                </button>
            </div>
        </div>
    </form>
</body>
</html>

<?php include '../includes/footer.php'; ?>   
