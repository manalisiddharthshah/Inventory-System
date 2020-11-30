<?php
/**
 * Database class is used for connecting to the server database
 * 
 * Database class is used to connect the Mysql server database.
 * Host name of database is localhost
 * Name of the database is root
 * 
 */
class database 
{
   /**
     * defines the hostname by using public access modifier
     * 
     * @param string $host hostname 
     */
   public $host  = HOST;
    /**
     * defines the username by using public access modifier
     * 
     * @param string $user database user
     */
   public $user  = USER;
    /**
     * defines the database name by using public access modifier
     * 
     * @param string $database database name
     */
   public $database = DATABASE;
   /**
     * defines the password by using public access modifier
     * 
     * @param string password databse user's password
     */
   public $password = PASSWORD;
   /**
     * A public access modifier which is used to define the connection to the database instance by using PDO class
     * 
     * @param string $conn connection object
     */
   public $con;
    /**
     * __construct() method with PDO class object for connecting to the mysql database
     *
     * @return $this->conn
     */
   public function __construct()
   {
      try
      {
        return $this->con = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->database,$this->user, $this->password);
      } 
      catch(PDOException $e)
      {
         echo "Database connection Error: ". $e->getMessage();
      }
   }   
}
?>