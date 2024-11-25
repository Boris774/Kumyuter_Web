<?php
include("config/config.php");
include("config/firebaseRDB.php");

$db = new firebaseRDB($databaseURL);
$id = $_POST['id'];
if($id != ""){
   $update = $db->update("drivers-info", $id, [
            "sflag"    => "1"
            ]);
}
header('location: index.php?a=adminnotifydriver');
exit();
?>