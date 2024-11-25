    <?php
        if (isset($_POST['last']) &&
            isset($_POST['first']) &&
            isset($_POST['middle']) &&
            isset($_POST['gender']) &&
            isset($_POST['address']) &&
            isset($_POST['contact']) &&
            isset($_POST['dlnum']) &&
            isset($_POST['dlcode']) &&
            isset($_POST['dlexpiry']) &&
            isset($_POST['motorplate']) &&
            isset($_POST['franchiseexpiry']) &&
            isset($_FILES['files'])){

            include 'phpqrcode/qrlib.php';
            $path = 'qrcodes/';

            include("config/config.php");
            include("config/firebaseRDB.php");
            $db = new firebaseRDB($databaseURL);

            date_default_timezone_set('Asia/Manila');
            $code = date('ymd-His') . "-". intval( "0" . rand(1,9) . rand(0,9) . rand(0,9) . rand(0,9) . rand(0,9) );
            $last = ucwords(strtolower(trim($_POST['last'])));
            $first = ucwords(strtolower(trim($_POST['first'])));
            $middle = ucwords(strtolower(trim($_POST['middle'])));
            $gender = trim($_POST['gender']);
            $address = trim($_POST['address']);
            $contact = trim($_POST['contact']);
            $dlnum = trim($_POST['dlnum']);
            $dlcode = trim($_POST['dlcode']);
            $dlexpiry = trim($_POST['dlexpiry']);
            $motorplate = trim($_POST['motorplate']);
            $franchiseexpiry = trim($_POST['franchiseexpiry']);
            $username = "";
            $password = "";
            $confirm = "";
            $role = "Driver";
            $dateon = strtotime(date("Y-m-d h:i:sa"));

            $qrcode = "qrcodes/";
            $qrname = $first." ".$last;
            $qrimage = $code.'.png';
            
            $pathqrcode = $qrcode.$qrimage;
            $urlqrcode = $qrcode.$qrimage;
            
            if ($password == $confirm) {
                if (!file_exists($pathqrcode)) {
                    QRcode::png($code, $pathqrcode);

                    $insert = $db->insert("drivers-info", [
                        "code"     => $code,
                        "last" => $last,
                        "first"      => $first,
                        "middle"    => $middle,
                        "gender"    => $gender,
                        "address"    => $address,
                        "contact"    => $contact,
                        "dlnum"    => $dlnum,
                        "dlcode"    => $dlcode,
                        "dlexpiry"    => $dlexpiry,
                        "dflag"    => "",
                        "motorplate"    => $motorplate,
                        "franchiseexpiry"    => $franchiseexpiry,
                        "fflag"    => "",
                        "username"    => $username,
                        "password"    => $password,
                        "role"    => $role,
                        "picture"    => "Unknown",
                        "qrcode"    => $urlqrcode,
                        "status"    => "PENDING",
                        "sflag"    => "0"
                        ]);

                        $imagename = date('ymd-His') . "-". intval( "0" . rand(1,9) . rand(0,9) . rand(0,9) . rand(0,9) ). "-";
                        $directory = "uploads/";

                        foreach($_FILES['files']['tmp_name'] as $key => $tmp_name ){
                            $file_name = $imagename.$_FILES['files']['name' ][$key];
                            $size =$_FILES['files']['size'][$key];
                            $file_f = $size / 1024;
                            $file_size =round($file_f);
                            $file_tmp =$_FILES['files']['tmp_name'][$key];
                            $file_type=$_FILES['files']['type'][$key];
                            $path="uploads/$file_name";

                            if ($path == "uploads/0") {
                                $path = "---";
                            }

                            $insert = $db->insert("drivers-document", [
                            "code"     => $code,
                            "documents" => $path
                            ]);

                            move_uploaded_file($file_tmp,"$directory".$file_name);
                        }

                
                    $_SESSION['CODE'] = $code;
                    $_SESSION['FIRSTNAME'] = $first;
                    $_SESSION['LASTNAME'] = $last;

                    header('location: index.php?a=driverprofile');
                    exit();
                }
                else{
                    ?>
                        <div class="row text-center">
                            <h5 style='color:red; font-size: 17px;'>File already generated! We can use this cached file to speed up site on common codes!</h5>
                        </div> 
                    <?php
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
                <div class="panel-heading">Driver Registration Form</div>
                <div class="panel-body">
                    <div class="col-sm-12">                        
                        <form class="form-signin" action="index.php?a=driverregister" method="POST" enctype="multipart/form-data">

                            <h2 style="color: black;">Driver Basic Info</h2>
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

                                <div class="col-md-4">
                                    <label style="color: #000000;">Licence No.</label>
                                    <input type="text" name="dlnum" class="form-control" placeholder="Licence No." value="<?php if(isset($_POST['dlnum'])) echo $_POST['dlnum']; ?>" maxlength="150" required />
                                </div>

                                <div class="col-md-4">
                                    <label style="color: #000000;">DL Code</label>
                                    <input type="text" name="dlcode" class="form-control" placeholder="DL Code" value="<?php if(isset($_POST['dlcode'])) echo $_POST['dlcode']; ?>" maxlength="150" required />
                                </div>
                            </div>

                            <div class="row" style="text-align: left; margin-bottom: 30px;">
                                <div class="col-md-4">
                                    <label style="color: #000000;">License Expiration</label>
                                    <input type="date" name="dlexpiry" class="form-control" placeholder=">License Expiration" value="<?php if(isset($_POST['dlexpiry'])) echo $_POST['dlexpiry']; ?>" maxlength="51" required />
                                    <span id="errormsg" style='color:red; font-size: 15px;'></span>
                                </div>

                                <div class="col-md-4">
                                    <label style="color: #000000;">Motor Plate No.</label>
                                    <input type="text" name="motorplate" class="form-control" placeholder="Motor Plate No." value="<?php if(isset($_POST['motorplate'])) echo $_POST['motorplate']; ?>" maxlength="150" required />
                                </div>

                                <div class="col-md-4">
                                    <label style="color: #000000;">Franchise Expiry</label>
                                    <input type="date" name="franchiseexpiry" class="form-control" placeholder="Franchise Expiry" value="<?php if(isset($_POST['franchiseexpiry'])) echo $_POST['franchiseexpiry']; ?>" maxlength="150" required />
                                </div>
                            </div>

                            <div class="row" style="text-align: left; margin-bottom: 30px;">
                                <div class="col-md-4">
                                    <label style="color: #000000;">Upload Documents (*jpg | *png)</label>
                                    <input type="file" name="files[]" class="form-control" accept="image/*" multiple required />
                                </div>

                                <div class="col-md-8">
                                    <h5 class="text-danger" style="margin-top: 20px; line-height: 1.5em;">Note: &nbsp;&nbsp; Please attach documents front & back of Driver License, Official Receipt (OR), Certificate of Registration (CR) and Franchise Documents.</h5>
                                </div>
                            </div>

                            <div class="row" style="text-align: right;">
                                <div class="col-md-6" style="margin-top: 10px;"></div>
                                <div class="col-md-6" style="margin-top: 10px;">
                                    <input type="submit" class="btn btn-sm btn-success" value="Register">
                                    <a href="index.php?a=index" class="btn btn-sm btn-danger" style="color: white; ">Close</a>
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