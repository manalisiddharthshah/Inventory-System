<?php
include_once 'D:\Inventory-System\application\models\modelModel.php';
include_once 'D:\Inventory-System\system\classes\database.php';
use PHPUnit\Framework\TestCase;

class modelModelTests extends TestCase
{
    private $model;

    public function setUp(){
      $this->model = new modelModel();
     }
    public function tearDown(){
        $thsi->model = NULL;
     }
  
    public function testInputDataString()
    {
      $result = $this->model->testInput("manali");
      $this->assertEquals("manali", $result);
    }
}
?>