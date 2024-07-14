
<?php
session_start();
$images = json_decode(file_get_contents('images.json'), true);

echo "<h1>Gallery</h1>";
foreach ($images as $image) {
    echo "<img src='".$image['s3_url']."' width='200'><br>";
}

if (isset($_SESSION['username'])) {
    echo '<a href="upload.php">Upload More Photos</a><br>';
    echo '<a href="logout.php">Logout</a>';
} else {
    echo '<a href="login.php">Login</a>';
}
?>