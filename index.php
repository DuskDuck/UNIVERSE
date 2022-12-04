<?php
include("includes/header.php");
include("includes/classes/User.php");
include("includes/classes/Post.php");

if(isset($_POST['post'])){
    $post= new Post($con, $userLoggedIn);
    $post->submitPost($_POST['post_text'],'none');
    header("Location: index.php");
}
?>
    <!--User detail panel-->
    <div class="channel_list">
        <div class="channel_name"><p>HUST Web Group 3<i class="fa-solid fa-chevron-down"></i></p></div>
        <div class="channel_ads">
            <img src="asset/images/ads/blackhole.jpg">
            <p>Expand your universe now with UNI Expansion Version</p>
        </div>  
        <div class="channels">
            <div class="text_channels"><i class="fa-solid fa-chevron-down"></i>TEXT CHANNELS
                <button><i class="fa-solid fa-hashtag"></i>General-chat</button>
                <button><i class="fa-solid fa-hashtag"></i>Pre-meeting-chat</button>
                <button><i class="fa-solid fa-hashtag"></i>Front-end-chat</button>
                <button><i class="fa-solid fa-hashtag"></i>Back-end-chat</button>
                <button><i class="fa-solid fa-hashtag"></i>UI/UX-team</button>
                <button><i class="fa-solid fa-hashtag"></i>Public-file</button>
                <button><i class="fa-solid fa-hashtag"></i>Management-Detail</button>
                <button><i class="fa-solid fa-hashtag"></i>Chill-zone</button>
            </div>
            <br>
            <div class="voice_channels"><i class="fa-solid fa-chevron-down"></i>VOICE CHANNELS
                <button><i class="fa-solid fa-headphones"></i>General-Voice-chat</button>
                <button><i class="fa-solid fa-headphones"></i>Meeting</button>
                <button><i class="fa-solid fa-headphones"></i>Front-end-meeting</button>
                <button><i class="fa-solid fa-headphones"></i>Back-end-meeting</button>
                <button><i class="fa-solid fa-headphones"></i>World-Cup-Live</button>
                <button><i class="fa-solid fa-headphones"></i>ITSS-Project</button>
                <button><i class="fa-solid fa-headphones"></i>Gaming-Room-#1</button>
                <button><i class="fa-solid fa-headphones"></i>Gaming-Room-#2</button>
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
                <i class="fa-solid fa-hashtag"></i> General-chat
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
                    Online
                    <?php
                    $userlist_query = "SELECT * FROM users";
                    if($result = mysqli_query($con,$userlist_query)){
                        while($row = $result->fetch_assoc()){
                            if($row['online']){
                                $name = $row["first_name"] . " " . $row["last_name"];
                                $profile_pic = $row["profile_pic"];
                                echo    "<div class='user_list_item'>
                                            <img src='$profile_pic'></img>
                                            <p>$name</p>
                                        </div>";
                            }
                        }
                    }
                    ?>
                </div>
                <div class="offline">
                    Offline
                    <?php
                    $userlist_query = "SELECT * FROM users";
                    if($result = mysqli_query($con,$userlist_query)){
                        while($row = $result->fetch_assoc()){
                            if($row['online']){
                            }else{
                                $name = $row["first_name"] . " " . $row["last_name"];
                                $profile_pic = $row["profile_pic"];
                                echo    "<div class='user_list_item' style='opacity: 0.5;'>
                                            <img src='$profile_pic'></img>
                                            <p>$name</p>
                                        </div>";
                            }
                        }
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
    <script>
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
                            // console.log("loading");
                        }
                    });
                
                    function loadPosts() {
                        if(inProgress) { //If it is already in the process of loading some posts, just return
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
                             rect.top >= 96 &&
                        //     rect.left >= 325 &&
                             rect.bottom >= 180  //* or $(window).height()
                        //     rect.right <= ($(".posts_area").innerWidth || $(".posts_area").width) //* or $(window).width()
                        );
                    }
                });
        
    </script>
</body>
</html>