<?php
	include_once("SpecConverter.php");
	class GenderSpec extends SpecConverter{
		function __construct(){
		
		}
		function getAllData(){
			return array(array("id"=>0, "name"=>"Male"), array("id"=>1, "name"=>"Female"));
		}
	}

?>