<?php

$subFolder="";
include_once("PageBuilder_AbstractFactory.php");
include_once("MainDiv_AttendanceBuilder.php");
include_once("OptionBar_Attendance.php");
include_once("MenuBarBuilder.php");

class PageBuilder_Attendance extends PageBuilder_AbstractFactory{
    private $EventID;
    private $MainBuilder;
    public function __construct( $userName = "NoName", $EventID = null, $isAdmin = false,$isEdit=false ,$page="Attendance"){
        parent::__construct($userName, $isAdmin, $isEdit,$page);
        $this->EventID = $EventID;
        
        $this->buildPage();
        $this->buildMainDisplay();
    }
    
    protected function buildPage(){
        $menuBar = new MenuBarBuilder($this->userName, $this->isAdmin);
        $optionBar = new OptionBar_Attendance($this->EventID, $this->isEdit);
        $this->page->addComponent($menuBar->getContainer());
        $this->page->addComponent($optionBar->getContainer());
    }
    protected function buildMainDisplay(){
        $main = new MainDiv_AttendanceBuilder($this->EventID, $this->isEdit);
        $this->MainBuilder=$main;
        $this->mainDisplay ->addChild($main->getContainer());
        $this->page->addComponent($this->mainDisplay);

        $AppInfoDialog = new html("div", null, "dialog_AppInfo");
        $AppInfoDialog->addAttribute("title", "Appointment Info");
        $this->page->addComponent($AppInfoDialog);
    }
    
    public function Search($fileIDs, $searchString = null){
        return $this->MainBuilder->Search($fileIDs, $searchString);    
    }
    
}


?>