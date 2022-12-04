<?php
class User {
    private $user;
    private $con;

    //call when object is init/created
    public function __construct($con, $user){
        $this->con = $con;
        $user_details_query = mysqli_query($con, "SELECT * FROM users WHERE username='$user'");
        $this->user = mysqli_fetch_array($user_details_query);
    }

    //Return User's Full name
    public function getFirstAndLastName(){
        $username = $this->user['username'];
        $query = mysqli_query($this->con,"SELECT first_name, last_name FROM users WHERE username='$username'");
        $row = mysqli_fetch_array($query);
        return $row['first_name'] . " " . $row['last_name'];
    }
    //Return username
    public function getUsername(){
        return $this->user['username'];
    }
    //Return amount of post
    public function getNumPosts(){
        $username = $this->user['username'];
        $query = mysqli_query($this->con, "SELECT num_posts FROM users WHERE username='$username'");
        $row = mysqli_fetch_array($query);
        return $row['num_posts'];
    }
    //Check if user is friend
    public function isFriend($username_to_check){
        $usernameComma = "," . $username_to_check . ",";

        if((strstr($this->user['friend_array'], $usernameComma) || $username_to_check == $this->user['username'])) {
            return true;
        }
        else{
            return false;
        }
    }
    //Check if from the same group
    public function getGroupId(){
        $username = $this->user['username'];
        $query = mysqli_query($this->con, "SELECT group_id FROM users WHERE username='$username'");
        $row = mysqli_fetch_array($query);
        return $row['group_id'];    
    }
    //Check if account is closed
    public function isClosed(){
        $username = $this->user['username'];
        $query = mysqli_query($this->con, "SELECT users_close FROM users WHERE username='$username'");
        $row = mysqli_fetch_array($query);

        if($row['users_close']=="yes")
            return true;
        else
            return false;
    }
}
?>