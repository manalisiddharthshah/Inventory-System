<?php
/**
 * for starting the session
 */
session_start();
/**
 * Model Class used for performing some operation based on database tables using PDOStatment SQL Queries
 */
class modelModel extends database
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
    private $tableName = "car_detail";
    /**
     * @the $tableName1 defines the table name
     * 
     * @access private
     */
    private $tableName1 = "transcation";
    /**
     * @the $tableName2 defines the table name
     * 
     * @access private
     */
    private $tableName2 = "user";
    /**
     * @the $tableName3 defines the table name
     * 
     * @access private
     */
    private $tableName3 = "manufacturer";
     /**
     * Object properties
     * 
     * @the $id  id of model
     * 
     * @the $userId  user id
     * 
     * @the $manufactureId  manufacturer id
     * 
     * @the $modelType  type of model
     * 
     * @the $modelName  name of model
     * 
     * @the $modelColor  color of model
     * 
     * @the $noOfSeats  no of seats exist in model
     * 
     * @the $kiloMetersDriven  kilometer driven by model
     * 
     * @the $refurbished refurblished
     * 
     * @the $modelYear year of model
     * 
     * @the $mileage  mileage
     * 
     * @the $fuelType type of fuel
     * 
     * @the $transmission  Transmission
     * 
     * @the $fuelTankCapacity tank capacity of model's fuel tank
     * 
     * @the $powerSteering power streeing
     * 
     * @the $airconditioner air conditioner
     * 
     * @the $airbag airbag
     * 
     * @the $price price of model
     * 
     * @the $description  description for model
     * 
     * @the $vinnumber  vin number
     * 
     * @the $registrationNumber register number
     * 
     * @the $sold sold status
     * 
     * @the $deleted deleted status
     * 
     * @the $image1 image1
     * 
     * @the $image2 image2
     * 
     * @the $created date of putting post to sell the model
     * 
     * @the $modified  date of editing the model post
     * 
     * @access public 
     */
    public $id;
    public $userId;
    public $manufactureId;
    public $modelType;
    public $modelname;
    public $modelColor;
    public $noOfSeats;
    public $kiloMetersDriven;
    public $refurbished;
    public $modelYear;
    public $mileage;
    public $fuelType;
    public $transmission;
    public $fuelTankCapacity;
    public $powerSteering;
    public $airConditioner;
    public $airbag;
    public $price;
    public $description;
    public $vinNumber;
    public $registrationNumber;
    public $sold;
    public $deleted;
    public $image1;
    public $image2;
    public $created;
    public $modified;
    /**
     * __construct() magic method for defining connection object using parent class __construct()
     */
    public function __construct()
    {
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
     * create() method will insert the data which is enter by admin to the database table
     * 
     * create() consist a query and PDOStatment which will prepare,bind and execute the query
     * if the PDOStatment executes then it return true means the data will be inserted
     * else it return false means the data will not be inserted
     * 
     * @return true means model added
     * 
     * @return false means model not added
     */
    public function create()
    {
        //prepare the query using PDOStatment
        $stmt = $this->conn->prepare("INSERT INTO " . $this->tableName . " SET user_id=:userid,manufacture_id=:manufactureid,model_type=:modeltype,model_name=:modelname,model_color=:modelcolor,no_of_seats=:noofseats,kilometers_driven=:kilometersdriven,refurbished=:refurbished,model_year=:modelyear,mileage=:mileage,fuel_type=:fueltype,transmission=:transmission,fuel_tank_capacity=:fueltankcapacity,power_steering=:powersteering,air_conditioner=:airconditioner,airbag=:airbag,price=:price,description=:description,vin_number=:vinnumber,registration_number=:registrationnumber,image1=:image1,image2=:image2,created_date=:created");
      
        //Bind Parameters using PDO Statment
        $stmt->bindParam(":userid",$this->userId);
        $stmt->bindParam(":manufactureid",$this->manufactureId);
        $stmt->bindParam(":modeltype",$this->modelType);
        $stmt->bindParam(":modelname",$this->modelName);
        $stmt->bindParam(":modelcolor",$this->modelColor); 
        $seats = (int)$this->noOfSeats;
        $stmt->bindParam(":noofseats",$seats);
        $km = (int)$this->kiloMetersDriven;
        $stmt->bindParam(":kilometersdriven",$km);
        $stmt->bindParam(":refurbished",$this->refurbished);
        $year = (int)$this->modelYear;
        $stmt->bindParam(":modelyear",$year);
        $mileage1=(int)$this->mileage;
        $stmt->bindParam(":mileage",$mileage1);
        $stmt->bindParam(":fueltype",$this->fuelType);
        $stmt->bindParam(":transmission",$this->transmission);
        $stmt->bindParam(":fueltankcapacity",$this->fuelTankCapacity);
        $stmt->bindParam(":powersteering",$this->powerSteering);
        $stmt->bindParam(":airconditioner",$this->airConditioner);
        $stmt->bindParam(":airbag",$this->airbag);
        $priceRange=(int)$this->price;
        $stmt->bindParam(":price",$priceRange);
        $stmt->bindParam(":description",$this->description);
        $stmt->bindParam(":vinnumber",$this->vinNumber);
        $stmt->bindParam(":registrationnumber",$this->registrationNumber);
        $stmt->bindParam(":image1",$this->image1);
        $stmt->bindParam(":image2",$this->image2);
        
        // to get time-stamp for 'created' field
        $this->created = date('Y-m-d');
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

        $this->deleted="not deleted";
        //Bind Parameters using PDO Statment
        $stmt->bindParam(":delete",$this->deleted);
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
        $stmt = $this->conn->prepare("SELECT * FROM " . $this->tableName . " WHERE deleted=:delete");

        $this->deleted = "not deleted";
        //Bind Parameters using PDO Statment
        $stmt->bindParam(":delete",$this->deleted);

        //execute the PDOStatment
        $stmt->execute();

        //rowCount() predefine function
        $totalRows=$stmt->rowCount();
        return $totalRows;
    }
    /**
     *  will upload image file to server for first image
     */
    public function uploadPhoto1()
    {   
        // now, if image1 is not empty, try to upload the image
        if(isset($this->image1))
        {
            $targetDirectory = "uploads1/";
            $targetFile = $targetDirectory . $this->image1;
            
            $fileType = pathinfo($targetFile, PATHINFO_EXTENSION);
            
            // error message is empty
            $uploadOk = 1;
            // make sure that file is a real image
            $check = getimagesize($_FILES["image1"]["tmp_name"]);
            
            if($check!=false)
            {
                // submitted file is an image
                $uploadOk = 1;
            }
            else
            {
                //Submitted file is not an image.
                $uploadOk = 0;
                return 0;
            }
            // make sure certain file types are allowed
            $allowedFileTypes=array("jpg", "jpeg", "png", "gif");
            if(!in_array($fileType, $allowedFileTypes))
            {
                //Only JPG, JPEG, PNG, GIF files are allowed.
                $uploadOk = 0;
                return 2;
            }
            // make sure submitted file is not too large, can't be larger than 1 MB
            if($_FILES['image1']['size'] > (1024000))
            {
                //Image must be less than 1 MB in size.
                $uploadOk = 0;
                return 3;
            }
            // make sure the 'uploads' folder exists
            // if not, create it
            if(!is_dir($targetDirectory)){
                mkdir($targetDirectory, 0777, true);
            }
            if($uploadOk == 0)
            {
                //Sorry, your file was not uploaded.
            }
            else{
                if (move_uploaded_file($_FILES["image1"]["tmp_name"], $targetFile))
                {
                    //image has been upload
                    return 1;
                } 
                else 
                {
                    //Sorry, there was an error uploading your file.
                    return 4;
                }
            }
        }
    }
    /**
     * will upload image file to server which is image2
     */
    public function uploadPhoto2()
    {   
        // now, if image2 is not empty, try to upload the image
        if(($this->image2))
        {
            $targetDirectory = "uploads2/";
            $targetFile = $targetDirectory . $this->image2;
            
            $fileType = pathinfo($targetFile, PATHINFO_EXTENSION);
            
            // error message is empty
            $uploadOk = 1;
            // make sure that file is a real image
            $check = getimagesize($_FILES["image2"]["tmp_name"]);
            if($check!=false)
            {
                // submitted file is an image
                $uploadOk = 1;
            }
            else
            {
                //Submitted file is not an image.
                $uploadOk = 0;
                return 0;
            }
            // make sure certain file types are allowed
            $allowedFileTypes=array("jpg", "jpeg", "png", "gif");
            if(!in_array($fileType, $allowedFileTypes))
            {
                //Only JPG, JPEG, PNG, GIF files are allowed.
                $uploadOk = 0;
                return 2;
            }
            // make sure submitted file is not too large, can't be larger than 1 MB
            if($_FILES['image2']['size'] > (1024000))
            {
                //Image must be less than 1 MB in size.
                $uploadOk = 0;
                return 3;
            }
            //make sure the 'uploads' folder exists
            //if not, create it
            if(!is_dir($targetDirectory)){
                mkdir($targetdDirectory, 0777, true);
            }
            if($uploadOk == 0)
            {
                //Sorry, your file was not uploaded.
            }
            else{
                if (move_uploaded_file($_FILES["image2"]["tmp_name"], $targetFile))
                {
                    //image has been upload
                    return 1;
                } 
                else 
                {
                    //Sorry, there was an error uploading your file.
                    return 4;
                }
            }

        }
    }
     /**
     * modelDelete() is used to delete the model by soft delete
     * 
     * modelDelete() method consist a query from which it will be fetch all the data from the databse which matches with the modelid
     * After fetching all the record rowCount() will be calculated and then it will greater then 0 then with the help of a query the model delete status will be updated
     * 
     * @return 1 if model deleted
     */
    public function modelDelete()
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
            if($result[0]['deleted']=="not deleted")
            {
                //prepare the query using PDOStatment
                $stmt = $this->conn->prepare("UPDATE " . $this->tableName . " SET deleted=:delete WHERE id=:id");
                $this->deleted = "deleted";
                
                //Bind Parameters using PDO Statment
                $stmt->bindParam(":id", $this->id);
                $stmt->bindParam(":delete",$this->deleted);

                //execute the PDOStatment
                $stmt->execute();
                return 1;
            } 
        }
    }
    /**
     * readOne() is used to get the model details with the help of modelid
     * 
     * @return $row
     */   
    function readOne($carid)
    {
        //prepare the query using PDOStatment with right join
        $stmt = $this->conn->prepare("SELECT * FROM " . $this->tableName . " RIGHT JOIN manufacturer  
        ON " . $this->tableName . ".manufacture_id=manufacturer.id WHERE " . $this->tableName . ".id=:id");

        //Bind Parameters using PDO Statment
        $stmt->bindParam(":id", $carid);

        //execute the PDOStatment
        $stmt->execute();
     
        //fetchAll PDO Associative data from the PDOStatement which executes previously
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row;
    }
    /**
     * modelPurchase() is used to purchase the model by any user
     * 
     * modelPurchase() is consist of 3 queries from which the one will be used to select the data of user which want to sell the model with the help of their id
     * then check if the sold is status is not updated then it updates using 2nd query
     * After that the user which purchase the product and the product which is to be sell their id's are insert into the database table with purchase date using 3rd query
     * 
     * @return 1
     */
    public function modelPurchase()
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
            if($result[0]['sold']=="not sold")
            {
                //prepare the query using PDOStatment
                $stmt = $this->conn->prepare("UPDATE " . $this->tableName . " SET sold=:sold,deleted=:delete WHERE id=:id");
                $this->sold = "sold";
                $this->deleted = "deleted";
                
                //Bind Parameters using PDO Statment
                $stmt->bindParam(":id", $this->id);
                $stmt->bindParam(":sold",$this->sold);
                $stmt->bindParam(":delete",$this->deleted);

                //execute the PDOStatment
                $stmt->execute();
            }
            //prepare the query using PDOStatment
            $stmt = $this->conn->prepare("INSERT INTO " . $this->tableName1 . " SET user_id=:id,model_id=:modelid,transcation_date=:created");
           
            $this->userId=$_SESSION["userId"];
            $this->created = date('Y-m-d');
            
            //Bind Parameters using PDO Statment
            $stmt->bindParam(":id",$this->userId);
            $stmt->bindParam(":modelid",$this->id);
            $stmt->bindParam(":created", $this->created);

            //execute the PDOStatment
            $stmt->execute();
            
            return 1; 
        }
    }
    /**
     * modelSold() is used to provide sold model of a particular user
     * 
     * The model which is to be sell by a particular user and which to be purchase by another user their data to be shown on the client side by this function
     * 
     * @return data
     */
    public function modelSold()
    {
       /**
        * @the data array()
        */
        $data = array();
        
        //prepare the query using PDOStatment
        $stmt = $this->conn->prepare("SELECT * FROM " . $this->tableName . " WHERE sold=:sold AND user_id=:id");

        $this->sold="sold";
        $this->userId=$_SESSION["userId"];
        
        //Bind Parameters using PDO Statment
        $stmt->bindParam(":sold",$this->sold);
        $stmt->bindParam(":id",$this->userId);
        
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
     * totalRowCount() method is used to count the total no of rows in the datatable which are sold 
     * 
     * @the totalRows variable
     * 
     * @return $totalRows
     */
    public function totalCount()
    {
        //prepare the query using PDOStatment
        $stmt = $this->conn->prepare("SELECT * FROM " . $this->tableName . " WHERE sold=:sold AND user_id=:id");

        $this->userId=$_SESSION["userId"];
        $this->sold="sold";
        
        //Bind Parameters using PDO Statment
        $stmt->bindParam(":sold",$this->sold);
        $stmt->bindParam(":id",$this->userId);
        
        //execute the PDOStatment
        $stmt->execute();
 
        //rowCount() predefine function
        $totalRows=$stmt->rowCount();
        return $totalRows;  
    }
    /**
     * updateModel() is used to update the model which is posted to sell by any particular user
     * 
     * it is only used by the user which post their model for sell
     * It consist one query throw which the user record will be updated
     * 
     * @return true if record upadtes
     * 
     * @return false  if record not update
     */
    public function updateModel()
    {
        //prepare the query using PDOStatment
        $stmt = $this->conn->prepare("UPDATE " . $this->tableName . " SET manufacture_id=:manufactureid,model_type=:modeltype,model_name=:modelname,model_color=:modelcolor,no_of_seats=:noofseats,kilometers_driven=:kilometersdriven,refurbished=:refurbished,model_year=:modelyear,mileage=:mileage,fuel_type=:fueltype,transmission=:transmission,fuel_tank_capacity=:fueltankcapacity,power_steering=:powersteering,air_conditioner=:airconditioner,airbag=:airbag,price=:price,description=:description,vin_number=:vinnumber,registration_number=:registrationnumber,image1=:image1,image2=:image2,modified_date=:modified WHERE id=:id");
      
        //Bind Parameters using PDO Statment
        $stmt->bindParam(":id",$this->id);
        $stmt->bindParam(":manufactureid",$this->manufactureId);
        $stmt->bindParam(":modeltype",$this->modelType);
        $stmt->bindParam(":modelname",$this->modelName);
        $stmt->bindParam(":modelcolor",$this->modelColor); 
        $seats = (int)$this->noOfSeats;
        $stmt->bindParam(":noofseats",$seats);
        $km = (int)$this->kiloMetersDriven;
        $stmt->bindParam(":kilometersdriven",$km);
        $stmt->bindParam(":refurbished",$this->refurbished);
        $year = (int)$this->modelYear;
        $stmt->bindParam(":modelyear",$year);
        $mileage1=(int)$this->mileage;
        $stmt->bindParam(":mileage",$mileage1);
        $stmt->bindParam(":fueltype",$this->fuelType);
        $stmt->bindParam(":transmission",$this->transmission);
        $stmt->bindParam(":fueltankcapacity",$this->fuelTankCapacity);
        $stmt->bindParam(":powersteering",$this->powerSteering);
        $stmt->bindParam(":airconditioner",$this->airConditioner);
        $stmt->bindParam(":airbag",$this->airbag);
        $priceRange=(int)$this->price;
        $stmt->bindParam(":price",$priceRange);
        $stmt->bindParam(":description",$this->description);
        $stmt->bindParam(":vinnumber",$this->vinNumber);
        $stmt->bindParam(":registrationnumber",$this->registrationNumber);
        $stmt->bindParam(":image1",$this->image1);
        $stmt->bindParam(":image2",$this->image2);
        
        // to get time-stamp for 'created' field
        $this->modified = date('Y-m-d');
        $stmt->bindParam(":modified", $this->modified);
        //execute the PDOStatment
        if($stmt->execute())
        {
            return true;
        }else{
            return false;
        }
    } 
    /**
     * transcation() is used to display the model details which is to be sell and puchased by any particular users
     * 
     * @return $data array()
     */
    public function transcation()
    {
        /**
         * @the data array
         */
        $data = array();
        
        //prepare the query using PDOStatment
        $stmt = $this->conn->prepare("SELECT DISTINCT " . $this->tableName2 . 
        ".user_name As Sold, " . $this->tableName . ".created_date, " . $this->tableName . ".model_name, " . 
    $this->tableName . ".image1, " . $this->tableName3 . ".manufacturer_name, " . $this->tableName1 .
 ".transcation_date , (SELECT user_name FROM " . $this->tableName2 ." WHERE id=" . $this->tableName1 . ".user_id ) 
 As Purchase FROM " . $this->tableName . " JOIN " . $this->tableName2 . 
" ON " . $this->tableName2 . ".id=" . $this->tableName . ".user_id JOIN " . $this->tableName3 . " ON "
. $this->tableName3 . ".id=" . $this->tableName . ".manufacture_id JOIN " . $this->tableName1 .
" ON " . $this->tableName1 . ".model_id=" . $this->tableName . ".id");

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
    public function transcationCount()
    {
        //prepare the query using PDOStatment
         $stmt = $this->conn->prepare("SELECT DISTINCT " . $this->tableName2 . 
        ".user_name As Sold, " . $this->tableName . ".created_date, " . $this->tableName . ".model_name, " . 
    $this->tableName . ".image1, " . $this->tableName3 . ".manufacturer_name, " . $this->tableName1 .
 ".transcation_date, (SELECT user_name FROM " . $this->tableName2 ." WHERE id=" . $this->tableName1 . ".user_id ) 
 As Purchase FROM " . $this->tableName . " JOIN " . $this->tableName2 . 
" ON " . $this->tableName2 . ".id=" . $this->tableName . ".user_id JOIN " . $this->tableName3 . " ON "
. $this->tableName3 . ".id=" . $this->tableName . ".manufacture_id JOIN " . $this->tableName1 .
" ON " . $this->tableName1 . ".model_id=" . $this->tableName . ".id");
        
        //execute the PDOStatment
        $stmt->execute();

        //rowCount() predefine function
        $totalRows=$stmt->rowCount();
        return $totalRows;
    }
    /**
     * Inventory() will select the model details which is to be sold out
     * 
     * @return $data array()
     */
    public function inventory()
    {
        //prepare the query using PDOStatment
        $stmt = $this->conn->prepare("SELECT " . $this->tableName3 . ".manufacturer_name,". $this->tableName . 
        ".model_name,COUNT(case when " . $this->tableName . ".sold=:sold 
    THEN " . $this->tableName . ".manufacture_id else null end) as sold_cars, count(" . 
$this->tableName . ".manufacture_id) as total_cars," . $this->tableName3 . ".id  FROM " . $this->tableName . " INNER JOIN "
    . $this->tableName3 . " ON " . $this->tableName3 . ".id=" . $this->tableName . ".manufacture_id
     GROUP BY " . $this->tableName . ".manufacture_id");

        $this->sold="sold";
        
        //Bind Parameters using PDO Statment
        $stmt->bindParam(":sold",$this->sold);

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
     * inventoryCount() method is used to count the total no of rows in the datatable which are solded
     * 
     * @the totalrows variable
     * 
     * @return $totalrows
     */
    public function inventoryCount()
    {
        //prepare the query using PDOStatment
        $stmt = $this->conn->prepare("SELECT " . $this->tableName3 . ".manufacturer_name,". $this->tableName . 
        ".model_name,COUNT(case when " . $this->tableName . ".sold=:sold 
    THEN " . $this->tableName . ".manufacture_id else null end) as sold_cars, count(" . 
$this->tableName . ".manufacture_id) as total_cars," . $this->tableName3 . ".id  FROM " . $this->tableName . " INNER JOIN "
    . $this->tableName3 . " ON " . $this->tableName3 . ".id=" . $this->tableName . ".manufacture_id
     GROUP BY " . $this->tableName . ".manufacture_id");

        $this->sold="sold";
        
        //Bind Parameters using PDO Statment
        $stmt->bindParam(":sold",$this->sold);

       //execute the PDOStatment
       $stmt->execute();

       //rowCount() predefine function
       $totalRows=$stmt->rowCount();
       return $totalRows;
    }
    /**
     *readManufacture() reads the manufacturer details based on the manuafacture id
     *
     * @return $data array()
     */
    public function readManufacturer($id)
    {
        //prepare the query using PDOStatment with right join
        $stmt = $this->conn->prepare("SELECT " . $this->tableName2 . ".user_name," . $this->tableName .
    ".model_name," . $this->tableName . ".image1," . $this->tableName . ".model_color," 
    . $this->tableName . ".sold," . $this->tableName . ".created_date FROM " . $this->tableName .
" INNER JOIN " . $this->tableName2 . " ON " . $this->tableName . ".user_id=" . $this->tableName2 .
".id WHERE " . $this->tableName . ".manufacture_id=:id");

        //Bind Parameters using PDO Statment
        $stmt->bindParam(":id", $id);

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
     * Read Model details which to be purchased by particular user
     * 
     * @return $data array()
     */
    public function readMyModel()
    {
        $stmt = $this->conn->prepare("SELECT " . $this->tableName . ".id," . $this->tableName . ".model_type,"
        . $this->tableName . ".model_name," . $this->tableName . ".model_color," . $this->tableName . ".model_year,"
        . $this->tableName . ".registration_number," . $this->tableName . ".image1," . $this->tableName1 .
        ".transcation_date," . $this->tableName1 . ".user_id FROM " . $this->tableName . " JOIN " . 
        $this->tableName1 . " ON " . $this->tableName . ".id=" . $this->tableName1 . ".model_id WHERE "
     . $this->tableName1 . ".user_id=:id"); 
        
        $this->id=$_SESSION['userId'];

        //Bind Parameters using PDO Statment
        $stmt->bindParam(":id", $this->id);

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
     * totalMyModelCount() will count the total no of records of model details which are to be purchased by a purticular user
     * 
     * @the variable totalRows
     * 
     * @return $totalRows
     */
    public function totalMyModelCount()
    {
        $stmt = $this->conn->prepare("SELECT " . $this->tableName . ".id," . $this->tableName . ".model_type,"
        . $this->tableName . ".model_name," . $this->tableName . ".model_color," . $this->tableName . ".model_year,"
        . $this->tableName . ".registration_number," . $this->tableName . ".image1," . $this->tableName1 .
        ".transcation_date," . $this->tableName1 . ".user_id FROM " . $this->tableName . " JOIN " . 
        $this->tableName1 . " ON " . $this->tableName . ".id=" . $this->tableName1 . ".model_id WHERE "
     . $this->tableName1 . ".user_id=:id");
        
        $this->id=$_SESSION['userId'];

        //Bind Parameters using PDO Statment
        $stmt->bindParam(":id", $this->id);

        //execute the PDOStatment
        $stmt->execute();

        //rowCount() predefine function
        $totalRows=$stmt->rowCount();
        return $totalRows;
    }
}
?>