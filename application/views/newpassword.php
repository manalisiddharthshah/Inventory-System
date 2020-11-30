<?php
include_once '../system/classes/header.php';
?>
<?php linkCSS("assets/css/register.css"); ?>
<section class="login-wrap mtb-40">
        <div>
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <div class="login-box">
                        <h1>Reset Password</h1>
                        <form action="" method="post" id="form-data">
                            <div class="form-group form-row">
                                <label class="col-md-3" for="password">New Password :</label>
                                <input type="password" name="password" class="form-control" placeholder="Enter New Password" id="password">
                            </div>
                            <div class="form-group form-row">
                                <label class="col-md-3" for="confirm_password">Confirm Password :</label>
                                <input type="password" name="confirm_password" class="form-control" placeholder="Enter Confirm Password" id="confirm_password">
                            </div>
                            <div class="form-group">
                                <input type="submit" id="btn" name="Submit" class="btn btn-primary" value="Submit">
                            </div>
                        </form>
                    </div>         
                </div>
            </div>
        </div>
    </section>
<?php
include_once '../system/classes/footer.php';
?>
<!--our custom js--> 
<script>
$(document).ready(function(){
    //validation addMethod for testing regular expression
    $.validator.addMethod("regex", function(value, element, regexp){
            var re = new RegExp(regexp);
            return this.optional(element) || re.test(value);
        }, "Invalid Validation Expression" ); 
        
        //jQuery Validation for validation the Login page
        $("#form-data").validate({
            rules:
            {
                password:{
                required:true,
                minlength : 8
                },
                confirm_password:{
                    required:true,
                    minlength:8,
                    equalTo:"#password"
                }
            },
            messages:{
                password:{
                required:"Please Enter Your Password",
                minlength:"Your Password Must Consist Of Atleast 8 Characters"
                },
                confirm_password:{
                    required:"Please Enter Your Confirm Password",
                    minlength:"Your Password Must Consist Of Atleast 8 Characters",
                    equalTo:"Confirm password must be match with above password"
                },
            },
            highlight: function (element) {
                $(element).addClass("is-invalid").removeClass("is-valid");
            },
            unhighlight: function (element) {
                $(element).addClass("is-valid").removeClass("is-invalid");
            },
            submitHandler: submitForm
        
        });
        function submitForm()
        {

            //for authentication of data
            $.ajax({
                url:"<?php echo BASEURL; ?>userController/newPass",
                type:'POST',
                data:$("#form-data").serialize()+"&action=newPass",
                success:function(response)
                {
                    var getData = $.parseJSON(response);
                    if(getData.status == 1)
                    {
                        swal({
                            title: getData.msg,
                            type: 'success'
                        }, function() {
                            window.location = "userController/login";
                        });
                    }
                   // console.log(response);    
                }
            });
    }
});
</script>