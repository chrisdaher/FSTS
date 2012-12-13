<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />

		<title>FSTS Admin Panel</title>

    <!-- JQuery -->
    <link type="text/css" href="theme/dark/jquery/css/custom-theme/jquery-ui-1.8.17.custom.css" rel="stylesheet" />	
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
    <script type="text/javascript" src="js/adminPage.js"></script>
    <script type="text/javascript" src="js/MenuBar.js"></script>
    
</head>
<body id="body">
<?php
	include('php/services/security/SecurityManager.php');
	if (!verifyLoginAdmin()){
		denied();
	}
?>
<?php include('php/view/MenuBar.php'); ?>
<div id="div_MainDiv">
    <center>
        <div id="MainSearchDiv" align="left">
			Language: <input type="text" name="txt_lang" id="txt_lang" />
			<button type="button" id="btn_submit">Add</button>
			<br/>
			<select id="ui_select" onchange="change();"></select>
			<button type="button" id="btn_remove">X</button>
        </div>
    </center>
</div>

</body>
</html>