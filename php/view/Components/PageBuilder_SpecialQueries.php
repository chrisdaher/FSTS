<?php

$subFolder="";
include_once("PageBuilder_AbstractFactory.php");
include_once("MainDiv_SpecialQueriesBuilder.php");
include_once("MenuBarBuilder.php");

class PageBuilder_SpecialQueries extends PageBuilder_AbstractFactory{
    public function __construct( $userName = "NoName", $isAdmin = false, $page="Homepage"){
        parent::__construct($userName, $isAdmin, $page);
        
        $this->buildPage();
        $this->buildMainDisplay();
    }
    
    protected function buildPage(){
        $menuBar = new MenuBarBuilder($this->userName, $this->isAdmin);
        $this->page->addComponent($menuBar->getContainer());
    }
    protected function buildMainDisplay(){
        $main = new MainDiv_SpecialQueriesBuilder();
        $this->mainDisplay ->addChild($main->getContainer());
        $this->page->addComponent($this->mainDisplay);
    }    
}


?>