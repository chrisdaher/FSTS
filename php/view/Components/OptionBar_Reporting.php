<?php
include_once("html.php");
include_once("Bar.php");
include_once("GeneralBar.php");
include_once("OptionBar_AbstractFactory.php");

class OptionBar_Reporting extends OptionBar_AbstractFactory{
    const IMGSOURCE = "Images/FlagAlert.png";
   
    public function __construct(){
        parent::__construct();
                
        $this->buildBar();
    }

    protected function buildLeft(){
	
    }
    protected function buildCenter(){
            $toBeAdded = new html("button", $this->execute_attributes);
            $toBeAdded->toJQuery("button");
            $toBeAdded->setText("Execute", $this->execute_attributes);
            $this->bar->addCenter($toBeAdded);
    }
    protected function buildRight(){

    }
    

}
?>