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
            font-size: 16px;
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
            Notifications
            <?php
                if (isset($_SESSION['CODE']) && isset($_SESSION['FIRSTNAME']) && isset($_SESSION['LASTNAME']) && isset($_SESSION['USERNAME'])) {
                //echo $_SESSION['FIRSTNAME'] ." ". $_SESSION['LASTNAME'] ."!";
                }
            ?>
            </p>

            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav navbar-right">
                <li><a href="?a=adminhome"><span class="glyphicon glyphicon-home text-success" style="margin-right: 3px;"></span> Home</a></li>
                <li><a href="?a=logout"><span class="glyphicon glyphicon-off text-danger" style="margin-right: 3px;"></span> Logout</a></li>
            </ul>
            </div>
        </div>
    </nav>

    <?php
        include("config/config.php");
        include("config/firebaseRDB.php");
        $db = new firebaseRDB($databaseURL);
    ?>

    <div class="row" style="margin-left: 20px; margin-right: 20px;">
      <div class="col-md-3">
        <div class="list-group">
          <a href="index.php?a=adminnotifydriver" class="list-group-item active" style="font-size: 15px; font-weight: normal;">
            <span class="glyphicon glyphicon-th-list" style="margin-right: 10px;"></span>
            Driver's New Entry
            <?php $data = $db->retrieve("drivers-info"); $data = json_decode($data, 1);
                
                $ctr = 0;
                
                if(is_array($data)){
                    foreach($data as $id => $driverinfo){
                        if ($driverinfo['sflag'] == '0'){
                            $ctr = $ctr + 1;
                        }
                    }
                    ?>
                        <span class="badge"><?php echo $ctr; ?></span>
                    <?php
                 } ?>
          </a>
          <a href="index.php?a=adminnotifylicense" class="list-group-item" style="font-size: 15px; font-weight: normal;">
            <span class="glyphicon glyphicon-th-list" style="margin-right: 10px;"></span>
            Driver License Expiry <span class="badge"><?php $data = $db->retrieve("drivers-info"); $data = json_decode($data, 1); $ct = 0;
                
                if(is_array ($data)){
                    foreach($data as $id => $driverinfo){
                        if ($driverinfo['dflag'] == '0'){
                            $ct = $ct + 1;
                        }
                     }

                     echo $ct;
                 } ?></span>
          </a>
          <a href="index.php?a=adminnotifyfranchise" class="list-group-item" style="font-size: 15px; font-weight: normal;">
            <span class="glyphicon glyphicon-th-list" style="margin-right: 10px;"></span>
            Franchise Expiry <span class="badge"><?php $data = $db->retrieve("drivers-info"); $data = json_decode($data, 1); $c = 0;
                
                if(is_array ($data)){
                    foreach($data as $id => $driverinfo){
                        if ($driverinfo['fflag'] == '0'){
                            $c = $c + 1;
                        }
                     }

                     echo $c;
                 } ?></span>
          </a>
        </div>
      </div>

      <div class="col-md-9">
        <div class="row" style="background-color: #f9f9f9; padding-left: 20px; padding-right: 20px;">

          <h3 style="text-align: center;"><strong>VIEW DRIVER'S NEW PENDING ENTRY</strong></h3><br>

          <table id="facultyrecords" class="table table-bordered w-auto" style="width:100%; color: black; font-size: 14px;">
            <thead>
              <tr>
                  <td style="text-align: center;"><b>#</b></td>
                  <td style="text-align: center;"><b>NAME</b></td>
                  <td style="text-align: center;"><b>CONTACT</b></td>
                  <td style="text-align: center;"><b>STATUS</b></td>
                  <td style="text-align: center;" width="15%"><b>ACTION</b></td>
              </tr>
            </thead>
            <tbody>
              <?php
                $data = $db->retrieve("drivers-info");
                $data = json_decode($data, 1);
                
                $count = 0;
                
                if(is_array($data)){
                    foreach($data as $id => $driverinfo){
                        if ($driverinfo['status'] == 'PENDING' || $driverinfo['sflag'] == '0'){
                        
                        $count = $count + 1;
                        ?>
                        <tr style="background-color: #FFF9A6;">
                            <td style="text-align: center;"><?php echo $count; ?></td>
                            <td style="text-align: left;"><?php echo $driverinfo['last'] .", ".$driverinfo['first'] ." ".$driverinfo['middle']; ?></td>
                            <td style="text-align: center;"><?php echo $driverinfo['contact']; ?></td>
                            <td style="text-align: center;"><b class="text-danger"><?php echo ucwords(strtolower($driverinfo['status'])); ?></b></td>
                            <td style="text-align: center;"><a href="?a=adminnotifydriveredit&id=<?php echo $id; ?>" class="btn btn-sm text-primary">EDIT</a>  |  <a href="#" class="btn btn-sm text-success" data-toggle="modal" data-target="#modalDriver<?php echo $id; ?>">VIEW</a></td>
                        </tr>

                        <div class="modal fade" id="modalDriver<?php echo $id; ?>">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    
                                    <div class="modal-header">
                                        <h4 class="modal-title">Driver Details</h4>
                                        <button type="button" class="close" data-dismiss="modal" style="margin-top: -25px;">&times;</button>
                                    </div>

                                    <div class="modal-body">
                                        <div class="row" style="margin-left: 20px; margin-right: 20px; margin-top: 20px; margin-bottom: 20px;">
                                            <div class="col-md-12">
                                                <p style="font-style: bold; font-size: 14px;  font-weight: bold;">
                                                    DRIVER INFO

                                                    <div class="row" style="margin-top: 10px; margin-left: 20px; margin-right: 20px;">
                                                        <div class="col-md-4">Driver Name</div>
                                                        <div class="col-md-1">-</div>
                                                        <div class="col-md-7"><?php echo $driverinfo['first']." ".$driverinfo['last']; ?></div>
                                                    </div>

                                                    <div class="row" style="margin-top: 10px; margin-left: 20px; margin-right: 20px;">
                                                        <div class="col-md-4">Contact</div>
                                                        <div class="col-md-1">-</div>
                                                        <div class="col-md-7"><?php echo $driverinfo['contact']; ?></div>
                                                    </div>

                                                    <div class="row" style="margin-top: 10px; margin-left: 20px; margin-right: 20px;">
                                                        <div class="col-md-4">Address</div>
                                                        <div class="col-md-1">-</div>
                                                        <div class="col-md-7"><?php echo $driverinfo['address']; ?></div>
                                                    </div>

                                                    <div class="row" style="margin-top: 10px; margin-left: 20px; margin-right: 20px;">
                                                        <div class="col-md-4">Driver License</div>
                                                        <div class="col-md-1">-</div>
                                                        <div class="col-md-7"><?php echo $driverinfo['dlnum']." - ".$driverinfo['dlcode']; ?></div>
                                                    </div>

                                                    <div class="row" style="margin-top: 10px; margin-left: 20px; margin-right: 20px;">
                                                        <div class="col-md-4">DL Expiration</div>
                                                        <div class="col-md-1">-</div>
                                                        <div class="col-md-7"><?php echo $driverinfo['dlexpiry']; ?></div>
                                                    </div>

                                                    <div class="row" style="margin-top: 10px; margin-left: 20px; margin-right: 20px;">
                                                        <div class="col-md-4">Motor Plate No.</div>
                                                        <div class="col-md-1">-</div>
                                                        <div class="col-md-7"><?php echo $driverinfo['motorplate']; ?></div>
                                                    </div>

                                                    <div class="row" style="margin-top: 10px; margin-left: 20px; margin-right: 20px;">
                                                        <div class="col-md-4">Franchise Expiry</div>
                                                        <div class="col-md-1">-</div>
                                                        <div class="col-md-7"><?php echo $driverinfo['franchiseexpiry']; ?></div>
                                                    </div>

                                                    <div class="row" style="margin-top: 10px; margin-left: 20px; margin-right: 20px;">
                                                        <div class="col-md-4">Status</div>
                                                        <div class="col-md-1">-</div>
                                                        <div class="col-md-7"><b class="text-danger"><?php echo ucwords(strtolower($driverinfo['status'])); ?></b></div>
                                                    </div>
                                                </p>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-md btn-danger view" data-dismiss="modal" data-id="<?php echo $id; ?>">Close</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php
                        }
                        elseif ($driverinfo['status'] == 'PENDING' || $driverinfo['sflag'] == '1'){
                        
                        $count = $count + 1;
                        ?>
                        <tr>
                            <td style="text-align: center;"><?php echo $count; ?></td>
                            <td style="text-align: left;"><?php echo $driverinfo['last'] .", ".$driverinfo['first'] ." ".$driverinfo['middle']; ?></td>
                            <td style="text-align: center;"><?php echo $driverinfo['contact']; ?></td>
                            <td style="text-align: center;"><b class="text-danger"><?php echo ucwords(strtolower($driverinfo['status'])); ?></b></td>
                            <td style="text-align: center;"><a href="?a=adminnotifydriveredit&id=<?php echo $id; ?>" class="btn btn-sm text-primary">EDIT</a>  |  <a href="#" class="btn btn-sm text-success" data-toggle="modal" data-target="#modalDriver<?php echo $id; ?>">VIEW</a></td>
                        </tr>

                        <div class="modal fade" id="modalDriver<?php echo $id; ?>">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    
                                    <div class="modal-header">
                                        <h4 class="modal-title">Driver Details</h4>
                                        <button type="button" class="close" data-dismiss="modal" style="margin-top: -25px;">&times;</button>
                                    </div>

                                    <div class="modal-body">
                                        <div class="row" style="margin-left: 20px; margin-right: 20px; margin-top: 20px; margin-bottom: 20px;">
                                            <div class="col-md-12">
                                                <p style="font-style: bold; font-size: 14px;  font-weight: bold;">
                                                    DRIVER INFO

                                                    <div class="row" style="margin-top: 10px; margin-left: 20px; margin-right: 20px;">
                                                        <div class="col-md-4">Driver Name</div>
                                                        <div class="col-md-1">-</div>
                                                        <div class="col-md-7"><?php echo $driverinfo['first']." ".$driverinfo['last']; ?></div>
                                                    </div>

                                                    <div class="row" style="margin-top: 10px; margin-left: 20px; margin-right: 20px;">
                                                        <div class="col-md-4">Contact</div>
                                                        <div class="col-md-1">-</div>
                                                        <div class="col-md-7"><?php echo $driverinfo['contact']; ?></div>
                                                    </div>

                                                    <div class="row" style="margin-top: 10px; margin-left: 20px; margin-right: 20px;">
                                                        <div class="col-md-4">Address</div>
                                                        <div class="col-md-1">-</div>
                                                        <div class="col-md-7"><?php echo $driverinfo['address']; ?></div>
                                                    </div>

                                                    <div class="row" style="margin-top: 10px; margin-left: 20px; margin-right: 20px;">
                                                        <div class="col-md-4">Driver License</div>
                                                        <div class="col-md-1">-</div>
                                                        <div class="col-md-7"><?php echo $driverinfo['dlnum']." - ".$driverinfo['dlcode']; ?></div>
                                                    </div>

                                                    <div class="row" style="margin-top: 10px; margin-left: 20px; margin-right: 20px;">
                                                        <div class="col-md-4">DL Expiration</div>
                                                        <div class="col-md-1">-</div>
                                                        <div class="col-md-7"><?php echo $driverinfo['dlexpiry']; ?></div>
                                                    </div>

                                                    <div class="row" style="margin-top: 10px; margin-left: 20px; margin-right: 20px;">
                                                        <div class="col-md-4">Motor Plate No.</div>
                                                        <div class="col-md-1">-</div>
                                                        <div class="col-md-7"><?php echo $driverinfo['motorplate']; ?></div>
                                                    </div>

                                                    <div class="row" style="margin-top: 10px; margin-left: 20px; margin-right: 20px;">
                                                        <div class="col-md-4">Franchise Expiry</div>
                                                        <div class="col-md-1">-</div>
                                                        <div class="col-md-7"><?php echo $driverinfo['franchiseexpiry']; ?></div>
                                                    </div>

                                                    <div class="row" style="margin-top: 10px; margin-left: 20px; margin-right: 20px;">
                                                        <div class="col-md-4">Status</div>
                                                        <div class="col-md-1">-</div>
                                                        <div class="col-md-7"><b class="text-danger"><?php echo ucwords(strtolower($driverinfo['status'])); ?></b></div>
                                                    </div>
                                                </p>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-md btn-danger" data-dismiss="modal">Close</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php
                        }
                    }
                }
              ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>

    <footer>
        <div class="container footer-container">
            <div class="row centered" style="margin-top: 100px;">
                <p style="text-align: center; color: white;">Kumyuter System. All rights reserved.</p>
            </div>
            <br><br>
        </div>
        <img style="display: block; max-width: 100%;" src="images/Footer.png">
    </footer>

    <script src="js/jquery.js"></script>
    <script src="js/bootstrap.min.js"></script>
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
                    //'excel',
                    'pdf',
                    'print'
                ]
            } );
        });
    </script>

    <script language="JavaScript">
        $("button.view").click(function(){
            var emergencyid = $(this).attr("data-id");
            $.ajax({
                url: "index.php?a=admindriverflags",
                data:{"id":emergencyid},
                type:"post", 
                success:function(response){
                    window.location.reload();
                } 
            })
        }); 
    </script>
</body>

</html>