<?php
    include_once 'Homepage.php';
?>
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12" style="padding:150px">
                <h4 class="text-center text-success font-weight-normal my-3">Welcome <?php echo $_SESSION['username'];?></h4>
            </div>
        </div>
    </div>
</div>
<?php
    include_once '../system/classes/footer.php';
?>