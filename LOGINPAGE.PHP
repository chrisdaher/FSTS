<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>

    <?php
	$access="";
    if(!empty($_GET['Access'])){
	$access = $_GET['Access'];
	}
	
	require_once('php/services/Security/LoginRedirect.php');
		checkRedirect();
	
    if($access=="denied"){
        include('php/services/security/accessDenied.php');
    }elseif($access=="tryAgain"){
		
	}else{
		
	}
    ?>
    <?php
        require_once('php/services/BrowserDetection/Browser.php');
        $browser = new Browser();

        //if( $browser->getBrowser() == Browser::BROWSER_IE){
        //    print("<link type=\"text/css\" href=\"css/IE".ceil($browser->getVersion())."/admin.css\" rel=\"stylesheet\" />");
       // }
        //else{
            print("<link type=\"text/css\" href=\"css/IE9/Login.css\" rel=\"stylesheet\" />");
        //}
    ?>
<script type="text/javascript" src="js/Login.js"></script>
<script type="text/javascript" src="js/Get.js"></script>
<meta content="text/html; charset=utf-8" http-equiv="Content-Type" />
<title>Login</title>
</head>

<body onload="checkLogin();">

<div id="div_MissionHallImage">
			<img class="top" src="Images/MissionHall.png" alt="Welcome to the Mission Hall"/>
</div>

<div id="login">
		
	<div id="content">
		<form method="post" action="php/services/login/doLogin.php">
				<div class="checkbox">
					<label class="login-error" name="label_error" id="label_error"></label>
					<label class="login-hi" name="label_hi" id="label_hi"></label>
				</div>
				<br/>
				<br/>
			<label class="login-info">Username</label>
			<input class="input" type="text" name="input_username" id="input_username"/>
			<label class="login-info">Password</label>
			<input class="input" type="password" id="input_password" name="input_password" />
			
			
			<div id="remember-forgot">
				
				<br/>
				<div id="login-buttton">
					<input name="Submit" src="images/login-button.jpg" type="image" value="" /></div>
			</div>
		</form>
	</div>
</div>

</body>

</html>
