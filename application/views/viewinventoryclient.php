<?php
include_once 'Homepage.php';
?>
<br>
<div class="content">
    <div class="container-fluid">
        <div class="row">
        <div class="table-responsive" id="showAllSoldModel">
        
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
    showAllSoldModels();
    function showAllSoldModels(){
        $.ajax({
            url:'<?php echo BASEURL; ?>modelController/showAllSoldModel',
            type:"POST",
            data:{action:"viewallsoldmodel"},
            success:function(response){
                $("#showAllSoldModel").html(response);
                $("table").DataTable({
                });
            }
        });
    }
});
</script>