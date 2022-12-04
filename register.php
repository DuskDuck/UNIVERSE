<?php
require 'config/config.php';
require 'includes/form_handlers/register_handler.php';
require 'includes/form_handlers/login_handler.php';
?>
<html lang="en">
<head>
    <title>DUSK - Sign up</title>
    <link rel="stylesheet" type="text/css" href="asset/css/register_style.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
    <script src="asset/js/register.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.2/css/all.min.css" integrity="sha512-1sCRPdkRXhBV2PBLUdRb4tMg1w2YPf37qatUFeS7zlBy7jJI8Lf4VHwWfZZfpXtYSLy85pkm9GaYVYMfw5BC1A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body>
    <?php
    if(isset($_POST['register_button'])){
        echo '
        <script>
        $(document).ready(function() {
            $("#first").hide();
            $("#second").show();
        })
        </script>
        ';
    }
    ?>
    <div class="wrapper">
        <div class="login_box">
            <div class="login_header">
                <h2>DUSK</h2>
                Login or sign up
            </div>
            <div id="first">
                <form action = "register.php" method="POST">
                    <div class="InputAddOn">
                        <div class="InputAddOn-item">
                            <p class="input-group-text"><i class="fa-solid fa-envelope"></i></p>
                        </div>
                        <input type="email" name="log_email" placeholder="Email Address" value="<?php 
                        if(isset($_SESSION['log_email'])){
                            echo $_SESSION['log_email'];
                        }
                        ?>" required>
                    <br>
                    </div>
                    <div class="InputAddOn">
                        <div class="InputAddOn-item">
                            <p class="input-group-text"><i class="fa-solid fa-lock"></i></i></p>
                        </div>
                        <input type="password" name="log_password" placeholder="Password" required>
                        <br>
                    </div>
                    <?php if(in_array("Email or password was incorrect!<br>",$error_array)) echo '<span class="notification">Email or password was incorrect!</span><br>';?>
                    <input type="submit" name="login_button" value="Login"><br>
                    New to DUSK? <a href="#" id="signup" class="signup">Create an Account</a>
                    <br>
                </form>
            </div>
            <div id="second">
                <form action = "register.php" method="POST">
                <form action = "register.php" method="POST">
                    <div class="InputAddOn">
                        <div class="InputAddOn-item">
                            <p class="input-group-text"><i class="fa-solid fa-user"></i></p>
                        </div>
                        <input type="text" name="reg_fname" placeholder="First Name" value="<?php 
                        if(isset($_SESSION['reg_fname'])){
                            echo $_SESSION['reg_fname'];
                        }
                        ?>" required>
                        <br>
                    </div>
                    <?php if(in_array("Your first name must be between 2 and 25 character<br>",$error_array)) echo '<span class="notification">Your first name must be between 2 and 25 character</span><br>'; ?>
                    <form action = "register.php" method="POST">
                    <div class="InputAddOn">
                        <div class="InputAddOn-item">
                            <p class="input-group-text"><i class="fa-solid fa-user"></i></i></p>
                        </div>
                        <input type="text" name="reg_lname" placeholder="Last Name" value="<?php 
                        if(isset($_SESSION['reg_lname'])){
                            echo $_SESSION['reg_lname'];
                        }
                        ?>" required>
                        <br>
                    </div>
                    <?php if(in_array("Your last name must be between 2 and 25 character<br>",$error_array)) echo '<span class="notification">Your last name must be between 2 and 25 character</span><br>'; ?>
                    <form action = "register.php" method="POST">
                    <div class="InputAddOn">
                        <div class="InputAddOn-item">
                            <p class="input-group-text"><i class="fa-solid fa-envelope"></i></p>
                        </div>
                        <input type="email" name="reg_email" placeholder="Email" value="<?php 
                        if(isset($_SESSION['reg_email'])){
                            echo $_SESSION['reg_email'];
                        }
                        ?>" required>
                        <br>
                    </div>
                    <form action = "register.php" method="POST">
                    <div class="InputAddOn">
                        <div class="InputAddOn-item">
                            <p class="input-group-text"><i class="fa-solid fa-envelope-circle-check"></i></p>
                        </div>
                        <input type="email" name="reg_email2" placeholder="Confirm Email" value="<?php 
                        if(isset($_SESSION['reg_email2'])){
                            echo $_SESSION['reg_email2'];
                        }
                        ?>" required>
                        <br>
                    </div>
                    <?php if(in_array("Email already in use<br>",$error_array)) echo '<span class="notification">Email already in use</span><br>'; 
                    else if(in_array("Invalid email format<br>",$error_array)) echo '<span class="notification">Invalid email format</span><br>'; 
                    else if(in_array("Emails don't match<br>",$error_array)) echo '<span class="notification">Emails do not match</span><br>'; ?>
                    <form action = "register.php" method="POST">
                    <div class="InputAddOn">
                        <div class="InputAddOn-item">
                            <p class="input-group-text"><i class="fa-solid fa-unlock-keyhole"></i></p>
                        </div>
                        <input type="password" name="reg_password" placeholder="Password" required>
                        <br>
                    </div>
                    <form action = "register.php" method="POST">
                    <div class="InputAddOn">
                        <div class="InputAddOn-item">
                            <p class="input-group-text"><i class="fa-solid fa-lock"></i></p>
                        </div>
                        <input type="password" name="reg_password2" placeholder="Confirm Password" required>
                        <br>
                    </div>
                    <?php if(in_array("Your password can only letter or numbers<br>",$error_array)) echo '<span class="notification">Your password can only letter or numbers</span><br>'; 
                    else if(in_array("Your password must be between 6 and 30 charcter<br>",$error_array)) echo '<span class="notification">Your password must be between 6 and 30 charcter</span><br>'; 
                    else if(in_array("Your password do not match<br>",$error_array)) echo '<span class="notification">Your password do not match</span><br>'; ?>
                    
                    <input type="submit" name="register_button" value="Register">

                    <br>

                    <?php if(in_array("<span style='color:#00A181;'> You're all set! Go ahead and log in</span><br>",$error_array)) echo "<span style='color:#00A181;'> You're all set! Go ahead and log in</span><br>";?>
                    Already have an account? <a href="#" id="signin" class="signin">Sign in</a>
                </form>
            </div>
        </div>
    </div>
</body>
</html>