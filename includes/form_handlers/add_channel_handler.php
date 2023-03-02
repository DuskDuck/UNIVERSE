<?php
if(isset($_POST['create_channel_button'])){
    if(isset($_POST['channel_type'])){
        $channelname = $_POST['channel_name'];
        $new_channel_list = $channelname;
        $current_group = $_SESSION['current_group'];
        $check_database_query = mysqli_query($con, "SELECT * FROM channel WHERE id = '$current_group'");
        $check_login_query = mysqli_num_rows($check_database_query);

        if($check_login_query == 1){
            $row = mysqli_fetch_array($check_database_query);
            $server_id = $row['id'];
            if($_POST['channel_type'] == "text"){
                $new_channel_list = $row['text_channel'] . "," . $channelname;
                $query = mysqli_query($con, "UPDATE channel SET text_channel = '$new_channel_list' WHERE id = '$current_group'");
            }else{
                $new_channel_list = $row['voice_channel'] . "," . $channelname;
                $query = mysqli_query($con, "UPDATE channel SET voice_channel = '$new_channel_list' WHERE id = '$current_group'");
            }
            header("Location: index.php");
        }
    }
}
?>