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
        isset($_POST['position']) &&
        isset($_POST['email']) &&
        isset($_POST['password']) &&
        isset($_POST['confirm'])){

        date_default_timezone_set('Asia/Manila');
        $code = date('ymd-His') . "-". intval( "0" . rand(1,9) . rand(0,9) . rand(0,9) . rand(0,9) . rand(0,9) );
        $last = trim($_POST['last']);
        $first = trim($_POST['first']);
        $middle = trim($_POST['middle']);
        $gender = trim($_POST['gender']);
        $address = trim($_POST['address']);
        $contact = trim($_POST['contact']);
        $position = trim($_POST['position']);
        $username = trim($_POST['email']);
        $password = trim($_POST['password']);
        $confirm = trim($_POST['confirm']);
        $role = "Admin";
        $dateon = strtotime(date("Y-m-d h:i:sa"));
        
        
        if ($password == $confirm) {
            $sql = mysqli_query($conn, "SELECT * FROM tbl_staff WHERE USERNAME ='$username'");
            if (mysqli_num_rows($sql) > 0){
                $info = mysqli_fetch_array($sql);

                ?>
                    
                    <div class="row text-center">
                        <h5 style='color:red; font-size: 17px;'>Email Address has already registered!</h5>
                    </div> 
                <?php

            }
            else{

                $sql = "INSERT INTO tbl_staff(CODE, LASTNAME, FIRSTNAME, MIDDLENAME, GENDER, ADDRESS, CONTACT, POSITION, USERNAME, PASSWORD, ROLE, DATEON) VALUES('$code','$last','$first','$middle','$gender','$address', '$contact', '$position', '$username', '$password', '$role', '$dateon')";
                if (!mysqli_query($conn,$sql)) {
                    die('Error:'.mysqli_error($conn));
                }

                header('location: ?a=adminuser');
                exit();
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
                <div class="panel-heading">Staff Registration Form</div>
                <div class="panel-body">
                    <div class="col-sm-12">                        
                        <form class="form-signin" action="index.php?a=adminuseradd" method="POST">

                            <h2 style="color: black;">Staff Basic Info</h2>
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

                                <div class="col-md-8">
                                    <label style="color: #000000;">Position</label>
                                    <input type="text" name="position" class="form-control" placeholder="Position" value="<?php if(isset($_POST['position'])) echo $_POST['position']; ?>" maxlength="150" required />
                                </div>
                            </div>

                            <h2 style="color: black;">User Account</h2>
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
                            </div>

                            <div class="row" style="text-align: right;">
                                <div class="col-md-6" style="margin-top: 10px;"></div>
                                <div class="col-md-6" style="margin-top: 10px;">
                                    <input class="btn btn-sm btn-success" name="facultyregister" type="submit" value="Save Staff">
                                    <a href="index.php?a=adminuser" class="btn btn-sm btn-danger" style="color: white; ">Close</a>
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
                    //'excel', 'pdf', 'print'
                ]
            } );
        });
    </script>
</body>

</html>