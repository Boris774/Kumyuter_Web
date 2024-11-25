<?php
  if (isset($_GET['image'])) {
    $file = $_GET['image'];

    if (file_exists($file)) {
      header('Content-Description:File Transfer');
      header('Content-Type:application/image');
      header('Content-Disposition:attachement;filename="'.basename($file).'"');
      header('Content-Lenght:'.filesize($file));
      readfile($file);
    }
  }
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Passenger Scan QR</title>
    <link href="css/bootstrap.min.css" rel="stylesheet" type="text/css">

    <style type="text/css">
        body{
            font-family: 'Roboto', sans-serif;
            font-size: 16px;
        }

        .container {
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

        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
          <ul class="nav navbar-nav navbar-right">
            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Settings <span class="caret"></span></a>
              <ul class="dropdown-menu">
                <li><a href="?a=facultyprofile">Profile</a></li>
                <li><a href="?a=facultychangepassword">Change Password</a></li>
                <li role="separator" class="divider"></li>
                <li><a href="?a=logout">Logout</a></li>
              </ul>
            </li>
          </ul>
        </div>
      </div>
    </nav>

    <div class="row" style="margin-left: 20px; margin-right: 20px;">
      <div class="col-md-3">
        <div class="list-group">
          <a href="index.php?a=facultyhome" class="list-group-item active" style="font-size: 15px; font-weight: normal;">
            <span class="glyphicon glyphicon-qrcode" style="margin-right: 10px;"></span>
            Basic Info 
          </a>
          <a href="index.php?a=facultyattendance" class="list-group-item" style="font-size: 15px; font-weight: normal;">
            <span class="glyphicon glyphicon-folder-open" style="margin-right: 10px;"></span>
            History Records
          </a>
        </div>
      </div>

      <div class="col-md-9">
        <div class="row">
          <?php
            $code = $_SESSION['CODE'];
            $sql = mysqli_query($conn,"SELECT * FROM tbl_faculty WHERE CODE = '$code'");
            if (mysqli_num_rows($sql) > 0) {
              while ($info = mysqli_fetch_array($sql)){
                $fullname = $info['FIRSTNAME']." ".substr($info['MIDDLENAME'],0, 1).". ".$info['LASTNAME'];
                $gender = $info['GENDER'];
                $address = $info['ADDRESS'];
                $contact = $info['CONTACT'];
                $position = $info['POSITION'];
                $qrcode = $info['QRCODE'];
                ?>
                    <div class="col-md-7">
                      <div class="thumbnail">
                          <img src="images/Faculty.png" class="img-circle" alt="Picture" style="width:20%; height: 20%; margin-top: 20px; margin-bottom: 20px;">
                          <div class="caption">
                            <table class="table">
                              <tr>
                                <td colspan="3"><b>PROFILE INFO</b></td>
                              </tr>
                              <tr>
                                <td width="25%" style="font-weight: normal;">Name</td>
                                <td width="10%">-</td>
                                <td><?php echo $fullname; ?></td>
                              </tr>
                              <tr>
                                <td width="25%" style="font-weight: normal;">Gender</td>
                                <td width="10%">-</td>
                                <td><?php echo $gender; ?></td>
                              </tr>
                              <tr>
                                <td width="25%" style="font-weight: normal;">Address</td>
                                <td width="10%">-</td>
                                <td><?php echo $address; ?></td>
                              </tr>
                              <tr>
                                <td width="25%" style="font-weight: normal;">Contact</td>
                                <td width="10%">-</td>
                                <td><?php echo $contact; ?></td>
                              </tr>
                              <tr>
                                <td width="25%" style="font-weight: normal;">Position</td>
                                <td width="10%">-</td>
                                <td><?php echo $position; ?></td>
                              </tr>
                            </table>
                          </div>
                      </div>
                    </div>

                    <div class="col-md-5">

                    </div>
                <?php
              }
            }

          ?>
        </div>

      </div>
    </div>

    <footer>
        <div class="container">
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