<?php
include("../../config/config.php");

// Update the database
$name = $_POST['name'];
$onlinestate = $_POST['online'];

$update_account = mysqli_query($tmpcon, "UPDATE users SET online = $onlinestate WHERE username='$name'");

if ($con->query($update_account) === TRUE) {
  echo "Record updated successfully";
} else {
  echo "Error updating record: " . $con->error;
}
?>