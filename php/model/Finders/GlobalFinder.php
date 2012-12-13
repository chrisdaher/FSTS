<?php
	include_once("/../mysqlManager.php");
	class GlobalFinder{
		private $finder;
		private $mysql;
		function __construct(Finder $theFinder){
			$this->finder = $theFinder;
			$this->mysql = new mysqlManager();
		}
	
		function find($args, $isLike){
			$unique = array();
			
			for ($i=0;$i<sizeof($args);$i++){
				$tempSk = $args[$i];
				$tempName = $tempSk->name;
				$tempVal = $tempSk->value;
				$unique = array_merge($unique,array($tempName=>$tempVal));
			}
			
			$res = $this->createAndExecQueryResult($unique, $isLike);
			$res = $this->finder->buildArrayObjects($res);
			//var_dump($res);
			return $res;
		}
		
		function setFinder(Finder $finder){
			$this->finder = $finder;
		}
		
		function createAndExecQueryResult($unique, $isLike){
			$tableName = $this->finder->getTableName();
			if (!$isLike){
				$res = $this->mysql->createSelectQuery($unique, $tableName, true);
			}
			else{
				$res = $this->mysql->createSelectLikeQuery($unique, $tableName, true);
			}
			return $this->convertSqlResultToArray($res);
		}
		
		function convertSqlResultToArray($res){
			$rows = array();
			while($r = mysql_fetch_assoc($res)) {
				$rows[] = $r;
			}		
			return $rows;
		}
		
		
	}
	
?>