<link rel="stylesheet" href="/btspcardpage1.css" type="text/css">
<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);

    $users = json_decode(file_get_contents('users.json'), true);
    $users[] = ['username' => $username, 'password' => $password];
    file_put_contents('users.json', json_encode($users));

    echo "Registration successful";
}
?>

<form method="post" action="register.php">
    Username: <input type="text" name="username" required><br>
    Password: <input type="password" name="password" required><br>
    <button type="submit">Register</button>
</form>
<a href="login.php">Login</a>