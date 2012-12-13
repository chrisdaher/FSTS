<?php
$subFolder="";
include_once("Page.php");

abstract class PageBuilder_AbstractFactory{
    const MAIN_DISPLAY_CLASS="MainDisplay";
    const MAIN_DISPLAY_ID="_MainDisplay";
    
    protected $page;
    protected $mainDisplay;
    
    protected $userName;
    protected $isAdmin;
    protected $isEdit;
    
    protected function __construct($userName = "NoName", $isAdmin=false, $isEdit=false , $page="home" ){
        $this->page = new Page($page);
        $this->userName = $userName;
        $this->isAdmin = $isAdmin;
        $this->isEdit = $isEdit;
        $this->mainDisplay = new html("div", self::MAIN_DISPLAY_CLASS, $this->page->getID().self::MAIN_DISPLAY_ID);
    }
    
    protected abstract function buildPage();
    protected abstract function buildMainDisplay();
    
    public function getContainer(){
        return $this->page->getContainer();
    }
    
    public function display(){
        echo($this->page->renderPage());
    }
}


?>