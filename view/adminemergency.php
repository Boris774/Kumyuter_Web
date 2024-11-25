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
                    $code = $_SESSION['CODE'];
                    ?>
                        <a href="?a=staffpassword&code=<?php echo $code; ?>" class="text-primary"><?php echo $_SESSION['FIRSTNAME'] ." ". $_SESSION['LASTNAME']; ?></a>
                    <?php
                }
            ?>
            </p>

            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav navbar-right">
                <li><a href="?a=adminnotifydriver"><span class="glyphicon glyphicon-bell text-success" style="margin-right: 3px;"></span> Notifications <span class="badge"><?php include("config/config.php"); include("config/firebaseRDB.php"); $db = new firebaseRDB($databaseURL); $data = $db->retrieve("drivers-info"); $data = json_decode($data, 1);
                
                $ctr = 0;
                $ct = 0;
                $c = 0;
                
                if(is_array($data)){
                    foreach($data as $id => $driverinfo){
                        if ($driverinfo['sflag'] == '0'){
                            $ctr = $ctr + 1;
                        }

                        if ($driverinfo['dflag'] == '0'){
                            $ct = $ct + 1;
                        }
                         
                        if ($driverinfo['fflag'] == '0'){
                            $c = $c + 1;
                        }
                    }

                    $numnotify = $ctr + $ct +$c;

                    echo $numnotify;
                 } ?></span></a></li>
                <li><a href="?a=adminemergencyadd"><span class="glyphicon glyphicon-plus-sign text-success" style="margin-right: 3px;"></span> Add</a></li>
                <li><a href="?a=logout"><span class="glyphicon glyphicon-off text-danger" style="margin-right: 3px;"></span> Logout</a></li>
            </ul>
            </div>
        </div>
    </nav>

    <div class="row" style="margin-left: 20px; margin-right: 20px;">
      <div class="col-md-3">
        <div class="list-group">
          <a href="index.php?a=adminhome" class="list-group-item" style="font-size: 15px; font-weight: normal;">
            <span class="glyphicon glyphicon-user" style="margin-right: 10px;"></span>
            Passenger Lists
          </a>
          <a href="index.php?a=adminpassengeremergency" class="list-group-item" style="font-size: 15px; font-weight: normal;">
            <span class="glyphicon glyphicon-bell" style="margin-right: 10px;"></span>
            Passenger Emergency <?php $data = $db->retrieve("emergency-info"); $data = json_decode($data, 1);
                
                $counter = 0;
                
                if(is_array($data)){
                    foreach($data as $id => $emergencyinfo){
                        if ($emergencyinfo['status'] == '0'){
                            $counter = $counter + 1;
                        }
                    }
                    ?>
                    <span class="badge"><?php echo $counter; ?></span>
                    <?php
                 } ?>
          </a>
          <a href="index.php?a=admindriverlists" class="list-group-item" style="font-size: 15px; font-weight: normal;">
            <span class="glyphicon glyphicon-user" style="margin-right: 10px;"></span>
            Driver Lists
          </a>
          <a href="index.php?a=adminhistory" class="list-group-item" style="font-size: 15px; font-weight: normal;">
            <span class="glyphicon glyphicon-th-list" style="margin-right: 10px;"></span>
            History Records
          </a>
          <a href="index.php?a=adminemergency" class="list-group-item active" style="font-size: 15px; font-weight: normal;">
            <span class="glyphicon glyphicon-phone" style="margin-right: 10px;"></span>
            Emergency Contact
          </a>
          <a href="index.php?a=adminuser" class="list-group-item" style="font-size: 15px; font-weight: normal;">
            <span class="glyphicon glyphicon-user" style="margin-right: 10px;"></span>
            Users
          </a>
        </div>
      </div>

      <div class="col-md-9">
        <div class="row" style="background-color: #f9f9f9; padding-left: 20px; padding-right: 20px;">

          <h3 style="text-align: center;"><strong>EMERGENCY CONTACT RECORD</strong></h3><br>

          <table class="table table-striped table-bordered w-auto" style="width:100%; color: black; font-size: 14px;">
            <thead>
              <tr>
                  <td style="text-align: center;"><b>#</b></td>
                  <td style="text-align: center;"><b>EMERGENCY NAME</b></td>
                  <td style="text-align: center;"><b>CONTACT</b></td>
                  <td style="text-align: center;"><b>ACTION</b></td>
              </tr>
            </thead>
            <tbody>
              <?php
                $data = $db->retrieve("contact-info");
                $data = json_decode($data, 1);
                $count = 0;
                
                if(is_array($data)){
                    foreach($data as $id => $contactinfo){
                        $count = $count + 1;

                        ?>
                        <tr>
                            <td style="text-align: center;"><?php echo $count; ?></td>
                            <td style="text-align: center;"><?php echo $contactinfo['emergencyname']; ?></td>
                            <td style="text-align: center;"><?php echo $contactinfo['contact']; ?></td>
                            <td style="text-align: center;"><a href="?a=adminemergencyedit&id=<?php echo $id; ?>" class="btn btn-sm text-primary">EDIT</a>  |  <a href="?a=adminemergencydelete&id=<?php echo $id; ?>" class="btn btn-sm text-danger">DELETE</a></td>
                        </tr>
                        <?php
                    }
                }

                if ( $count == 0){
                    ?>
                        <tr>
                            <td style="text-align: center;" colspan="4">There was no records.</td>
                        </tr>
                    <?php
                }
              ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>

    <br><br><br><br>

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