<?php
/**
 * for starting the session
 */
session_start();
/**
 * Manufacturer Class used for performing some operation based on database tables using PDOStatment SQL Queries
 */
class manufacturerModel extends database
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
    private $tableName = "manufacturer";
    /**
     * Object properties
     * 
     * @the $id  id of manufacturer
     * 
     * @the $manufacturerName  manufacturer name
     * 
     * @the $delete  delete the manufacturer
     * 
     * @the $status  status of maufacturer
     * 
     * @the $created  uses for creation date entering in the database
     * 
     * @access public 
     */
    public $id;
    public $manufacturerName;
    public $delete;
    public $status;
    public $created;
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
     * checkDuplicate() method check the manufacturer already exists in the database table of not 
     * 
     * checkDuplicate() consists a query which select the rows of table which has manufacturer already exists
     * query will be prepare,bind and execute then the result will fetch in the variable $result using fetchAll()
     * if the PDOStatment rowCount will greater then 0 then return 0 means maufacturer already exists
     * else return 1 means maufacturer is not exists it is unique entry
     * 
     * @return 0 means maufacturer already exists
     * 
     * @return 1 means maufacturer already not exists
    */ 
    public function checkDuplicate()
    {
        //prepare the query using PDOStatment
        $stmt = $this->conn->prepare("SELECT * FROM " . $this->tableName . " WHERE manufacturer_name=:manufacturername");
        
        //Bind Parameters using PDO Statment
        $stmt->bindParam(":manufacturername", $this->manufacturerName);
        
        //execute the PDOStatment
        $stmt -> execute();

        //fetchAll PDO Associative data from the PDOStatement which executes previously
        $result=$stmt->fetchAll(PDO::FETCH_ASSOC);

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
     * create() method will insert the data which is enter by admin to the database table
     * 
     * create() consist a query and PDOStatment which will prepare,bind and execute the query
     * if the PDOStatment executes then it return true means the data will be inserted
     * else it return false means the data will not be inserted
     * 
     * @return true means manufacturer added
     * 
     * @return false means manufacturer not added
     */
    public function create()
    {
        //prepare the query using PDOStatment
        $stmt = $this->conn->prepare("INSERT INTO " . $this->tableName . " SET manufacturer_name=:manufacturername,created_date=:created");
 
        // to get time-stamp for 'created' field
        $this->created = date('Y-m-d');

        //Bind Parameters using PDO Statment
        $stmt->bindParam(":manufacturername", $this->manufacturerName);
        $stmt->bindParam(":created", $this->created);
 
        //execute the PDOStatment
        if($stmt->execute())
        {
            return true;
        }else{
            return false;
        }
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
        $stmt = $this->conn->prepare("SELECT * FROM " . $this->tableName . " WHERE deleted=:delete");

        $this->delete = "not deleted";
        //Bind Parameters using PDO Statment
        $stmt->bindParam(":delete", $this->delete);

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
     * @the totalRows variable
     * 
     * @return $totalRows
     */
    public function totalRowCount()
    {
        //prepare the query using PDOStatment
        $stmt = $this->conn->prepare("SELECT * FROM " . $this->tableName . " WHERE deleted=:delete");

        $this->delete = "not deleted";
        //Bind Parameters using PDO Statment
        $stmt->bindParam(":delete", $this->delete);

        //execute the PDOStatment
        $stmt->execute();

        //rowCount() predefine function
        $totalRows=$stmt->rowCount();
        return $totalRows;
    }
    /**
     * getManufacturerById() is used to get the Manufacturer details with the help of manufacturerid
     * 
     * @return $result
     */   
    public function getManufacturerById()
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
     * update() is used to update the maufacturer infromation
     * 
     * update() is only used by admin
     * It consist one query throw which the user record will be updated
     * 
     * @return 0 if the maufacturer record updates
     * 
     * @return 1 if the user manufacturer not updated
     */
    public function update()
    {
        //prepare the query using PDOStatment
        $stmt = $this->conn->prepare("UPDATE " . $this->tableName . " SET manufacturer_name=:manufacturername WHERE id=:id");

        //Bind Parameters using PDO Statment
        $stmt->bindParam(":id", $this->id);
        $stmt->bindParam(":manufacturername", $this->manufacturerName);
 
        //execute the PDOStatment
        if($stmt->execute())
        {
            return true;
        }else{
            return false;
        }
    }
    /**
     * manufactureDelete() is used to delete the manufacturer by soft delete
     * 
     * manufactureDelete() method consist a query from which it will be fetch all the data from the databse which matches with the manufactureid
     * After fetching all the record rowCount() will be calculated and then it will greater then 0 then with the help of a query the manufacturer status and user manufacture delete status will be updated
     * 
     * @return 1 if manufacturer deleted
     */
    public function manufactureDelete()
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
            $statment = $this->conn->prepare("UPDATE " . $this->tableName . " SET deleted=:delete,manufacturer_status=:status WHERE id=:id");
            if($result[0]['deleted']=="not deleted")
            {
                $this->delete = "deleted";
                $this->status = "block";
                
                //Bind Parameters using PDO Statment
                $statment->bindParam(":id", $this->id);
                $statment->bindParam(":delete",$this->delete);
                $statment->bindParam(":status",$this->status);

                //execute the PDOStatment
                $statment->execute();
                return 1;
            }
            
        }
    }
    /**
     * status() method is used change the status of the manufacturer
     * 
     * status() method consists a query from which the data which is matches with the id are to selected from the database using prepare,bind and execute PDOStatment
     * after execute the query the data will be fetch and find the rowCount is greater than zero or not using rowCount() method
     * then we have to update the status if the status is active or inactive then it will converted to block and if it is block then converted it to inactive
     * 
     * @return 0 if status updated to inactive
     * 
     * @return 1 if status updated to block
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
            $statment = $this->conn->prepare("UPDATE " . $this->tableName . " SET manufacturer_status=:status WHERE id=:id");
            if($result[0]['manufacturer_status']=="block")
            {
                $this->status = "unblock";

                //Bind Parameters using PDO Statment
                $statment->bindParam(":id", $this->id);
                $statment->bindParam(":status",$this->status);

                //execute the PDOStatment
                $statment->execute();
                return 0;
            }
            if($result[0]['manufacturer_status']=="unblock")
            {
                $this->status = "block";

                //Bind Parameters using PDO Statment
                $statment->bindParam(":id", $this->id);
                $statment->bindParam(":status",$this->status);

                //execute the PDOStatment
                $statment->execute();
                return 1;
            }
            
        }
    }
    /**
     * readAll() method is used select all the records from the databse table
     * 
     * @return $data
     */  
    public function readAll()
    {
        /**
         * @the data array
         */
        $data = array();

        //prepare the query using PDOStatment
        $stmt = $this->conn->prepare("SELECT * FROM " . $this->tableName . " WHERE deleted=:delete AND manufacturer_status=:status");

        $this->status = "unblock";
        $this->delete = "not deleted";
        //Bind Parameters using PDO Statment
        $stmt->bindParam(":delete", $this->delete);
        $stmt->bindParam(":status",$this->status);

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
     * totalRowCountAll() method is used to count the total no of rows in the datatable which are not deleted and not block
     * 
     * @the totalRows variable
     * 
     * @return $totalRows
     */
    public function totalRowCountAll()
    {
        //prepare the query using PDOStatment
        $stmt = $this->conn->prepare("SELECT * FROM " . $this->tableName . " WHERE deleted=:delete AND manufacturer_status=:status");

        $this->status = "unblock";
        $this->delete = "not deleted";
        //Bind Parameters using PDO Statment
        $stmt->bindParam(":delete", $this->delete);
        $stmt->bindParam(":status",$this->status);

        //execute the PDOStatment
        $stmt->execute();

        //rowCount() predefine function
        $totalRows=$stmt->rowCount();
        return $totalRows;
    }
}
?>