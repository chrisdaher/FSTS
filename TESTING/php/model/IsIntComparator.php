<?php
	include_once("IComparator.php");
	class IsIntComparator implements IComparator{
		public function compare($a, $b){
			return (is_int($a) == $b);
		}
		
		public function __toString(){
			return get_class();
		}
	}
	
?>