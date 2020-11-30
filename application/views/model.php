<?php
include_once 'Homepage.php';
?>
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <button type="button" class="btn btn-primary m-1 float-right" data-toggle="modal" data-target="#addModel"><i class="fas fa-plus"></i> Add Model</button>
            </div>
        </div>
        <hr/>
        <div class="row">
            <div class="col-lg-12">
                <div class="table-responsive" id="showModel">
                </div>
            </div>
        </div>
        <?php
            if(isset($_SESSION['insert'])){
                echo "<div class='alert alert-success alert-dismissable'>";
                    echo $_SESSION['insert'];
                echo "</div>";
            }
            else if(isset($_SESSION['update'])){
                echo "<div class='alert alert-success alert-dismissable'>";
                    echo $_SESSION['update'];
                echo "</div>";
            }
            else{
                
            }
            unset($_SESSION['insert']);
            unset($_SESSION['update']);
        ?>
        <!-- The Modal -->
        <div class="modal fade" id="addModel">
            <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
            
                <!-- Modal Header -->
                <div class="modal-header">
                <h4 class="modal-title">Add Model</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                
                <!-- Modal body -->
                <div class="modal-body">
                    <form action="<?php echo BASEURL; ?>modelController/insert" method="post" id="form-data" enctype="multipart/form-data">
                    <input type="hidden" name="addmodel" value="addmodel">
                        <div class="form-row">
                            <div class="form-group col-md-6">
                            Manufacture Name:
                                <div id="manufacture">
                                </div>
                            </div>
                            <div class="form-group col-md-6">
                            Model Name:
                                <input type="text" class="form-control" placeholder="Model Name" name="modelname">
                            </div> 
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-5">
                            Model Type:
                                <input type="text" class="form-control" placeholder="Model Type" name="modeltype">
                            </div>
                            <div class="form-group col-md-4">
                            Model Color:
                                <input type="text" class="form-control" placeholder="Model Color" name="modelcolor">
                            </div>
                            <div class="form-group col-md-3">
                            No Of Seats:
                                <input type="number" class="form-control" placeholder="No of seats" name="noofseats">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-5">
                            Kilometer Driven:
                                <input type="text" class="form-control" placeholder="Kilometer Driven" name="kilometerdriven">
                            </div>
                            <div class="form-group col-md-4">
                            Refublished:
                                <select class='form-control' name="refublished">
                                    <option value="new car">new car</option>
                                    <option value="old car">old car</option>
                                </select>
                            </div>
                            <div class="form-group col-md-3">
                            Model Year:
                                <input type="text" class="form-control" placeholder="Year" name="modelyear">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                            Mileage:
                                <input type="text" class="form-control" placeholder="Mileage" name="mileage">
                            </div>
                            <div class="form-group col-md-6">
                            Fuel Type:
                                <input type="text" class="form-control" placeholder="fueltype" name="fueltype">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-4">
                            Transmission:
                                <input type="text" class="form-control" placeholder="transmission" name="transmission">
                            </div>
                
                            <div class="form-group col-md-4">
                            Fuel Tank Capacity:
                                <input type="text" class="form-control" placeholder="Fuel Tank Capacity" name="fueltankcapacity">
                            </div>
                            <div class="form-group col-md-4">
                            Power Streering:
                            <select name="powerstreering" class="form-control">
                                    <option value="No">No</option>
                                    <option value="Yes">Yes</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-4">
                            Air Conditioner:
                                <select name="airconditioner" class="form-control">
                                    <option value="No">No</option>
                                    <option value="Yes">Yes</option>
                                </select>
                            </div>
                            <div class="form-group col-md-4">
                            Air Bag:
                                <select name="airbag" class="form-control">
                                    <option value="No">No</option>
                                    <option value="Yes">Yes</option>
                                </select>
                            </div>
                            <div class="form-group col-md-4">
                            Price:
                                <input type="text" class="form-control" placeholder="Price" name="price">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-12">
                            Description:
                                <textarea class="form-control" placeholder="Description" name="description"></textarea>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                            Vin Number:
                                <input type="text" class="form-control" placeholder="Vin Number" name="vinnumber">
                            </div>
                            <div class="form-group col-md-6">
                            Registration Number:
                                <input type="text" class="form-control" placeholder="Registeration No" name="registerno">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                            Image1:
                            <input type="file" name="image1" id="image1">
                            </div>
                            <div class="form-group col-md-6">
                            Image2:
                                <input type="file" id="image2" name="image2">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-12">
                                <input type="submit" class="btn btn-primary btn" name="model" value="Add Model" id="Add">
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            </div>
        </div>
    </div>
</div>
<?php
include_once '../system/classes/footer.php';
?>
<!--our custom js -->
<script type="text/javascript">
$(document).ready(function(){
    //show all models
    showAllModels();
    function showAllModels()
    {
        $.ajax
        ({
            url:'<?php echo BASEURL; ?>modelController/viewModel',
            type:"POST",
            data:{action:"viewmodel"},
            success:function(response)
            {
                $("#showModel").html(response);
                $("table").DataTable
                ({
                    order:[0,'desc']
                });
            }
        });
    }

    //show all Manufacture name
    showAllManufacture();
    function showAllManufacture()
    {
        $.ajax
        ({
            url:'<?php echo BASEURL; ?>manufacturerController/manufactureById',
            type:"POST",
            data:{action:"manufacture"},
            success:function(response)
            {
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
            },
            image1:
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
            },
            image1:
            {
                required:"Upload Image"
            }
        },
        highlight: function (element) {
                $(element).addClass("is-invalid").removeClass("is-valid");
        },
        unhighlight: function (element) {
            $(element).addClass("is-valid").removeClass("is-invalid");
        },    
    });

    //soft delete user
    $("body").on("click",".delBtnModel",function(e){
        e.preventDefault();
        del_id=$(this).attr('id');
           $.ajax({
            url:'<?php echo BASEURL; ?>modelController/delModel',
            type:'POST',
            data:{del_id:del_id},
            success:function(response)
            {
                var getData = $.parseJSON(response);
                if(getData.status == 1)
                {
                    swal({
                    title: getData.msg,
                    type:'success'
                    });
                    showAllModels();
                }
            }
        });
    });   
});
</script>