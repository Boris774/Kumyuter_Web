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
            isset($_POST['dlexpiry']) &&
            isset($_POST['motorplate']) &&
            isset($_POST['franchiseexpiry']) &&
            isset($_POST['status'])){

            include("config/config.php");
            include("config/firebaseRDB.php");
            $db = new firebaseRDB($databaseURL);

            date_default_timezone_set('Asia/Manila');
            $id = $_POST['id'];
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
            $status = trim($_POST['status']);
            
            $update = $db->update("drivers-info", $id, [
            "last"     => $last,
            "first"     => $first,
            "middle"     => $middle,
            "gender"     => $gender,
            "address"     => $address,
            "contact"    => $contact,
            "dlnum"    => $dlnum,
            "dlcode"    => $dlcode,
            "dlexpiry"    => $dlexpiry,
            "motorplate"    => $motorplate,
            "franchiseexpiry"    => $franchiseexpiry,
            "status"    => $status
            ]);

            header('location: index.php?a=admindriverlists');
            exit();
        }
    ?>

    <div class="container">
        <div class="col-md-1"></div>
        <div class="col-md-10">

            <div class="panel panel-default">
                <div class="panel-heading">Update Driver Info</div>
                <div class="panel-body">
                    <div class="col-sm-12">     
                        <?php
                            include("config/config.php");
                            include("config/firebaseRDB.php");

                            $db = new firebaseRDB($databaseURL);
                            $id = $_GET['id'];
                            $retrieve = $db->retrieve("drivers-info/$id");
                            $data = json_decode($retrieve, 1);
                        ?>                   
                        <form class="form-signin" action="index.php?a=admindriveredit" method="POST">

                            <h2 style="color: black;">Driver Basic Info</h2>
                            <hr style="border-top: 2px dashed red;">

                            <div class="row" style="text-align: left;">
                                <div class="col-md-4">
                                    <label style="color: #000000;">Last Name</label>
                                    <input type="text" name="last" class="form-control" placeholder="Last Name" value="<?php if(isset($_POST['last'])) echo $_POST['last']; else echo $data['last']; ?>" style="margin-bottom: 30px;" maxlength="50" required />
                                </div>
                                <div class="col-md-4">
                                    <label style="color: #000000;">First Name</label>
                                    <input type="text" name="first" class="form-control" placeholder="First Name" value="<?php if(isset($_POST['first'])) echo $_POST['first']; else echo $data['first']; ?>" style="margin-bottom: 30px;" maxlength="50" required />
                                </div>
                                <div class="col-md-4">
                                    <label style="color: #000000;">Middle Name</label>
                                    <input type="text" name="middle" class="form-control" placeholder="Middle Name" value="<?php if(isset($_POST['middle'])) echo $_POST['middle']; else echo $data['middle']; ?>" style="margin-bottom: 30px;" maxlength="50" required />
                                </div>
                            </div>

                            <div class="row" style="text-align: left;">
                                <div class="col-md-4">
                                    <label style="color: #000000;">Gender</label>
                                    <select class="form-control" name="gender" style="margin-bottom: 30px;" required>
                                       

                                        <?php
                                            $gender = $data['gender'];
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
                                                if ($gender == 'Male') {
                                                    ?>
                                                        <option value="Male" selected>Male</option>
                                                        <option value="Female">Female</option>
                                                    <?php
                                                }
                                                elseif ($gender == 'Female'){
                                                    ?>
                                                        <option value="Male">Male</option>
                                                        <option value="Female" selected>Female</option>
                                                    <?php
                                                }
                                            }
                                        ?>
                                    </select>
                                </div>

                                <div class="col-md-8">
                                    <label style="color: #000000;">Home Address</label>
                                    <input type="text" name="address" class="form-control" placeholder="Home Address" value="<?php if(isset($_POST['address'])) echo $_POST['address']; else echo $data['address']; ?>" style="margin-bottom: 30px;" maxlength="150" required />
                                </div>
                            </div>

                            <div class="row" style="text-align: left; margin-bottom: 30px;">
                                <div class="col-md-4">
                                    <label style="color: #000000;">Phone Number</label>
                                    <input type="text" name="contact" class="form-control" id="contact" placeholder="Phone Number" value="<?php if(isset($_POST['contact'])) echo $_POST['contact']; else echo $data['contact']; ?>" maxlength="11" required />
                                    <span id="errormsg" style='color:red; font-size: 15px;'></span>
                                </div>

                                <div class="col-md-4">
                                    <label style="color: #000000;">Licence No.</label>
                                    <input type="text" name="dlnum" class="form-control" placeholder="Licence No." value="<?php if(isset($_POST['dlnum'])) echo $_POST['dlnum']; else echo $data['dlnum']; ?>" maxlength="150" required />
                                </div>

                                <div class="col-md-4">
                                    <label style="color: #000000;">DL Code</label>
                                    <input type="text" name="dlcode" class="form-control" placeholder="DL Code" value="<?php if(isset($_POST['dlcode'])) echo $_POST['dlcode']; else echo $data['dlcode']; ?>" maxlength="150" required />
                                </div>
                            </div>

                            <div class="row" style="text-align: left; margin-bottom: 30px;">
                                <div class="col-md-4">
                                    <label style="color: #000000;">License Expiration</label>
                                    <input type="date" name="dlexpiry" class="form-control" placeholder=">License Expiration" value="<?php if(isset($_POST['dlexpiry'])) echo $_POST['dlexpiry']; else echo $data['dlexpiry']; ?>" maxlength="51" required />
                                    <span id="errormsg" style='color:red; font-size: 15px;'></span>
                                </div>

                                <div class="col-md-4">
                                    <label style="color: #000000;">Motor Plate No.</label>
                                    <input type="text" name="motorplate" class="form-control" placeholder="Motor Plate No." value="<?php if(isset($_POST['motorplate'])) echo $_POST['motorplate']; else echo $data['motorplate']; ?>" maxlength="150" required />
                                </div>

                                <div class="col-md-4">
                                    <label style="color: #000000;">Franchise Expiry</label>
                                    <input type="date" name="franchiseexpiry" class="form-control" placeholder="Franchise Expiry" value="<?php if(isset($_POST['franchiseexpiry'])) echo $_POST['franchiseexpiry']; else echo $data['franchiseexpiry']; ?>" maxlength="150" required />
                                </div>
                            </div>

                            <div class="row" style="text-align: left;">
                                <div class="col-md-4">
                                    <label style="color: #000000;">Status</label>
                                    <select class="form-control" name="status" style="margin-bottom: 30px;" required>
                                        <?php
                                            $status = $data['status'];
                                            if (isset($_POST['status'])) {
                                                if ($_POST['status'] == 'ACTIVE') {
                                                    ?>
                                                        <option value="ACTIVE" selected>ACTIVE</option>
                                                        <option value="DEACTIVE">DEACTIVE</option>
                                                    <?php
                                                }
                                                elseif ($_POST['status'] == 'PENDING' || $_POST['status'] == 'DEACTIVE'){
                                                    ?>
                                                        <option value="ACTIVE">ACTIVE</option>
                                                        <option value="DEACTIVE" selected>DEACTIVE</option>
                                                    <?php
                                                }
                                            }
                                            else{
                                                if ($status == 'ACTIVE') {
                                                    ?>
                                                        <option value="ACTIVE" selected>ACTIVE</option>
                                                        <option value="DEACTIVE">DEACTIVE</option>
                                                    <?php
                                                }
                                                elseif ($status == 'PENDING' || $status == 'DEACTIVE'){
                                                    ?>
                                                        <option value="ACTIVE">ACTIVE</option>
                                                        <option value="DEACTIVE" selected>DEACTIVE</option>
                                                    <?php
                                                }
                                            }
                                        ?>
                                    </select>
                                </div>

                                <div class="col-md-8">

                                </div>
                            </div>

                            <div class="row" style="text-align: right;">
                                <div class="col-md-6" style="margin-top: 10px;"></div>
                                <div class="col-md-6" style="margin-top: 10px;">
                                    <input type="hidden" name="id" value="<?php echo $id; ?>">
                                    <input type="submit" class="btn btn-sm btn-success" value="Update Driver">
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
    