<?php
/**
 * manufacturerController class extends the framework class
 * It is used to controlling the manufacturer based operation from model to view
 * 
 */
class manufacturerController extends framework
{
    /**
     * Object of userModel class
     */
	 public function __construct(){
        $this->helper("link");
        $this->manufacturerModel = $this->model('manufacturerModel');
        
    }
    /**
     * default method used to call manufacturer view
     */
    public function manufacture(){
        $this->view("manufacture");
    } 
    /**
     * Manufacture details which is to be shown only to admin only
     * 
     * @return $output
     */
    public function viewManufacture()
    {
        if(isset($_POST['action']) && $_POST['action'] == "viewmanufacture")
        {
            $output='';
            $cnt=1;
            //read() method will returns the array which consists key and value of all the non deleted record
            $data = $this->manufacturerModel->read();
            //totlRowCount() will returns the total record count which are not deleted
            if($this->manufacturerModel->totalRowCount()>0)
            {
                $output.='<table class="table table-striped table-sm table-bordered">
                <thead>
                    <tr class="text-center">
                        <th>No</th>
                        <th>Manufacturer Name</th>
                        <th>Manufacturer Status</th>
                        <th>Created Date</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>';
                foreach($data as $row)
                {
                    $output.='<tr class="text-center text-secondary">
                    <td>'.$cnt.'</td>
                    <td>'.$row['manufacturer_name'].'</td>
                    <td>'.$row['manufacturer_status'].'</td>
                    <td>'.$row['created_date'].'</td>
                    <td>
                        <a href="#" title="Edit" id="'.$row['id'].'" class="text-primary editBtn" data-toggle="modal" data-target="#editManufacturer"><i class="fas fa-edit fa-lg"></i></a>
                        <a href="#" class="text-primary blockBtn" title="Block/UnBlock" id="'.$row['id'].'"><i class="fas fa-user-lock"></i></a>
                        <a href="#" class="text-danger delBtn" title="Delete" id="'.$row['id'].'"><i class="fas fa-trash"></i></a>
                    </td>
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
     * Passing the data from the manufacture(view) to the manufacture(Model)
     * 
     * It consists the logic that if post action passes from the ajax is addmanufacture then pass all the data between manufacture(view) to manufacture(model)
     * First of checks that if manufacture already exists in datbase or not
     * If exists then it will not insert the data in the database and genrate json formated error message with json formated status
     * If manufacture is unqiue then it will be complete the manufacture registration
     * 
     * @return json encoded data
     */
    public function addManufacture()
    {
        if(isset($_POST['action']) && $_POST['action'] == "addmanufacture")
        {
            //fetching the data
            $this->manufacturerModel->manufacturerName = $this->manufacturerModel->testInput($_POST['manufacturer']);

            //uses for checking duplication entries help of manufacturer
            $result = $this->manufacturerModel->checkDuplicate();
            if($result == 0)
            { 
                //Manufacturer Name Already Exists
                $jsonData['status'] = 0;
                $jsonData['msg'] = "Manufacturer Name Already Exists";
            }
            if($result == 1)
            {
                if($this->manufacturerModel->create())
                {
                    //Manufacturer Added Successfully
                    $jsonData['status'] = 1;
                    $jsonData['msg'] = "Manufacturer Added Successfully";
                }
                else
                {
                    //something went Wrong
                    $jsonData['status'] = 3;
                    $jsonData['msg'] = "something went Wrong";
                }
            }
            //returns json encoded data
            echo json_encode($jsonData);
        }
    }
    /**
     * For edit or update manufacturer details
     * 
     * @return json encoded data
     */
    public function editManufacture()
    {
        if(isset($_POST['edit_id']))
        {
            //fetch the edit id to whom admin  want to upadate
            $this->manufacturerModel->id = $_POST['edit_id'];

            //get the details of manufacturer in array form
            $row = $this->manufacturerModel->getManufacturerById($this->manufacturerModel->id);

            //encode the array in json formate
            echo json_encode($row);
        }
    }
    /**
     * For update the manufacturer according to the admin enters detail
     * 
     * If the post action comming from the ajax is updatemanufacture then it will fetch all the details from the database using model
     * Update the details using model's checkDuplicate() and update() method
     * 
     * @return json encoded data
     */
    public function updateManufacture()
    {
        if(isset($_POST['action']) && $_POST['action'] == "updatemanufacture")
        {
            //fetching the details which is to be update ny admin
            $this->manufacturerModel->id = $_POST['id'];
            $this->manufacturerModel->manufacturerName = $this->manufacturerModel->testInput($_POST['manufacturer']);

            //checks in updated details are already exists or not 
            $result = $this->manufacturerModel->checkDuplicate();
            if($result == 0)
            { 
                //Manufacturer Name Already Exists
                $json_data['status'] = 0;
                $json_data['msg'] = "Manufacturer Name Already Exists";
            }
            if($result == 1)
            {
                //unique updated detail so updates 
                if($this->manufacturerModel->update())
                {
                    //Manufacturer Updated Successfully
                    $jsonData['status'] = 1;
                    $jsonData['msg'] = "Manufacturer Updated Successfully";
                }
                else
                {
                    //echo "NotFound";
                    $jsonData['status'] = 3;
                    $jsonData['msg'] = "something went Wrong";
                }
            }
            //return json encoded data
            echo json_encode($jsonData);
        }
    }
    /**
     * Delete the manufacturer 
     * 
     * @return json encoded data
     */
    public function delManufacture()
    {
        if(isset($_POST['del_id']))
        {
            //fetch the id of manuafacturer which admin want to delete
            $this->manufacturerModel->id = $_POST['del_id'];  
            
            //manufactureDelete() method will return result through which the manufacturer will be delete
            $result=$this->manufacturerModel->manufactureDelete();
            if($result == 1)
            {
                //Manufacture Deleted Successfully
                $jsonData['status'] = 1;
                $jsonData['msg'] = "Manufacture Deleted Successfully";
            }
            //return json encoded data
            echo json_encode($jsonData);
        }
    }
    /**
     * Change the status of the manufacturer
     * 
     * If the post action fetch from the ajax consist the id then the status of manuafcturer will be updated block and unblock accordingly
     * 
     * @return json encoded data
     */
    public function blockManufacture()
    {
        if(isset($_POST['block_id']))
        {
            
            //fetch the manufacturer id of user which admin wants to unblock or block
            $this->manufacturerModel->id = $_POST['block_id'];

            //returns status in the form of 0 and 1
            $result = $this->manufacturerModel->status();
            if($result == 1)
            {
                //Manufacturer Blocked Successfully
                $jsonData['status'] = 1;
                $jsonData['msg'] = "Manufacturer Blocked Successfully";
            }
            else
            {
                //Manufacturer UnBlocked Successfully
                $jsonData['status'] = 0;
                $jsonData['msg'] = "Manufacturer UnBlocked Successfully";
            }
            //return json encoded data
            echo json_encode($jsonData);
        }
    }
    /**
     * Manufacture details which is to be shown in Add model module
     * 
     * @return $output1
     */
    public function manufactureById()
    {
        if(isset($_POST['action']) && $_POST['action'] == "manufacture")
        {
            $output1='';
            //read() method will returns the array which consists key and value of all the non deleted record
            $data = $this->manufacturerModel->readAll();
            //totlRowCount() will returns the total record count which are not deleted
            if($this->manufacturerModel->totalRowCountAll()>0)
            {
                $output1.='<select class="form-control" name="manufactureid" id="manufactureid">';
                foreach($data as $row)
                {
                    $output1.='<option value='.$row['id'].'>'.$row['manufacturer_name'].'</option>';
                }
                $output1.='</select>';
                echo $output1;
            }
        }
    }
    /**
     * For Editing Manufacture details which is to be shown in Add model module
     * 
     * @return $output1
     */
    public function editManufactureById()
    {
        if(isset($_POST['action']) && $_POST['action'] == "editmanufacture")
        {
            $output1='';
            //read() method will returns the array which consists key and value of all the non deleted record
            $data = $this->manufacturerModel->read();
            //totlRowCount() will returns the total record count which are not deleted
            if($this->manufacturerModel->totalRowCount()>0)
            {
                $output1.='<select class="form-control" name="manufactureid" id="manufactureid">';
                foreach($data as $row)
                {
                    if($_SESSION['edit']['manufacture_id']==$row['id'])
                    {
                        $output1.='<option value='.$_SESSION['edit']['manufacture_id'].' selected>'.$row['manufacturer_name'].'</option>';
                    }
                    else
                    {
                        $output1.='<option value='.$row['id'].'>'.$row['manufacturer_name'].'</option>';
                    }
                }
                $output1.='</select>';
                echo $output1;
            }
        }
    }
}
?>