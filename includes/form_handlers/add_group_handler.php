<?php
if(isset($_POST['create_button'])){
    if(isset($_FILES['img'])){
        $target_dir = "asset/images/uploads/";
        $target_file = $target_dir . basename($_FILES["img"]["name"]);
        move_uploaded_file($_FILES["img"]["tmp_name"], $target_file);
        
        $servername = $_POST['server-name'];
        srand(time());
        $gencode = rand(100000,999999);
        $query = mysqli_query($con, "INSERT INTO channel VALUES ('','$servername','$target_file','Voice Room','General Chat','$gencode','$userLoggedIn','')");
        
        $check_database_query = mysqli_query($con, "SELECT * FROM channel WHERE name = '$servername'");
        $check_login_query = mysqli_num_rows($check_database_query);

        if($check_login_query == 1){
            $row = mysqli_fetch_array($check_database_query);
            $server_id = $row['id'];
            $new_group_id = $user['group_id'] . "," . $row['id'];
            $update_account = mysqli_query($con,"UPDATE users SET group_id='$new_group_id' WHERE username = '$userLoggedIn'");
            header("Location: index.php");
        } 
    }
}
?>