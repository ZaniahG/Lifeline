<!DOCTYPE html>

<html>
<link rel="stylesheet" href="/Style/btspcardpage1.css" type="text/css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
</html>

<div class="sbcontent">
    <a target="_blank" href="Lifeline1.html">
    <img src="e:\MAMP\htdocs\photos\LifeLine Logo 1.png" width="20%"></a>
    <input type="search" id="search" placeholder="Search">
<div class="shoppingcart">
        <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="35" height="35" fill="none" viewBox="0 0 24 24">
            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 4h1.5L9 16m0 0h8m-8 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4Zm8 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4Zm-8.5-3h9.25L19 7H7.312"/>
          </svg>
          
</div>
<body>
<div class="heading1">
    <h1>Your Current Photocards</h1>
    </div>


    
<div class="RMheader"></div>
<div class="btscontainer">
<?php
session_start();

// Check if admin is logged in
if (isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in']) {
    echo '<p>Welcome, ' . htmlspecialchars($_SESSION['username']) . '! <a href="logout.php">Logout</a></p>';
    include 'upload.php';
} else {
    // Include admin login form
    echo '<p><a href="admin_login.php">Admin Login</a> | <a href="admin_register.php">Register</a></p>';
}
?>
</div>
<div>
    <div class="btscontainer">
    <?php
    // Display images if admin is logged in
    if (isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in']) {
        $images = json_decode(file_get_contents('images.json'), true);
        foreach ($images as $image) {
            echo "<div class='img-area'><img src='" . htmlspecialchars($image['s3_url']) . "' width='200'><br></div>";
        }
    }
    ?>
    </div>
</div>
</div>

<div class="Jinheader"></div>



<div class="Jhopeheader"></div>

<div class="Jiminheader"></div>


<div class="Vheader"></div>

<div class="Sugaheader"></div>

<div class="Jungkookheader"></div>



</body>
</div>