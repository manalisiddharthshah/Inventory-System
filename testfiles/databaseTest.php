<?php
include_once 'D:\Inventory-System\system\classes\database.php';
use PHPUnit\Framework\TestCase;

class databseTests extends TestCase
{
    public function setUp(){ }
    public function tearDown(){ }
  
    public function testConnectionIsValid()
    {
      $connObj = new database();
      $this->assertTrue($connObj!== false);
    }
}
?>