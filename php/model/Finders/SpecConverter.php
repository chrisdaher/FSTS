<?php
	include_once("/../converter.php");
	class SpecConverter{
		var $table_name;
		var $conv;
		function __construct($tabName){
			$this->table_name = $tabName;
			$this->conv = new converter($tabName, false);
		}
		
		function getAllData(){
			$toRet = array();
			$rows = $this->conv->getTableData();
			return $rows;
		}
	}

?>