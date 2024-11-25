<?php
include("config/config.php");
include("config/firebaseRDB.php");

$db = new firebaseRDB($databaseURL);
$id = $_POST['id'];
if($id != ""){
   $update = $db->update("emergency-info", $id, [
            "status"    => "1"
            ]);
}
header('location: index.php?a=adminpassengeremergency');
exit();
?>