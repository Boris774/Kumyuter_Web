        <div class="container">
            <div class="col-md-3"></div>
            <div class="col-md-6 alert-default" style="margin-top: 30px; background-image: linear-gradient(to right, #A0522D , #954535);">
                <div class="col-sm-12" style="text-align: center;">
                    <div class="wrapper">                          
                        <form class="form-signin" action="index.php?a=sendpassword" method="POST">
                            <br>
                            <h3 class="form-signin-heading" style="color: white;">Reset Password</h3><br>
                            <p class="text-left" style="color: white; margin-left: 20px; margin-right: 20px; text-align: justify; text-justify: inter-word;">
                                We're sending you this email because you requested a password reset. Kindly enter your recovery email to sending a temporarily password. Thank you!
                            </p>
                            <div class="row" style="text-align: left; margin-top: 20px; margin-left: 5px; margin-right: 5px;">
                                <div class="col-md-4">
                                    <select class="form-control" name="role" style="margin-bottom: 15px;">
                                        <?php
                                            if (isset($_POST['role'])) {
                                                ?>
                                                <option><?php if(isset($_POST['role'])) echo $_POST['role']; ?></option>
                                                <?php
                                            }
                                        ?>
                                        <option value="Passenger">Passenger</option>
                                        <option value="Administrator">Administrator</option>
                                    </select>
                                </div>
                                <div class="col-md-8">
                                    <input type="email" name="email" class="form-control" placeholder="Enter recovery email address" maxlength="100" required />
                                </div>
                            </div>

                            <div class="row" style="text-align: center;">
                                <div class="col-md-4" style="margin-top: 30px;"></div>
                                <div class="col-md-4" style="margin-top: 30px;">
                                    <input class="btn btn-md btn-success btn-block" name="send" type="submit" value="Submit">
                                </div>
                                <div class="col-md-4" style="margin-top: 30px;"></div>
                            </div>
                            <div class="row" style="text-align: center;">
                                <br>
                                <a href="index.php?a=index" style="color: white; font-weight: normal;">Back</a>
                            </div>
                        </form>
                        <br>
                    </div>
                </div>
            </div>
            <div class="col-md-3"></div>
        </div>