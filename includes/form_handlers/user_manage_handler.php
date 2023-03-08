<?php
if(isset($_POST['selecteduValue'])){

    $buffer_result = $_POST['selecteduValue'];
    $result_array = explode(",",$buffer_result);

    $worksname = $result_array[0];

    $current_group = $_SESSION['current_group'];
    $check_database_query = mysqli_query($con, "SELECT * FROM channel WHERE id = '$current_group'");
    $check_login_query = mysqli_num_rows($check_database_query);

    $check_user_query = mysqli_query($con, "SELECT * FROM users WHERE username = '$worksname'");
    $selected_user_row = mysqli_fetch_array($check_user_query);

    if($check_login_query == 1){
        $row = mysqli_fetch_array($check_database_query);
        $server_id = $row['id'];
    
        if($result_array[1] == "kick"){ 
            $new_group_list = str_replace("," . $server_id, "", $selected_user_row['group_id']);
            $update_account = mysqli_query($con,"UPDATE users SET group_id = '$new_group_list' WHERE username = '$worksname'");
        }else if($result_array[1] == "ban"){
            $new_ban_list = $row['ban_list'] . "," . $worksname;
            $query = mysqli_query($con, "UPDATE channel SET ban_list = '$new_ban_list' WHERE id = '$current_group'");
        }else if($result_array[1] == "transfer"){

        }else if($result_array[1] == "unban"){

        }
        header("Location: index.php");
        }
}
?>