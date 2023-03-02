<?php
if(isset($_POST['join_button'])){
    $invitecode = $_POST['invite_code'];
    //$query = mysqli_query($con, "INSERT INTO channel VALUES ('','$servername','$target_file','Voice Room','General Chat','$gencode','$userLoggedIn')");
        
    $check_database_query = mysqli_query($con, "SELECT * FROM channel WHERE invite_code = '$invitecode'");
    $check_login_query = mysqli_num_rows($check_database_query);

    if($check_login_query == 1){
        $row = mysqli_fetch_array($check_database_query);
        $group_id = $row['id'];
        $group_array = explode(",",$user['group_id']);
        if(in_array($invitecode,$group_array)){

        }else{
            $new_group_id = $user['group_id'] . "," . $row['id'];
            $update_account = mysqli_query($con,"UPDATE users SET group_id='$new_group_id' WHERE username = '$userLoggedIn'");
            header("Location: index.php");
        }
    } 
}
?>