<?php
if(isset($_POST['leave_group'])){
    $current_group = $_SESSION['current_group'];
    $check_database_query = mysqli_query($con, "SELECT * FROM channel WHERE id = '$current_group'");
    $check_login_query = mysqli_num_rows($check_database_query);

    if($check_login_query == 1){
        $row = mysqli_fetch_array($check_database_query);
        $server_id = $row['id'];
        $new_group_list = str_replace("," . $server_id, "", $user['group_id']);
        $update_account = mysqli_query($con,"UPDATE users SET group_id = '$new_group_list' WHERE username = '$userLoggedIn'");
        $_SESSION['current_channel'] = 'General Chat';
        header("Location: index.php");
    } 
}
?>