<?php
	include_once("IComparator.php");
	class HTMLComparator implements IComparator{
		public function compare($a, $b){
		var_dump($a);
			return (strcmp($a, $b) == 0);
		}
		
		public function __toString(){
			return get_class();
		}
	}

?>