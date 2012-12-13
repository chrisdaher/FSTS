<?php

$subFolder="";
include_once($subFolder."PageBuilder_AbstractFactory.php");
include_once($subFolder."MainDiv_AdminBuilder.php");
include_once($subFolder."OptionBar_Admin.php");
include_once($subFolder."MenuBarBuilder.php");

class PageBuilder_Admin extends PageBuilder_AbstractFactory{
    private $MainBuilder;
    public function __construct( $userName = "NoName", $isAdmin = true, $section = "Language", $title="Language",$page="Admin"){
        parent::__construct($userName, $isAdmin, false, $page);
        
        $this->buildPage();
        $this->buildMainDisplay($section, $title);
    }
    
    protected function buildPage(){
        $menuBar = new MenuBarBuilder($this->userName, $this->isAdmin);
        $optionBar = new OptionBar_Admin();
        $this->page->addComponent($menuBar->getContainer());
        $this->page->addComponent($optionBar->getContainer());
    }
    protected function buildMainDisplay($section="section", $title="title"){
        $main = new MainDiv_AdminBuilder($section, $title);
        $this->MainBuilder=$main;
        $this->mainDisplay->addChild($main->getContainer());
        $this->page->addComponent($this->mainDisplay);
    }    
}


?>