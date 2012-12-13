<?php

$subFolder="";
include_once("PageBuilder_AbstractFactory.php");
include_once("MainDiv_HomepageBuilder.php");
include_once("MenuBarBuilder.php");

class PageBuilder_Homepage extends PageBuilder_AbstractFactory{
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
        $main = new MainDiv_HomepageBuilder();
        $this->mainDisplay ->addChild($main->getContainer());
        $this->page->addComponent($this->mainDisplay);
    }
    
    public function Search($fileIDs, $searchString = null){
        return $this->MainBuilder->Search($fileIDs, $searchString);    
    }
    
}


?>