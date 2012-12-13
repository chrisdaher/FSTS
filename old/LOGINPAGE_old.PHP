<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html id="html" xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

<head>
    <!-- JQuery -->
    <?php
	$access="";
    if(!empty($_GET['Access'])){
	$access = $_GET['Access'];
	}
    if($access=="denied"){
        include('security/accessDenied.php');
    }elseif($access=="tryAgain"){
		
	}else{
		require_once('Security/LoginRedirect.php');
		checkRedirect();
	}
    ?>
    <link type="text/css" href="jquery/css/custom-theme/jquery-ui-1.8.17.custom.css" rel="stylesheet" />	
	<script type="text/javascript" src="jquery/js/jquery-1.7.1.min.js"></script>
	<script type="text/javascript" src="jquery/js/jquery-ui-1.8.17.custom.min.js"></script>

	<meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
	<meta name="author" content="Chris" />
    <script type="text/javascript" src="security/AccessDenied.js"></script>
   	<script type="text/javascript" src="js/Get.js"></script>
    
    <link type="text/css" href="css/Login.css" rel="stylesheet" />	
   	<script type="text/javascript" src="js/Login.js"></script>
	<title>Login</title>
</head>

<body onload="checkAccess();setInitialFocus();">
<div id="div_Container">
<div id="div_MissionHallImage">
    <img src="Images/MissionHall.jpg" alt="Welcome to the Mission Hall"/>
</div>
<div  onkeypress="checkSubmit(event)" id="div_loginForm">
<form id="frm_login" action="doLogin.php" method="post">
    <center>
    <div id="div_Username"><label>Username: </label><input  type="text" id="input_username" name="input_username" /></div>
    <div id="div_Password"><label>Password: </label><input type="password" id="input_password" name="input_password" /></div>
    <input type="submit" style="display: none;"/>
    </center>
</form>
</div>
</div>

</body>
</html>

