<?php
    $recipient = "";

    if (isset($_POST['email']) && isset($_POST['role'])) {
        $recipient = strtolower(trim($_POST['email']));
        $role = $_POST['role'];
        $subject = "Reset Password";
        $message = "Password";
        $pass = intval( "0" . rand(1,9) . rand(0,9) . rand(0,9) . rand(0,9) . rand(0,9) );

        if ($role == 'Passenger') {
            $sql = mysqli_query($conn, "SELECT * FROM tbl_faculty WHERE USERNAME ='$recipient'");
            if (mysqli_num_rows($sql) > 0){
                $info = mysqli_fetch_array($sql);

                $id = $info['ID'];
                $first = $info['FIRSTNAME'];

                $sql = "UPDATE tbl_faculty SET PASSWORD='$pass' WHERE ID='$id'";
                if (!mysqli_query($conn,$sql)) {
                    die('Error:'.mysqli_error($conn));
                }

                require 'PHPMailerAutoload.php';
                require 'credential.php';

                $mail = new PHPMailer;

                //$mail->SMTPDebug = 4;  

                $mail->isSMTP();                                                                          
                $mail->Host = 'smtp.gmail.com';                         
                $mail->SMTPAuth = true;                                                      
                $mail->Username = EMAIL;                                                                  
                $mail->Password = PASS;                                                      
                $mail->SMTPSecure = 'tls';                                                       
                $mail->Port = 587;                                                         
                $mail->setFrom(EMAIL, "Web-based Kumyuter System");
                $mail->addAddress($recipient);  
                $mail->addReplyTo(EMAIL);
                $mail->isHTML(true);                                                                          
                $mail->Subject = $subject;
                $mail->Body    = "Hi " .$first."! we've sent reset the password for your account of <b>KUMYUTER</b> system. Your password is: <b>".$pass ."</b><br><br>Thank you";
                $mail->AltBody = $message;

                if(!$mail->send()) { 
                    
                    ?>
                        <div class="row text-center">
                            <h5 style='color:red; font-size: 17px;'>Message could not be sent.</h5>
                        </div>
                    <?php

                    header('Refresh: 2;url=index.php?a=sendpassword');

                }
                else{
                    ?>
                        <div class="row text-center">
                            <h5 style='color:green; font-size: 17px;'>Message has been sent</h5>
                        </div>
                    <?php
                }
            }
            else{
                ?>
                    <div class="row text-center">
                        <h5 style='color:red; font-size: 17px;'>There was no email from the server. Please try again!</h5>
                    </div>
                <?php
            }
        }
        elseif ($role == 'Driver') {
            $sql = mysqli_query($conn, "SELECT * FROM tbl_staff WHERE USERNAME ='$recipient'");
            if (mysqli_num_rows($sql) > 0){
                $info = mysqli_fetch_array($sql);

                $id = $info['ID'];
                $first = $info['FIRSTNAME'];

                $sql = "UPDATE tbl_staff SET PASSWORD='$pass' WHERE ID='$id'";
                if (!mysqli_query($conn,$sql)) {
                    die('Error:'.mysqli_error($conn));
                }

                require 'PHPMailerAutoload.php';
                require 'credential.php';

                $mail = new PHPMailer;

                //$mail->SMTPDebug = 4;  

                $mail->isSMTP();                                                                          
                $mail->Host = 'smtp.gmail.com';                         
                $mail->SMTPAuth = true;                                                      
                $mail->Username = EMAIL;                                                                  
                $mail->Password = PASS;                                                      
                $mail->SMTPSecure = 'tls';                                                       
                $mail->Port = 587;                                                         
                $mail->setFrom(EMAIL, "Web-based Kumyuter System");
                $mail->addAddress($recipient);  
                $mail->addReplyTo(EMAIL);
                $mail->isHTML(true);                                                                          
                $mail->Subject = $subject;
                $mail->Body    = "Hi " .$first."! we've sent reset the password for your account of <b>KUMYUTER</b> system. Your password is: <b>".$pass ."</b><br><br>Thank you";
                $mail->AltBody = $message;

                if(!$mail->send()) { 
                    
                    ?>
                        <div class="row text-center">
                            <h5 style='color:red; font-size: 17px;'>Message could not be sent.</h5>
                        </div>
                    <?php

                    header('Refresh: 2;url=index.php?a=sendpassword');

                }
                else{
                    ?>
                        <div class="row text-center">
                            <h5 style='color:green; font-size: 17px;'>Message has been sent</h5>
                        </div>
                    <?php
                }
            }
            else{
                ?>
                    <div class="row text-center">
                        <h5 style='color:red; font-size: 17px;'>There was no email from the server. Please try again!</h5>
                    </div>
                <?php
            }
        }
    }
?>

        <div class="container">
            <div class="col-md-3"></div>
            <div class="col-md-6 alert-success" style="margin-top: 30px;">
                <div class="col-sm-12" style="text-align: center;">
                    <div class="wrapper">                          
                        <form class="form-signin">
                            <br>
                            <h4 class="form-signin-heading"><span class="glyphicon glyphicon-envelope"></span> PASSWORD THRU EMAIL</h4><br>

                            <h4>
                                <?php
                                    if (isset($_SESSION['EMAIL'])) {
                                        echo $_SESSION['EMAIL'];
                                    }
                                    elseif (isset($_POST['email'])) {
                                        echo $_POST['email'];
                                    }
                                ?>
                            </h4>

                            <p class="text-left" style="color: #71797E; margin-left: 20px; margin-right: 20px; text-align: justify; text-justify: inter-word;">
                                <?php
                                    if (isset($_SESSION['FIRSTNAME'])) {
                                        echo "Hi ".$_SESSION['FIRSTNAME']."! ";
                                    }
                                    elseif (isset($_POST['email'])) {
                                        echo "Hi ".$first."! ";
                                    }
                                ?>
                                please kindly check your entered email for your access account of system.
                                Just click the button below go to login and you'll be on your way.
                            </p>

                            <div class="row" style="text-align: center;">
                                <div class="col-md-3"></div>
                                <div class="col-md-6" style="margin-top: 30px;">
                                    <a href="index.php?a=index" class="btn btn-sm btn-success btn-block" style="color: white; ">Go To Login</a>
                                </div>
                                <div class="col-md-3"></div>
                            </div>
                        </form>
                        <br><br>
                    </div>
                </div>
            </div>
            <div class="col-md-3"></div>
        </div>