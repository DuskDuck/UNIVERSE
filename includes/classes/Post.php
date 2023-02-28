<?php
class Post {
    private $user_obj;
    private $con;

    //call when object is init/created
    public function __construct($con, $user){
        $this->con = $con;
        $this->user_obj = new User($con, $user);
    }
    public function savePost($body, $from_channel, $c_group){
        $body = strip_tags($body);

        //escape single quote from input text to not mess up the SQL query
        $body = mysqli_real_escape_string($this->con, $body);
        //remove all spaces incase of post full of spaces still count
        
        $body = str_replace('\r\n', "\n" ,$body);
        $body = nl2br($body);
        
        $check_empty = preg_replace('/\s+/',"",$body); 

        if($check_empty != ""){

            //Current date and time
            $date_added = date("Y/m/d H:i:s");
            //Get username
            $added_by = $this->user_obj->getUsername();
            //echo "<script>$from_channel</script>";
            $user_to = "none";

            $query = mysqli_query($this->con,"INSERT INTO posts VALUES('','$body','$added_by','$user_to','$date_added','no','no','0','$from_channel','$c_group')");
            $returned_id = mysqli_insert_id($this->con);//unused for now

            //insert notification
            //update post count for user
            $num_posts = $this->user_obj->getNumPosts();
            $num_posts++;
            $update_query = mysqli_query($this->con,"UPDATE users SET num_posts='$num_posts' WHERE username='$added_by' ");
        }
    }

    public function submitPost($body, $user_to){
        $body = strip_tags($body);

        //escape single quote from input text to not mess up the SQL query
        $body = mysqli_real_escape_string($this->con, $body);
        //remove all spaces incase of post full of spaces still count
        
        $body = str_replace('\r\n', "\n" ,$body);
        $body = nl2br($body);
        
        $check_empty = preg_replace('/\s+/',"",$body); 

        if($check_empty != ""){

            //Current date and time
            $date_added = date("Y/m/d H:i:s");
            //Get username
            $added_by = $this->user_obj->getUsername();
            if(array_key_exists('current_channel',$_SESSION)){
                $from_channel = $_SESSION['current_channel'];
            }else{
                $from_channel = 'General Chat';
            }
            //echo "<script>$from_channel</script>";
            $user_to = "none";
            $current_user_group_array = explode(",",$this->user_obj->getGroupId());
            $first_user_group = $current_user_group_array[0];
            $c_group = $_SESSION['current_group'] ?? $first_user_group;

            $query = mysqli_query($this->con,"INSERT INTO posts VALUES('','$body','$added_by','$user_to','$date_added','no','no','0','$from_channel','$c_group')");
            $returned_id = mysqli_insert_id($this->con);//unused for now

            //insert notification
            //update post count for user
            $num_posts = $this->user_obj->getNumPosts();
            $num_posts++;
            $update_query = mysqli_query($this->con,"UPDATE users SET num_posts='$num_posts' WHERE username='$added_by' ");
        }
    }

