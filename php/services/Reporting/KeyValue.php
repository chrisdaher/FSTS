<?php
	class KeyValue{
		var $key;
		var $value;
		function __construct($key, $val){
			$this->key = $key;
			$this->value = $val;
		}
		
		function JSONEncode(){
			return (array("name"=>$this->key, "value"=>$this->value));
		}
			
	}
?>