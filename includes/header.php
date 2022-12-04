<?php
require 'config/config.php';

if(isset($_SESSION['username'])) {
    $userLoggedIn = $_SESSION['username'];
    $user_details_query = mysqli_query($con, "SELECT * FROM users WHERE username = '$userLoggedIn'");
    $user = mysqli_fetch_array($user_details_query);
}
else {
    header("Location: register.php");
}
?>

<html lang="en">
<head>
    <title>DUSK</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="asset/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.2/css/all.min.css" integrity="sha512-1sCRPdkRXhBV2PBLUdRb4tMg1w2YPf37qatUFeS7zlBy7jJI8Lf4VHwWfZZfpXtYSLy85pkm9GaYVYMfw5BC1A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    
</head>
<body>
    <div class="sidenav">
        <a href="#" class="group_icon"><i class="fa-solid fa-square-virus"></i></a>
        <a href="#" class="group_icon"><i class="fa-solid fa-square"></i></a>
        <a href="#" class="group_icon"><i class="fa-solid fa-square"></i></a>
        <a href="#" class="group_icon"><i class="fa-solid fa-square"></i></a>
        <a href="#" class="group_icon"><i class="fa-solid fa-square"></i></a>
    </div>
    <!-- <div class="top_bar">
        <div class="logo">
            <a href="index.php">TALKY</a>
        </div>
        <nav>
            <a href="index.php"><i class="fa-solid fa-house"></i></a>
            <a href="#"><i class="fa-solid fa-thumbtack"></i></a>
            <a href="#"><i class="fa-solid fa-bell"></i></a>
            <a href="<?php echo $userLoggedIn; ?>"><?php echo $user['first_name']?></a>
            <a href="#"><i class="fa-solid fa-inbox"></i></a>
            <a href="#"><i class="fa-solid fa-circle-question"></i></a>
            <a href="includes/handlers/logout.php"><i class="fa-solid fa-arrow-right-from-bracket"></i></a>
        </nav>   
    </div>

<div class="wrapper"> -->