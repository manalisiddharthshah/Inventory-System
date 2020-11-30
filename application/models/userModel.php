<?php
// Import PHPMailer classes into the global namespace
// These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

// Load Composer's autoloader
require '../vendor/autoload.php';
/** 
 * for starting the session
 */
session_start();
/**
 * User Class used for performing some operation based on database tables using PDOStatment SQL Queries
 */
// Instantiation and passing `true` enables exceptions
$mail = new PHPMailer(true);

class userModel extends database
{
    /**
     * @the $conn variable
     * 
     * @access private
     */
    private $conn;
    /**
     * @the $tableName defines the table name
     * 
     * @access private
     */
    private $tableName = "user";
    /**
     * Object properties
     * 
     * @the $id  id of user
     * 
     * @the $userName  username
     * 
     * @the $email  user emailid 
     * 
     * @the $phoneNo  user phoneno
     * 
     * @the $address  address of user
     * 
     * @the $password  password
     * 
     * @the $newPassword new password
     * 
     * @the $userType  type of user
     * 
     * @the $userStatus  status of user
     * 
     * @the $userDelete  delete the user
     * 
     * @the $createdDate  date of creation
     * 
     * @the $modifiedDate  date of modification
     * 
     * @access public 
     */
    public $id;
    public $userName;
    public $email;
    public $phoneNo;
    public $address;
    public $password;
    public $newPassword;
    public $userType;
    public $userStatus;
    public $userDelete;
    public $createdDate;
    public $modifiedDate;
    /**
     * __construct() magic method for defining connection object using parent class __construct()
     */
    public function __construct(){
        $this->conn = parent::__construct();
    }
    
