<?php
include_once 'Homepage.php';
?>
<div class="content">
    <div class="container-fluid">
        <form action="<?php echo BASEURL; ?>userController/update" method="post" id="form-data">
            <input type="hidden" name="id1" id="id1" class="form-control" value="<?php echo $_SESSION['row']['id'] ?>" required>
            <div class="form-group form-row">
                <label class="col-md-3" for="username">User Name<span class="text-danger">*</span> :</label>
                <input type="text" name="username" class="primary-field form-control" placeholder="Enter Username" id="user" value="<?php echo $_SESSION["row"]['user_name']; ?>" required>
                <span id="usererror" style="color:red;"></span>
            </div>
            <div class="form-group form-row">
                <label class="col-md-3" for="email">Email Id<span class="text-danger">*</span>:</label>
                <input type="email" name="email" class="primary-field form-control" placeholder="Enter Email" id="emailid" value="<?php echo $_SESSION["row"]['user_email']; ?>" required>
                <span id="emailerror" style="color:red;"></span>
            </div>
            <div class="form-group form-row">
            <label class="col-md-3" for="phoneno">Phone No<span class="text-danger">*</span> :</label>
                <input type="text" name="phoneno" class="primary-field form-control" placeholder="Enter Phone No" id="phone" value="<?php echo $_SESSION["row"]['user_phone']; ?>" required> 
                <span id="phoneerror" style="color:red;"></span>
            </div>
            <div class="form-group form-row">
                <label class="col-md-3" for="address">Address :</label>
                <textarea col="5" row="10" placeholder="Enter Address" class="primary-field form-control" id="addr" name="address" value="<?php echo $_SESSION["row"]['user_address']; ?>"></textarea>
            </div>
                <?php
                if(isset($_SESSION['success'])){
                    echo "<div class='alert alert-success alert-dismissable'>";
                        echo "Profile updated.";
                    echo "</div>";
                }
                else{
                    
                }
                ?>
            <div class="form-group">
                <button type="submit" id="edit1" name="editBtn1" class="btn btn-primary" onclick="return validation()">Edit</button>
            </div>
            <br>
        </form>
    </div>
</div>
<?php
    include_once '../system/classes/footer.php';
?>

<script type="text/javascript">
    function validation()
    {
        var username = document.getElementById('user').value;
        var emailid = document.getElementById('emailid').value;
        var phone = document.getElementById('phone').value;

        var unamecheck = /^[a-zA-Z_ ]*$/;
        var emailidcheck = /^[A-Za-z0-9_]{3,}@[A-Za-z0-9]{3,}.{1}[A-Za-z.]{2,}$/;
        var phonecheck = /^[0-9]{10}$/;
        if(unamecheck.test(username))
        {
            document.getElementById('usererror').innerHTML = "";
        }
        else
        {
            document.getElementById('usererror').innerHTML = "Username Contains only Letter";
            return false;
        }
        if(emailidcheck.test(emailid))
        {
            document.getElementById('emailerror').innerHTML = " ";
        }
        else
        {
            document.getElementById('emailerror').innerHTML = "Email id is invalid";
            return false;
        } 
        if(phonecheck.test(phone))
        {
            document.getElementById('phoneerror').innerHTML = " ";
        }
        else
        {
            document.getElementById('phoneerror').innerHTML = "Your Phone No Must Consist Of 10 Numbers";
            return false;
        }  
    }
</script>