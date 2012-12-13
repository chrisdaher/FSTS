<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />

		<title>FSTS Homepage</title>

    <!-- JQuery -->
    <link type="text/css" href="jquery/css/custom-theme/jquery-ui-1.8.17.custom.css" rel="stylesheet" />	
	<script type="text/javascript" src="jquery/js/jquery-1.7.1.min.js"></script>
	<script type="text/javascript" src="jquery/js/jquery-ui-1.8.17.custom.min.js"></script>

    
    <!-- MAIN-->
    <LINK REL=StyleSheet HREF="css/Homepage.css" TYPE="text/css">
    <script type="text/javascript" src="js/Homepage.js"></script>
    <script type="text/javascript" src="js/WindowSizeHandler.js"></script>
    <script type="text/javascript" src="js/MainDivResize.js"></script>
    <script type="text/javascript" src="js/MenuBar.js"></script>
    <script>
        var theTop=40;
    </script>
    
</head>
<body id="body" onload="resizeMainDiv(0);setInitialFocus();">
<?php
	include('security/SecurityManager.php');
	verifyLogin();
?>
<?php include('php/MenuBar.php'); ?>
<div id="div_MainDiv">
    <center>
        <div id="MainSearchDiv" align="center">
            <?php include('php/SearchByGroup.php'); ?>
            <?php include('php/SearchGroup.php'); ?>
        </div>
    </center>
</div>

</body>
</html>