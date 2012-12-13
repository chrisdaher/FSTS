<?php
	function checkRedirect(){
		require_once('SecurityManager.php');
		if (verifyLoginBool()){
			header( 'Location: Homepage.php ') ;
		}
	}
?>
