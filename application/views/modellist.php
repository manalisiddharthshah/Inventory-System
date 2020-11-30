<?php
include_once 'Homepage.php';
?>
<br>
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="table-responsive" id="showAllModel">
            </div>
        </div>
    </div>
</div>
<?php
    include_once '../system/classes/footer.php';
?>
<script>
$(document).ready(function(){
    //show all models
    showAllModels();
    function showAllModels(){
        $.ajax({
            url:'<?php echo BASEURL; ?>modelController/viewAllModel',
            type:"POST",
            data:{action:"viewallmodel"},
            success:function(response){
                $("#showAllModel").html(response);
                $("table").DataTable({
                    order:[0,'desc']
                });
            }
        });
    }

    //For Purchase The Model
    $("body").on("click",".purchaseModel",function(e){
        e.preventDefault();
        purchaseId=$(this).attr('id');
           $.ajax({
            url:'<?php echo BASEURL; ?>modelController/purchaseModel',
            type:'POST',
            data:{purchase_id:purchaseId},
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
               // console.log(response);
            }
         });
    });
});
</script>