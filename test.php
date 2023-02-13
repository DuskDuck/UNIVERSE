<!DOCTYPE html>
<html>
<body>
<?php
$channel_array = array("Volvo", "BMW", "Toyota");
$a = 0;
$i = 0;
?>

<form method="post" action="<?php echo $_SERVER['PHP_SELF'];?>">
    <?php
        foreach($channel_array as $value){
            echo "<i class='fa-solid fa-hashtag'></i><input type=\"submit\" value=\"$value\" name=\"button[$value]\"/>";
        }
    ?>
</form>

<?php
    if(array_key_exists('button',$_POST)){
        $_SESSION['current_channel'] = key($_POST['button']);
        if(strcmp($_SESSION['current_channel'],"Volvo")){
            echo $_SESSION['current_channel'];
        }
    }
?>

</body>
</html>