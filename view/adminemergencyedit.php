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
        if (isset($_POST['emergencyname']) &&
            isset($_POST['contact'])){

            include("config/config.php");
            include("config/firebaseRDB.php");
            $db = new firebaseRDB($databaseURL);

            $id = $_POST['id'];
            $emergencyname = trim($_POST['emergencyname']);
            $contact = trim($_POST['contact']);
            
            $update = $db->update("contact-info", $id, [
            "emergencyname"     => $emergencyname,
            "contact"    => $contact
            ]);

            header('location: index.php?a=adminemergency');
            exit();
        }
    ?>

    <div class="container">
        <div class="col-md-1"></div>
        <div class="col-md-10">

            <div class="panel panel-default">
                <div class="panel-heading">Edit Emergency Contact</div>
                <div class="panel-body">
                    <div class="col-sm-12">
                    
                        <?php
                            include("config/config.php");
                            include("config/firebaseRDB.php");

                            $db = new firebaseRDB($databaseURL);
                            $id = $_GET['id'];
                            $retrieve = $db->retrieve("contact-info/$id");
                            $data = json_decode($retrieve, 1);
                        ?>
                        <form class="form-signin" action="index.php?a=adminemergencyedit" method="POST">
                            <h2 style="color: black;">Emergency Contact Info</h2>
                            <hr style="border-top: 2px dashed red;">

                            <div class="row" style="text-align: left;">
                                <div class="col-md-7">
                                    <label style="color: #000000;">Emergency Name</label>
                                    <input type="text" name="emergencyname" class="form-control" placeholder="Emergency Name" value="<?php if(isset($_POST['emergencyname'])) echo $_POST['emergencyname']; else echo $data['emergencyname']; ?>" style="margin-bottom: 30px;" maxlength="80" required />
                                </div>
                                <div class="col-md-5">
                                    <label style="color: #000000;">Phone Number</label>
                                    <input type="text" name="contact" class="form-control" id="contact" placeholder="Phone Number" value="<?php if(isset($_POST['contact'])) echo $_POST['contact']; else echo $data['contact']; ?>" maxlength="11" required />
                                    <span id="errormsg" style='color:red; font-size: 15px;'></span>
                                </div>
                            </div>

                            <div class="row" style="text-align: right;">
                                <div class="col-md-6" style="margin-top: 10px;"></div>
                                <div class="col-md-6" style="margin-top: 10px;">
                                    <input type="hidden" name="id" value="<?php echo $id; ?>">
                                    <input type="submit" class="btn btn-sm btn-success" value="Update Contact">
                                    <a href="index.php?a=adminemergency" class="btn btn-sm btn-danger" style="color: white; ">Close</a>
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
    