
<?php
session_start();
session_destroy();
header("Location: btspcardpage.php");
exit();
?>