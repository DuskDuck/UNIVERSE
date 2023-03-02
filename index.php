<?php
include("includes/header.php");
include("includes/classes/User.php");
include("includes/classes/Post.php");
require("includes/form_handlers/add_channel_handler.php");
require("includes/form_handlers/add_group_handler.php");
require("includes/form_handlers/join_channel_handler.php");

if(isset($_POST['post'])){
    $post= new Post($con, $userLoggedIn);
    $post->submitPost($_POST['post_text'],'none');
    header("Location: index.php");
}
?>
    <div id="overlay_join_channel">
        <div class="wrapper_add_channel">
            <h1 style="text-align: center;">Join a Planet</h1>
            <p style="text-align: center;">Enter an invite code below to join an existing planet</p>
            <form action = "index.php" method="POST" enctype="multipart/form-data">
                <br><br>
                <label class = "server_name_text" for="server-name">INVITE CODE</label>
                <input type="text" id="server-name" name="invite_code" required>
                <br><br>
                <input class="button" type="submit" name="join_button" value="Join Planet">
            </form>
            
            <div class="esc_button">
                <a href="#" onclick="toggleDiv('overlay_join_channel')"><i class="fa-solid fa-circle-xmark"></i></a>
            </div>
        </div>
    </div>
    <!-- Add Channel's Group Widget -->
    <div id="overlay_add_channel">
        <div class="wrapper_add_channel">
            <h1 style="text-align: center;">Create a Planet</h1>
            <p style="text-align: center;">A planet is where you and your friend hang out. Make yours and start talking.</p>
            <form action = "index.php" method="POST" enctype="multipart/form-data">
                <label class = "upfile" for="server-image"><i class="fa-solid fa-circle-plus"></i></label>

                <div class="container">
                    <img id="blah" src="https://placehold.it/100" alt="your image"/>
                </div>

                <input type="file" id="server-image" name="img" accept="image/*" onchange="readURL(this);" hidden>
                <br><br>
                <label class = "server_name_text" for="server-name">PLANET NAME</label>
                <input type="text" id="server-name" name="server-name" required>
                <br><br>
                <input class="button" type="submit" name="create_button" value="Create">
            </form>
            <h2 style="text-align: center;">Have an invite already?</h2>
            <button id="join" type="submit" onclick="toggleDivJoin()">Join a Planet</button>
            
            <div class="esc_button">
                <a href="#" onclick="toggleDiv('overlay_add_channel')"><i class="fa-solid fa-circle-xmark"></i></a>
            </div>
        </div>
    </div>
    <script>
        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $('#blah')
                        .attr('src', e.target.result);
                };

                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>

    <!-- Add Text Channel Widget -->
    <div id="overlay_add_text_channel">
        <div class="wrapper_add_text_channel">
            <form action="index.php" method="post">
                <h1>Create Channel</h1>
                <h2>CHANNEL TYPE</h2>
                <div class = "checkbox_class">
                    <label>
                        <div class = "checkbox_card">
                            <i class='fa-solid fa-hashtag'></i>
                            Text
                            <input type="radio" name="channel_type" value="text"> 
                        </div>
                    </label>
                    <label>
                        <div class = "checkbox_card">
                            <i class="fa-solid fa-headphones"></i>
                            Voice
                            <input type="radio" name="channel_type" value="voice">
                        </div>
                    </label>
                </div>
                
                <br>

                <label class = "server_name_text" for="server-name">SERVER NAME</label>
                <input type="text" id="channel-name" name="channel_name" required>
                <br><br>
                <input class="button" type="submit" name="create_channel_button" value="Create Channel">
            </form>
            
            
            <div class="esc_button">
                <a href="#" onclick="toggleDiv('overlay_add_text_channel')"><i class="fa-solid fa-xmark"></i></a>
            </div>
        </div>
    </div>

    <!-- Clear other checkbox, except current choice -->
    <!-- <script>
        var checkboxes = document.querySelectorAll('input[type="checkbox"]');
        selectOneCheckbox(checkboxes);
        function selectOneCheckbox(checkboxes) {
            for (var i = 0; i < checkboxes.length; i++) {
                checkboxes[i].addEventListener('change', function() {
                    if (this.checked) {
                        for (var j = 0; j < checkboxes.length; j++) {
                            if (checkboxes[j] != this) {
                                checkboxes[j].checked = false;
                            }
                        }
                    }
                });
            }
        }
    </script> -->


    <div class="channel_list">
        <div class="channel_name"><p>
            <!-- Get Channel Name -->
            <?php
            $current_user_group_array = explode(",",$user['group_id']);
            $first_user_group = reset($current_user_group_array);
            $channel_id = $_SESSION['current_group'] ?? $first_user_group;
            $_SESSION['current_group'] = $channel_id;
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
            <?php
                if($user['username'] == $channel['admin']){
                    echo "<a href='#' onclick=\"toggleDiv('overlay_add_text_channel')\"><i class='fa-solid fa-plus'></i></a>";
                }
            ?>
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
                if($user['username'] == $channel['admin']){
                    echo "<a href='#' onclick=\"toggleDiv('overlay_add_text_channel')\"><i class='fa-solid fa-plus'></i></a>";
                }
            ?>
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
                        $_SESSION['current_channel'] = 'General Chat';
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
                            $user_group_array = explode(",",$row['group_id']);
                            if($row['online']){
                                if(in_array($channel_id,$user_group_array)){
                                    $name = $row["first_name"] . " " . $row["last_name"];
                                    $profile_pic = $row["profile_pic"];
                                    if($row['username'] == $channel['admin']){
                                        echo    "<div class='user_list_item'>
                                                    <img src='$profile_pic'></img>
                                                    <p>$name</p>
                                                    <i style = 'color: #fee75c;' class='fa-solid fa-crown'></i>
                                                </div>";
                                    }else{
                                        echo    "<div class='user_list_item'>
                                                    <img src='$profile_pic'></img>
                                                    <p>$name</p>
                                                </div>";
                                    }
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
                            $user_group_array = explode(",",$row['group_id']);
                            if($row['online']){
                            }else{
                                if(in_array($channel_id,$user_group_array)){
                                    $name = $row["first_name"] . " " . $row["last_name"];
                                    $profile_pic = $row["profile_pic"];
                                    if($row['username'] == $channel['admin']){
                                        echo    "<div class='user_list_item'>
                                                    <img src='$profile_pic'></img>
                                                    <p>$name</p>
                                                    <i style = 'color: #fee75c;' class='fa-solid fa-crown'></i>
                                                </div>";
                                    }else{
                                        echo    "<div class='user_list_item'>
                                                    <img src='$profile_pic'></img>
                                                    <p>$name</p>
                                                </div>";
                                    }
                                }
                            }
                        }
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
    <script> 
        const container = document.querySelector('.posts_area');
        function on() {
        document.getElementById("overlay").style.display = "block";
        }

        function off() {
        document.getElementById("overlay").style.display = "none";
        }       
                //Function to load 10 message each time (Calculate if messages are on screen or not...).
                $(function(){
                
                    var userLoggedIn = '<?php echo $userLoggedIn; ?>';
                    var inProgress = false;
                    

                    loadPosts(); //Load first posts
                
                    $(".posts_area").scroll(function() {
                        var bottomElement = $(".status_post").last();
                        var noMorePosts = $('.posts_area').find('.noMorePosts').val();
                
                        // isElementInViewport uses getBoundingClientRect(), which requires the HTML DOM object, not the jQuery object. The jQuery equivalent is using [0] as shown below.
                        if (isElementInView(bottomElement[0]) && noMorePosts == 'false') {
                            loadPosts();
                            //console.log("loading");
                        }
                    });
                    $(".channels input" ).click(function() {
                        
                    });
                    function removeAllChildNodes(parent) {
                        while (parent.firstChild) {
                            parent.removeChild(parent.firstChild);
                        }
                    }
                    function reloadPosts(){
                        removeAllChildNodes(container);
                        loadPosts();
                    }
                
                    function loadPosts() {
                        if(inProgress) { 
                            //If it is already in the process of loading some posts, just return
                            return;
                        }

                        inProgress = true;
                        $('#loading').show();
                
                        var page = $('.posts_area').find('.nextPage').val() || 1; //If .nextPage couldn't be found, it must not be on the page yet (it must be the first time loading posts), so use the value '1'
                        var test = $('.posts_area').find('.noMorePosts').val();

                        $.ajax({ //using a bit of AJAX to load data without refreshing the page
                            url: "includes/handlers/ajax_load_posts.php",
                            type: "POST",
                            data: "page=" + page + "&userLoggedIn=" + userLoggedIn,
                            cache:false,
                            success: function(response) {
                                $('.posts_area').find('.nextPage').remove(); //Removes current .nextpage
                                $('.posts_area').find('.noMorePosts').remove(); //Removes current .nextpage
                                $('.posts_area').find('.noMorePostsText').remove(); //Removes current .nextpage
                
                                $('#loading').hide();
                                $(".posts_area").append(response);
                                // console.log( "page=" + page + "&userLoggedIn=" + userLoggedIn );
                
                                inProgress = false;
                            }
                        });
                    }
                
                    //Check if the element is in view
                    function isElementInView (el) {
                            if(el == null) {
                                console.log("return");
                                return;
                            }
                
                        var rect = el.getBoundingClientRect();
                         console.log(rect.top);
                         console.log("bottom" + rect.bottom);
                        // console.log($(".posts_area").height);
                
                        return (
                             rect.top >= 44 &&
                        //     rect.left >= 325 &&
                             rect.bottom >= 135 //* or $(window).height()
                        //     rect.right <= ($(".posts_area").innerWidth || $(".posts_area").width) //* or $(window).width()
                        );
                    }
                });

                $(document).ready(function(){
                    var conn = new WebSocket('ws://localhost:8080');
                    conn.onopen = function(e){
                        console.log("Connection established!");
                        // var bridge = new WebSocket("ws://localhost:8080/chat.php?name=<?php echo $userLoggedIn; ?>")
                    };
                    conn.onclose = function(e){

                    };
                    conn.onmessage = function(e){
                        console.log(e.data);

                        var data = JSON.parse(e.data);

                        if(data.from == 'Me'){
                            var html_data = "<div class='status_post'><div class='post_profile_pic'><img src='"+data.profile_pic+"' width='30'><div class='online-indicator'><span class='blink'></span></div></div><div class='posted_by' style='color:#ACACAC;'><a href='"+data.username+"' onclick='on()'> "+data.fullname+" </a>&nbsp;&nbsp;&nbsp;&nbsp;"+data.dt+"</div><div class='post_body'>"+data.msg+"<br></div><div class='newsfeedPostOptions'><iframe src='like.php?post_id=$id' scrolling='no'></iframe></div></div>";
                        }else{
                            var c_group = '<?php echo $channel_id; ?>';
                            var c_channel = '<?php echo $_SESSION['current_channel']; ?>'; 
                            if(data.group == c_group){
                                if(data.channel == c_channel){
                                    var html_data = "<div class='status_post'><div class='post_profile_pic'><img src='"+data.profile_pic+"' width='30'><div class='online-indicator'><span class='blink'></span></div></div><div class='posted_by' style='color:#ACACAC;'><a href='"+data.username+"' onclick='on()'> "+data.fullname+" </a>&nbsp;&nbsp;&nbsp;&nbsp;"+data.dt+"</div><div class='post_body'>"+data.msg+"<br></div><div class='newsfeedPostOptions'><iframe src='like.php?post_id=$id' scrolling='no'></iframe></div></div>";
                                }
                            }
                        }
                        //$(".posts_area").append(html_data);
                        $(".posts_area").prepend(html_data);
                        
                    }
                    $('.message_area').on('submit',function(event){
                        event.preventDefault(); //prevent web refresh
                        var userLoggedIn = '<?php echo $userLoggedIn; ?>';
                        var message = $('#post_text').val();
                        var channel = '<?php echo $_SESSION['current_channel']; ?>';
                        var group = '<?php echo $channel_id; ?>';

                        var data = {
                            username : userLoggedIn,
                            msg : message,
                            channel : channel,
                            group : group
                        };

                        conn.send(JSON.stringify(data));
                    });
                });
    </script>
</body>
</html>