<?php
session_start();

$users_file = 'users.json';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    // Load existing users
    if (file_exists($users_file)) {
        $users = json_decode(file_get_contents($users_file), true);
    } else {
        $users = [];
    }

    // Check if username already exists
    if (isset($users[$username])) {
        $error = 'Username already exists';
    } else {
        // Save new user
        $users[$username] = ['password' => $password];
        file_put_contents($users_file, json_encode($users));
        $_SESSION['admin_logged_in'] = true;
        $_SESSION['username'] = $username;
        header('Location: btspcardpage.php');
        exit;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Register</title>
    <link rel="stylesheet" type="text/css" href="Style/btspcardpage1.css">
</head>
<body>
<div class="form-container">
    <h2>Admin Register</h2>
    <?php if (isset($error)) { echo "<p class='error'>$error</p>"; } ?>
    <form method="post" action="admin_register.php">
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" required>
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required>
        <button type="submit">Register</button>
    </form>
    <p>Already have an account? <a href="admin_login.php">Login here</a></p>
</div>
</body>
</html>
