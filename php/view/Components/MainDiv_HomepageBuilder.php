<?php

$subFolder="";
include_once($subFolder."MainDiv_AbstractFactory.php");
$subFolder="";
include_once($subFolder."html.php");
$subFolder="";
include_once($subFolder."SearchGroup_MainBuilder.php");
$subFolder="";
include_once($subFolder."SearchByGroup_Builder.php");
class MainDiv_HomepageBuilder extends MainDiv_AbstractFactory{
    private $SearchBarContainer;
    private $SearchResultsContainer;
    private $tableContainer;
    public function __construct(){

        $this->Container = new html("div");
        $this->Wrapper = new html("div","Wrapper");
        $this->Wrapper->addClass(self::MAIN_DIV_CLASS);
        $NumOfCols = 3;
        for($i=0;$i<$NumOfCols;$i++){
            $this->Columns[$i] = new html("td", null, self::COLUMN_ID . ($i+1));
        }
        
        $this->SearchBarContainer = new html("div", "SearchBarContainer");
        $this->SearchResultsContainer = new html("div", "SearchResultsContainer");
        
        $this->buildMain();
        $this->render();
    }
  
    protected function buildMain(){
        $this->buildSearch();
        $this->buildResults();
    }
    protected function buildSearch(){
        $SearchByGroup = new SearchByGroup_Builder();
        $this->SearchBarContainer->addChild($SearchByGroup->getContainer());
        $SearchBar = new SearchGroup_MainBuilder("Start here");
        $this->SearchBarContainer->addChild($SearchBar->getContainer());
		
		$tempDiv = new html("div", "imgLogo");
        $this->SearchBarContainer->addChild($tempDiv);
    }
    protected function buildResults(){
        $this->tableContainer = new html("table", "SearchResults_MainTable");
        
        $tempDiv = new html("div", "SearchGroup");
        $this->Columns[0]->addChild($tempDiv);
        
        $tempDiv = new html("div", "SearchResults");
        $this->Columns[1]->addChild($tempDiv);
        
        $tempDiv = new html("div", "SearchHover");
        $this->Columns[2]->addChild($tempDiv);
    }
    protected function render(){
        $this->Container->removeChildren();
        $this->Container->addChild($this->SearchBarContainer);
        $this->tableContainer->addChildren($this->Columns);
        $this->SearchResultsContainer->addChild($this->tableContainer);
        $this->Container->addChild($this->SearchResultsContainer);
    }
}

?>