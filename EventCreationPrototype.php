<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />

		<title>FSTS Admin Panel</title>

    <!-- JQuery -->
    <link type="text/css" href="theme/dark/jquery/css/custom-theme/jquery-ui-1.8.17.custom.css" rel="stylesheet" />	
	<link type="text/css" href="css/IE9/Timepicker.css" rel="stylesheet" />	
	<link type="text/css" href="css/IE9/EventCreationPt.css" rel="stylesheet" />	
	<script type="text/javascript" src="theme/dark/jquery/js/jquery-1.7.1.min.js"></script>
	<script type="text/javascript" src="theme/dark/jquery/js/jquery-ui-1.8.17.custom.min.js"></script>

    <?php
        require_once('php/services/BrowserDetection/Browser.php');
        $browser = new Browser();

        //if( $browser->getBrowser() == Browser::BROWSER_IE){
        //    print("<link type=\"text/css\" href=\"css/IE".ceil($browser->getVersion())."/Homepage.css\" rel=\"stylesheet\" />");
       // }
        //else{
            print("<link type=\"text/css\" href=\"css/IE9/Homepage.css\" rel=\"stylesheet\" />");
        //}
    ?>
    <!-- MAIN-->
    <script type="text/javascript" src="js/eventCreationPt.js"></script>
    <script type="text/javascript" src="js/MenuBar.js"></script>
	<script type="text/javascript" src="js/jquery-ui-timepicker-addon.js"></script>
	
	<!-- TIME PICKER -->
	<script type="text/javascript" src="bin/ui-timepickr/dist/jquery.timepickr.js"></script>
	<link type="text/css" href="bin/ui-timepickr/dist/jquery.timepickr.css" rel="stylesheet" />	
    
</head>
<body id="body">
<?php
	include('php/services/security/SecurityManager.php');
	if (!verifyLoginBool	()){
		denied();
	}
?>
<?php include('php/view/MenuBar.php'); ?>
<div id="div_MainDiv">
    <center>
        <div id="MainSearchDiv" align="left">
			Event Name: <input id="txt_eventName"/>
			<br/>
			Event Start-Date: <input id="start_date"/> 
			
			Event End-Date: <input id="end_date"/> 
			<br/>
			Event Type: <select id="typeSelect"> </select>
			<br/>
			Appointments <button id="btn_addAppointment">+</button>
			<div id="appointmentDivMain">
			
			</div>
			<br/>
			<br/>
			<button id="btnCreateEvent">Create Event!</button>
        </div>
    </center>
</div>

</body>
</html>