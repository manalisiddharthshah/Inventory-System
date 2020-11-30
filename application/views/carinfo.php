<?php
include_once 'Homepage.php';
?>
<div class="row">
    <div class="col-lg-12">
        <a href="<?php echo BASEURL;?>modelController/modelList">
            <button type="button" class="btn btn-primary m-1 float-right">Available Model</button>
        </a>
    </div>
</div>
    <div class="col-lg-12">
        <!--Shows the car detail in this div by the infoController using ajax-->
        <div class="table-responsive">
            <table class="table">
                <tr class="text-center">
                    <td class="font-weight-bold">ID</td>
                    <td><?php echo $_SESSION['info']['id']?></td>
                </tr>
                <tr class="text-center">
                    <td class="font-weight-bold">Image1</td>
                    <td>
                        <?php 
                        if($_SESSION['info']['image1']!= "") 
                        {
                        ?>
                            <img src="<?php echo BASEURL;?>uploads1/<?php echo $_SESSION['info']['image1'];?>" style='width:300px;' /> 
                        <?php
                            }
                            else
                            {
                                echo "No image found"; 
                            }
                        ?>
                    </td>
                </tr>
                <tr class="text-center">
                    <td class="font-weight-bold">Manuafcture Name</td>
                    <td><?php echo $_SESSION['info']['manufacturer_name']?></td>
                </tr>
                <tr class="text-center">
                    <td class="font-weight-bold">Model Name</td>
                    <td><?php echo $_SESSION['info']['model_name']?></td>
                </tr>
                <tr class="text-center">
                    <td class="font-weight-bold">Model Type</td>
                    <td><?php echo $_SESSION['info']['model_type']?></td>
                </tr>
               
                <tr class="text-center">
                    <td class="font-weight-bold">Model Color</td>
                    <td><?php echo $_SESSION['info']['model_color']?></td>
                </tr>
                <tr class="text-center">
                    <td class="font-weight-bold">No Of seats</td>
                    <td><?php echo $_SESSION['info']['no_of_seats']?></td>
                </tr>
                <tr class="text-center">
                    <td class="font-weight-bold">Kilometer Driven</td>
                    <td><?php echo $_SESSION['info']['kilometers_driven']?></td>
                </tr>
                <tr class="text-center">
                    <td class="font-weight-bold">Refurblished</td>
                    <td><?php echo $_SESSION['info']['refurbished']?></td>
                </tr>
                <tr class="text-center">
                    <td class="font-weight-bold">Model Year</td>
                    <td><?php echo $_SESSION['info']['model_year']?></td>
                </tr>
                <tr class="text-center">
                    <td class="font-weight-bold">Mileage</td>
                    <td><?php echo $_SESSION['info']['mileage']?></td>
                </tr>
                <tr class="text-center">
                    <td class="font-weight-bold">Fuel Type</td>
                    <td><?php echo $_SESSION['info']['fuel_type']?></td>
                </tr>
                <tr class="text-center">
                    <td class="font-weight-bold">Transmission</td>
                    <td><?php echo $_SESSION['info']['transmission']?></td>
                </tr>
                <tr class="text-center">
                    <td class="font-weight-bold">Fuel Tank Capacity</td>
                    <td><?php echo $_SESSION['info']['fuel_tank_capacity']?></td>
                </tr>
                <tr class="text-center">
                    <td class="font-weight-bold">Power Streeing</td>
                    <td><?php echo $_SESSION['info']['power_steering']?></td>
                </tr>
                <tr class="text-center">
                    <td class="font-weight-bold">Air Conditioner</td>
                    <td><?php echo $_SESSION['info']['air_conditioner']?></td>
                </tr>
                <tr class="text-center">
                    <td class="font-weight-bold">Air Bag</td>
                    <td><?php echo $_SESSION['info']['airbag']?></td>
                </tr>
                <tr class="text-center">
                    <td class="font-weight-bold">Price</td>
                    <td><?php echo $_SESSION['info']['price']?></td>
                </tr>
                <tr class="text-center">
                    <td class="font-weight-bold">Description</td>
                    <td><?php echo $_SESSION['info']['description']?></td>
                </tr>
                <tr class="text-center">
                    <td class="font-weight-bold">Vin Number</td>
                    <td><?php echo $_SESSION['info']['vin_number']?></td>
                </tr>
                <tr class="text-center">
                    <td class="font-weight-bold">Registartion Number</td>
                    <td><?php echo $_SESSION['info']['registration_number']?></td>
                </tr>
                
                <tr class="text-center">
                    <td class="font-weight-bold">Image2</td>
                    <td>
                    <?php 
                        if($_SESSION['info']['image2']!= "") 
                        {
                        ?>
                            <img src="<?php echo BASEURL;?>uploads2/<?php echo $_SESSION['info']['image2'];?>" style='width:300px;' /> 
                        <?php
                            }
                            else
                            {
                                echo "No image found"; 
                            }
                        ?>
                    </td>
                </tr>
        </div>
    </div>
</div>
<?php
    include_once '../system/classes/footer.php';
?>