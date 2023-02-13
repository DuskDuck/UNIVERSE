<html>
<head>
    <title></title>
    <link rel="stylesheet" type="text/css" href="asset/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.2/css/all.min.css" integrity="sha512-1sCRPdkRXhBV2PBLUdRb4tMg1w2YPf37qatUFeS7zlBy7jJI8Lf4VHwWfZZfpXtYSLy85pkm9GaYVYMfw5BC1A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body>
    <style type="text/css">
        * {
            font-family: 'Quicksand-Bold',sans-serif;
        }
        body {
            background-color: transparent;
        }
        form {
            position: absolute;
            top: 0;
            height: 0;
        }
    </style>
    <?php
        require 'config/config.php';
        include("includes/classes/User.php");
        include("includes/classes/Post.php");       

        if(isset($_SESSION['username'])) {
            $userLoggedIn = $_SESSION['username'];
            $user_details_query = mysqli_query($con, "SELECT * FROM users WHERE username = '$userLoggedIn'");
            $user = mysqli_fetch_array($user_details_query);
        }
        else {
            header("Location: register.php");
        }
        //Get post's ID
        if(isset($_GET['post_id'])){
            $post_id = $_GET['post_id'];
        }

        $get_likes = mysqli_query($con, "SELECT likes, added_by FROM posts WHERE id='$post_id'");
        $row = mysqli_fetch_array($get_likes);
        $total_likes = $row['likes'];
        $user_liked = $row['added_by'];

        $user_details_query = mysqli_query($con,"SELECT * FROM users WHERE username='$user_liked'");
        $row = mysqli_fetch_array($user_details_query);
        $total_user_likes = $row['num_likes'];

        if(isset($_POST['like_button'])){
            $total_likes++;
            $query = mysqli_query($con,"UPDATE posts SET likes='$total_likes' WHERE id='$post_id'");
            $total_user_likes++;
            $user_liked = mysqli_query($con,"UPDATE users SET num_likes='$total_user_likes' WHERE username='$user_liked'");
            $insert_user = mysqli_query($con,"INSERT INTO likes VALUES('','$userLoggedIn','$post_id')");
        }

        
        if(isset($_POST['unlike_button'])){
            $total_likes--;
            $query = mysqli_query($con,"UPDATE posts SET likes='$total_likes' WHERE id='$post_id'");
            $total_user_likes--;
            $user_liked = mysqli_query($con,"UPDATE users SET num_likes='$total_user_likes' WHERE username='$user_liked'");
            $insert_user = mysqli_query($con,"DELETE FROM likes WHERE username = '$userLoggedIn' AND post_id='$post_id'");
        }

        $check_query = mysqli_query($con, "SELECT * FROM likes WHERE username='$userLoggedIn' AND post_id='$post_id'");
        $num_row = mysqli_num_rows($check_query);

        if($num_row > 0){
            echo '<form action="like.php?post_id=' . $post_id . '" method="POST">
                    <button type="submit" class="comment_like" name="unlike_button" value = "" style="color:#F3BB1F;"><i class="fa-solid fa-thumbs-up"></i></button>
                    <div class="like_value">' . $total_likes .' </div></form>';
        }else{
            echo '<form action="like.php?post_id=' . $post_id . '" method="POST">
                    <button type="submit" class="comment_like" name="like_button" value = "" ><i class="fa-solid fa-thumbs-up"></i></button>
                    <div class="like_value">' . $total_likes .' </div></form>';
        }
    ?>
    
</body>
</html>