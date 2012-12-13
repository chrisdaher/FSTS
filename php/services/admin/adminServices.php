<?php
	include_once("/../../model/converter.php");	
	include_once("/../../model/PostalCodeConverter.php");
    include_once("/../../model/IncomeLengthConverter.php");		
	
	
	$isPcode = false;
	
	if (isset($_GET['data'])){
		$data = $_GET['data'];
		if ($data == 'postalcode'){
			$isPcode = true;
		}
		$tableName = $data."converter";
	}
	if (isset($_GET['op'])){
		$op = $_GET['op'];
			
	
		if ($op == 'get'){
			echo getConverterDataJSON($tableName);
		}
		else if ($op == 'remove'){
			if (!$isPcode){
				$id = $_GET['id'];
				echo removeRowFromConverter($id, $tableName);
			}
			else{
				$pcode = $_GET['pcode'];
				$city = $_GET['city'];
				$prov = $_GET['prov'];
			}
		}
		else if ($op == 'add'){
			if (!$isPcode){
				$name = $_GET['name'];
				echo addRowToConverter($name, $tableName);
			}
			else{
				$pcode = $_GET['pcode'];
			}
		}
	}
	function getConverterDataJSON($tableName){	
		$conv = new Converter($tableName, false);
		return $conv->getTableDataJSON();
	}
	
	function removeRowFromConverterPcode($pcode, $tableName){
		$conv = new PostalCodeConverter();
		if (!$conv){
			return "D";
		}
		else{
			if ($conv->removeRow($pcode)){
				return "S";
			}
			else{
				return "E";
			}
			
		}
	}
    function removeRowFromConverterIncomeLength($id, $tableName){
		$conv = new PostalIncomeLength();
		if (!$conv){
			return "D";
		}
		else{
			if ($conv->removeRow($id)){
				return "S";
			}
			else{
				return "E";
			}
			
		}
	}
	
	function removeRowFromConverter($id, $tableName){
		$conv = new Converter($tableName, true);
		if (!$conv){
			return "D";
		}
		else{
			if ($conv->removeRow($id)){
				return "success";
			}
			else{
				return "E";
			}
			
		}
	}
	
	function addRowToConverterPcode($pcode, $city, $prov, $tableName){	
		$conv = new PostalCodeConverter();
		if (!$conv){
			return "D";
		}
		else{
			$id = $conv->addRow($pcode, $city, $prov);
			return $id;			
		}
	}
	function addRowToConverterIncomeLength($incomeLength, $value, $tableName){	
		$conv = new IncomeLengthConverter();
		if (!$conv){
			return "D";
		}
		else{
			$id = $conv->addRow($incomeLength, $value);
			return $id;			
		}
	}
	
	function updateRowToConverterPcode($pcode, $city, $prov, $tableName){
		$conv = new PostalCodeConverter();
		if (!$conv){
			return "D";
		}
		else{
			$conv->updateRow($pcode, $city, $prov);
		}
	}
	function updateRowToConverterIncomeLength($id, $incomeLength, $value, $tableName){
		$conv = new IncomeLengthConverter();
		if (!$conv){
			return "D";
		}
		else{
			$conv->updateRow($id, $incomeLength, $value);
		}
	}    
	
	function updateRowToConverter($id, $name, $tableName){
		$conv = new Converter($tableName, true);
		if (!$conv){
			return "D";
		}
		else{
			$conv->updateRow($id, $name);
		}
	}
	
	function addRowToConverter($name, $tableName){	
		$conv = new Converter($tableName, true);
		if (!$conv){
			return "D";
		}
		else{
			$id = $conv->addRow($name);
			return $id;
			
		}
	}
?>