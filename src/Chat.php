<?php
namespace MyApp;


use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;
use User;
use Post;
session_start();
$timezone = date_default_timezone_set("Asia/Ho_Chi_Minh");
require dirname(__DIR__) . "/includes/classes/User.php"; 
require dirname(__DIR__) . "/includes/classes/Post.php";
//require dirname(__DIR__) . "database/ChatUser.php";

class Chat implements MessageComponentInterface {
    
    protected $clients;

    public function __construct() {
        $this->clients = new \SplObjectStorage;
    }

    public function onOpen(ConnectionInterface $conn) {
        // Store the new connection to send messages to later
        $this->clients->attach($conn);
        // if(isset($_GET['name'])){
        //     $tmpcon = mysqli_connect("localhost","root","","social");
        //     $username = $_GET['name'];
            
        //     $update_account = mysqli_query($tmpcon, "UPDATE users SET online = 1 WHERE username='$username'");

        //     $tmpcon->close();//close right away for potential threat
        // }
        

        echo "New connection! ({$conn->resourceId})\n";
    }

    public function onMessage(ConnectionInterface $from, $msg) {
        $numRecv = count($this->clients) - 1;
        // echo sprintf('Connection %d sending message "%s" to %d other connection%s' . "\n"
        //     , $from->resourceId, $msg, $numRecv, $numRecv == 1 ? '' : 's');

            $data = json_decode($msg, true);
            $user_name = $data['username'];
            //echo sprintf('Sender: %s'. "\n",$user_name);
            $tmpcon = mysqli_connect("localhost","root","","social");

            $user_pic_query = mysqli_query($tmpcon, "SELECT profile_pic FROM users WHERE username='$user_name'");
            $user_row = mysqli_fetch_array($user_pic_query);
            $data['profile_pic'] = $user_row['profile_pic'];
          
            $user_obj = new User($tmpcon, $user_name);
            $post_obj = new Post($tmpcon,$user_name);
            
            $post_obj->savePost($data['msg'],$data['channel'],$data['group']);

            $data['dt'] = date("d/m/Y h:i:s");
            $data['fullname'] = $user_obj->getFirstAndLastName();
            $tmpcon->close();//close right away for potential threat



        foreach ($this->clients as $client) {
            // if ($from !== $client) {
            //     // The sender is not the receiver, send to each client connected
            //     $client->send($msg);
            // }
            if($from == $client){
                $data['from'] = 'Me';
            }else{
                $data['from'] = $user_name;
            }
            $client->send(json_encode($data));
            echo sprintf("%s" . "\n", json_encode($data));
        }
    }

    public function onClose(ConnectionInterface $conn) {
        // The connection is closed, remove it, as we can no longer send it messages
        $this->clients->detach($conn);

        // if(isset($_SESSION['username'])){
        //     $tmpcon = mysqli_connect("localhost","root","","social");
        //     $username = $_SESSION['username'];
            
        //     $update_account = mysqli_query($tmpcon, "UPDATE users SET online = 1 WHERE username='$username'");

        //     $tmpcon->close();//close right away for potential threat
        // }

        echo "Connection {$conn->resourceId} has disconnected\n";
    }

    public function onError(ConnectionInterface $conn, \Exception $e) {
        echo "An error has occurred: {$e->getMessage()}\n";

        $conn->close();
    }
}
?>