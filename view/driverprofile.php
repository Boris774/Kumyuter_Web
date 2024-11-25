<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Kumyuter - Driver</title>
    <link href="css/bootstrap.min.css" rel="stylesheet" type="text/css">

    <style type="text/css">
        body{
            font-family: 'Roboto', sans-serif;
            font-size: 16px;
        }

        .footercontainer {
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

<body id="page-top" data-spy="scroll" data-target=".navbar-fixed-top">
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
          <?php
            if (isset($_SESSION['CODE']) && isset($_SESSION['FIRSTNAME']) && isset($_SESSION['LASTNAME'])) {
              echo "Hi ".$_SESSION['FIRSTNAME'] .", you are now registered!" ;
            }
          ?>
        </p>
      </div>
    </nav>

    <div class = "container">
        <nav aria-label = "breadcrumb">
            <ul class = "breadcrumb">
               <li class = "breadcrumb-item"><a href = "?a=index">Home</a></li>
               <li class = "breadcrumb-item active" aria-current = "page">Profile</li>
            </ul>
        </nav>
    </div>

	<section class="intro-section">
        <div class="container" style="margin-top: 20px;">
            <div class="row">
                <div class="col-lg-3">

                </div>
                <div class="col-lg-6">
                	<div class="panel panel-success">
                        <div class="panel-heading">
                            <h3 class="panel-title" style="font-weight: bold; color: black;">
                                <span class="glyphicon glyphicon-user"></span>&nbsp;&nbsp;DRIVER INFO
                            </h3>
                        </div>
                        <div class="panel-body">
                            <table style="font-weight: normal; font-size: 15px;" width="100%">
                                <?php

                                include("config/config.php");
                                include("config/firebaseRDB.php");
                                $db = new firebaseRDB($databaseURL);

                                $data = $db->retrieve("drivers-info");
                                $data = json_decode($data, 1);
                                $count = 0;
                                
                                if(is_array($data)){
                                    foreach($data as $id => $driverinfo){
                                        $count = $count + 1;

                                        if ($driverinfo['code'] == $_SESSION['CODE']){
                                        ?>

                                        <tr>
                                            <td>
                                                <div class="row">
                                                    <p class="text-danger" style="margin-top: 10px; margin-left: 20px; margin-right: 20px; font-style: bold; font-size: 12px; font-weight: bold; text-align: center;">Please submit photocopy of Driver License, Official Receipt, Certificate of Registration and Franchise Documents in our office to change your account status to the Kumyuter App System.</p>
                                                    <div class="col-md-12">
                                                        <p style="font-style: bold; font-size: 14px;  font-weight: bold;">
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
                                                                <div class="col-md-7 text-danger"><?php echo $driverinfo['status']; ?></div>
                                                            </div>
                                                        </p>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        <?php
                                        }
                                    }
                                }
                                ?>
                            </table>
                        </div>
                    </div>

                <div class="col-lg-3">

                </div>
            </div>
        </div>
    </section>

    <footer>
        <div class="container footercontainer">
            <div class="row centered" style="margin-top: 100px;">
                <p style="text-align: center; color: white;">Kumyuter System. All rights reserved.</p>
            </div>
            <br><br>
        </div>
        <img style="display: block; max-width: 100%;" src="images/Footer.png">
    </footer>

    <script src="js/jquery.js"></script>
    <script src="js/bootstrap.min.js"></script>

    <script type="text/javascript">
        $(document).ready(function () {
            $("#contact").keypress(function (e) {
                if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
                    $("#errormsg").html("Please enter digit only!").show().delay(3000).fadeOut();
                    return false;
                }
           });

            $("#last").keypress(function(event){
                var inputValue = event.charCode;
                
                if(!((inputValue > 64 && inputValue < 91) || (inputValue==190) || (inputValue > 96 && inputValue < 123)||(inputValue==32) || (inputValue==0))){
                    event.preventDefault();
                    $("#errormsg").html("Please enter characters only!").show().fadeOut("slow");
                    return false;
                }
            });
        });
    </script>
</body>

</html>