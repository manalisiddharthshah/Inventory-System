<?php
include_once 'Homepage.php';
?>
<div class="content">
    <div class="container-fluid">
        <form action="" method="post" id="form-data">   
            <div class="form-group form-row">
            
                <label class="col-md-3" for="oldpass">Old Password<span class="text-danger">*</span> :</label>
                <input type="password" name="oldpass" class="primary-field form-control" placeholder="Enter Old Password" id="oldpass">
            </div>
            <div class="form-group form-row">
                <label class="col-md-3" for="newpass">New Password<span class="text-danger">*</span>:</label>
                <input type="password" name="newpass" class="primary-field form-control" placeholder="Enter New Password" id="newpass">
            </div>
            <div class="form-group form-row">
                <label class="col-md-3" for="newconpass">New Confirm Password<span class="text-danger">*</span>:</label>
                <input type="password" name="newconpass" class="primary-field form-control" placeholder="Enter New Confirm Password" id="newconpass">
            </div>
            <div class="form-group">
            <input type="submit" class="btn btn-primary btn" value="Edit Password" id="editpass">
            </div>
            <br>
        </form>
    </div>
</div>
<?php
    include_once '../system/classes/footer.php';
?>
<script>

$(document).ready(function(){
    //validation addMethod for testing regular expression
    $.validator.addMethod("regex", function(value, element, regexp){
            var re = new RegExp(regexp);
            return this.optional(element) || re.test(value);
        }, "Invalid Validation Expression" );  

        //jQuery Validation for validation the registration page
        $("#form-data").validate({
        rules:
        {
            oldpass:{
                required:true,
                minlength : 8
            },
            newpass:{
                required:true,
                minlength : 8
            },
            newconpass:{
                required:true,
                minlength:8,
               equalTo:"#newpass"
            },
        },
        messages:{
            oldpass:{
                required:"Please Enter Your Old Password",
                minlength:"Your Password Must Consist Of Atleast 8 Characters"
            },
            newpass:{
                required:"Please Enter Your New Password",
                minlength:"Your Password Must Consist Of Atleast 8 Characters"
            },
            newconpass:{
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
        //for insertion of data 
        $.ajax({
                url:"<?php echo BASEURL; ?>userController/updatePass",
                type:'POST',
                data:$("#form-data").serialize()+"&action=updatepass",
                success:function(response)
                {
                    var getData = $.parseJSON(response);
                    if(getData.status == 0)
                    {
                        swal({
                        title: getData.msg,
                        type:'success'
                        });
                        $("#form-data")[0].reset();
                    }
                }
            });
    }
});
</script>