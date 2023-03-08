<?php
include("includes/header.php");
include("includes/classes/User.php");
include("includes/classes/Post.php");

if(isset($_GET['profile_username'])){
    $username = $_GET['profile_username'];
    $user_details_query = mysqli_query($con, "SELECT * FROM users WHERE username = '$username'");
    $user_array = mysqli_fetch_array($user_details_query);

    $num_friends = (substr_count($user_array['friend_array'],",")) - 1;
}
?>
<!--User detail panel-->
    <div id="overlay">
        <div class="wrapper">
            <div class = "profile_left">
                <div id="pbg" class = "profile_background"></div>
                <img src="<?php echo $user_array['profile_pic']; ?>">
                <?php
                    
                ?>
                <div class='online-indicator'>
                    <span class='blink'></span>
                </div>
                
                    <div class="profile_info">
                        <p><?php echo $user_array['first_name'] . " " . $user_array['last_name']; ?></p>
                        <p><?php echo "Friends: " . $num_friends; ?></p>
                    </div>

                    <div class="esc_button">
                        <a href="index.php"><i class="fa-solid fa-circle-xmark"></i></a>
                    </div>

                    <form action="<?php echo $username;?>">
                        <?php 
                            $profile_user_obj = new User($con,$username);
                            if($profile_user_obj->isClosed()){
                                header("Location: user_closed.php");
                            }

                            $logged_in_user_obj = new User($con, $userLoggedIn);
                            
                            if($userLoggedIn != $username){
                                if($logged_in_user_obj->isFriend($username)){
                                    echo '<input type="submit" name="remove_friend" class="danger" value="Remove Friend">';
                                }
                                else if($logged_in_user_obj->didRecieveRequest($username)){
                                    echo '<input type="submit" name="respond_request " class="warning" value="Respond Request">';
                                }
                                else if($logged_in_user_obj->didSendRequest($username)){
                                    echo '<input type="submit" name="" class="default" value="Request Sent">';
                                }else{
                                    echo '<input type="submit" name="add_friend" class="success" value="Add Friend">';
                                }
                            }
                        ?>
                    </form>

                </div>
            </div>
        </div>
    </div>

    <!-- Background -->
    <div class="channel_list">
        <div class="channel_name"><p>
            <!-- Get Channel Name -->
            <?php
            $channel_id = $user["group_id"];
            $channel_query = mysqli_query($con,"SELECT * FROM channel WHERE id='$channel_id'");
            $channel = mysqli_fetch_array($channel_query); 
            echo $channel["name"];
            ?>
            <i class="fa-solid fa-chevron-down"></i></p></div>
        <div class="channel_ads">
            <img src="asset/images/ads/blackhole.jpg">
            <p>Expand your universe now with UNI Expansion Version</p>
        </div>  
                <?php
                    if(array_key_exists('clicked',$_POST)){
                        $_SESSION['current_channel'] = key($_POST['clicked']);
                    }
                ?>
        <div class="channels">
            <div class="text_channels"><i class="fa-solid fa-chevron-down"></i>TEXT CHANNELS
                <form action="index.php" method="POST">
                    <?php
                        $channelname = $channel['text_channel'];
                        $channel_array = explode(",",$channelname);
                        foreach($channel_array as $value){
                            $buffer_channel = $_SESSION['current_channel'] ?? 'General Chat';
                            if($value == $buffer_channel){
                                echo "<input type=\"submit\" value=\"# $value\" name=\"clicked[$value]\" style='background-color:rgb(90, 95, 99);
                                                                                                                color: rgb(217, 222, 228);
                                                                                                                ''/>";
                            }else{
                                echo "<input type=\"submit\" value=\"# $value\" name=\"clicked[$value]\" style=' 
                                                                                                                {background-color:#303336FF;}
                                                                                                                :hover{
                                                                                                                    background-color: rgb(70, 74, 78);
                                                                                                                }
                                                                                                                ''/>";
                            }
                        }
                    ?>
                </form>
            </div>
            <br>
            <div class="voice_channels"><i class="fa-solid fa-chevron-down"></i>VOICE CHANNELS
                <?php
                    $channelname = $channel['voice_channel'];
                    $channel_array = explode(",",$channelname);
                    foreach($channel_array as $value){
                    echo "<button><i class='fa-solid fa-hashtag'></i>$value</button>";
                    }
                ?>
            </div>
        </div> 
        <div class="user_info">
            <a href="<?php echo $userLoggedIn; ?>"><img src="<?php echo $user['profile_pic']; ?>"></a>
            <div class="user_info_detail">
                <a href="<?php echo $userLoggedIn; ?>">
                <?php
                    echo $user['first_name'] . " " . $user['last_name'];  
                ?>
                </a>
                #4042
            </div>
        </div>
    </div>
    <div class="main_area">
        <div class="nav">
            <div class="chat_welcome">
                <i class="fa-solid fa-hashtag"></i> 
                <?php 
                    if(array_key_exists('current_channel',$_SESSION)){
                        echo $_SESSION['current_channel'];
                    }else{
                        echo 'General Chat';
                    }
                ?>
            </div>
            <div class="button">
                <a href="index.php"><i class="fa-solid fa-house"></i></a>
                <a href="#"><i class="fa-solid fa-thumbtack"></i></a>
                <a href="#"><i class="fa-solid fa-bell"></i></a>
                <a href="#"><i class="fa-solid fa-inbox"></i></a>
                <a href="#"><i class="fa-solid fa-circle-question"></i></a>
                <a href="includes/handlers/logout.php"><i class="fa-solid fa-arrow-right-from-bracket"></i></a>
            </div>
        </div>
        <div class="sub_level">
            <div class="post_area">
                <div class="posts_area"></div>
                <img class="loadingicon"id="loading" src="asset/images/icon/ZZ5H.gif">
                <div class="message_area">
                    <form class="post_form" action="index.php" method="POST">
                        <textarea name="post_text" id="post_text" placeholder="Type your message"></textarea>
                        <input type="submit" name="post" id="post_button" value="SEND">
                        <br>
                    </form>
                </div>
            </div>
            <div class="user_list">
                <div class="online">
                    ONLINE
                    <?php
                    $userlist_query = "SELECT * FROM users";
                    if($result = mysqli_query($con,$userlist_query)){
                        while($row = $result->fetch_assoc()){
                            if($row['online']){
                                if($row['group_id'] == $channel_id){
                                    $name = $row["first_name"] . " " . $row["last_name"];
                                    $profile_pic = $row["profile_pic"];
                                    echo    "<div class='user_list_item'>
                                                <img src='$profile_pic'></img>
                                                <p>$name</p>
                                            </div>";
                                }
                            }
                        }
                    }
                    ?>
                </div>
                <div class="offline">
                    OFFLINE
                    <?php
                    $userlist_query = "SELECT * FROM users";
                    if($result = mysqli_query($con,$userlist_query)){
                        while($row = $result->fetch_assoc()){
                            if($row['online']){
                            }else{
                                if($row['group_id'] == $channel_id){
                                    $name = $row["first_name"] . " " . $row["last_name"];
                                    $profile_pic = $row["profile_pic"];
                                    echo    "<div class='user_list_item'>
                                                <img src='$profile_pic'></img>
                                                <p>$name</p>
                                            </div>";
                                }
                            }
                        }
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/color-thief/2.3.0/color-thief.umd.js"></script>
    <script src="profile.js" defer></script>
</body>
</html>