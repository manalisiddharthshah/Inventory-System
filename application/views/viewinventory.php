<?php
include_once 'Homepage.php';
?>
<br>
<div class="content">
    <div class="container-fluid">
        <div class="row">
        <div class="table-responsive" id="showTranscationModel">
        
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
    showTranscationModels();
    function showTranscationModels(){
        $.ajax({
            url:'<?php echo BASEURL; ?>modelController/inventoryModel',
            type:"POST",
            data:{action:"inventorymodel"},
            success:function(response){
                $("#showTranscationModel").html(response);
                $("table").DataTable({
                });
            }
        });
    }
});
</script>