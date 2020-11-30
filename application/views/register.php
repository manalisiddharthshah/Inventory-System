<?php
include_once '../system/classes/header.php';
?>
<!--custom css-->
<?php linkCSS("assets/css/register.css"); ?>
</head>
<section class="Singup-wrap mtb-40">
    <div>
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="login-box">
                    <h1>User Registration</h1>
                        <form action="" method="post" id="form-data">
                            <div class="form-group form-row">
                                <label class="col-md-3" for="username">User Name<span class="text-danger">*</span> :</label>
                                <input type="text" name="username" class="primary-field form-control" placeholder="Enter Username" id="username">
                            </div>
                            <div class="form-group form-row">
                                <label class="col-md-3" for="email">Email Id<span class="text-danger">*</span>:</label>
                                <input type="email" name="email" class="primary-field form-control" placeholder="Enter Email" id="email">
                            </div>
                            <div class="form-group form-row">
                            <label class="col-md-3" for="phoneno">Phone No<span class="text-danger">*</span> :</label>
                                <input type="text" name="phoneno" class="primary-field form-control" placeholder="Enter Phone No" id="phoneno">
                            </div>
                            <div class="form-group form-row">
                                <label class="col-md-3" for="address">Address :</label>
                                <textarea col="5" row="10" placeholder="Enter Address" class="primary-field form-control" id="address" name="address"></textarea>
                            </div>
                            <div class="form-group form-row">
                                <label class="col-md-3" for="password">Password<span class="text-danger">*</span> :</label>
                                <input type="password" name="password" class="primary-field form-control" placeholder="Enter Password" id="password">
                            </div>
                            <div class="form-group form-row">
                                <label class="col-md-4" for="confirm_password">Confirm Password<span class="text-danger">*</span> :</label>
                                <input type="password" name="confirm_password" class="primary-field form-control" placeholder="Enter Confirm Password" id="confirm-password">
                            </div>
                            <div class="form-group">
                                <input type="submit" id="register" name="register" class="btn btn-primary" value="Register">
                            </div>
                            <br>
                            <a href="<?php echo BASEURL; ?>userController/login">Have any account?</a>
                        </form>
                    </div>         
                </div>
            </div>
        </div>  
    </div>
</section>
<?php
include_once '../system/classes/footer.php';
?>
<!--our custom js--> 
<?php linkJS("assets/js/register.js"); ?>