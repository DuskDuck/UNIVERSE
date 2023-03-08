<?php
if(isset($_POST['update_button'])){
    if(isset($_FILES['img'])){
        $target_dir = "asset/images/uploads/";
        $target_file = $target_dir . basename($_FILES["img"]["name"]);
        move_uploaded_file($_FILES["img"]["tmp_name"], $target_file);

        $servername = $_POST['server-name'];
        $current_group = $_SESSION['current_group'];
        $check_database_query = mysqli_query($con, "SELECT * FROM channel WHERE id = '$current_group'");
        $check_login_query = mysqli_num_rows($check_database_query);

        if($check_login_query == 1){
            $row = mysqli_fetch_array($check_database_query);
            $server_id = $row['id'];
   
            if($target_file == $target_dir){
               $target_file = $row['group_img']; 
            }
            
            $update_group = mysqli_query($con,"UPDATE channel SET name = '$servername',group_img = '$target_file' WHERE id = '$server_id'");
            header("Location: index.php");
        } 
    }
}
?>