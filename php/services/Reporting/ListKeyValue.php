<?php	
	include_once("KeyValue.php");
	
	class ListKeyValue{
		var $id;
		var $dbId;
		var $keyValues;
		
		function __construct($id, $dbId = -1){
			$this->id = $id;
			$this->keyValues = array();
			$this->dbId = $dbId;
		}
		
		function addKeyValue($key, $val){
			$kv = new KeyValue($key, $val);
			$cntr = sizeof($this->keyValues);
			$this->keyValues[$cntr] = $kv;
		}
		
		function JSONEncode(){
			return array("id"=>$this->id, "keyValues"=>$this->keyValues);
		}
		
		
	}
?>