    /**
     * testInput() method for forming the data into proper form
     * 
     * @the stripslashes() removes slashes in the string
     * 
     * @the strip_tags() removes html tags
     * 
     * @the htmlspecialchars() removes special characters of html
     * 
     * @return $data
     */
    public function testInput($data)
	{
		$data = stripslashes($data);
		$data = strip_tags($data);
		$data = htmlspecialchars($data);
		return $data;
    } 
    /** 
     * checkDuplicate() method check the email id or username already exists in the database table of not 
     * 
     * checkDuplicate() consists a query which select the rows of table which has username or email id already exists
     * query will be prepare,bind and execute then the result will fetch in the variable $result using fetchAll()
     * if the PDOStatment rowCount will greater then 0 then return 0 means username or email already exists
     * else return 1 means username or email is not exists it is unique entry
     * 
     * @return 0 means userName or email already exists
     * 
     * @return 1 means userName or email already not exists
    */
    public function checkDuplicate()
    {
        //prepare the query using PDOStatment
        $stmt = $this->conn->prepare("SELECT * FROM " . $this->tableName . " WHERE user_name=:username OR user_email=:email");
        
        //Bind Parameters using PDO Statment
        $stmt -> bindParam(":username", $this->userName);
        $stmt -> bindParam(":email", $this->email);
        
        //execute the PDOStatment
        $stmt -> execute();

        //fetchAll PDO Associative data from the PDOStatement which executes previously
        $result = $stmt -> fetchAll(PDO::FETCH_ASSOC);

        //rowCount() predefine function
        if($stmt->rowCount()>0)
        {
            return 0;
        }
        else
        {
            return 1;
        }
    }
    /**
     * create() method will insert the data which is enter by user to the database table
     * 
     * create() consist a query and PDOStatment which will prepare,bind and execute the query
     * if the PDOStatment executes then it return true means the data will be inserted
     * else it return false means the data will not be inserted
     * 
     * @return true means registration successful
     * 
     * @return false means not register
     */
    public function create()
    {
        //prepare the query using PDOStatment
        $stmt = $this->conn->prepare("INSERT INTO " . $this->tableName . " SET user_name=:username, user_email=:email, user_phone=:phoneno,user_address=:address,user_password=:password, user_type=:usertype, created_date=:created");
        
        // to get time-stamp for 'created' field
        $this->createdDate = date('Y-m-d');

        //Bind Parameters using PDO Statment
        $stmt->bindParam(":username", $this->userName);
        $stmt->bindParam(":email", $this->email);
        $stmt->bindParam(":phoneno", $this->phoneNo);
        $stmt->bindParam(":address", $this->address);
        $stmt->bindParam(":password", $this->password);
        $stmt->bindParam(":usertype", $this->userType);
        $stmt->bindParam(":created", $this->createdDate);
        
        //execute the PDOStatment
        if($stmt->execute())
        {
            return true;
        }else{
            return false;
        }
    } 
    /**
     * authorize() method checks the user email and user password is correct or not
     * 
     * authorize() method is used for provides access to authorized user by checking their email id and password are correct or not
     * it will select the user if email and password matches by prepare,bind and execute the query and fetch the data of vaild user using fetchAll() method
     * if the user status is block then return 0 means invaild user 
     * else if will fetch the userId,username,usertype  into the session and return 1 means valid user
     * 
     * @return 0 maens invalid user
     * 
     * @return 1 means valid user
     */  
    public function authorize()
    {
        //prepare the query using PDOStatment
        $stmt = $this->conn->prepare("SELECT * FROM " . $this->tableName . " WHERE user_email=:email AND user_password=:password");
        
        //Bind Parameters using PDO Statment
        $stmt->bindParam(":email", $this->email);
        $stmt->bindParam(":password", $this->password);

        //execute the PDOStatment
        $stmt -> execute();
        
        //fetchAll PDO Associative data from the PDOStatement which executes previously
        $result=$stmt->fetchAll(PDO::FETCH_ASSOC);

        //rowCount() predefine function
        if($stmt->rowCount()>0)
        {
            if($result[0]['user_status']=="block" || $result[0]['user_delete']=="deleted")
            {
                return 2;
            }
            else
            {
                //prepare the query using PDOStatment
                $statment = $this->conn->prepare("UPDATE " . $this->tableName . " SET user_status=:status WHERE id=:id");
                $this->userStatus = "active";
                
                $this->id = $result[0]['id'];

                //Bind Parameters using PDO Statment
                $statment->bindParam(":id", $this->id);
                $statment->bindParam(":status",$this->userStatus);

                //execute the PDOStatment
                if($statment->execute()){
                     //sets the session
                    $_SESSION['userId'] = $result[0]['id'];
                    $_SESSION['username'] = $result[0]['user_name'];
                    $_SESSION['usertype'] = $result[0]['user_type'];  
                    return 1;
                }
            }
        }
        return 0;
    }
    /**
     * read() method is used select all the records from the databse table
     * 
     * @return $data
     */
    public function read()
    {
        /**
         * @the data array
         */
        $data = array();
        
        //prepare the query using PDOStatment
        $stmt = $this->conn->prepare("SELECT * FROM " . $this->tableName . " WHERE user_delete=:userdelete");

        $this->userDelete = "not deleted";
        //Bind Parameters using PDO Statment
        $stmt->bindParam(":userdelete",$this->userDelete);

        //execute the PDOStatment
        $stmt->execute();

        //fetchAll PDO Associative data from the PDOStatement which executes previously
        $result=$stmt->fetchAll(PDO::FETCH_ASSOC);

        //stores the $result data to the $data array
        foreach($result as $row)
        {
            $data[]=$row;
        }
        return $data;
    }
    /**
     * totalRowCount() method is used to count the total no of rows in the datatable which are not deleted
     * 
     * @the totalrows variable
     * 
     * @return $totalrows
     */
    public function totalRowCount()
    {
        //prepare the query using PDOStatment
        $stmt = $this->conn->prepare("SELECT * FROM " . $this->tableName . " WHERE user_delete=:userdelete");

        $this->userDelete = "not deleted";
        //Bind Parameters using PDO Statment
        $stmt->bindParam(":userdelete",$this->userDelete);

        //execute the PDOStatment
        $stmt->execute();

        //rowCount() predefine function
        $totalRows=$stmt->rowCount();
        return $totalRows;
    }  
    /**
     * status() method is used change the status of the user
     * 
     * status() method consists a query from which the data which is matches with the id are to selected from the database using prepare,bind and execute PDOStatment
     * after execute the query the data will be fetch and find the rowCount is greater than zero or not using rowCount() method
     * then we have to update the user status if the status is active or inactive then it will converted to block and if it is block then converted it to inactive
     * 
     * @return 0 if userstatus updated to inactive
     * 
     * @return 1 if userstatus updated to block
     */
    public function status()
    {
        //prepare the query using PDOStatment
        $stmt = $this->conn->prepare("SELECT * FROM " . $this->tableName . " WHERE id=:id");

        //Bind Parameters using PDO Statment
        $stmt->bindParam(":id", $this->id);

        //execute the PDOStatment
        $stmt->execute();

        //fetchAll PDO Associative data from the PDOStatement which executes previously
        $result=$stmt->fetchAll(PDO::FETCH_ASSOC);
        if($stmt->rowCount()>0)
        {
            //prepare the query using PDOStatment
            $statment = $this->conn->prepare("UPDATE " . $this->tableName . " SET user_status=:status WHERE id=:id");
            if($result[0]['user_status']=="block")
            {
                $this->userStatus = "inactive";

                //Bind Parameters using PDO Statment
                $statment->bindParam(":id", $this->id);
                $statment->bindParam(":status",$this->userStatus);

                //execute the PDOStatment
                $statment->execute();
                return 0;
            }
            if($result[0]['user_status']=="inactive" || $result[0]['user_status']=="active")
            {
                $this->userStatus = "block";

                //Bind Parameters using PDO Statment
                $statment->bindParam(":id", $this->id);
                $statment->bindParam(":status",$this->userStatus);

                //execute the PDOStatment
                $statment->execute();
                return 1;
            }
            
        }
    } 
    /**
     * userDelete() is used to delete the user by soft delete
     * 
     * userDelete() method consist a query from which it will be fetch all the data from the databse which matches with the userid
     * After fetching all the record rowCount() will be calculated and then it will greater then 0 then with the help of a query the user status and user delete status will be updated
     *
     * @return 1 if user deleted
     */
    public function userDelete()
    {
        //prepare the query using PDOStatment
        $stmt = $this->conn->prepare("SELECT * FROM " . $this->tableName . " WHERE id=:id");

        //Bind Parameters using PDO Statment
        $stmt->bindParam(":id", $this->id);

        //execute the PDOStatment
        $stmt->execute();

        //fetchAll PDO Associative data from the PDOStatement which executes previously
        $result=$stmt->fetchAll(PDO::FETCH_ASSOC);
        if($stmt->rowCount()>0)
        {
            //prepare the query using PDOStatment
            $statment = $this->conn->prepare("UPDATE " . $this->tableName . " SET user_delete=:delete,user_status=:status WHERE id=:id");
            if($result[0]['user_delete']=="not deleted")
            {
                $this->userDelete = "deleted";
                $this->userStatus = "block";
            
                //Bind Parameters using PDO Statment
                $statment->bindParam(":id", $this->id);
                $statment->bindParam(":delete",$this->userDelete);
                $statment->bindParam(":status",$this->userStatus);
        
                //execute the PDOStatment
                $statment->execute();
                return 1;
            } 
        }
    } 
    /**
     * logout() is used to logout the user
     * 
     * logout() consists a query from which the user status will be updated on their userid to inactive from the active 
     * 
     * @return 0
     */
    public function logout()
    {
        //prepare the query using PDOStatment
        $stmt = $this->conn->prepare("UPDATE " . $this->tableName . " SET user_status=:status WHERE id=:id");
            
        $this->userStatus = "inactive";

        //Bind Parameters using PDO Statment
        $stmt->bindParam(":id", $this->id);
        $stmt->bindParam(":status",$this->userStatus);

        //execute the PDOStatment
        $stmt->execute();
        return 0;
    }
    /**
     * getUserById() is used to get the user details with the help of userid
     * 
     * @return $result
     */
    public function getUserById()
    {
        //prepare the query using PDOStatment
        $stmt = $this->conn->prepare("SELECT * FROM " . $this->tableName . " WHERE id=:id");

        //Bind Parameters using PDO Statment
        $stmt->bindParam(":id", $this->id);

        //execute the PDOStatment
        $stmt->execute();

        //fetchAll PDO Associative data from the PDOStatement which executes previously
        $result=$stmt->fetch(PDO::FETCH_ASSOC);
        
        return $result;
    }
    /**
     * updateProfile() is used to update the user infromation
     * 
     * updateProfile() is mainly used to edit the user profile
     * It consist one query throw which the user record will be updated
     * 
     * @return 0 if the user record updates
     * 
     * @return 1 if the user records not updated
     */
    public function updateProfile()
    {
        //prepare the query using PDOStatment
        $stmt = $this->conn->prepare("UPDATE " . $this->tableName . " SET user_name=:username,user_email=:email,user_phone=:phoneno,user_address=:address,modified_date=:modified WHERE id=:id");
        //print_r($stmt);
        // to get time-stamp for 'created' field
        $this->modifiedDate = date('Y-m-d');

        //Bind Parameters using PDO Statment
        $stmt->bindParam(":id",$this->id);
        $stmt->bindParam(":username",$this->userName);
        $stmt->bindParam(":email",$this->email);
        $stmt->bindParam(":phoneno",$this->phoneNo);
        $stmt->bindParam(":address",$this->address);
        $stmt->bindParam(":modified",$this->modifiedDate);
 
        //execute the PDOStatment
        if($stmt->execute())
        {
            return 0;
        }else{
            return 1;
        }
    }
    /**
     * updatePassword() will update the password where id matches
     * 
     * First of all it will select the user's password on the specific id
     * Then it will fetch that password if the password matches with the old password enter by user
     * Then it will be update the new password on that place
     * 
     * @return 0
     */
    public function updatePassword()
    {
        //prepare the query using PDOStatment
        $stmt = $this->conn->prepare("SELECT user_password FROM " . $this->tableName . " WHERE id=:id");
        $this->id = $_SESSION['userId'];
        //Bind Parameters using PDO Statment
        $stmt->bindParam(":id",$this->id);
       
        //execute the PDOStatment
        $stmt->execute();

        //fetchAll PDO Associative data from the PDOStatement which executes previously
        $result=$stmt->fetchAll(PDO::FETCH_ASSOC);
        
        if($stmt->rowCount()>0)
        {
            if($result[0]['user_password'] == $this->password)
            {
                $statment = $this->conn->prepare("UPDATE " . $this->tableName . " SET user_password=:password WHERE id=:id");

                //Bind Parameters using PDO Statment
                $statment->bindParam(":id", $this->id);
                $statment->bindParam(":password",$this->newPassword);
                //execute the PDOStatment
                $statment->execute();
                return 0;
            }
        }
    }
   /*public function forgotPassword()
    {
        //prepare the query using PDOStatment
        $stmt = $this->conn->prepare("SELECT user_name,user_email FROM " . $this->tableName . " WHERE user_name=:username AND user_email=:email");
        
        //Bind Parameters using PDO Statment
        $stmt->bindParam(":username",$this->userName);
        $stmt->bindParam(":email",$this->email);
       
        //execute the PDOStatment
        $stmt->execute();
        
        $check = $stmt->rowCount();
        
        //if the name exists it gives an error
        if($check == 0) 
        {
            return 0;
        }
        else
        {
            //create a new random password
            $this->pass = substr(md5(uniqid(rand(),1)),3,10);
            $this->password = md5($this->pass); //encrypted version for database entry
           
            try {
                //Server settings
                $mail->SMTPDebug = 2;                // Enable verbose debug output
                $mail->isSMTP();                                            // Send using SMTP
                $mail->Host = 'smtp.gmail.com'; // Set the SMTP server to send through
               
                $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
                $mail->Username   = SEND-MAIL;                     // SMTP username
                $mail->Password   = MAIL-PASSWORD;                               // SMTP password
                $mail->SMTPSecure = 'tls';         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` also accepted
                $mail->Port       = 587;                                    // TCP port to connect to
               
                //Recipients
                $mail->setFrom('manalis.shah@thegatewaycorp.co.in', 'Manali');
               
                $mail->addAddress($this->email,$this->userName);     // Add a recipient
               
                // Content
                $mail->isHTML(true);                                  // Set email format to HTML
                $mail->Subject = 'Forgot Password';
                $content = "<b>Hi $this->userName, nn you or someone else have requested your account details. nn 
            Here is your account information please keep this as you may need this at a later stage. nn
            Your username is $this->userName nn your password is $this->pass nn 
            Your password has been reset please login and change your password .nn 
            Regards Your Website</b>"; 
                $mail->Body  = $content;
                
                $mail->send();
                echo 'Message has been sent';

                //prepare the query using PDOStatment
                $statment = $this->conn->prepare("UPDATE " . $this->tableName . " SET user_password=:password WHERE email=:email");

                //Bind Parameters using PDO Statment
                $statment->bindParam(":password",$this->password);
                $statment->bindParam(":email",$this->email);
       
                //execute the PDOStatment
                $statment->execute();
                return 1;
            } 
            catch (Exception $e) 
            {
                echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
                return 2;
            }
            
        }
    }*/
    /**
     * If user missing the old password then we hav eto use forgotPassword() method
     * 
     * First of all it will checks the email id and username are exists in database or not
     * If exist then it will genrate a session in which id wll be stored
     * 
     * @return 0 if email or username is incorrect
     * 
     * @return 1 if the user exists in the database
     */
    public function forgotPassword()
    {
        //prepare the query using PDOStatment
        $stmt = $this->conn->prepare("SELECT id,user_name,user_email FROM " . $this->tableName . " WHERE user_name=:username AND user_email=:email");
        
        //Bind Parameters using PDO Statment
        $stmt->bindParam(":username",$this->userName);
        $stmt->bindParam(":email",$this->email);
       
        //execute the PDOStatment
        $stmt->execute();
        
        $check = $stmt->rowCount();

        //fetchAll PDO Associative data from the PDOStatement which executes previously
        $result=$stmt->fetchAll(PDO::FETCH_ASSOC);
       
        //if the name exists it gives an error
        if($check == 0) 
        {
            return 0;
        }
        else
        {
            $_SESSION['Id'] = $result[0]['id'];
            return 1;
        }
    }
    /**
     * It will update the new password on the particular user details which forgot's his or her password
     * 
     * @return 1 
     */
    public function newPassword()
    {
        //prepare the query using PDOStatment
        $stmt = $this->conn->prepare("UPDATE " . $this->tableName . " SET user_password=:password WHERE id=:id");
        
        //Bind Parameters using PDO Statment
        $stmt->bindParam(":password",$this->password);
        $stmt->BindParam(":id",$_SESSION["Id"]);

        //execute the PDOStatment
        $result= $stmt->execute();
        
        return 1;
    }
}
?>