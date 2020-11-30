<?php
include_once '../system/classes/header.php';
?>
<?php linkCSS("assets/css/register.css"); ?>
<section class="login-wrap mtb-40">
        <div>
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <div class="login-box">
                        <h1>Login</h1>
                        <form action="" method="post" id="form-data">
                            <div class="form-group form-row">
                                <label class="col-md-3" for="email">Email Id<span class="text-danger">*</span>:</label>
                                <input type="email" name="email" class="form-control" placeholder="Enter Email" id="emails">
                            </div>
                            <div class="form-group form-row">
                                <label class="col-md-3" for="password">Password<span class="text-danger">*</span> :</label>
                                <input type="password" name="password" class="form-control" placeholder="Enter Password">
                            </div>
                            <div class="form-group">
                                <input type="submit" id="btn" name="login" class="btn btn-primary" value="Login">
                            </div>
                            <br>
                            <a href="<?php echo BASEURL; ?>userController/forgotPassword">Forgot Password?</a>
                            <br>
                            <a href="/register">Don't Have any account?</a>
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
    $.validator.addMethod("regex", function(value, element, regexp)
    {
            var re = new RegExp(regexp);
            return this.optional(element) || re.test(value);
        }, "Invalid Validation Expression" ); 
        
        //jQuery Validation for validation the Login page
        $("#form-data").validate({
            rules:
            {
                email:{
                    required : true,
                    regex : /^[A-Za-z0-9_]{3,}@[A-Za-z0-9]{3,}.{1}[A-Za-z.]{2,6}$/
                },
                password:{
                    required:true,
                    minlength:8
                }
            },
            messages:{
                email:{
                    required:"Please Enter Your Email",
                    regex : "Enter valid Email Id"
                },
                password:{
                    required:"Please Enter Your Password",
                    minlength:"Your Password Must Consist Of Atleast 8 Characters",
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
                url:"<?php echo BASEURL; ?>userController/authentication",
                type:'POST',
                data:$("#form-data").serialize()+"&action=authentication",
                success:function(response)
                {
                    var getData = $.parseJSON(response);
                    if(getData.status == 0 || getData.status == 2)
                    {
                        swal({
                        title: getData.msg,
                        type:'warning'
                        });
                    }
                    if(getData.status == 3)
                    {
                        window.location = "<?php echo BASEURL; ?>userController/dashboard";
                    }
                }
            });
        
    }
});
</script>