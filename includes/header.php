<?php
require 'config/config.php';
// require 'form_handlers/add_channel_handler.php';

if(isset($_SESSION['username'])) {
    //$_SESSION['current_group'] = 0;
    $userLoggedIn = $_SESSION['username'];
    $user_details_query = mysqli_query($con, "SELECT * FROM users WHERE username = '$userLoggedIn'");
    $user = mysqli_fetch_array($user_details_query);
    // $_SESSION['current_channel'] = 'General Chat';
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
    <link rel="stylesheet" type="text/css" href="asset/css/menu_style.css">
    <link rel="stylesheet" type="text/css" href="asset/css/planet_style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.2/css/all.min.css" integrity="sha512-1sCRPdkRXhBV2PBLUdRb4tMg1w2YPf37qatUFeS7zlBy7jJI8Lf4VHwWfZZfpXtYSLy85pkm9GaYVYMfw5BC1A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    
</head>
<body>
    <div class="sidenav">
        <a href="#" class="app_logo"><i class="fa-solid fa-square-virus"></i></a>
        <?php
                    if(array_key_exists('clicked_c',$_POST)){
                        $_SESSION['current_group'] = key($_POST['clicked_c']);
                        $c_group_id = $_SESSION['current_group'];
                        $group_query = mysqli_query($con,"SELECT * FROM channel WHERE id=$c_group_id");
                        $group_row = mysqli_fetch_array($group_query);
                        $channel_array = explode(",",$group_row['text_channel']);
                        $_SESSION['current_channel'] = $channel_array[0];
                    }
        ?>
        <form action="index.php" method="POST">
            <?php
                if($user['group_id'] != ""){
                    $groupId = $user['group_id'];
                    $group_array = explode(",",$groupId);
                    array_shift($group_array);
                    //$first_user_group = reset($group_array);
                    foreach($group_array as $group){
                        if(isset($_SESSION['current_group'])){
                            
                        }else{
                            $_SESSION['current_group'] = $group_array[0];
                        }
                        $each_group_query = mysqli_query($con,"SELECT * FROM channel WHERE id=$group");
                        $group_row = mysqli_fetch_array($each_group_query);
                        $img = $group_row['group_img'];
                        if($group == $_SESSION['current_group']){
                            echo "<input type=\"image\" class=\"group_icon\" src=\"$img\" value=\"# $group\" name=\"clicked_c[$group]\"/>";
                        }else{
                            echo "<input type=\"image\" class=\"group_icon_nonactive\" src=\"$img\" value=\"# $group\" name=\"clicked_c[$group]\"/>";
                        }
                    }
                }
                
            ?>

            <a href="#" class="group_icon_nonactive" onclick="toggleDiv('overlay_add_channel')"><i class="fa-solid fa-square-plus"></i></a>
        </form>
    </div>
    <script>
		function toggleDiv($Id) {
			var div = document.getElementById($Id);
			if (div.style.display != "block") { 
				div.style.display = "block";
			} else {
				div.style.display = "none";
			}
		}
        function toggleDivJoin() {
            toggleDiv('overlay_join_channel');
            toggleDiv('overlay_add_channel');
        }
        function hideDiv($Id){
            var div = document.getElementById($Id);
            div.style.display = "none";
            console.log("okok");
        }
	</script>
