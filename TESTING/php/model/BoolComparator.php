<?php
	include_once("IComparator.php");
	class BoolComparator implements IComparator{
		public function compare($a, $b){
			return ($a == $b);
		}
		
		public function __toString(){
			return get_class();
		}
	}
	
?>