    //function to load post (10 at the time)
    public function loadPostsFriends($data , $limit){

        $page = $data['page'];
        $userLoggedIn= $this->user_obj->getUsername();

        if($page == 1){
            $start = 0;
        }else{
            $start = ($page - 1) * $limit;
        }

        $str = "";
        $data_query = mysqli_query($this->con,"SELECT * FROM posts WHERE deleted='no' ORDER BY id DESC");//link to posts data table
        
        $current_user_group_array = explode(",",$this->user_obj->getGroupId());
        $first_user_group = $current_user_group_array[0];
        $c_group = $_SESSION['current_group'] ?? $first_user_group;
        if(array_key_exists('current_channel',$_SESSION)){
            $c_channel = $_SESSION['current_channel'];
        }else{
            $c_channel = 'General Chat';
        }
        //Loop through database to get all message info
        if(mysqli_num_rows($data_query) > 0){

            $num_iterations = 0;
            $count = 1;

            while($row = mysqli_fetch_array($data_query)) {
                $fc_channel = strval($row['from_channel']);
                if($fc_channel != $c_channel){
                    
                }else{
                    $id = $row['id'];
                    $body = $row['body'];
                    $added_by = $row['added_by'];
                    $date_time = $row['date_added'];

                    //Prepare user_to string to included even if not posted to a user
                    if($row['user_to'] == "none") {
                        $user_to = "";
                    }
                    else {
                        $user_to_obj = new User($this->con , $row['user_to']);
                        $user_to_name = $user_to_obj->getFirstAndLastName();
                        $user_to = "<a href='" . $row['user_to'] . "'>" . $user_to_name . "</a>";
                    }


                    //Check if user who posted, has their account closed
                    $added_by_obj = new User($this->con, $added_by);
                    $added_by_group_array = explode(",",$added_by_obj->getGroupId());
                    if($added_by_obj->isClosed()){
                        continue;
                    }
                    //Check if post is from group member
                    if($c_group == $row['group_id']){
                    //Check if post is from friend
                    //if($user_logged_obj->isFriend($added_by)){
                       
                        if($num_iterations++ < $start)
                            continue;

                        //Once 10 posts have been loaded, break
                        if($count > $limit) {
                            break;
                        }else {
                            $count++;
                        }

                        //get row info
                        $user_details_query = mysqli_query($this->con, "SELECT first_name, last_name, profile_pic FROM users WHERE username='$added_by'");
                        $user_row = mysqli_fetch_array($user_details_query);
                        $first_name = $user_row['first_name'];
                        $last_name = $user_row['last_name'];
                        $profile_pic = $user_row['profile_pic'];


                        //Time handler
                        $date_time_now = date("Y-m-d H:i:s");
                        $start_date = new DateTime($date_time);
                        $end_date = new DateTime($date_time_now);
                        $interval = $start_date->diff($end_date);
                        if($interval->y >= 1){
                            if($interval == 1)
                                $time_message = $interval->y . " year ago";
                            else
                                $time_message = $interval->y . " years ago";
                        }
                        else if ($interval-> m >= 1) {
                            if($interval->d == 0){
                                $days = " ago";
                            }
                            else if($interval->d == 1) {
                                $days = $interval->d . " day ago";
                            }
                            else {
                                $days = $interval->d . " days ago";
                            }

                            if($interval->m == 1) {
                                $time_message = $interval->m . " month" . $days;
                            }
                            else {
                                $time_message = $interval->m . " months" . $days;
                            }
                        }
                        else if($interval->d >= 1) {
                            if($interval->d == 1) {
                                $time_message = "Yesterday";
                            }
                            else {
                                $time_message = $interval->d . " days ago";
                            }
                        }
                        else if($interval->h >= 1) {
                            if($interval->h >= 1) {
                                $time_message = $interval->h . " hour ago";
                            }
                            else {
                                $time_message = $interval->h . " hours ago";
                            }
                        }
                        else if($interval->i >= 1) {
                            if($interval->i >= 1) {
                                $time_message = $interval->i . " minute ago";
                            }
                            else {
                                $time_message = $interval->i . " minutes ago";
                            }
                        }
                        else {
                            if($interval->s < 30) {
                                $time_message = " Just now";
                            }
                            else {
                                $time_message = $interval->s . " seconds ago";
                            }
                        }

                        if($added_by_obj->isOnline()){
                            $str .= "<div class='status_post'>
                                    <div class='post_profile_pic'>
                                        <img src='$profile_pic' width='30'>
                                        <div class='online-indicator'>
                                            <span class='blink'></span>
                                        </div>
                                    </div>

                                    <div class='posted_by' style='color:#ACACAC;'>
                                        <a href='$added_by' onclick='on()'> $first_name $last_name </a> $user_to &nbsp;&nbsp;&nbsp;&nbsp;$date_time
                                    </div>
                                    <div class='post_body'>
                                        $body<br>
                                    </div>
                                    <div class='newsfeedPostOptions'>
                                        <iframe src='like.php?post_id=$id' scrolling='no'></iframe>
                                    </div>
                                </div>
                                ";
                        }else{
                            $str .= "<div class='status_post'>
                                    <div class='post_profile_pic'>
                                        <img src='$profile_pic' width='30'>
                                    </div>
                                    <div class='posted_by' style='color:#ACACAC;'>
                                        <a href='$added_by'  onclick='on()'> $first_name $last_name </a> $user_to &nbsp;&nbsp;&nbsp;&nbsp;$date_time
                                    </div>
                                    <div class='post_body'>
                                        $body<br>
                                    </div>
                                    <div class='newsfeedPostOptions'>
                                        <iframe src='like.php?post_id=$id' scrolling='no'>''</iframe>
                                    </div>
                                </div>
                                ";
                        }
                        //append everything into this string var as html code to echo out( each of this part is one message)
                        //}
                    }
                }
            }

            //Page loading (check if there are any post left in database to show - because it is onlu load 10 each)
            if($count >  $limit){
                $str .= "<input type='hidden' class='nextPage' value='" . ($page + 1) . "'>
                            <input type='hidden' class='noMorePosts' value='false'>";
            }
            else{
                $str .= "<input type='hidden' class='noMorePosts' value='true'>
                            <p class='noMorePostsubnotify' style='text-align: center;'> This is the start of this server. </p>
                            <p class='noMorePostnotify' style='text-align: center;'> Welcome to the Planet! </p>"; 
            }
        }
        echo $str;
    }
}
?>