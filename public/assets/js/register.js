
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
            username:{
                required:true,
                minlength : 2,
                regex : /^[a-zA-Z_ ]*$/  
            },
            email:{
                required : true,
                regex : /^[A-Za-z0-9_]{3,}@[A-Za-z0-9]{3,}.{1}[A-Za-z.]{2,6}$/
            },
            phoneno:{
                required : true,
                minlength:10,
                regex : /^[0-9]{10}$/ 
            },
            password:{
                required:true,
                minlength : 8
            },
            confirm_password:{
                required:true,
                minlength:8,
               equalTo:"#password"
            },
        },
        messages:{
            username:{
                required:"Please Enter Your UserName",
                minlength:"Your UserName Must Consist Of Atleast 2 characters",
                regex : "Username Contains only Letter"
            },
            email:{
                required:"Please Enter Your Email",
                regex : "Enter valid Email Id"
            },
            phoneno:{
                required:"Please Enter Your Phone No",
                minlength:"Your Phone No Must Consist Of 10 Numbers",
                regx:"Your Phone No Must Consist Of 10 Numbers"
                
            },
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
        //for insertion of data 
        $.ajax({
                url:"userController/insert",
                type:'POST',
                data:$("#form-data").serialize()+"&action=register",
                success:function(response)
                {
                    var getData = $.parseJSON(response);
                    if(getData.status == 0 || getData.status == 3)
                    {
                        swal({
                            title: getData.msg,
                            type: 'warning'
                            });      
                    }
                    if(getData.status == 1)
                    {
                        swal({
                            title: getData.msg,
                            type: 'success'
                        }, function() {
                            window.location = "userController/login";
                        });
                    }
                }
            });
    }
});

