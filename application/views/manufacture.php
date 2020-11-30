<?php
include_once 'Homepage.php';
?>
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <button type="button" class="btn btn-primary m-1 float-right" data-toggle="modal" data-target="#addManufacturer"><i class="fas fa-plus"></i> Add Manufacturer</button>
            </div>
        </div>
        <hr/>
        <div class="row">
            <div class="col-lg-12">
                <div class="table-responsive" id="showManufacture">
                </div>
            </div>
        </div>
        <!-- The Modal -->
		
		
        <div class="modal fade" id="addManufacturer" data-backdrop="false">
            <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
            
                <!-- Modal Header -->
                <div class="modal-header">
                <h4 class="modal-title">Add Manufacturer</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                
                <!-- Modal body -->
                <div class="modal-body">
                    <form action="" method="post" id="form-data">
                        <div class="form-group">
                            <input type="text" name="manufacturer" placeholder="Add Manufacturer" class="form-control">
                        </div>
                        <div class="form-group">
                            <input type="submit" name="insert" id="insert" class="btn btn-primary" value="Add Manufacturer">
                        </div>
                    </form>
                </div>
            </div>
            </div>
        </div>

  <!-- The Modal -->
<div class="modal fade" id="editManufacturer" data-backdrop="static">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
      
        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title">Edit Manufacturer</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        
        <!-- Modal body -->
        <div class="modal-body">
            <form action="" method="post" id="edit-form-data">
            <input type="hidden" name="id" id="id" class="form-control">
                <div class="form-group">
                    <input type="text" name="manufacturer" id="manufacturer" class="form-control">
                </div>
                <div class="form-group">
                    <input type="submit" name="update" id="update" class="btn btn-primary" value="Update Manufacturer">
                </div>
            </form>
        </div>
      </div>
    </div>
  </div>
<?php
    include_once '../system/classes/footer.php';
?>
<!--our custom js--> 
<script type="text/javascript">
$(document).ready(function(){
    showAllManufactures();
    //show manufacture
    function showAllManufactures(){
        $.ajax({
            url:'<?php echo BASEURL;?>manufacturerController/viewManufacture',
            type:"POST",
            data:{action:"viewmanufacture"},
            success:function(response){
                $("#showManufacture").html(response);
                $("table").DataTable({
                    order:[0,'desc']
                });
            }
        });
    }
    
    //validation addMethod for testing regular expression
    $.validator.addMethod("regex", function(value, element, regexp){
        var re = new RegExp(regexp);
        return this.optional(element) || re.test(value);
    }, "Invalid Validation Expression" );  

    //jQuery Validation for validate the manufacturer
    $("#form-data").validate({
        rules:
        {
            manufacturer:{
                required:true,
                regex : /^[a-zA-Z_ ]*$/  
            }
        },
        messages:{
            manufacturer:{
                required:"Please Enter Manufacturer",
                regex : "Manufacturer name Contains only Letter"
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
        //insert the manufacture
        $.ajax({
            url:'<?php echo BASEURL;?>manufacturerController/addManufacture',
            type:"POST",
            data:$("#form-data").serialize()+"&action=addmanufacture",
            success:function(response)
            {
                var getData = $.parseJSON(response);
                if(getData.status == 0 || getData.status == 3)
                {
                    swal({
                    title: getData.msg,
                    type:'warning'
                    });
                    showAllManufactures();
                }
                if(getData.status == 1)
                {
                    swal({
                    title: getData.msg,
                    type:'success'
                    });
                    $("#addManufacturer").modal('hide');
                    $("#form-data")[0].reset();
                    showAllManufactures();
                }
            }
        });
    }

    //Edit manufacture
    $("body").on("click",".editBtn",function(e){
        e.preventDefault();
        editId=$(this).attr('id');
        $.ajax({
            url:'<?php echo BASEURL;?>manufacturerController/editManufacture',
            type:'POST',
            data:{edit_id:editId},
            success:function(response)
            {
                var getData = $.parseJSON(response);
                $("#id").val(getData.id);
                $("#manufacturer").val(getData.manufacturer_name);
            }

        });
    });
    //jQuery Validation for validate the manufacturer
    $("#edit-form-data").validate({
        rules:
        {
            manufacturer:{
                required:true,
                regex : /^[a-zA-Z_ ]*$/  
            }
        },
        messages:{
            manufacturer:{
                required:"Please Enter Manufacturer",
                regex : "Manufacturer name Contains only Letter"
            },
        },
        highlight: function (element) {
                $(element).addClass("is-invalid").removeClass("is-valid");
        },
        unhighlight: function (element) {
            $(element).addClass("is-valid").removeClass("is-invalid");
        },
        submitHandler: submitUpdateForm
    });
    function submitUpdateForm()
    {
        //update manufacturer
        $.ajax({
            url:'<?php echo BASEURL;?>manufacturerController/updateManufacture',
            type:"POST",
            data:$("#edit-form-data").serialize()+"&action=updatemanufacture",
            success:function(response)
            {
                var getData = $.parseJSON(response);
                if(getData.status == 0)
                {
                    swal({
                    title: getData.msg,
                    type:'warning'
                    });
                }
                if(getData.status == 1)
                {
                    swal({
                    title: getData.msg,
                    type:'success'
                    });
                    $("#editManufacturer").modal('hide');
                    $("#edit-form-data")[0].reset();
                    //tr.css('background-color','#00b300');
                }
                if(getData.status == 3)
                {
                    swal({
                    title: getData.msg,
                    icon: 'warning',
                    type:'warning'
                    });
                }
                showAllManufactures();
            }
        });
    }

    //Block or unblock manufacture 
    $("body").on("click",".blockBtn",function(e){
        e.preventDefault();
        var tr = $(this).closest('tr');
        var td = $(this).closest('td').prev().prev().closest('td');
        blockId=$(this).attr('id');
           $.ajax({
            url:'<?php echo BASEURL;?>manufacturerController/blockManufacture',
            type:'POST',
            data:{block_id:blockId},
            success:function(response){
                
                var getData = $.parseJSON(response);
                if(getData.status == 0 || getData.status == 1)
                {
                    swal({
                    title: getData.msg,
                    type:'success'
                    });
                    tr.css('background-color','#00b300');
                    if(getData.status == 0)
                        td.html("unblock");
                    else
                        td.html("block");
                }
            }
         });
    });

    //soft delete manufacture
    $("body").on("click",".delBtn",function(e){
        e.preventDefault();
        delId=$(this).attr('id');
        swal({
            title: "Are you sure?",
            text: "Your will not be able to recover this imaginary file!",
            type: "warning",
            showCancelButton: true,
            confirmButtonClass: "btn-danger",
            confirmButtonText: "Yes, delete it!",
            closeOnConfirm: false
          },
          function(){
            $.ajax({
                url:'<?php echo BASEURL;?>manufacturerController/delManufacture',
                type:'POST',
                data:{del_id:delId},
                success:function(response)
                {
                    var getData = $.parseJSON(response);
                    if(getData.status == 1)
                    {
                        swal({
                        title: getData.msg,
                        type:'success'
                        });
                        showAllManufactures();
                    }
                }
             });
          });   
    });
});
</script>
