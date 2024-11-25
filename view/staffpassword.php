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
          Welcome to logged in as
          <?php
            if (isset($_SESSION['CODE']) && isset($_SESSION['FIRSTNAME']) && isset($_SESSION['LASTNAME']) && isset($_SESSION['USERNAME'])) {
              echo $_SESSION['FIRSTNAME'] ." ". $_SESSION['LASTNAME'] ."!";
            }
          ?>
        </p>
      </div>
    </nav>

    <div class = "container">
        <nav aria-label = "breadcrumb">
            <ul class = "breadcrumb">
                <li class = "breadcrumb-item"><a href = "?a=adminhome">Home</a></li>
               <li class = "breadcrumb-item active" aria-current = "page">Change Password</li>
            </ul>
        </nav>
    </div>

    <?php
        if (isset($_POST['pass']) && isset($_POST['confirm'])){

            $code = $_SESSION['CODE'];
            $pass = trim($_POST['pass']);
            $confirm = trim($_POST['confirm']);

            if (strlen(trim($pass)) < 8){
                ?>
                <div class="row text-center">
                    <h5 style='color:red; font-size: 17px;'>Password must be at least 8 characters.</h5>
                </div>
                <?php
            }
            elseif ($pass == $confirm) {
                $sql = "UPDATE tbl_staff SET PASSWORD='$pass' WHERE CODE='$code'";
                if (!mysqli_query($conn,$sql)) {
                    die('Error:'.mysqli_error($conn));
                }

                ?>
                    <div class="row text-center">
                        <h5 style='color:green; font-size: 17px;'>Password has been changed successfully.</h5>
                    </div>
                <?php
            }
            else{
                ?>
                <div class="row text-center">
                    <h5 style='color:red; font-size: 17px;'>Password did not matched.</h5>
                </div>
                <?php
            }
        }
    ?>

    <div class="container">
        <div class="col-md-2"></div>
        <div class="col-md-8" style="margin-top: 30px;">
            <div class="panel panel-success">

                <div class="panel-heading">
                    <span class="glyphicon glyphicon-qrcode"></span>
                    <label style="margin-left: 10px; font-weight: normal;">Change Password</label>
                </div>

                <div class="panel-body">
                    <div class="col-sm-12" style="text-align: center;">
                        <div class="wrapper">                          
                            <form class="form-signin" action="index.php?a=staffpassword" method="POST">
                                <h3 style="text-align: center;"><strong>CHANGE PASSWORD</strong></h3><br>

                                <div class="row" style="text-align: left;">
                                    <div class="col-md-6">
                                        <span style="color: red;">*</span><label>Password</label>
                                        <input type="password" name="pass" class="form-control" placeholder="Password" style="margin-bottom: 30px;" maxlength="50" required />
                                    </div>

                                    <div class="col-md-6">
                                        <span style="color: red;">*</span><label>Confirm Password</label>
                                        <input type="password" name="confirm" class="form-control" placeholder="Confirm Password" style="margin-bottom: 30px;" maxlength="50" required />
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-4"></div>
                                    <div class="col-md-4">
                                        <input class="btn btn-md btn-success btn-block" style="text-decoration: none; " type="submit" value="Save Password">
                                    </div>
                                    <div class="col-md-4"></div>
                                </div>
                            </form>
                            <br> 
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-2"></div>
    </div>

    <footer>
        <div class="container footercontainer">
            <div class="row centered" style="margin-top: 100px;">
                <p style="text-align: center; color: white;">Tarangnan National High School Attendance QR Code System.<br>All rights reserved.</p>
            </div>
            <br><br>
        </div>
        <img style="display: block; max-width: 100%;" src="images/Footer.png">
    </footer>

    <script src="js/jquery.js"></script>
    <script src="js/bootstrap.min.js"></script>
</body>

</html>