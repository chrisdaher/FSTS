<?php
	include_once("/../../model/converter.php");	
	include_once("/../../model/mysqlManager.php");	
	if (isset($_GET['id'])){
		$id = $_GET['id'];
	}
	if (isset($_GET['op'])){
		$op = $_GET['op'];
		if ($op == "set"){
		$data = $_GET['data'];
		echo setThemeId($id, $data);
	}
	
		if ($op == "get"){
			echo getThemeString($id);
		}
	}
	
	
	
	function getThemeString($id){
		//first get theme id
		$conv = new Converter("themeconverter", false);
		$mysql = new mysqlManager();
		$unique = array("user_id"=>$id);
		$res = $mysql->createSelectQuery($unique, "app_user_theme", true);
		$row = mysql_fetch_array($res);
		if ($row!=null){
			$theme_id = $row['theme_id'];
			$name = $conv->getRow($theme_id);
			return $name['name'];
		}
		else{
			$data = $conv->getTableDataJSON();
			$data = json_decode($data);
			return $data[0]->name;
		}
	}

	
	function setThemeId($userId, $data){
		
	}
?>