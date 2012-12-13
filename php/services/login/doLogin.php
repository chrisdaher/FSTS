<?php

include('/../mysql/phpMySql.php');

$tableName = "app_user";
$colUsername = "username";
$colPassword = "password";

$username= $_POST["input_username"];
$password= md5crypt($_POST["input_password"]);


$res = selectWhereQuery($tableName, $colUsername, $username);
$row = mysql_fetch_array($res);
if ($row == NULL){
	echo "Invalid username/password";
	header( 'Location: ../../../LoginPage.php?Access=tryAgain ') ;
}
$thePass = $row[$colPassword];

/*
echo "<br/>";
if (strcmp($thePass, $password) == 0){ echo "ALL GOOD"; }
echo $thePass . "<br/>";
echo $password;
echo "<br/>";
die("DEAD");
*/
if (strcmp($thePass, $password) == 0){
	echo "LOGGED IN!";
	$str = $username.$password;
	$md5Val = md5crypt($str);
	setcookie("LoginVal", $md5Val, time()+99999, "/");
	setcookie("LoginName", $username, time()+99999, "/");
	setcookie("LoginID", $row['id'], time()+99999, "/");
	
	setDbStayLoggedIn($username, $md5Val);
	
	header( 'Location: ../../../Homepage.php ') ;
}
else{
	echo "Invalid username/password </br>";
	header( 'Location: ../../../LoginPage.php?Access=tryAgain ') ;
}

function setDbStayLoggedIn($un, $cookiev){
	$tableName = "stay_loggedin";
	$colUsername = "username";
	$colCookieVal = "cookieVal";
	$res = selectWhereQuery($tableName, $colUsername, $un);
	$row = mysql_fetch_array($res);
	if ($row == NULL){
		echo "<br/>";
		$query = "INSERT INTO `$tableName` (`$colUsername`, `$colCookieVal`) VALUES ('$un', '$cookiev')";
		$res = sqlExecQuery($query);
		
	}
}


function md5crypt($password){
	return md5($password);
/*
    // create a salt that ensures crypt creates an md5 hash
    $base64_alphabet='ABCDEFGHIJKLMNOPQRSTUVWXYZ'
                    .'abcdefghijklmnopqrstuvwxyz0123456789+/';
    $salt='$1$';
    for($i=0; $i<9; $i++){
        $salt.=$base64_alphabet[rand(0,63)];
    }
    // return the crypt md5 password
    return crypt($password,$salt.'$');
	*/
}

?>