<?php
/**
 * modelController class extends the framework class
 * It is used to controlling the the model(car) based operation from model to view
 * 
 */
class modelController extends framework{
    /**
     * Object of userModel class
     */
     public function __construct()
     {
        $this->helper("link");
        $this->modelModel = $this->model('modelModel');  
    }
    /**
     * default method used to call model view
     */
    public function index()
    {
        $this->view("model");
    } 
    /**
     * Model details which is to be posted by a particular user shown to the user who posted the model(My Posted Model)
     * 
     * @return $output
     */
    public function viewModel()
    {
        if(isset($_POST['action']) && $_POST['action'] == "viewmodel")
        {
            $output='';
            $cnt=1;
            //read() method will returns the array which consists key and value of all the non deleted record
            $data = $this->modelModel->read();
            //totlRowCount() will returns the total record count which are not deleted
            if($this->modelModel->totalRowCount()>0)
            {
                $output.='<table class="table table-striped table-sm table-bordered">
                <thead>
                    <tr class="text-center">
                        <th>No</th>
                        <th>Model Type</th>
                        <th>Model Name</th>
                        <th>Color</th>
                        <th>Model Year</th>
                        <th>Registration Number</th>
                        <th>Request Date</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>';
                foreach($data as $row)
                {
                    //shown the detail to the specific user for that this condition
                    if($row['user_id'] == $_SESSION['userId'])
                    {
                            $output.='<tr class="text-center text-secondary">
                            <td>'.$cnt.'</td>
                            <td>'.$row['model_type'].'</td>
                            <td>'.$row['model_name'].'</td>
                            <td>'.$row['model_color'].'</td>
                            <td>'.$row['model_year'].'</td>
                            <td>'.$row['registration_number'].'</td>
                            <td>'.$row['created_date'].'</td>
                            <td>
                                <a href="'.BASEURL.'modelController/editModel?id='.$row['id'].'" title="Edit" class="text-primary editmodel"><i class="fas fa-edit fa-lg"></i></a>
                                
                                <a href="#" class="text-danger delBtnModel" title="Delete" id="'.$row['id'].'"><i class="fas fa-trash"></i></a>
                            </td>
                        </tr>';
                        $cnt=$cnt+1;
                    }
                }
                $output.='</tbody></table>';
                echo $output;
            }
            else
            {
                echo '<h3 class="text-center text-secondary mt-5">No Record found</h3>';
            }
        }
    }
    /**
     * Passing the data from the model(view) to the modelModel(Model)
     * 
     * It will insert the posted model details by a specific user to sold their model
     * 
     * @return json encoded data
     */
    public function insert()
    {
        $this->modelModel->userId = $_SESSION['userId'];
        $this->modelModel->manufactureId = $this->modelModel->testInput($_POST['manufactureid']);
        $this->modelModel->modelType = $this->modelModel->testInput($_POST['modeltype']);
        $this->modelModel->modelName = $this->modelModel->testInput($_POST['modelname']);
        $this->modelModel->modelColor = $this->modelModel->testInput($_POST['modelcolor']);
        $this->modelModel->noOfSeats = $this->modelModel->testInput($_POST['noofseats']);
        $this->modelModel->kiloMetersDriven = $this->modelModel->testInput($_POST['kilometerdriven']);
        $this->modelModel->refurbished = $this->modelModel->testInput($_POST['refublished']);
        $this->modelModel->modelYear = $this->modelModel->testInput($_POST['modelyear']);
        $this->modelModel->mileage = $this->modelModel->testInput($_POST['mileage']);
        $this->modelModel->fuelType = $this->modelModel->testInput($_POST['fueltype']);
        $this->modelModel->transmission = $this->modelModel->testInput($_POST['transmission']);
        $this->modelModel->fuelTankCapacity = $this->modelModel->testInput($_POST['fueltankcapacity']);
        $this->modelModel->powerSteering = $this->modelModel->testInput($_POST['powerstreering']);
        $this->modelModel->airConditioner = $this->modelModel->testInput($_POST['airconditioner']);
        $this->modelModel->airbag = $this->modelModel->testInput($_POST['airbag']);
        $this->modelModel->price =  $this->modelModel->testInput($_POST['price']);
        $this->modelModel->description = $this->modelModel->testInput($_POST['description']);
        $this->modelModel->vinNumber = $this->modelModel->testInput($_POST['vinnumber']);
        $this->modelModel->registrationNumber = $this->modelModel->testInput($_POST['registerno']);
        $image=!empty($_FILES["image1"]["name"]) ? basename($_FILES["image1"]["name"]) : "";
        $this->modelModel->image1 = $image;
        $img=!empty($_FILES["image2"]["name"]) ? basename($_FILES["image2"]["name"]) : "";
        $this->modelModel->image2 = $img;
        
        $result = $this->modelModel->uploadPhoto1();
        $result1 = $this->modelModel->uploadPhoto2();
        if($result == 1 || $result1 == 1)
        {
            if($this->modelModel->create())
            {
                //Model Added Successfully
                $json_data['status'] = 1;
                $json_data['msg'] = "Model Added Successfully";
            }
            else
            {
                //something went Wrong
                $json_data['status'] = 5;
                $json_data['msg'] = "something went Wrong";
            }
        }
        else if($result == 0 || $result1 == 0)
        {
            //Submitted file is not an image.
            $json_data['status'] = 0;
            $json_data['msg'] = "Submitted file is not an image";
        }
        else if($result == 2 || $result1 == 2)
        {
            //Only JPG, JPEG, PNG, GIF files are allowed.
            $json_data['status'] = 2;
            $json_data['msg'] = "Only JPG, JPEG, PNG, GIF files are allowed";
        }
        else if($result == 3 || $result1 == 3)
        {
            //Image must be less than 1 MB in size.
            $json_data['status'] = 3;
            $json_data['msg'] = "Image must be less than 1 MB in size";
        }  
        else
        {
            //Sorry, there was an error uploading your file
            $json_data['status'] = 4;
            $json_data['msg'] = "Sorry, there was an error uploading your file";
        }    
    $_SESSION['insert']=json_encode($json_data);
    $this->view("model");
    }
    public function delModel()
    {
        if(isset($_POST['del_id']))
        {
            $this->modelModel->id = $_POST['del_id'];  
            
            $result=$this->modelModel->modelDelete();
            if($result == 1)
            {
                $json_data['status'] = 1;
                $json_data['msg'] = "Model Deleted Successfully";
            }
        echo json_encode($json_data);
        }
    }
    /**
     * Edit the model details which to be posted by a specific user who post their model for selling
     * Post of the model can be editable only by a user who post that model
     *
     */
    public function editModel()
    {
        //get the id from the url
        $id = !empty($_GET['id']) ? $_GET['id'] : die('ERROR: missing ID.');
        $_SESSION['id1']=$id;
        //genrate session and passed it to the view file which consist all the model details based on their id
        $_SESSION['edit'] = $this->modelModel->readOne($id);
        $this->view("editcar");
    }
    /**
     * For update the model details
     * 
     * @return json encoded data
     */
    public function updateModel()
    {
        $this->modelModel->id = $this->modelModel->testInput($_POST['id1']);
        $this->modelModel->manufactureId = $this->modelModel->testInput($_POST['manufactureid']);
        $this->modelModel->modelType = $this->modelModel->testInput($_POST['modeltype']);
        $this->modelModel->modelName = $this->modelModel->testInput($_POST['modelname']);
        $this->modelModel->modelColor = $this->modelModel->testInput($_POST['modelcolor']);
        $this->modelModel->noOfSeats = $this->modelModel->testInput($_POST['noofseats']);
        $this->modelModel->kiloMetersDriven = $this->modelModel->testInput($_POST['kilometerdriven']);
        $this->modelModel->refurbished = $this->modelModel->testInput($_POST['refublished']);
        $this->modelModel->modelYear = $this->modelModel->testInput($_POST['modelyear']);
        $this->modelModel->mileage = $this->modelModel->testInput($_POST['mileage']);
        $this->modelModel->fuelType = $this->modelModel->testInput($_POST['fueltype']);
        $this->modelModel->transmission = $this->modelModel->testInput($_POST['transmission']);
        $this->modelModel->fuelTankCapacity = $this->modelModel->testInput($_POST['fueltankcapacity']);
        $this->modelModel->powerSteering = $this->modelModel->testInput($_POST['powerstreering']);
        $this->modelModel->airConditioner = $this->modelModel->testInput($_POST['airconditioner']);
        $this->modelModel->airbag = $this->modelModel->testInput($_POST['airbag']);
        $this->modelModel->price =  $this->modelModel->testInput($_POST['price']);
        $this->modelModel->description = $this->modelModel->testInput($_POST['description']);
        $this->modelModel->vinNumber = $this->modelModel->testInput($_POST['vinnumber']);
        $this->modelModel->registrationNumber = $this->modelModel->testInput($_POST['registerno']);
        
        $image=!empty($_FILES["image1"]["name"]) ? basename($_FILES["image1"]["name"]) : "";
        $this->modelModel->image1 = $image;
        $img=!empty($_FILES["image2"]["name"]) ? basename($_FILES["image2"]["name"]) : "";
        $this->modelModel->image2 = $img;
        
        $result = $this->modelModel->uploadPhoto1();
        $result1 = $this->modelModel->uploadPhoto2();
        if($result == 1 || $result1 == 1)
        {
            if($this->modelModel->updateModel())
            {
                //Model Edited Successfully
                $json_data['status'] = 1;
                $json_data['msg'] = "Model Edited Successfully";
            }
            else
            {
                //something went Wrong
                $json_data['status'] = 5;
                $json_data['msg'] = "something went Wrong";
            }
        }
        else if($result == 0 || $result1 == 0)
        {
            //Submitted file is not an image.
            $json_data['status'] = 0;
            $json_data['msg'] = "Submitted file is not an image";
        }
        else if($result == 2 || $result1 == 2)
        {
            //Only JPG, JPEG, PNG, GIF files are allowed.
            $json_data['status'] = 2;
            $json_data['msg'] = "Only JPG, JPEG, PNG, GIF files are allowed";
        }
        else if($result == 3 || $result1 == 3)
        {
            //Image must be less than 1 MB in size.
            $json_data['status'] = 3;
            $json_data['msg'] = "Image must be less than 1 MB in size";
        }  
        else
        {
            //Sorry, there was an error uploading your file
            $json_data['status'] = 4;
            $json_data['msg'] = "Sorry, there was an error uploading your file";
        }    
    $_SESSION['update']=json_encode($json_data);
    $this->view("model");
    }
    /**
     * modelList method used to call modellist view
     */
    public function modelList()
    {
        $this->view("modellist");
    }
    /**
     * View All the available models which to be posted by different different user for sell their models
     * 
     * @return $output
     */
    public function viewAllModel()
    {
        if(isset($_POST['action']) && $_POST['action'] == "viewallmodel")
        {
            $output='';
            $cnt=1;
            //read() method will returns the array which consists key and value of all the non deleted record
            $data = $this->modelModel->read();
            unset($_SESSION['info']);
            //totlRowCount() will returns the total record count which are not deleted
            if($this->modelModel->totalRowCount()>0)
            {
                $output.='<table class="table table-striped table-sm table-bordered">
                <thead>
                    <tr class="text-center">
                        <th>No</th>
                        <th>Model Type</th>
                        <th>Model Name</th>
                        <th>Color</th>
                        <th>Model Year</th>
                        <th>Registration Number</th>
                        <th>Image</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>';  
                foreach($data as $row)
                {
                    if($row['user_id']!=$_SESSION['userId'])
                    {
                        $output.='<tr class="text-center text-secondary">
                        <td>'.$cnt.'</td>
                        <td>'.$row['model_type'].'</td>
                        <td>'.$row['model_name'].'</td>
                        <td>'.$row['model_color'].'</td>
                        <td>'.$row['model_year'].'</td>
                        <td>'.$row['registration_number'].'</td>
                        <td><img src="'.BASEURL.'uploads1/'.$row['image1'].'" style="width:300px;" /></td>
                        <td>
                            <a href="'.BASEURL.'modelController/infoModel?id='.$row['id'].'" title="info" class="text-primary infoBtnModel"><i class="fas fa-info"></i></a>';
                            if($_SESSION['usertype'] == 'client') 
                            {
                                $output.= ' | <a href="#" class="text-danger purchaseModel" title="Purchase" id="'.$row['id'].'"><i class="fas fa-shopping-cart"></i></a>
                                </td>
                            </tr>';
                            
                            }
                            else
                            {
                               
                            }
                            
                    $cnt=$cnt+1;
                    }
                }
                $output.='</tbody></table>';
                echo $output;
            }
            else
            {
                echo '<h3 class="text-center text-secondary mt-5">No Record found</h3>';
            }
        }
    }
    /**
     * For purchase the model which to be available
     * 
     * @return json encoded data
     */
    public function purchaseModel()
    {
        if(isset($_POST['purchase_id']))
        {
            $this->modelModel->id = $_POST['purchase_id'];
            $row = $this->modelModel->modelPurchase();
            if($row == 1)
            {
                $json_data['status']=1;
                $json_data['msg']="Car Model Purchased";
            }
            echo json_encode($json_data);
        }
    }
    /**
     * For getting the information of model
     */
    public function infoModel()
    {
        //getting id from the url
        $id = !empty($_GET['id']) ? $_GET['id'] : die('ERROR: missing ID.');
        //read the details of that id's model and stores it in session and passes it to the view
        $_SESSION['info'] = $this->modelModel->readOne($id);
        $this->view("carinfo");
    }
    /**
     * It will show all the solded model of a specific user who has posted his/her model for sell and in that which are to be sell succesfully are display
     * 
     * @return $output
     */
    public function showAllSoldModel()
    {
        if(isset($_POST['action']) && $_POST['action'] == "viewallsoldmodel")
        {
            $output='';
            $cnt=1;
            //read the all solded models of a specific user
            $data = $this->modelModel->modelSold();
            unset($_SESSION['info']);
            if($this->modelModel->totalCount()>0)
            {
                $output.='<table class="table table-striped table-sm table-bordered">
                <thead>
                    <tr class="text-center">
                        <th>No</th>
                        <th>Model Type</th>
                        <th>Model Name</th>
                        <th>Color</th>
                        <th>Model Year</th>
                        <th>Registration Number</th>
                        <th>Sold</th>
                    </tr>
                </thead>
                <tbody>';
                    
                foreach($data as $row)
                {
                    if($row['user_id']==$_SESSION['userId'])
                    {
                        $output.='<tr class="text-center text-secondary">
                        <td>'.$cnt.'</td>
                        <td>'.$row['model_type'].'</td>
                        <td>'.$row['model_name'].'</td>
                        <td>'.$row['model_color'].'</td>
                        <td>'.$row['model_year'].'</td>
                        <td>'.$row['registration_number'].'</td>
                        <td>'.$row['sold'].'</td>
                    </tr>';
                    $cnt=$cnt+1;
                    }
                }
                $output.='</tbody></table>';
                echo $output;
            }
            else
            {
                echo '<h3 class="text-center text-secondary mt-5">No Record found</h3>';
            }
        }
    }
    /**
     * viewInventoryClient() method call viewinventoryclient view
     */
    public function viewInventoryClient()
    {
        $this->view("viewinventoryclient");
    }
    /**
     * viewInventoryAdmin() method call viewinventoryadmin view
     */
    public function viewInventoryAdmin()
    {
        $this->view("viewinventoryadmin");
    }
    /**
     * It will shown only at admin side 
     * 
     * It will display all the transcation like who posted the model,who purchase,At which time the model is posted and sell etc
     * 
     * @return $output
     */
    public function viewTranscationModel()
    {
        if(isset($_POST['action']) && $_POST['action'] == "viewtranscationmodel")
        {
            $output='';
            $cnt=1;
            $data = $this->modelModel->transcation();
            if($this->modelModel->transcationCount()>0)
            {
                $output.='<table class="table table-striped table-sm table-bordered">
                <thead>
                    <tr class="text-center">
                        <th>No</th>
                        <th>Sold User</th>
                        <th>Posted Date</th>
                        <th>Model Name</th>
                        <th>Image</th>
                        <th>manufacturer Name</th>
                        <th>Purchase Date</th>
                        <th>Purchase User</th>
                    </tr>
                </thead>
                <tbody>';
                foreach($data as $row)
                { 
                    $output.='<tr class="text-center text-secondary">
                    <td>'.$cnt.'</td>
                    <td>'.$row['Sold'].'</td>
                    <td>'.$row['created_date'].'</td>
                    <td>'.$row['model_name'].'</td>
                    <td><img src="'.BASEURL.'uploads1/'.$row['image1'].'" style="width:300px;" /></td>
                    <td>'.$row['manufacturer_name'].'</td>
                    <td>'.$row['transcation_date'].'</td>
                    <td>'.$row['Purchase'].'</td>
                </tr>';
                $cnt=$cnt+1;
                  
                }
                $output.='</tbody></table>';
                echo $output;
            }
            else
            {
                echo '<h3 class="text-center text-secondary mt-5">No Record found</h3>';
            }
        }
    }
    /**
     * inventory() method will call the viewinventory view
     */
    public function inventory()
    {
        $this->view("viewinventory");
    }
    /**
     * show the inventory Model
     * 
     * @return $output
     */
    public function inventoryModel()
    {
        if(isset($_POST['action']) && $_POST['action'] == "inventorymodel")
        {
            $output='';
            $cnt=1;
            $data = $this->modelModel->inventory();
            if($this->modelModel->inventoryCount()>0)
            {
                $output.='<table class="table table-striped table-sm table-bordered">
                <thead>
                    <tr class="text-center">
                        <th>No</th>
                        <th>Manufacturer Name</th>
                        <th>Model Name</th>
                        <th>Sold Model/Total Model</th>
                    </tr>
                </thead>
                <tbody>';
                foreach($data as $row)
                { 
                    $output.='<tr class="text-center text-secondary">
                    <td>'.$cnt.'</td>
                    <td><a href="'.BASEURL.'modelController/infoManufacturerModel?id='.$row['id'].'">'.$row['manufacturer_name'].'</a></td>
                    <td>'.$row['model_name'].'</td>
                    <td>'.$row['sold_cars'].'/'.$row['total_cars'].'</td>
                </tr>';
                $cnt=$cnt+1;
                }
                $output.='</tbody></table>';
                echo $output;
            }
            else
            {
                echo '<h3 class="text-center text-secondary mt-5">No Record found</h3>';
            }
        }
    }
    /**
     * Shows the information based on a manufacturer name
     */
    public function infoManufacturerModel()
    {
        $id = !empty($_GET['id']) ? $_GET['id'] : die('ERROR: missing ID.');
        $_SESSION['infoManufacturer'] = $this->modelModel->readManufacturer($id);
        $this->view("readmanufacturer");
    }
    /**
     * Shows the models purchased by a specific user to its on portal
     */
    public function myInventory()
    {
        $this->view("myInventory");
    }
    /**
     * show the Purchase Inventory Model
     * 
     * @return $output
     */
    public function myModel()
    {
        if(isset($_POST['action']) && $_POST['action'] == "viewmymodel")
        {
            $output='';
            $cnt=1;
            //readMyModel() method will returns the array which consists key and value of all the non deleted record
            $data = $this->modelModel->readMyModel();
           
            //totalMyModelCount() will returns the total record count which are not deleted
            if($this->modelModel->totalMyModelCount()>0)
            {
                $output.='<table class="table table-striped table-sm table-bordered">
                <thead>
                    <tr class="text-center">
                        <th>No</th>
                        <th>Model Type</th>
                        <th>Model Name</th>
                        <th>Color</th>
                        <th>Model Year</th>
                        <th>Registration Number</th>
                        <th>Image</th>
                        <th>Purchase Date</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>';  
                foreach($data as $row)
                {
                    $output.='<tr class="text-center text-secondary">
                    <td>'.$cnt.'</td>
                    <td>'.$row['model_type'].'</td>
                    <td>'.$row['model_name'].'</td>
                    <td>'.$row['model_color'].'</td>
                    <td>'.$row['model_year'].'</td>
                    <td>'.$row['registration_number'].'</td>
                    <td><img src="'.BASEURL.'uploads1/'.$row['image1'].'" style="width:300px;" /></td>
                    <td>'.$row['transcation_date'].'</td>
                    <td>
                        <a href="'.BASEURL.'modelController/infoModel?id='.$row['id'].'" title="info" class="text-primary infoBtnModel"><i class="fas fa-info"></i></a>'; 
                    $cnt=$cnt+1;
                    
                }
                $output.='</tbody></table>';
                echo $output;
            }
            else
            {
                echo '<h3 class="text-center text-secondary mt-5">No Record found</h3>';
            }
        }
    }
}
?>