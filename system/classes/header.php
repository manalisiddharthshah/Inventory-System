<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8" />
	<link rel="icon" type="image/png" href="../assets/img/favicon.ico">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!--title of page-->
    <title><?php echo $page_title; ?></title>
    <!-- Latest compiled and minified CSS -->
    <?php linkCSS("assets/css/bootstrap.min.css"); ?>
    <!--animation css library-->
    <?php linkCSS("assets/css/animate.min.css"); ?>
    <!--  Light Bootstrap Table core CSS    -->
    <?php linkCSS("assets/css/light-bootstrap-dashboard.css?v=1.4.0"); ?>
    <!--  CSS for Demo Purpose, don't include it in your project     -->
    <?php linkCSS("assets/css/demo.css"); ?>
    <!--fonts icon library-->
    <?php linkCSS("assets/css/font-awesome.min.css"); ?>
    <!--fonts css library-->
    <?php linkCSS("assets/css/font.css"); ?>
    <!--pe-icon-7 css library-->
    <?php linkCSS("assets/css/pe-icon-7-stroke.css"); ?>
    <!--ajax dataTables css-->
    <?php linkCSS("assets/css/datatables.min.css"); ?>
    <!--Sweetalert css-->
    <?php linkCSS("assets/css/sweetalert.css"); ?>
	<style>
    .modal-backdrop 
    {
        /* bug fix - no overlay */    
        display: none;    
    }
	</style>
</head>