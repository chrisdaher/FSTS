<?php
	include_once("SpecConverter.php");
	class SearchKey{
		var $name;
		var $value;
		var $isSpec;
		var $specConv;
		function __construct($str, $val, $isSpec = false, $specConv = null){
			$this->name = $str;
			$this->value = $val;
			$this->isSpec = $isSpec;
			$this->specConv = $specConv;
		}	
		
		function isSpec(){
			return $this->isSpec;
		}
		
		function __toString(){
			return $this->name;
		}
		
		function setName($nam){
			$this->name = $nam;
		}
		
		function setValue($val){
			$this->val = $val;
		}
	}
?>