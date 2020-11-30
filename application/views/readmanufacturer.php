<?php
include_once 'Homepage.php';
?>
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <!--Shows the client details in this div by the userController using ajax-->
                <div class="table-responsive">
                    <?php 
                        $output='';
                        $cnt=1;
                        $data = $_SESSION['infoManufacturer'];
                        $output.='<table class="table table-striped table-sm table-bordered">
                            <thead>
                                <tr class="text-center">
                                <th>No</th>
                                <th>User Name</th>
                                <th>Model Name</th>
                                <th>Image</th>
                                <th>Model Color</th>
                                <th>Status</th>
                                <th>Post Date</th>
                                </tr>
                            </thead>
                            <tbody>';
                        foreach($data as $row)
                        { 
                            $output.='<tr class="text-center text-secondary">
                            <td>'.$cnt.'</td>
                            <td>'.$row['user_name'].'</td>
                            <td>'.$row['model_name'].'</td>
                            <td><img src="'.BASEURL.'uploads1/'.$row['image1'].'" style="width:300px;" /></td>
                            <td>'.$row['model_color'].'</td>
                            <td>'.$row['sold'].'</td>
                            <td>'.$row['created_date'].'</td>
                        </tr>';
                        $cnt=$cnt+1;
                        
                        }
                        $output.='</tbody></table>';
                        echo $output;
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
    include_once '../system/classes/footer.php';
?>
<script>
$(document).ready(function(){
    $("table").DataTable({
    });
           
});
</script>