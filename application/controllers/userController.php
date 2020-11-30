<?php
/**
 * UserController class extends the framework class
 * It is used to controlling the the user based operation from model to view
 * 
 */
class userController extends framework{
    /**
     * Object of userModel class
     */
	 public function __construct(){

        $this->helper("link");
        $this->userModel = $this->model('userModel');
        
    }
    /**
     * default method used to call register view
     */
    public function index(){

        $this->view("register");
    } 
    /**
     * Passing the data from the register(view) to the userModel(Model)
     * 
     * It consists the logic that if post action passes from the ajax is register then pass all the data between register(view) to user(model)
     * First of checks that if username or email id already exists in datbase or not
     * If exists then it will not insert the data in the database and genrate json formated error message with json formated status
     * If username or email is unqiue then it will be complete the user registration
     * 
     * @return json encoded data
     */
    public function insert()
    {
        if(isset($_POST['action']) && $_POST['action'] == "register")
        { 
            //fetching the data
            $this->userModel->userName = $this->userModel->testInput($_POST['username']);
            $this->userModel->email = $this->userModel->testInput($_POST['email']);
            $this->userModel->phoneNo = $this->userModel->testInput($_POST['phoneno']);
            $this->userModel->address = $this->userModel->testInput($_POST['address']);
            $this->userModel->password = md5($this->userModel->testInput($_POST['password']));
            $this->userModel->userType = "client";
            
            //uses for checking duplication entries help of email and username
            $result = $this->userModel->checkDuplicate();
            if($result == 0)
            { 
                //Invalid user->username or email id already exists
                $jsonData['status'] = 0;
                $jsonData['msg'] = "username or email id already exists";
            }
            if($result == 1)
            {
                //uses for registartion
                if($this->userModel->create())
                {
                    //Registartion successful
                    $jsonData['status'] = 1;
                    $jsonData['msg'] = "Registration Sucessful";
                }
                else
                {
                    //Something went wrong during registration
                    $jsonData['status'] = 3;
                    $jsonData['msg'] = "something went Wrong";
                }
            }
            //returns json encoded data
            echo json_encode($jsonData); 
        }
    }
    /**
     * login method used to call login view
     */
    public function login(){

        $this->view("login");
    } 
    /**
     * Authenticate the user is vaild or not with the help of email id and password enters by user
     * 
     * It consists the logic that if post action passes from the ajax is authentication then checks the user is authorized or not
     * First it passes the email id with white format and passes the password in the encrpted form to the model
     * If the user is authorized then it will passes to the dashboard page using ajax
     * If user is blocked or deleted by admin then if will get the alert that invaild User using ajax
     * If email id or password is incorrect then it will get alert that Wrong username or password using ajax
     * 
     * @return json encoded data
     */
    public function authentication()
    {
        if(isset($_POST['action']) && $_POST['action'] == "authentication")
        {
            //fetching the data
            $this->userModel->email = $this->userModel->testInput($_POST['email']);
            $this->userModel->password = md5($this->userModel->testInput($_POST['password']));

            //uses for authentication
            $result = $this->userModel->authorize();
            if($result == 2)
            {
                //Invaild User->blocked or deleted user
                $jsonData['status'] = 2;
                $jsonData['msg'] = "Invalid User";
            }
            else if($result == 0)
            {
                //Wrong Username or Password
                $jsonData['status'] = 0;
                $jsonData['msg'] = "Wrong email id or password";
            }  
            else
            {
                //authorized
                $jsonData['status'] = 3;
            }
            //returns json encoded data
            echo json_encode($jsonData);
        }
    }
    /**
     * Dashboard() used to view dashboard page
     */
    public function dashboard()
    {
        $this->view("dashboard");
    }
    /**
     * clientdetail() used to view clientdetail page
     */
    public function clientDetail()
    {
        $this->view("clientdetail");
    }
    /**
     * Client details which is to be shown only to admin only
     * 
     * @return $output
     */
    public function viewUser()
    {
        if(isset($_POST['action']) && $_POST['action'] == "viewuser")
        {
            $output='';
            $cnt=1;
            //read() method will returns the array which consists key and value of all the non deleted record
            $data = $this->userModel->read();
            //totlRowCount() will returns the total record count which are not deleted
            if($this->userModel->totalRowCount()>0)
            {
                $output.='<table class="table table-striped table-sm table-bordered">
                <thead>
                    <tr class="text-center">
                        <th>No</th>
                        <th>User Name</th>
                        <th>User Email</th>
                        <th>User Phone</th>
                        <th>User Address</th>
                        <th>User Type</th>
                        <th>Joining Date</th>
                        <th>Modified Profile Date</th>
                        <th>User Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>';
                foreach($data as $row)
                {
                    $output.='<tr class="text-center text-secondary">
                    <td>'.$cnt.'</td>
                    <td>'.$row['user_name'].'</td>
                    <td>'.$row['user_email'].'</td>
                    <td>'.$row['user_phone'].'</td>
                    <td>'.$row['user_address'].'</td>
                    <td>'.$row['user_type'].'</td>
                    <td>'.$row['created_date'].'</td>
                    <td>'.$row['modified_date'].'</td>
                    <td>'.$row['user_status'].'</td>
                    <td>
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
     * Change the status of the user
     * 
     * If the post action fetch from the ajax consist the id then the status of user will be updated block and unblock accordingly
     * 
     * @return json encoded data
     */
    public function blockUser()
    {
        if(isset($_POST['id']))
        {
            //fetch the id of user which admin wants to unblock or block
            $this->userModel->id = $_POST['id'];

            //returns status in the form of 0 and 1
            $result = $this->userModel->status();
            if($result == 1)
            {
                //User block
                $jsonData['status'] = 1;
                $jsonData['msg'] = "User Blocked Successfully";
            }
            else
            {
                //Unblock user
                $jsonData['status'] = 0;
                $jsonData['msg'] = "User UnBlocked Successfully";
            }
            //returns json encoded data
            echo json_encode($jsonData);
        }
    }
    /**
     * Delete the user 
     * 
     * @return json encoded data
     */
    public function delUser()
    { 
        if(isset($_POST['del_id']))
        {
            //fetch the id of user which admin want to delete
            $this->userModel->id = $_POST['del_id'];  
            
            //userDelete() method will return result through which the user will be delete
            $result=$this->userModel->userDelete();
            if($result == 1)
            {
                //User Deleted
                $jsonData['status'] = 1;
                $jsonData['msg'] = "User Deleted Successfully";
            }
            //return json encoded data
            echo json_encode($jsonData);

        }
    }
    /**
     * fetch the data of user by their id
     */
    public function editProfile()
    {
        //fetch the user id who wants to update their profile
        $this->userModel->id = $_SESSION['userId'];

        //get the details of user in array form
        $row = $this->userModel->getUserById($this->userModel->id);

            //stores array in to the session
        $_SESSION["row"] = $row;
        $this->view("editprofile");
    }
    /**
     * For update the user profile according to the user enters their detail
     * 
     * If the post action comming from the ajax is updateuser then it will fetch all the details enters by user
     * Update the details using model's updateProfile() method
     * 
     * @return json encoded data
     */
    public function update()
    {
        if(isset($_POST['editBtn1']))
        { 
            //fetching the details enters by user to update
            $this->userModel->id = $_POST['id1'];
        
            $this->userModel->userName = $this->userModel->testInput($_POST['username']);
            $this->userModel->email = $this->userModel->testInput($_POST['email']);
            $this->userModel->phoneNo = $this->userModel->testInput($_POST['phoneno']);
            $this->userModel->address = $this->userModel->testInput($_POST['address']);
                unset($_SESSION['success']);
                //unique updated detail so updates profile
                $ans=$this->userModel->updateProfile();
                if($ans==0)
                {
                    //For redirect to another page
                    $_SESSION['success'] = 1;
                    //fetch the user id who wants to update their profile
                    $user->id = $_SESSION['userId'];

                    //get the details of user in array form
                    $row = $this->userModel->getUserById($user->id);

                    //stores array in to the session
                    $_SESSION["row"] = $row;
                    $this->view("editprofile");
                }
        }
    }
    /**
     * logout the user
     * 
     * logout() get the userId's session value and pass to the model's logout() and if the result is 0 then all the session will be destroy
     */
    public function logout()
    {
        $this->userModel->id = $_SESSION['userId'];
        //logout function return the 0 or 1
        $result=$this->userModel->logout();
        if($result == 0) 
        {
            //distroy the session
            session_destroy();
            //redirect to the login page
            $this->view("login");
        }
    }
    /**
     * ChangePassword() used to view changepassword page
     */
    public function ChangePassword()
    {
        $this->view("Changepassword");
    }
    /**
     * update the user
     * 
     * updatePass() will update the user password ,first it will verify the old password matches with the database stored password
     * Then it will update the password which will enter by user to the old password
     * 
     * @return json encoded data
     */
    public function updatePass()
    {
        if(isset($_POST['action']) && $_POST['action'] == "updatepass")
        {
            //fetch the user id who wants to update their profile
            $this->userModel->id = $_SESSION['userId'];
           
            //fetching the data
            $this->userModel->password = md5($this->userModel->testInput($_POST['oldpass']));
            $this->userModel->newPassword = md5($this->userModel->testInput($_POST['newpass']));
            
            //uses for authentication and updation
            $result = $this->userModel->updatePassword();
            if($result == 0)
            {
                //User Updated
                $jsonData['status'] = 0;
                $jsonData['msg'] = "Your Password Updated Successfully";    
            }
            //return json encoded data
            echo json_encode($jsonData);
        }
    }
    public function forgotPassword()
    {
        $this->view("forgotpassword");
    }
    /*public function forgotPass()
    {
        if(isset($_POST['action']) && $_POST['action'] == "forgotPass")
        {
            
            //fetching the data
            $this->userModel->userName = $this->userModel->testInput($_POST['username']);
            $this->userModel->email = $this->userModel->testInput($_POST['email']);
            
            //uses for authentication and updation
            $result = $this->userModel->forgotPassword();
            if($result == 0)
            {
                //User Deleted
                $jsonData['status'] = 0;
                $jsonData['msg'] = "UserName or Email Id is incoorect";    
            }
            if($result == 1)
            {
                //User Deleted
                $jsonData['status'] = 1;
                $jsonData['msg'] = "Message has been sent and Your password updated successfully";    
            }
            if($result == 2)
            {
                //User Deleted
                $jsonData['status'] = 2;
                $jsonData['msg'] = "Message could not be sent.";    
            }
            //return json encoded data
            echo json_encode($jsonData);
        }
    }
    */
    /**
     * It is used for forgoting the password if the password is not remember by user
     * 
     * @return json encoded data
     */
    public function forgotPass()
    {
        if(isset($_POST['action']) && $_POST['action'] == "forgotPass")
        {
            
            //fetching the data
            $this->userModel->userName = $this->userModel->testInput($_POST['username']);
            $this->userModel->email = $this->userModel->testInput($_POST['email']);
            
            //uses for authentication and updation
            $result = $this->userModel->forgotPassword();
           
            if($result == 0)
            {
                //User Deleted
                $jsonData['status'] = 0;
                $jsonData['msg'] = "UserName or Email Id is incoorect";   
                
            }
            if($result == 1)
            {
                $jsonData['status'] = 1;
                
            }  
            echo json_encode($jsonData); 
        }
    }
    /**
     * For entering new password in the client view
     */
    public function new()
    {
        $this->view("newpassword");
    }
    /**
     * It is used for reseting new password
     * 
     * @return json encoded data
     */
    public function newPass()
    {
        if(isset($_POST['action']) && $_POST['action'] == "newPass")
        {
            //fetching the data
            $this->userModel->password =  md5($this->userModel->testInput($_POST['password']));

            //uses for updation
            $result = $this->userModel->newPassword();
            if($result == 1)
            {
                $jsonData['status'] = 1;
                $jsonData['msg'] = "Password Updated Successfully";   
                echo json_encode($jsonData); 
            }
        }
    }
}
?>