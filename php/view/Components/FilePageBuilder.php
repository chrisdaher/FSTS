<?php

$subFolder="";
include_once($subFolder."PageBuilder_AbstractFactory.php");
include_once($subFolder."MenuBarBuilder.php");
include_once($subFolder."OptionBar_FilePage.php");
class FilePageBuilder extends PageBuilder_AbstractFactory{
   private $menuBar;
   private $optionBar;
   
   private $fileID;
   private $isEdit;
   private $isFlagged;
   private $userName;
   private $isAdmin;
   
   public function __construct($page="File", $fileID = "new", $isEdit=false, $isFlagged=false){
        parent::__construct("File");
        
        $user="unknown";
        $isAdmin=false;
        
        $this->fileID=$fileID;
        $this->isEdit=$isEdit;
        $this->isFlagged=$isFlagged;
        $this->userName=$user;
        $this->isAdmin=$isAdmin;
        
        $this->buildPage();
   }
   protected function buildPage(){
        $menuBarBuilder= new MenuBarBuilder($this->userName, $this->isAdmin);
        $optionBarBuilder= new OptionBar_FilePage($this->fileID, $this->isEdit, $this->isFlagged);
        $this->menuBar=$menuBarBuilder->getContainer(); 
        $this->optionBar=$optionBarBuilder->getContainer();
        
        $this->buildMainDisplay();
        
        $this->page->addComponent($this->menuBar);
        $this->page->addComponent($this->optionBar);
        $this->page->addComponent($this->mainDisplay);
   }
   
   protected function buildMainDisplay(){
        
   }
}

?>