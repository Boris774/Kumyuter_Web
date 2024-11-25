<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Kumyuter - Admin</title>
    <link href="css/bootstrap.min.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.1/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/2.3.2/css/buttons.dataTables.min.css">

    <style type="text/css">
        body{
            font-family: 'Roboto', sans-serif;
            font-size: 15px;
        }

        .section-container {
            position: relative;
            text-align: center;
            color: white;
        }

        .footer-container {
            position: relative;
            text-align: center;
            color: white;
        }

        .centered {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
        }
    </style>
</head>

<body id="page-top" data-spy="scroll" data-target=".navbar-fixed-top" onload="startTime()">
    <header>
        <img style="display: block; max-width: 100%;" src="images/Header.png">
    </header>
    
    <nav class="navbar navbar-default">
        <div class="container-fluid">
            <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="#"></a>
            </div>

            <p class="navbar-text">
            Welcome to logged in as
            <?php
                if (isset($_SESSION['CODE']) && isset($_SESSION['FIRSTNAME']) && isset($_SESSION['LASTNAME']) && isset($_SESSION['USERNAME'])) {
                echo $_SESSION['FIRSTNAME'] ." ". $_SESSION['LASTNAME'] ."!";
                }
            ?>
            </p>

            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav navbar-right">
                <li><a href="?a=admindriveradd"><span class="glyphicon glyphicon-plus-sign text-success" style="margin-right: 3px;"></span> Add</a></li>
                <li><a href="?a=logout"><span class="glyphicon glyphicon-off text-danger" style="margin-right: 3px;"></span> Logout</a></li>
            </ul>
            </div>
        </div>
    </nav>

    <?php
        if (isset($_POST['last']) &&
            isset($_POST['first']) &&
            isset($_POST['middle']) &&
            isset($_POST['gender']) &&
            isset($_POST['address']) &&
            isset($_POST['contact']) &&
            isset($_POST['dlnum']) &&
            isset($_POST['dlcode']) &&
            isset($_FILES['files'])){

            include 'phpqrcode/qrlib.php';
            $path = 'qrcodes/';

            include("config/config.php");
            include("config/firebaseRDB.php");
            $db = new firebaseRDB($databaseURL);

            date_default_timezone_set('Asia/Manila');
            $code = date('ymd-His') . "-". intval( "0" . rand(1,9) . rand(0,9) . rand(0,9) . rand(0,9) . rand(0,9) );
            $last = ucwords(strtolower(trim($_POST['last'])));
            $first = ucwords(strtolower(trim($_POST['first'])));
            $middle = ucwords(strtolower(trim($_POST['middle'])));
            $gender = trim($_POST['gender']);
            $address = trim($_POST['address']);
            $contact = trim($_POST['contact']);
            $dlnum = trim($_POST['dlnum']);
            $dlcode = trim($_POST['dlcode']);
            $dlexpiry = trim($_POST['dlexpiry']);
            $motorplate = trim($_POST['motorplate']);
            $franchiseexpiry = trim($_POST['franchiseexpiry']);
            $username = "";
            $password = "";
            $confirm = "";
            $role = "Driver";
            $dateon = strtotime(date("Y-m-d h:i:sa"));

            $qrcode = "qrcodes/";
            $qrname = $first." ".$last;
            $qrimage = $code.'.png';
            
            $pathqrcode = $qrcode.$qrimage;
            $urlqrcode = $qrcode.$qrimage;
            
            if ($password == $confirm) {
                if (!file_exists($pathqrcode)) {
                    QRcode::png($code, $pathqrcode);

                    $insert = $db->insert("drivers-info", [
                        "code"     => $code,
                        "last" => $last,
                        "first"      => $first,
                        "middle"    => $middle,
                        "gender"    => $gender,
                        "address"    => $address,
                        "contact"    => $contact,
                        "dlnum"    => $dlnum,
                        "dlcode"    => $dlcode,
                        "dlexpiry"    => $dlexpiry,
                        "motorplate"    => $motorplate,
                        "franchiseexpiry"    => $franchiseexpiry,
                        "username"    => $username,
                        "password"    => $password,
                        "role"    => $role,
                        "picture"    => "Unknown",
                        "qrcode"    => $urlqrcode,
                        "status"    => "ACTIVE"
                        ]);

                    $imagename = date('ymd-His') . "-". intval( "0" . rand(1,9) . rand(0,9) . rand(0,9) . rand(0,9) ). "-";
                    $directory = "uploads/";

                    foreach($_FILES['files']['tmp_name'] as $key => $tmp_name ){
                        $file_name = $imagename.$_FILES['files']['name' ][$key];
                        $size =$_FILES['files']['size'][$key];
                        $file_f = $size / 1024;
                        $file_size =round($file_f);
                        $file_tmp =$_FILES['files']['tmp_name'][$key];
                        $file_type=$_FILES['files']['type'][$key];
                        $path="uploads/$file_name";

                        if ($path == "uploads/0") {
                            $path = "---";
                        }

                        $insert = $db->insert("drivers-document", [
                        "code"     => $code,
                        "documents" => $path
                        ]);

                        move_uploaded_file($file_tmp,"$directory".$file_name);
                    }

                    header('location: index.php?a=admindriverlists');
                    exit();
                }
                else{
                    ?>
                        <div class="row text-center">
                            <h5 style='color:red; font-size: 17px;'>File already generated! We can use this cached file to speed up site on common codes!</h5>
                        </div> 
                    <?php
                }
            }
            else{
                ?>
                <script type="text/javascript">
                    alert("Password did not matched!");
                </script>
                <?php
            }
        }
    ?>

    <div class="container">
        <div class="col-md-1"></div>
        <div class="col-md-10">

            <div class="panel panel-default">
                <div class="panel-heading">Driver Registration Form</div>
                <div class="panel-body">
                    <div class="col-sm-12">                        
                        <form class="form-signin" action="index.php?a=admindriveradd" method="POST" enctype="multipart/form-data">

                            <h2 style="color: black;">Driver Basic Info</h2>
                            <hr style="border-top: 2px dashed red;">

                            <div class="row" style="text-align: left;">
                                <div class="col-md-4">
                                    <label style="color: #000000;">Last Name</label>
                                    <input type="text" name="last" class="form-control" placeholder="Last Name" value="<?php if(isset($_POST['last'])) echo $_POST['last']; ?>" style="margin-bottom: 30px;" maxlength="50" required />
                                </div>
                                <div class="col-md-4">
                                    <label style="color: #000000;">First Name</label>
                                    <input type="text" name="first" class="form-control" placeholder="First Name" value="<?php if(isset($_POST['first'])) echo $_POST['first']; ?>" style="margin-bottom: 30px;" maxlength="50" required />
                                </div>
                                <div class="col-md-4">
                                    <label style="color: #000000;">Middle Name</label>
                                    <input type="text" name="middle" class="form-control" placeholder="Middle Name" value="<?php if(isset($_POST['middle'])) echo $_POST['middle']; ?>" style="margin-bottom: 30px;" maxlength="50" required />
                                </div>
                            </div>

                            <div class="row" style="text-align: left;">
                                <div class="col-md-4">
                                    <label style="color: #000000;">Gender</label>
                                    <select class="form-control" name="gender" style="margin-bottom: 30px;" required>
                                       

                                        <?php
                                            if (isset($_POST['gender'])) {
                                                if ($_POST['gender'] == 'Male') {
                                                    ?>
                                                        <option value="Male" selected>Male</option>
                                                        <option value="Female">Female</option>
                                                    <?php
                                                }
                                                elseif ($_POST['gender'] == 'Female'){
                                                    ?>
                                                        <option value="Male">Male</option>
                                                        <option value="Female" selected>Female</option>
                                                    <?php
                                                }
                                            }
                                            else{
                                                ?>
                                                    <option value="Male">Male</option>
                                                    <option value="Female" selected>Female</option>
                                                <?php
                                            }
                                        ?>
                                    </select>
                                </div>

                                <div class="col-md-8">
                                    <label style="color: #000000;">Home Address</label>
                                    <input type="text" name="address" class="form-control" placeholder="Home Address" value="<?php if(isset($_POST['address'])) echo $_POST['address']; ?>" style="margin-bottom: 30px;" maxlength="150" required />
                                </div>
                            </div>

                            <div class="row" style="text-align: left; margin-bottom: 30px;">
                                <div class="col-md-4">
                                    <label style="color: #000000;">Phone Number</label>
                                    <input type="text" name="contact" class="form-control" id="contact" placeholder="Phone Number" value="<?php if(isset($_POST['contact'])) echo $_POST['contact']; ?>" maxlength="11" required />
                                    <span id="errormsg" style='color:red; font-size: 15px;'></span>
                                </div>

                                <div class="col-md-4">
                                    <label style="color: #000000;">Licence No.</label>
                                    <input type="text" name="dlnum" class="form-control" placeholder="Licence No." value="<?php if(isset($_POST['dlnum'])) echo $_POST['dlnum']; ?>" maxlength="150" required />
                                </div>

                                <div class="col-md-4">
                                    <label style="color: #000000;">DL Code</label>
                                    <input type="text" name="dlcode" class="form-control" placeholder="DL Code" value="<?php if(isset($_POST['dlcode'])) echo $_POST['dlcode']; ?>" maxlength="150" required />
                                </div>
                            </div>

                            <div class="row" style="text-align: left; margin-bottom: 30px;">
                                <div class="col-md-4">
                                    <label style="color: #000000;">License Expiration</label>
                                    <input type="date" name="dlexpiry" class="form-control" placeholder=">License Expiration" value="<?php if(isset($_POST['dlexpiry'])) echo $_POST['dlexpiry']; ?>" maxlength="51" required />
                                    <span id="errormsg" style='color:red; font-size: 15px;'></span>
                                </div>

                                <div class="col-md-4">
                                    <label style="color: #000000;">Motor Plate No.</label>
                                    <input type="text" name="motorplate" class="form-control" placeholder="Motor Plate No." value="<?php if(isset($_POST['motorplate'])) echo $_POST['motorplate']; ?>" maxlength="150" required />
                                </div>

                                <div class="col-md-4">
                                    <label style="color: #000000;">Franchise Expiry</label>
                                    <input type="date" name="franchiseexpiry" class="form-control" placeholder="Franchise Expiry" value="<?php if(isset($_POST['franchiseexpiry'])) echo $_POST['franchiseexpiry']; ?>" maxlength="150" required />
                                </div>
                            </div>

                            <div class="row" style="text-align: left; margin-bottom: 30px;">
                                <div class="col-md-4">
                                    <label style="color: #000000;">Upload Documents (*jpg | *png)</label>
                                    <input type="file" name="files[]" class="form-control" accept="image/*" multiple required />
                                </div>

                                <div class="col-md-8">
                                    <h5 class="text-danger" style="margin-top: 20px; line-height: 1.5em;">Note: &nbsp;&nbsp; Please attach documents front & back of Driver License, Official Receipt (OR), Certificate of Registration (CR) and Franchise Documents.</h5>
                                </div>
                            </div>

                            <!-- <h2 style="color: black;">User Account</h2>
                            <hr style="border-top: 2px dashed red;">

                            <div class="row" style="text-align: left;">
                                <div class="col-md-4">
                                    <label style="color: #000000;">Email Address</label>
                                    <input type="email" name="email" class="form-control" placeholder="Email Address" value="<?php if(isset($_POST['email'])) echo $_POST['email']; ?>" style="margin-bottom: 30px;" maxlength="50" required />
                                </div>

                                <div class="col-md-4">
                                    <label style="color: #000000;">Password</label>
                                    <input type="password" class="form-control" name="password" placeholder="Enter Password" value="<?php if(isset($_POST['password'])) echo $_POST['password']; ?>" style="margin-bottom: 15px;" required />
                                </div>

                                <div class="col-md-4">
                                    <label style="color: #000000;">Confirm Password</label>
                                    <input type="password" class="form-control" name="confirm" placeholder="Enter Confirm Password" value="<?php if(isset($_POST['confirm'])) echo $_POST['confirm']; ?>" style="margin-bottom: 15px;" required />
                                </div>
                            </div> -->

                            <div class="row" style="text-align: right;">
                                <div class="col-md-6" style="margin-top: 10px;"></div>
                                <div class="col-md-6" style="margin-top: 10px;">
                                    <input type="submit" class="btn btn-sm btn-success" value="Add Driver">
                                    <a href="index.php?a=admindriverlists" class="btn btn-sm btn-danger" style="color: white; ">Close</a>
                                </div>
                            </div>
                        </form>
                        <br>
                    </div>
                </div>
            </div>

        </div>
        <div class="col-md-1"></div>
    </div>

    <footer>
        <div class="container footer-container">
            <div class="row centered" style="margin-top: 100px;">
                <p style="text-align: center; color: white;">Copyright © Kumyuter <?php echo date('Y'); ?>. All rights reserved.</p>
            </div>
            <br><br>
        </div>
        <img style="display: block; max-width: 100%;" src="images/Footer.png">
    </footer>

    <script type="text/javascript" src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/buttons/2.3.2/js/dataTables.buttons.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/buttons/2.3.2/js/buttons.html5.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/buttons/2.3.2/js/buttons.print.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            $('#facultyrecords').DataTable( {
                dom: 'Bfrtip',
                buttons: [
                    'excel', 'pdf', 'print'
                ]
            } );
        });
    </script>
</body>

</html>
    