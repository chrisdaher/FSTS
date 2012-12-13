<?php
	include_once("phpMySql.php");
	function LanguageToInt($langStr){
		$res = selectWhereQuery("languageconverter","name",$langStr);
		$row = mysql_fetch_array($res);
		
		if ($row == null) return -1;
		return $row['id'];
	}
	
	function ContactToInt($conId){
		$res = selectWhereQuery("contactconverter","name",$conId);
		$row = mysql_fetch_array($res);
		if ($row == null) return -1;
		return $row['id'];
	}
	
	function MaritalStatusToInt($marStr){
		$res = selectWhereQuery("maritalconverter","name",$marStr);
		$row = mysql_fetch_array($res);
		if ($row == null) return -1;
		return $row['id'];
	}
	
	function WorkStatusToInt($workStr){
		$res = selectWhereQuery("workconverter","name",$workStr);
		$row = mysql_fetch_array($res);
		if ($row == null) return -1;
		return $row['id'];
	}
	
	function GenderToInt($genderStr){
		if ($genderStr[0] == 'm' || $genderStr[0]=='M'){
			 return 0;
		}
		return 1;
	}

	function LanguageIntToString($langId){
			$res = selectWhereQuery("languageconverter","id",$langId);
			$row = mysql_fetch_array($res);
			return $row['name'];
	}
	
	function ContactIntToString($conId){
			$res = selectWhereQuery("contactconverter","id",$conId);
			$row = mysql_fetch_array($res);
			return $row['name'];
	}
	
	function MaritalStatusIntToString($marId){
			$res = selectWhereQuery("maritalconverter","id",$marId);
			$row = mysql_fetch_array($res);
			return $row['name'];
	}
	
	function WorkStatusToString($workId){
			$res = selectWhereQuery("workconverter","id",$workId);
			$row = mysql_fetch_array($res);
			return $row['name'];
	}
	
	function GenderToString($genderId){
		if ($genderId == 0) return "Male";
		return "Female";
	}
	
	function EventTypeToInt($str){
		$res = selectWhereQuery("event_type","name",$str);
		$row = mysql_fetch_array($res);
		if ($row == null) return -1;
		return $row['id'];
	}
	
	function EventTypeToString($typeId){
		$res = selectWhereQuery("event_type","id",$typeId);
		$row = mysql_fetch_array($res);
		return $row['name'];
	}
?>