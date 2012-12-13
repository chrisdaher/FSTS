<?php
	function logOut(){
		session_start();
		include("/../mysql/phpMySql.php");
		
		$tableName = "stay_loggedin";
		$colUsername = "username";
		$colCookieVal = "cookieVal";
		
		$username = $_COOKIE['LoginName'];
		$pw = $_COOKIE['LoginVal'];
		
		$query = "DELETE FROM `$tableName` WHERE `$colUsername`='$username'";
		sqlExecQuery($query);
		setcookie("LoginVal", "", time()-3600, "/");
		setcookie("LoginName", "", time()-3600, "/");
		setcookie("LoginID", $row['id'], time()-3600, "/");
		header( 'Location: ../../../LOGINPAGE.php') ;
	}
	function verifyLoginAdmin(){
		if (verifyLoginBool()){
			if (!$_SESSION['isAdmin']){
				return false;
			}
			else{
				return true;
			}
		}
		return false;
		
	}
	
	function verifyLogin(){
		session_start();
		include("/../mysql/phpMySql.php");
		
		$tableName = "stay_loggedin";
		$colUsername = "username";
		$colCookieVal = "cookieVal";

		$username = $_COOKIE['LoginName'];
		$pw = $_COOKIE['LoginVal'];
		
		if ($username == NULL || $pw == NULL){
			//delete from db 
			//$query = "DELETE FROM `$tableName` WHERE `$colUsername`='$username'";
			//sqlExecQuery($query);
			denied();
		}
		else{
			$res = selectWhereQuery($tableName, $colUsername, $username);
			$row = mysql_fetch_array($res);
			if ($row == null){
				denied();
			}
			else{
				$dbPw = $row[$colCookieVal];
				if ($pw != $dbPw){
					denied();
				}
				else{
					$res = selectWhereQuery('app_user', 'username', $username);
					$row = mysql_fetch_array($res);
					$id = $row['id'];
					$res = selectWhereQuery('app_user_admin', 'id', $id);
					$row = mysql_fetch_array($res);
					$_SESSION['isAdmin'] = $row['isAdmin'];
				}
			}
		}
	}
	
	function verifyLoginBool(){

		include("/../mysql/phpMySql.php");
		
		$tableName = "stay_loggedin";
		$colUsername = "username";
		$colCookieVal = "cookieVal";
		
		$username = "";
		$pw = "";
		
        if(!empty($_COOKIE['LoginName'])){
            $username=$_COOKIE['LoginName'];
            }
            if(!empty($_COOKIE['LoginVal'])){
                $pw=$_COOKIE['LoginVal'];
            }
		if ($username == "" || $pw == ""){
			return false;
		}
		else{
			$res = selectWhereQuery($tableName, $colUsername, $username);
			$row = mysql_fetch_array($res);
			if ($row == null){
				return false;
			}
			else{
				$dbPw = $row[$colCookieVal];
				if ($pw != $dbPw){
					return false;
				}
				else{
					$res = selectWhereQuery('app_user', 'username', $username);
					$row = mysql_fetch_array($res);
					$userId = $row['id'];
					$res = selectWhereQuery('app_user_admin', 'id', $userId);
					$row = mysql_fetch_array($res);
					$_SESSION['isAdmin'] = $row['isAdmin'];
				}
			}
		}
		return true;
	}
	
	function denied(){
		header( 'Location: LOGINPAGE.php?Access=denied') ;
	}

?>