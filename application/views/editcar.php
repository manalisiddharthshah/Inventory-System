<?php
include_once 'Homepage.php';
?>

<div class="content">
    <div class="container-fluid">
        <form action="<?php echo BASEURL; ?>modelController/updateModel" method="post" id="form-data" enctype="multipart/form-data">
        <input type="hidden" name="addmodel" value="addmodel">
        <input type="hidden" name="id1" id="id1" class="form-control" value="<?php echo $_SESSION['id1'] ?>">
        <div class="form-row">
            <div class="form-group col-md-6">
            Manufacture Name:
                <div id="manufacture">
                </div>
            </div>
            <div class="form-group col-md-6">
            Model Name:
                <input type="text" class="form-control" placeholder="Model Name" name="modelname" value="<?php echo $_SESSION['edit']['model_name'] ?>">
            </div> 
        </div>
        <div class="form-row">
            <div class="form-group col-md-5">
            Model Type:
                <input type="text" class="form-control" placeholder="Model Type" name="modeltype" value="<?php echo $_SESSION['edit']['model_type'] ?>">
            </div>
            <div class="form-group col-md-4">
            Model Color:
                <input type="text" class="form-control" placeholder="Model Color" name="modelcolor" value="<?php echo $_SESSION['edit']['model_color'] ?>">
            </div>
            <div class="form-group col-md-3">
            No Of Seats:
            <input type="number" class="form-control" placeholder="No of seats" name="noofseats" value="<?php echo $_SESSION['edit']['no_of_seats'] ?>">
            </div>
        </div>
        <div class="form-row">
            <div class="form-group col-md-5">
            Kilometer Driven:
                <input type="text" class="form-control" placeholder="Kilometer Driven" name="kilometerdriven" value="<?php echo $_SESSION['edit']['kilometers_driven'] ?>">
            </div>
            <div class="form-group col-md-4">
            Refublished:
                <select class='form-control' name="refublished" value="<?php echo $_SESSION['edit']['refurbished'] ?>">
                    <option value="new car">new car</option>
                    <option value="old car">old car</option>
                </select>
            </div>
            <div class="form-group col-md-3">
            Model Year:
                <input type="text" class="form-control" placeholder="Year" name="modelyear" value="<?php echo $_SESSION['edit']['model_year'] ?>">
            </div>
        </div>
        <div class="form-row">
            <div class="form-group col-md-6">
            Mileage:
                <input type="text" class="form-control" placeholder="Mileage" name="mileage" value="<?php echo $_SESSION['edit']['mileage'] ?>">
            </div>
            <div class="form-group col-md-6">
            Fuel Type:
                <input type="text" class="form-control" placeholder="fueltype" name="fueltype" value="<?php echo $_SESSION['edit']['fuel_type'] ?>">
            </div>
        </div>
        <div class="form-row">
            <div class="form-group col-md-4">
            Transmission:
                <input type="text" class="form-control" placeholder="transmission" name="transmission" value="<?php echo $_SESSION['edit']['transmission'] ?>">
            </div>

            <div class="form-group col-md-4">
            Fuel Tank Capacity:
                <input type="text" class="form-control" placeholder="Fuel Tank Capacity" name="fueltankcapacity" value="<?php echo $_SESSION['edit']['fuel_tank_capacity'] ?>">
            </div>
            <div class="form-group col-md-4">
            Power Streering:
            <select name="powerstreering" class="form-control" value="<?php echo $_SESSION['edit']['power_steering'] ?>">
                    <option value="No">No</option>
                    <option value="Yes">Yes</option>
                </select>
            </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-4">
                Air Conditioner:
                    <select name="airconditioner" class="form-control" value="<?php echo $_SESSION['edit']['air_conditioner'] ?>">
                        <option value="No">No</option>
                        <option value="Yes">Yes</option>
                    </select>
                </div>
                <div class="form-group col-md-4">
                Air Bag:
                    <select name="airbag" class="form-control" value="<?php echo $_SESSION['edit']['airbag'] ?>">
                        <option value="No">No</option>
                        <option value="Yes">Yes</option>
                    </select>
                </div>
                <div class="form-group col-md-4">
                Price:
                    <input type="text" class="form-control" placeholder="Price" name="price" value="<?php echo $_SESSION['edit']['price'] ?>">
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-12">
                Description:
                    <textarea class="form-control" placeholder="Description" name="description"><?php echo $_SESSION['edit']['description'] ?></textarea>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-6">
                Vin Number:
                    <input type="text" class="form-control" placeholder="Vin Number" name="vinnumber" value="<?php echo $_SESSION['edit']['vin_number'] ?>">
                </div>
                <div class="form-group col-md-6">
                Registration Number:
                    <input type="text" class="form-control" placeholder="Registeration No" name="registerno" value="<?php echo $_SESSION['edit']['registration_number'] ?>">
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-6">
                Image1:
                <input type="file" name="image1" id="image1" value="<?php echo $_SESSION['edit']['image1'] ?>">
                </div>
                <div class="form-group col-md-6">
                Image2:
                    <input type="file" id="image2" name="image2" value="<?php echo $_SESSION['edit']['image2'] ?>">
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-12">
                    <input type="submit" class="btn btn-primary btn" name="model" value="Update Model" id="Add">
                </div>
            </div>
        </form>
    </div>
