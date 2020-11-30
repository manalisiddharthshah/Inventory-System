<?php
include_once 'Homepage.php';
?>
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <!--Shows the client details in this div by the userController using ajax-->
            <div class="table-responsive" id="showUser">
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
    showAllUsers();

    //showUsers by using this function
    function showAllUsers(){
        $.ajax({
            url:"<?php echo BASEURL; ?>userController/viewUser",
            type:"POST",
            data:{action:"viewuser"},
            success:function(response)
            {
                $("#showUser").html(response);
                $("table").DataTable();
            }
        });
    }

    //BlockUsers
    $("body").on("click",".blockBtn",function(e){
        e.preventDefault();
        var tr = $(this).closest('tr');
        var td = $(this).closest('td').prev().closest('td');
        id=$(this).attr('id');
           $.ajax({
            url:'<?php echo BASEURL; ?>userController/blockUser',
            type:'POST',
            data:{id:id},
            success:function(response)
            {
                var getData = $.parseJSON(response);
                if(getData.status == 0 || getData.status == 1)
                {
                    swal({
                    title: getData.msg,
                    type:'success'
                    });
                    tr.css('background-color','#00b300');
                    if(getData.status ==0)
                        td.html("inactive");
                    else
                        td.html("block");
                }
            }
         });
    });

    //soft delete user
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
                url:'<?php echo BASEURL; ?>userController/delUser',
                type:'POST',
                data:{del_id:delId},
                success:function(response)
                {
                    //tr.css('background-color','#ff6666');
                    var getData = $.parseJSON(response);
                    if(getData.status == 1)
                    {
                        swal({
                        title: getData.msg,
                        type:'success'
                        });
                        showAllUsers();
                    }
                }
            
             });
          });   
    });
});
</script>