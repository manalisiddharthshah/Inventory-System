<?php
include_once '../system/classes/header.php';
?>
<?php
session_start();
if(empty($_SESSION["username"]))
{
  header("Location:../userController/login");
}
else
{
  if($_SESSION['usertype'] == 'client')
{
?>
<div class="wrapper">
  <div class="sidebar" data-color="purple"> 
    <div class="sidebar-wrapper">
      <div class="logo">
          <a href="<?php echo BASEURL;?>userController/dashboard" class="simple-text">
              Inventory System
          </a>
      </div>
      <ul class="nav">
        
        <li>
            <a href="<?php echo BASEURL;?>modelController/index">
                <i class="pe-7s-science"></i>
                <p>My Model</p>
            </a>
        </li>
        <li>
            <a href="<?php echo BASEURL;?>modelController/modelList">
                <i class="pe-7s-note2"></i>
                <p>Available Model</p>
            </a>
        </li>
        <li>
            <a href="<?php echo BASEURL; ?>modelController/viewInventoryClient">
                <i class="pe-7s-news-paper"></i>
                <p>View Inventory</p>
            </a>
        </li>
        <li>
            <a href="<?php echo BASEURL; ?>modelController/myInventory">
                <i class="pe-7s-bell"></i>
                <p>My Inventory</p>
            </a>
        </li>
      </ul>
    </div>
  </div>
  <div class="main-panel">
  <nav class="navbar navbar-expand-lg navbar-white bg-white">
    
      <ul class="navbar-nav ml-auto">
        <li class="nav-item">
          <a class="nav-link" href="<?php echo BASEURL;?>userController/ChangePassword">Change Password</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="<?php echo BASEURL;?>userController/editProfile"> Edit Profile</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="<?php echo BASEURL;?>userController/logout">Logout</a>
        </li>    
      </ul>
  </nav>
<br>

<?php    
}
else if($_SESSION['usertype'] == 'admin')
{
?>
<div class="wrapper">
  <div class="sidebar" data-color="purple"> 
    <div class="sidebar-wrapper">
      <div class="logo">
          <a href="<?php echo BASEURL;?>userController/dashboard" class="simple-text">
              Inventory System
          </a>
      </div>
      <ul class="nav">
        <li>
          <a href="<?php echo BASEURL;?>userController/clientDetail">
              <i class="pe-7s-user"></i>
              <p>Client Detail</p>
          </a>
        </li>
        <li>
          <a href="<?php echo BASEURL;?>manufacturerController/manufacture">
              <i class="pe-7s-graph"></i>
              <p>Add Manufacturer</p>
          </a>
        </li>
        <li>
            <a href="<?php echo BASEURL;?>modelController/index">
                <i class="pe-7s-science"></i>
                <p>My Model</p>
            </a>
        </li>
        <li>
            <a href="<?php echo BASEURL;?>modelController/modelList">
                <i class="pe-7s-note2"></i>
                <p>Available Model</p>
            </a>
        </li>
        <li>
            <a href="<?php echo BASEURL; ?>modelController/viewInventoryAdmin">
                <i class="pe-7s-news-paper"></i>
                <p>View Inventory</p>
            </a>
        </li>
        <li>
            <a href="<?php echo BASEURL; ?>modelController/inventory">
                <i class="pe-7s-bell"></i>
                <p>Inventory</p>
            </a>
        </li>
      </ul>
    </div>
  </div>

  <div class="main-panel">
  <nav class="navbar navbar-expand-lg navbar-white bg-white">
    
      <ul class="navbar-nav ml-auto">
        <li class="nav-item">
          <a class="nav-link" href="<?php echo BASEURL;?>userController/ChangePassword">Change Password</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="<?php echo BASEURL;?>userController/editProfile"> Edit Profile</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="<?php echo BASEURL;?>userController/logout">Logout</a>
        </li>    
      </ul>
    
</nav>
<br>
<?php
  }
}
?>

