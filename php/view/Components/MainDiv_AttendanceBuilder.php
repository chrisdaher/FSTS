<?php

$subFolder="";
include_once($subFolder."MainDiv_AbstractFactory.php");
$subFolder="";
include_once($subFolder."html.php");
$subFolder="";
include_once($subFolder."SearchGroup_MainBuilder.php");
$subFolder="";
include_once($subFolder."SearchByGroup_Builder.php");
class MainDiv_AttendanceBuilder extends MainDiv_AbstractFactory{
    private $tableContainer;
    public function __construct(){
		parent::__construct(0);
        $this->Container->addClass("Attendance_SearchResults");
        //$this->SearchBarContainer = new html("div", "SearchBarContainer");
        //$this->SearchResultsContainer = new html("div", "SearchResultsContainer");
        
        $this->buildMain();
        $this->render();
    }
  
    protected function buildMain(){
        $this->buildResults();
    }
    protected function buildResults(){
        $this->tableContainer = new html("table", "SearchResults_MainTable");
    }
    protected function render(){
        $this->Container->removeChildren();
        //$this->Container->addChild($this->SearchBarContainer);
        $this->tableContainer->addChildren($this->Columns);
        //$this->SearchResultsContainer->addChild($this->tableContainer);
        //$this->Container->addChild($this->SearchResultsContainer);
    }
}

?>