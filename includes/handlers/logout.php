<?php
session_start();
include("../../config/config.php");
$username = $_SESSION['username'];
$update_account = mysqli_query($con, "UPDATE users SET online = 0 WHERE username='$username'");
session_destroy();
header("Location: ../../register.php")
?>