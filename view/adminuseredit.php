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
            isset($_POST['position'])){

            $id = $_POST['id'];
            $last = $_POST['last'];
            $first = $_POST['first'];
            $middle = $_POST['middle'];
            $gender = $_POST['gender'];
            $address = $_POST['address'];
            $contact = $_POST['contact'];
            $position = $_POST['position'];
            
            $sql = "UPDATE tbl_staff SET  LASTNAME='$last', FIRSTNAME='$first', MIDDLENAME='$middle', GENDER='$gender', ADDRESS='$address', CONTACT='$contact', POSITION='$position' WHERE ID='$id'";
            if (!mysqli_query($conn,$sql)) {
                die('Error:'.mysqli_error($conn));
            }

            ?>
                <div class="row text-center">
                    <h5 style='color:green; font-size: 17px;'>Profile details has been updated successfully.</h5>
                </div>
            <?php

            header('Refresh: 2;url=index.php?a=adminuser');
        }
    ?>

    <div class="container">
        <div class="col-md-1"></div>

        <div class="col-md-10" style="margin-top: 30px;">
            <div class="panel panel-success">

                <div class="panel-heading">
                    <span class="glyphicon glyphicon-user"></span>
                    <label style="margin-left: 10px; font-weight: normal;">Profile Information</label>
                </div>

                <div class="panel-body">
                    <div class="col-sm-12" style="text-align: center;">
                        <div class="wrapper">                          
                            <form class="form-signin" action="index.php?a=adminuseredit" method="POST">
                                <h3 style="text-align: center;"><strong>EDIT PROFILE INFO</strong></h3><br>

                                <?php
                                    $id = $_GET['id'];
                                    $sql = mysqli_query($conn,"SELECT * FROM tbl_staff WHERE ID = '$id'");
                                    while ($info = mysqli_fetch_array($sql)){
                                        ?>
                                        <div class="row" style="text-align: left;">
                                            <div class="col-md-4">
                                                <label style="color: #000000;">*Last Name</label>
                                                <input type="text" name="last" class="form-control" placeholder="Last Name" value="<?php echo $info['LASTNAME']; ?>" style="margin-bottom: 30px;" maxlength="50" required />
                                            </div>
                                            <div class="col-md-4">
                                                <label style="color: #000000;">*First Name</label>
                                                <input type="text" name="first" class="form-control" placeholder="First Name" value="<?php echo $info['FIRSTNAME']; ?>" style="margin-bottom: 30px;" maxlength="50" required />
                                            </div>
                                            <div class="col-md-4">
                                                <label style="color: #000000;">*Middle Name</label>
                                                <input type="text" name="middle" class="form-control" placeholder="Middle Name" value="<?php echo $info['MIDDLENAME']; ?>" style="margin-bottom: 30px;" maxlength="50" required />
                                            </div>
                                        </div>

                                        <div class="row" style="text-align: left;">
                                            <div class="col-md-4">
                                                <label style="color: #000000;">*Gender</label>
                                                <select class="form-control" name="gender" style="margin-bottom: 30px;" required>
                                                <?php
                                                    if ($info['GENDER'] == 'Male') {
                                                        ?>
                                                            <option value="Male" selected>Male</option>
                                                            <option value="Female">Female</option>
                                                        <?php
                                                    }
                                                    elseif ($info['GENDER'] == 'Female'){
                                                        ?>
                                                           <option value="Male">Male</option>
                                                           <option value="Female" selected>Female</option>
                                                        <?php
                                                    }
                                                ?>
                                            </select>
                                            </div>

                                            <div class="col-md-8">
                                                <label style="color: #000000;">*Home Address</label>
                                                <input type="text" name="address" class="form-control" placeholder="Home Address" value="<?php echo $info['ADDRESS']; ?>" style="margin-bottom: 30px;" maxlength="150" required />
                                            </div>
                                        </div>

                                        <div class="row" style="text-align: left; margin-bottom: 30px;">
                                            <div class="col-md-4">
                                                <label style="color: #000000;">*Phone Number</label>
                                                <input type="text" name="contact" class="form-control" id="contact" placeholder="Phone Number" value="<?php echo $info['CONTACT']; ?>" maxlength="11" required />
                                                <span id="errormsg" style='color:red; font-size: 15px;'></span>
                                            </div>
                                            <div class="col-md-8">
                                                <label style="color: #000000;">*Position</label>
                                                <input type="text" name="position" class="form-control" placeholder="Position" value="<?php echo $info['POSITION']; ?>" maxlength="150" required />
                                            </div>
                                        </div>

                                        <div class="row" style="text-align: center;">
                                            <div class="col-md-3"></div>

                                            <div class="col-md-3" style="margin-top: 10px;">
                                                <input class="btn btn-sm" name="id" type="hidden" value="<?php echo $_GET['id']; ?>">
                                                <input class="btn btn-sm btn-success btn-block" name="update" type="submit" value="Update Profile">
                                            </div>

                                            <div class="col-md-3" style="margin-top: 10px;">
                                                <a href="index.php?a=adminuser" class="btn btn-sm btn-danger btn-block" style="color: white; ">Close</a>
                                            </div>

                                            <div class="col-md-3"></div>
                                        </div>
                                        <?php
                                    }
                                ?>
                            </form>
                            <br> 
                        </div>
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