<?php
session_start();

$users_file = 'users.json';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Load existing users
    if (file_exists($users_file)) {
        $users = json_decode(file_get_contents($users_file), true);
    } else {
        $users = [];
    }

    // Check if username exists and password is correct
    if (isset($users[$username]) && password_verify($password, $users[$username]['password'])) {
        $_SESSION['admin_logged_in'] = true;
        $_SESSION['username'] = $username;
        header('Location: btspcardpage.php');
        exit;
    } else {
        $error = 'Invalid username or password';
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Login</title>
    <link rel="stylesheet" type="text/css" href="Style/btspcardpage1.css">
</head>
<body>
<div class="form-container">
    <h2>Admin Login</h2>
    <?php if (isset($error)) { echo "<p class='error'>$error</p>"; } ?>
    <form method="post" action="admin_login.php">
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" required>
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required>
        <button type="submit">Login</button>
    </form>
    <p>Don't have an account? <a href="admin_register.php">Register here</a></p>
</div>
</body>
</html>
