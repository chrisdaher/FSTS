<?php

$subFolder="";
include_once("PageBuilder_AbstractFactory.php");
include_once("MainDiv_ReportingBuilder.php");
include_once("MenuBarBuilder.php");
include_once("OptionBar_Reporting.php");

class PageBuilder_Reporting extends PageBuilder_AbstractFactory{
    public function __construct( $userName = "NoName", $isAdmin = false, $page="Reporting"){
        parent::__construct($userName, $isAdmin, $page);
        
        $this->buildPage();
        $this->buildMainDisplay();
    }
    
    protected function buildPage(){
        $menuBar = new MenuBarBuilder($this->userName, $this->isAdmin);
        $optionBar = new OptionBar_Reporting();
        $this->page->addComponent($menuBar->getContainer());
        $this->page->addComponent($optionBar->getContainer());
    }
    protected function buildMainDisplay(){
        $main = new MainDiv_ReportingBuilder();
        $this->mainDisplay ->addChild($main->getContainer());
        $this->page->addComponent($this->mainDisplay);
    }    
}


?>