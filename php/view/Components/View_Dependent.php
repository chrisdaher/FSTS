<?php
$subFolder="";
include_once($subFolder."View_Person.php");

class View_Dependent extends View_Person{
    public function __construct($ID=0){
        parent::__construct($ID);
    }

}

?>