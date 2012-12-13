<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />

		<title>File View</title>

    <!-- CSS LOADING BASED ON IE version -->
    <?php
        require_once('php/services/BrowserDetection/Browser.php');
        $browser = new Browser();

        //if( $browser->getBrowser() == Browser::BROWSER_IE){
        //    print("<link type=\"text/css\" href=\"css/IE".ceil($browser->getVersion())."/AssigningAppointments.css\" rel=\"stylesheet\" />");
        //}
        //else{
            print("<link type=\"text/css\" href=\"css/IE9/AssigningAppointments.css\" rel=\"stylesheet\" />");
        //}
    ?>

    <!-- JQuery -->
    <link type="text/css" href="theme/dark/jquery/css/custom-theme/jquery-ui-1.8.17.custom.css" rel="stylesheet" />	
	<script type="text/javascript" src="theme/dark/jquery/js/jquery-1.7.1.min.js"></script>
    <script type="text/javascript" src="bin/tooltip/jquery.cluetips.js"></script>
	<script type="text/javascript" src="theme/dark/jquery/js/jquery-ui-1.8.17.custom.min.js"></script>
    
    <script type="text/javascript" src="js/jquery.combobox.js"></script>
    <script type="text/javascript" src="js/jquery.simulate.js"></script>
    <script type="text/javascript" src="js/jquery.event.drag-2.0.min.js"></script>
    <script type="text/javascript" src="js/jquery.event.drop-2.0.min.js"></script>
    
    <!-- MAIN JAVASCRIPT-->
    

    <script type="text/javascript" src="js/AssigningAppointments.js"></script>
    <script type="text/javascript" src="js/DragDropExtensions.js"></script>
    <script type="text/javascript" src="js/SearchGroup.js"></script>
    <script type="text/javascript" src="js/MenuBar.js"></script>
    <script type="text/javascript" src="js/OptionBarAssigningAppointments.js"></script>
    <script type="text/javascript" src="js/Get.js"></script>
	<script type="text/javascript" src="js/ajax.js"></script>
	<script type="text/javascript" src="js/SearchBar.js"></script>
    
	
    <script>
        var theTop=100;    
    </script>
</head>

<body  style="background-color: rgb(239, 239, 239);" onload="setInitialFocus(); UpdateAppointmentInfo()">

<?php
	include('php/services/security/SecurityManager.php');
	verifyLogin();
	include('php/services/security/validateEventId.php');
	validateId($_GET['EventID']);
	//session_start();
?>


    <!-- Menu Bar-->
<?php include('php/view/MenuBar.php'); ?>
<?php
    $_GET['pageType']="AssigningAppointment"; 
    $editMode=3;
    $famId=$_GET['EventID'];
    include('php/view/OptionBar.php'); 
    ?>
<div id="div_MainDiv">
    <div id="div_Column1">
        <?php include('php/view/AppointmentAssignment/CalenderDiv.php'); ?>
    </div>
    <div id="div_Column2">
        <?php include('php/view/AppointmentAssignment/EventDiv.php'); ?>
        <!--<?php include('php/view/AppointmentAssignment/SeparationDiv.php'); ?>-->
        <?php include('php/view/AppointmentAssignment/CalenderDiv/DisplayAppointmentInfo.php'); ?>
        
    </div>
    
            
</div>

</body>
</html>