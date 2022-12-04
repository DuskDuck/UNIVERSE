<?php
ob_start();//turn on output buffering
session_start();
$timezone = date_default_timezone_set("Asia/Ho_Chi_Minh");
$con = mysqli_connect("localhost","root","","social");
if(mysqli_connect_errno()){
    echo "Fail to connect: " . mysqli_connect_errno();
}
?>