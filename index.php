<?php 
	session_start();
	require 'config/database.php';

	if(isset($_POST['a'])){
		$a = $_POST['a'];
	}
	elseif(isset($_GET['a'])){
		$a = $_GET['a'];
	}else{
		$a = 'index';
	}
	
	if($a == 'index'){
		include 'view/header.php';
        include 'view/menu.php';
		include 'view/main.php';	
		include 'view/footer.php';
	}
    elseif($a == 'sendpassword'){
        include 'view/header.php';
        include 'view/menu.php';
        include 'view/sendpassword.php';    
        include 'view/footer.php';
    }
    elseif($a == 'forgotpassword'){
        include 'view/header.php';
        include 'view/menu.php';
        include 'view/forgotpassword.php';    
        include 'view/footer.php';
    }
    elseif($a == 'aboutus'){
        include 'view/header.php';
        include 'view/menu.php';
        include 'view/about.php';    
        include 'view/footer.php';
    }
    elseif($a == 'driverregister'){
        include 'view/header.php';
        include 'view/menu.php';
        include 'view/driverregister.php';
        include 'view/footer.php';
    }
    elseif($a == 'adminuser'){
        include 'view/adminuser.php';
    }
    elseif($a == 'adminuseradd'){
        include 'view/adminuseradd.php';
    }
    elseif($a == 'adminuseredit'){
        include 'view/adminuseredit.php';
    }
    elseif($a == 'staffpassword'){
        include 'view/staffpassword.php';
    }
    elseif($a == 'driverprofile'){
        include 'view/driverprofile.php';
    }
    elseif($a == 'passengerhome'){
        include 'view/passengerhome.php';
    }
    elseif($a == 'mapping'){
        include 'view/mapping.php';
    }
    elseif($a == 'adminpassengeremergency'){
        include 'view/adminpassengeremergency.php';
    }
    elseif($a == 'adminpassengeremergencyupdate'){
        include 'view/adminpassengeremergencyupdate.php';
    }
    elseif($a == 'adminnotifydriver'){
        include 'view/adminnotifydriver.php';
    }
    elseif($a == 'admindriverflags'){
        include 'view/admindriverflags.php';
    }
    elseif($a == 'admindriverflagd'){
        include 'view/admindriverflagd.php';
    }
    elseif($a == 'admindriverflagf'){
        include 'view/admindriverflagf.php';
    }
    elseif($a == 'adminnotifydriveredit'){
        include 'view/adminnotifydriveredit.php';
    }
    elseif($a == 'adminnotifylicense'){
        include 'view/adminnotifylicense.php';
    }
    elseif($a == 'adminnotifyfranchise'){
        include 'view/adminnotifyfranchise.php';
    }
    elseif($a == 'adminhome'){
        include 'view/adminhome.php';
    }
    elseif($a == 'adminhomeedit'){
        include 'view/adminhomeedit.php';
    }
    elseif($a == 'adminstudentlists'){
        include 'view/adminstudentlists.php';
    }
    elseif($a == 'admindriverlists'){
        include 'view/admindriverlists.php';
    }
    elseif($a == 'admindriveradd'){
        include 'view/admindriveradd.php';
    }
    elseif($a == 'admindriveredit'){
        include 'view/admindriveredit.php';
    }
    elseif($a == 'adminhistory'){
        include 'view/adminhistory.php';
    }
    elseif($a == 'adminemergency'){
        include 'view/adminemergency.php';
    }
    elseif($a == 'adminemergencyadd'){
        include 'view/adminemergencyadd.php';
    }
    elseif($a == 'adminemergencyedit'){
        include 'view/adminemergencyedit.php';
    }
    elseif($a == 'adminemergencydelete'){
        include 'view/adminemergencydelete.php';
    }
    elseif ($a == 'logout') {
        include 'module/logout.php';
    }

    // include("config/config.php");
    // include("config/firebaseRDB.php");
    // $db = new firebaseRDB($databaseURL);

    $data = $db->retrieve("users-info");
    $data = json_decode($data, 1);
    $count = 0;
                
    if(is_array($data)){
        foreach($data as $id => $usersinfo){
            $count = $count + 1;

            $usercode = $usersinfo['code'];
            $name = $usersinfo['name'];
            $contact = $usersinfo['contact'];
            $address = $usersinfo['address'];
            $email = $usersinfo['email'];
            $user = $usersinfo['user'];
            $pass = $usersinfo['pass'];
            $role = $usersinfo['role'];
            $profile = $usersinfo['picture'];
            $status = $usersinfo['status'];
            $sql = mysqli_query($conn, "SELECT * FROM tbl_users WHERE USERNAME ='$user' AND PASSWORD ='$pass'");
            if (mysqli_num_rows($sql) > 0){
                $info = mysqli_fetch_array($sql);

                $sql = "UPDATE tbl_users SET FULLNAME = '$name', CONTACT = '$contact', ADDRESS = '$address', EMAIL = '$email', USERNAME = '$user', PASSWORD = '$pass', ROLE = '$role', PROFILE = '$profile', STATUS = '$status' WHERE USERCODE ='$usercode'";
                if (!mysqli_query($conn,$sql)) {
                    die('Error:'.mysqli_error($conn));
                }
            }
            else{
                $sql = "INSERT INTO tbl_users(USERCODE, FULLNAME, CONTACT, ADDRESS, EMAIL, USERNAME, PASSWORD, ROLE, PROFILE, STATUS) VALUES('$usercode','$name','$contact','$address', '$email', '$user', '$pass', '$role', '$profile', '$status')";
                if (!mysqli_query($conn,$sql)) {
                    die('Error:'.mysqli_error($conn));
                }
            }
        }
    }

    $data = $db->retrieve("drivers-info");
    $data = json_decode($data, 1);
    $count = 0;
                
    if(is_array($data)){
        foreach($data as $id => $driversinfo){
            $count = $count + 1;

            $usercode = $driversinfo['code'];
            $last = $driversinfo['last'];
            $first = $driversinfo['first'];
            $middle = $driversinfo['middle'];
            $gender = $driversinfo['gender'];
            $contact = $driversinfo['contact'];
            $address = $driversinfo['address'];
            $username = $driversinfo['username'];
            $password = $driversinfo['password'];
            $dlnum = $driversinfo['dlnum'];
            $dlcode = $driversinfo['dlcode'];
            $dlexpiry = $driversinfo['dlexpiry'];
            $motorplate = $driversinfo['motorplate'];
            $franchiseexpiry = $driversinfo['franchiseexpiry'];
            $role = $driversinfo['role'];
            $qrcode = $driversinfo['qrcode'];
            $profile = $driversinfo['picture'];
            $status = $driversinfo['status'];
            
            $sql = mysqli_query($conn, "SELECT * FROM tbl_drivers WHERE CODE ='$usercode'");
            if (mysqli_num_rows($sql) > 0){
                $info = mysqli_fetch_array($sql);

                $sql = "UPDATE tbl_drivers SET LAST = '$last', FIRST = '$first', MIDDLE = '$middle', GENDER = '$gender', CONTACT = '$contact', ADDRESS = '$address',  USERNAME = '$username', PASSWORD = '$password',  DLNUM = '$dlnum', DLCODE = '$dlcode', DLEXPIRY = '$dlexpiry', MOTORPLATE = '$motorplate', FRANCHISEEXPIRY = '$franchiseexpiry', ROLE = '$role', QRCODE= '$qrcode', PROFILE= '$profile', STATUS = '$status' WHERE CODE ='$usercode'";
                if (!mysqli_query($conn,$sql)) {
                    die('Error:'.mysqli_error($conn));
                }
            }
            else{
                $sql = "INSERT INTO tbl_drivers(CODE, LAST, FIRST, MIDDLE, GENDER, CONTACT, ADDRESS, USERNAME, PASSWORD, DLNUM, DLCODE, DLEXPIRY, MOTORPLATE, FRANCHISEEXPIRY, ROLE, QRCODE, PROFILE, STATUS) VALUES('$usercode','$last','$first','$middle', '$gender', '$contact', '$address', '$username', '$password', '$dlnum', '$dlcode', '$dlexpiry', '$motorplate', '$franchiseexpiry', '$role', '$qrcode', '$profile', '$status')";
                if (!mysqli_query($conn,$sql)) {
                    die('Error:'.mysqli_error($conn));
                }
            }
        }
    }

    $data = $db->retrieve("history-info");
    $data = json_decode($data, 1);
    $count = 0;
                
    if(is_array($data)){
        foreach($data as $id => $historyinfo){

            $co = $historyinfo['code'];
            $uc = $historyinfo['usercode'];
            $pn = $historyinfo['passengername'];
            $pc = $historyinfo['passengercontact'];
            $pa = $historyinfo['passengeraddress'];
            $dn = $historyinfo['drivername'];
            $dc = $historyinfo['drivercontact'];
            $da = $historyinfo['driveraddress'];
            $dlc = $historyinfo['dlcode'];
            $dle = $historyinfo['dlexpiry'];
            $mot = $historyinfo['motorplate'];
            $fra = $historyinfo['franchiseexpriy'];
            $dat = $historyinfo['dateon'];

            $sql = mysqli_query($conn, "SELECT * FROM tbl_history WHERE CODE='$co'");
            if (mysqli_num_rows($sql) > 0){
                $info = mysqli_fetch_array($sql);

                $sql = "UPDATE tbl_history SET USERCODE = '$uc', PASSENGERNAME = '$pn', PASSENGERCONTACT = '$pc', PASSENGERADDRESS = '$pa', DRIVERNAME = '$dn', DRIVERCONTACT = '$dc', DRIVERADDRESS = '$da', DLCODE = '$dlc', DLEXPIRY = '$dle', MOTORPLATE = '$mot', FRANCHISEEXPIRY = '$fra', DATEON = '$dat' WHERE CODE ='$code'";
                if (!mysqli_query($conn,$sql)) {
                    die('Error:'.mysqli_error($conn));
                }
            }
            else{
                $sql = "INSERT INTO tbl_history(CODE, USERCODE, PASSENGERNAME, PASSENGERCONTACT, PASSENGERADDRESS, DRIVERNAME, DRIVERCONTACT, DRIVERADDRESS, DLCODE, DLEXPIRY, MOTORPLATE, FRANCHISEEXPIRY, DATEON) VALUES('$co','$uc','$pn','$pc','$pa', '$dn','$dc','$da','$dlc','$dle','$mot','$fra','$dat')";
                if (!mysqli_query($conn,$sql)) {
                    die('Error:'.mysqli_error($conn));
                }
            }
        }
    }

    mysqli_close($conn);
?>