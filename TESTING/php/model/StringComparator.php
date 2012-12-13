<?php
	include_once("IComparator.php");
	class StringComparator implements IComparator{
		public function compare($a, $b){
			return (strcmp($a, $b) == 0);
		}
		
		public function __toString(){
			return get_class();
		}
	}

?>