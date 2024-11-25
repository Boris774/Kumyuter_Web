<?php
include("config/config.php");
include("config/firebaseRDB.php");

$db = new firebaseRDB($databaseURL);
$id = $_GET['id'];
if($id != ""){
   $delete = $db->delete("contact-info", $id);
   echo "Data deleted";
}

header('location: index.php?a=adminemergency');
exit();

?>