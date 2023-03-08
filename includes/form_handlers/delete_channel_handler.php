<?php
if(isset($_POST['selectedValue'])){
    $buffer_result = $_POST['selectedValue'];
    $result_array = explode(",",$buffer_result);

    $todelname = $result_array[0];
    
    $current_group = $_SESSION['current_group'];
    $check_database_query = mysqli_query($con, "SELECT * FROM channel WHERE id = '$current_group'");
    $check_login_query = mysqli_num_rows($check_database_query);

    if($check_login_query == 1){
        $row = mysqli_fetch_array($check_database_query);
        if($result_array[1] == "tc"){
            $new_channel_list = str_replace("," . $todelname, "", $row['text_channel']);
            $query = mysqli_query($con, "UPDATE channel SET text_channel = '$new_channel_list' WHERE id = '$current_group'");
        }else if($result_array[1] == "vc"){
            $new_channel_list = str_replace("," . $todelname, "", $row['voice_channel']);
            $query = mysqli_query($con, "UPDATE channel SET voice_channel = '$new_channel_list' WHERE id = '$current_group'");
        }
        header("Location: index.php");
        }
}
?>