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
            top: 3px;
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

        if(isset($_POST['pin'])){
            $query = mysqli_query($con,"UPDATE posts SET pin=1 WHERE id='$post_id'");
        }

        
        if(isset($_POST['unpin'])){
            $query = mysqli_query($con,"UPDATE posts SET pin=0 WHERE id='$post_id'");
        }

        $check_query = mysqli_query($con, "SELECT * FROM posts WHERE id='$post_id'");
        $post_row = mysqli_fetch_array($check_query);

        if($post_row['pin'] == 1){
            echo '<form action="pin.php?post_id=' . $post_id . '" method="POST">
                    <button type="submit" class="comment_like" name="unpin" value = "" style="color:#F3BB1F;"><i class="fa-solid fa-thumbtack"></i></button>
                    </form>';
        }else{
            echo '<form action="pin.php?post_id=' . $post_id . '" method="POST">
                    <button type="submit" class="comment_like" name="pin" value = "" ><i class="fa-solid fa-thumbtack"></i></button>
                    </form>';
        }
    ?>
    
</body>
</html>