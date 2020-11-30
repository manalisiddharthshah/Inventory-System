<?php
/**
 * For autoloading class files
 */
  spl_autoload_register(function($className){

    include "classes/$className.php";

  });
  /**
   * rout object
   */
$rout = new rout;
?>