</div>
<?php
include_once '../system/classes/footer.php';
?>
<!--our custom js -->
<script>
$(document).ready(function(){

    //show all Manufacture name
    showAllManufacture();
    function showAllManufacture(){
        $.ajax({
            url:'<?php echo BASEURL; ?>manufacturerController/editManufactureById',
            type:"POST",
            data:{action:"editmanufacture"},
            success:function(response){
                $("#manufacture").html(response);
            }
        });
    }

    //validation addMethod for testing regular expression
    $.validator.addMethod("regex", function(value, element, regexp){
    var re = new RegExp(regexp);
    return this.optional(element) || re.test(value);
    }, "Invalid Validation Expression" );  

        //jQuery Validation for validation the registration page
        $("#form-data").validate({
        rules:
        {
            manufactureid:{
                required:true
            },
            modeltype:{
                required : true,
                regex : /^[a-zA-Z_ ]*$/
            },
            modelname:{
                required : true,
                regex : /^[a-zA-Z_ ]*$/ 
            },
            modelcolor:{
                required : true,
                regex : /^[a-zA-Z]*$/ 
            },
            noofseats:{
                required:true,
                maxlength : 1
            },
            kilometerdriven:
            {
                required:true,
                regex:/^[0-9]*$/
            },
            modelyear:
            {
                required:true,
                regex:/^[0-9]*$/
            },
            price:
            {
                required:true,
                regex:/^[0-9]*$/
            },
            description:
            {
                required:true
            },
            registerno:
            {
                required:true
            }
        },
        messages:{
            manufactureid:{
                required:"Please select manufacture name",
            },
            modeltype:{
                required:"Please Enter Your model type",
                regex : "Type of model contains letter"
            },
            modelname:{
                required:"Please Enter model name",
                regx:"Your model name contains letter"
                
            },
            modelcolor:{
                required:"Please Enter modelcolor",
                minlength:"Model color contains letter"
        },
        noofseats:{
            required:"Please Enter model color",
            maxlength:"It Must only 1 Characters"
        },
        kilometerdriven:
        {
            required:"Enter Kilometer driven",
            regex:"Enter only number"
        },
        modelyear:
        {
            required:"Enter model year",
            regex : "It contains only number"
        },
        price:
        {
            required:"Enter Price",
            regex:"It contains only numbers"
        },
        description:
        {
            required:"Enter Description"
        },
        registerno:
        {
            required:"Enter Registration Number"
        }
    },
    highlight: function (element) {
            $(element).addClass("is-invalid").removeClass("is-valid");
    },
    unhighlight: function (element) {
        $(element).addClass("is-valid").removeClass("is-invalid");
    },   
    });
});
</script>

