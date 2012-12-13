<?php

$subFolder="";
include_once($subFolder."html.php");
abstract class MainDiv_AbstractFactory{
    const MAIN_DIV_CLASS = "MainDataDiv";
    const COLUMN_ID = "div_Column";

    protected $Container;
    protected $Wrapper;
    protected $Columns;
    
    protected function __construct($NumOfCols){
        $this->Container = new html("table");
        $this->Wrapper = new html("div","Wrapper");
        $this->Wrapper->addClass(self::MAIN_DIV_CLASS);
        for($i=0;$i<$NumOfCols;$i++){
            $this->Columns[$i] = new html("td", null, self::COLUMN_ID . ($i+1));
        }
    }

    public function getContainer(){
        $this->Wrapper->removeChildren();
        $this->Wrapper->addChild($this->Container);
        return $this->Wrapper;
    }
    public function display(){
        echo ($this->getContainer()->toHTML());
    }
    protected function render(){
        $this->Container->removeChildren();
        $this->Container->addChildren($this->Columns);
    }
  
    protected abstract function buildMain();
}

?>