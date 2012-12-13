<?php
	include_once("mysqlManager.php");
	include_once("Finders/FileFinder.php");
	include_once("Finders/GlobalFinder.php");
	include_once("/../services/getCityFromPcode.php");
	class FileInfo{
		var $id;
		var $addr_street;
		var $addr_nb;
		var $addr_city;
		var $addr_prov;
		var $addr_pcode;
		var $notes;
		var $table_name = "file_info";
		var $isNew;
		var $deleteFlag = false;
		
		function __construct($id){
			$this->deleteFlag = false;
			if ($id != -1){
				$mysql = new mysqlManager();
				$params = array("id"=>$id);
				$res = $mysql->createSelectQuery($params, $this->table_name,true);
				
				$row = mysql_fetch_array($res);
				
				if ($row != null){
					$this->id = $id;
					$this->addr_street = $row['addr_street'];
					$this->addr_nb = $row['addr_nb'];
					$this->addr_city = $row['addr_city'];
					$this->addr_prov = $row['addr_prov'];
					$this->addr_pcode = $row['addr_pcode'];
					
					$temp = getPcode($this->addr_pcode);
					$temp = preg_split("/::/", $temp);
					
					if (sizeof($temp) >1){
						$this->addr_city = $temp[0];
						$this->addr_prov = $temp[1];
					}

					$this->notes = $row['notes'];
					$this->isNew = false;
					return true;
				}
				$this->isNew = true;
				return false;
			}
			$this->isNew = true;
			return false;
		}
		
		function update(){
			$mysql = new mysqlManager();
			
			if ($this->deleteFlag){
				$res = $mysql->createDeleteQuery(array("id"=>$this->id), $this->table_name, true);
				if ($mysql->error != null){
						throw new Exception($mysql->error);
						return false;
				}
				return true;
			}
			else{
			
				$params = array("addr_street"=>$this->addr_street, "addr_nb"=>$this->addr_nb, "addr_city"=>$this->addr_city,
								"addr_prov"=>$this->addr_prov, "addr_pcode"=>$this->addr_pcode, "notes"=>$this->notes);
				if ($this->isNew){
					$res = $mysql->createInsertQuery($params, $this->table_name, true, true);
					if ($mysql->error != null){
						throw new Exception($mysql->error);
						return false;
					}
					$this->id = $res;
				}
				else{ //update
					$unique = array("id"=>$this->id);			
					$res = $mysql->createUpdateQuery($unique, $params, $this->table_name, true);
					if ($mysql->error != null){
						throw new Exception($mysql->error);
						return false;
					}
				}
				$this->isNew = false;
				return true;
			}
		}
		
		function getFamilyId(){
			$ff = new FileFinder();
			$gf = new GlobalFinder($ff);
			
			$sk = $ff->getSearchKeyByFileInfoId($this->id);
			$res = $gf->find(array($sk), false);
			$file = $res[0];
			return $file->id;
		}
		
		function __toString(){
			return "FileInfo Object id#".$this->id;
		}
	
	}

?>