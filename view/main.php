<?php
    if (isset($_POST['username']) && isset($_POST['password']) && $_POST['username'] !='' && $_POST['password'] !=''){
        $username = trim($_POST['username']);
        $password = trim($_POST['password']);
        $role = $_POST['role'];

        if ($role == 'Passenger'){
            $sql = mysqli_query($conn, "SELECT * FROM tbl_users WHERE USERNAME ='$username' AND PASSWORD ='$password'");
            if (mysqli_num_rows($sql) > 0){
                $info = mysqli_fetch_array($sql);

                $code = $info['USERCODE'];
                $first = $info['FULLNAME'];
                $last = $info['CONTACT'];
                $email = $info['USERNAME'];
                
                $_SESSION['CODE'] = $code;
                $_SESSION['FIRSTNAME'] = $first;
                $_SESSION['LASTNAME'] = $last;
                $_SESSION['USERNAME'] = $username;

                header('location: ?a=passengerhome');
                exit();
                        
            }
            else{
                ?>
                    <div class="row text-center">
                        <h5 style='color:red; font-size: 17px;'>Invalid account. Please try again!<br><small>Passenger</small></h5>
                    </div>
                <?php
            }
        }
        else{
            $sql = mysqli_query($conn, "SELECT * FROM tbl_staff WHERE USERNAME ='$username' AND PASSWORD ='$password'");
            if (mysqli_num_rows($sql) > 0){
                $info = mysqli_fetch_array($sql);

                $code = $info['CODE'];
                $first = $info['FIRSTNAME'];
                $last = $info['LASTNAME'];
                $email = $info['USERNAME'];
                $role = $info['ROLE'];
                
                $_SESSION['CODE'] = $code;
                $_SESSION['FIRSTNAME'] = $first;
                $_SESSION['LASTNAME'] = $last;
                $_SESSION['USERNAME'] = $username;

                if ($role == 'Admin' || $role == 'ADMIN' || $role == 'admin') {
                    header('location: ?a=adminhome');
                    exit();
                }
            }
            else{
                ?>
                    <div class="row text-center">
                        <h5 style='color:red; font-size: 17px;'>Invalid account. Please try again!<br><small>Administrator</small></h5>
                    </div>
                <?php
            }
        }
    }

?>

<div class="container">
    <div class="col-md-8" style="margin-top: 20px;">
        <div class="col-md-12">
            <img style="display: block; max-width: 95%;" src="images/QR.png">
        </div>
    </div>

    <div class="col-md-4 alert-default" style="margin-top: 20px; background-image: linear-gradient(to right, #3325aa , #211b61);">
        <div class="col-sm-12" style="text-align: center;">
            <div class="wrapper">
                <h3 class="form-signin-heading text-success" style="text-align: center; color: white;"><b>Login Security</b></h3><br>
                <form class="form-signin" action="index.php?a=index" method="POST">       
                    <select class="form-control" name="role" style="margin-bottom: 15px;">
                        <?php
                            if (isset($_POST['role'])) {
                                if ($_POST['role'] == 'Passenger') {
                                    ?>
                                    <option value="Passenger" selected>Passenger</option>
                                    <option value="Administrator">Administrator</option>
                                    <?php
                                }
                                else if ($_POST['role'] == 'Administrator') {
                                    ?>
                                    <option value="Passenger">Passenger</option>
                                    <option value="Administrator" selected>Administrator</option>
                                    <?php
                                }
                            }
                            else{
                                ?>
                                <option value="Passenger">Passenger</option>
                                <option value="Administrator">Administrator</option>
                                <?php
                            }
                        ?>
                    </select>
                    <input type="text" class="form-control" name="username" placeholder="Username" style="margin-bottom: 15px;" required autofocus="" />
                    <input type="password" class="form-control" name="password" placeholder="Password" style="margin-bottom: 15px;" required />
                    <input class="btn btn-md btn-success btn-block" name="login" type="submit" value="Login">
                    <br><hr>
                    <label style="text-align: center; color: #C4A484; font-weight: normal; ">Create new driver account?
                    <a href="index.php?a=driverregister" style="color: white; font-weight: normal;">Register</a></label>
                    <!--<br><hr>
                    <b><a href="index.php?a=forgotpassword" style="color: white; font-weight: normal; font-size: 13px;">Forgot Password?</a></b> -->
                    <br><br>
                </form>
            </div>
        </div>
    </div>
</div><br>