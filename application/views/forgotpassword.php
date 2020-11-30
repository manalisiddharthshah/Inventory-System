<?php
include_once '../system/classes/header.php';
?>
<?php linkCSS("assets/css/register.css"); ?>
<section class="login-wrap mtb-40">
        <div>
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <div class="login-box">
                        <h1>Forgot Password</h1>
                        <form action="" method="post" id="form-data">
                            <div class="form-group form-row">
                                <label class="col-md-3" for="username">UserName :</label>
                                <input type="text" name="username" class="form-control" placeholder="Enter UserName">
                            </div>
                            <div class="form-group form-row">
                                <label class="col-md-3" for="email">Email Id :</label>
                                <input type="email" name="email" class="form-control" placeholder="Enter Email" id="email">
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
                username:{
                    required:true
                },
                email:{
                    required : true,
                    regex : /^[A-Za-z0-9_]{3,}@[A-Za-z0-9]{3,}.{1}[A-Za-z.]{2,6}$/
                }
            },
            messages:{
                username:{
                    required:"Please Enter Your Username"
                },
                email:{
                    required:"Please Enter Your Email",
                    regex : "Enter valid Email Id"
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
                url:"<?php echo BASEURL; ?>userController/forgotPass",
                type:'POST',
                data:$("#form-data").serialize()+"&action=forgotPass",
                success:function(response)
                {
                    var getData = $.parseJSON(response);
                    if(getData.status == 1)
                    {
                        window.location = "<?php echo BASEURL; ?>userController/new";
                    }
                    if(getData.status == 0)
                    {
                        swal({
                        title: getData.msg,
                        type:'warning'
                        });
                    }
                }
            });
    }
});
</script>