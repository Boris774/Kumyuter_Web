    <footer>
        <div class="container footer-container">
            <div class="row centered" style="margin-top: 100px;">
                <p style="text-align: center; color: white;">Copyright © Kumyuter <?php echo date('Y'); ?>. All rights reserved.</p>
            </div>
            <br><br>
        </div>
        <img style="display: block; max-width: 100%;" src="images/Footer.png">
    </footer>

    <script src="js/script.js"></script>
    <script src="js/jquery.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/1.13.1/js/dataTables.bootstrap5.min.js"></script>

    <script type="text/javascript">
        $(document).ready(function () {
            $("#qrsuccess").delay(6000).fadeOut();
            $("#qrerror").delay(5000).fadeOut();
        });

        $(document).ready(function () {
            $('#scanqrdata').DataTable();
        });
    </script>

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

            $('#searchstudent').keyup(function(){
                var search = $(this).val();
                var middle = $('#searchmiddle').val();
                if (search !='')
                {
                    jQuery.ajax({
                        type: "POST",
                        url: 'view/get_specific_studentprofile.php',
                        data: {search : search, middle : middle},

                        success: function (response) {
                            console.log(response);
                            userData = jQuery.parseJSON(response)
                            $('#stud_id').val(userData[0].id);
                            $('#stud_code').val(userData[0].code);
                            $('#stud_lrn').val(userData[0].lrn);
                            $('#stud_last').val(userData[0].last);
                            $('#stud_first').val(userData[0].first);
                            $('#stud_middle').val(userData[0].middle);
                            $('#stud_grade').val(userData[0].grade);
                            $('#stud_section').val(userData[0].section);
                            $('#stud_schoolyear').val(userData[0].schoolyear);
                            $('#stud_facultycode').val(userData[0].facultycode);
                            $('#stud_facultyname').val(userData[0].facultyname);
                        }
                              
                    });
                }
            });
        });
    </script>
</body>

</html>