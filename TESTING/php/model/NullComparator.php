<?php
	include_once("IComparator.php");
	class NullComparator implements IComparator{
		public function compare($a, $b){
			return (($a == null) == $b);
		}
		
		public function __toString(){
			return get_class();
		}
	}
	
?>