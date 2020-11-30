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
            url:'<?php echo BASEURL; ?>modelController/myModel',
            type:"POST",
            data:{action:"viewmymodel"},
            success:function(response){
                $("#showAllModel").html(response);
                $("table").DataTable({
                    order:[0,'desc']
                });
            }
        });
    }

    
});
</script>