<?php
//Delcaring varibles to prevent errors

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
require("vendor/autoload.php");

$fname = ""; //first name
$lname = ""; //last name
$em = "";    //email 
$em2 = "";   //email 2
$password = ""; //password
$password2 = "";//password 2
$date = "";        //signup date
$error_array = array(); //hold error messages

if(isset($_POST['register_button'])){
    //registration from values

    //first name handle
    $fname = strip_tags($_POST['reg_fname']);   //remove HTML tags
    $fname = str_replace('','',$fname);         //remove space in name
    $fname = ucfirst(strtolower($fname));       //uppercase first letter only
    $_SESSION['reg_fname'] = $fname;

    //last name handle
    $lname = strip_tags($_POST['reg_lname']);   //remove HTML tags
    $lname = str_replace('','',$lname);         //remove space in name
    $lname = ucfirst(strtolower($lname));       //uppercase first letter only
    $_SESSION['reg_lname'] = $lname;

    //email handle
    $em = strip_tags($_POST['reg_email']);      //remove HTML tags
    $em = str_replace('','',$em);               //remove space in email
    $em = ucfirst(strtolower($em));             //uppercase first letter only
    $_SESSION['reg_email'] = $em;

    //email confirmation handle
    $em2 = strip_tags($_POST['reg_email2']);    //remove HTML tags
    $em2 = str_replace('','',$em2);             //remove space in email
    $em2 = ucfirst(strtolower($em2));           //uppercase first letter only
    $_SESSION['reg_email2'] = $em2;

    //password handle
    $password = strip_tags($_POST['reg_password']);         //remove HTML tags
    $password2 = strip_tags($_POST['reg_password2']);       //remove HTML tags

    $date = date("Y-m-d"); //get current date

    if($em == $em2){
        //check if email match is in valid format
        if(filter_var($em,FILTER_VALIDATE_EMAIL)){

            $em = filter_var($em,FILTER_VALIDATE_EMAIL);
            // Check if email exist
            $e_check = mysqli_query($con,"SELECT email FROM users WHERE email = '$em'");
            //Count number of row returned
            $num_rows = mysqli_num_rows($e_check);

            if($num_rows > 0){
                array_push($error_array,"Email already in use<br>");
            }
        }
        else{
            array_push($error_array,"Invalid email format<br>");
        }
    }
    else{
        array_push($error_array,"Emails don't match<br>");
    }

    if(strlen($fname) > 25 || strlen($fname) < 2){
        array_push($error_array,"Your first name must be between 2 and 25 character<br>");
    }
    if(strlen($lname) > 25 || strlen($lname) < 2){
        array_push($error_array,"Your last name must be between 2 and 25 character<br>");
    }
    if($password != $password2){
        array_push($error_array,"Your password do not match<br>");
    }
    else{
        if(preg_match('/[^A-Za-z0-9]/',$password)){
            array_push($error_array,"Your password can only letter or numbers<br>");
        }
    }
    if(strlen($password) > 30 || strlen($password) < 6){
        array_push($error_array,"Your password must be between 6 and 30 charcter<br>");
    }
    if(empty($error_array)){
        $password = md5($password); //Encrypt password before send to database

        //Generate username by concatenating first and last name
        $username = strtolower($fname . "_" . $lname);
        $check_username_query = mysqli_query($con, "SELECT username FROM users WHERE username='$username'");

        $i = 0;
        //if username already exist -> add number
        while(mysqli_num_rows($check_username_query) != 0){
            $i++; //add 1 to i
            $username = $username . "_" . $i;
            $check_username_query = mysqli_query($con, "SELECT username FROM users WHERE username='$username'");
        }

        //Profile picture assignment
        $profile_pic = "asset/images/profile_pic/default/DefaultUser.png";
        
        $query = mysqli_query($con, "INSERT INTO users VALUES ('','$fname','$lname','$username','$em','$password','$date','$profile_pic','0','0','no',',','','1')");

        // $mail = new PHPMailer(true);
        // $mail->isSMTP();
        // $mail->Host = 'smtpout.secureserver.net';
        // $mail->SMTPAuth = true;
        // $mail->Username = 'emailaddress@test.com';
        // $mail->Password = 'password';
        // $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        // $mail->Port = 80;
        // $mail->setFrom('tutorial@weblesson.info','Weblesson');
        // $mail->addAddress($_SESSION['reg_email']);
        // $mail->isHTML(true);
        // $mail->Subject = 'Registration Verification for UNIVERSE';
        // $mail->Body = '<p>Hello Bozo<p>';
        // $mail->send();



        array_push($error_array, "<span style='color:#00A181;'> You're all set! Go ahead and log in</span><br>");

        //clear session varible after finished register account
        $_SESSION['reg_fname']="";
        $_SESSION['reg_lname']="";
        $_SESSION['reg_email']="";
        $_SESSION['reg_email2']="";
    }
}
?>