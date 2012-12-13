<?php
	include_once("SpecConverter.php");
	class BooleanSpec extends SpecConverter{
		function __construct(){
		
		}
		function getAllData(){
			return array(array("id"=>1, "name"=>"True"), array("id"=>0, "name"=>"False"));
		}
	}

?>