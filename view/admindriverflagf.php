<?php
include("config/config.php");
include("config/firebaseRDB.php");

$db = new firebaseRDB($databaseURL);
$id = $_POST['id'];
if($id != ""){
   $update = $db->update("drivers-info", $id, [
            "fflag"    => "1"
            ]);
}
header('location: index.php?a=adminnotifyfranchise');
exit();
?>