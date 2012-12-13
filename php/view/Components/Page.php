<?php
$subFolder = "";
include_once($subFolder."html.php");
class Page{
    const PAGE_CLASS = "page";
    const PAGE_ID = "_page";
    protected $pageID;
    protected $Container;
    
    public function __construct($id="default"){
        $this->pageID=$id.self::PAGE_ID;
        $this->Container = new html("div", self::PAGE_CLASS, $this->pageID );
    } 
    
	public function getID(){
		return $this->pageID;
	}
	public function getContainer(){
		return $this->Container;
	}
	
    public function addComponent($component){
        $this->Container->addChild($component);
    }
    public function addComponents($component){
        $this->Container->addChildren($component);
    }
    public function removeComponentAt($index){
        $this->Container->removeChildByIndex($index);
    }
    public function removeComponent($component){
        $removeBy="id";
        $toRemove = $component->getID();
        if($toRemove=="" || $toRemove==null){
            $removeBy="class";
            $toRemove = $component->getClass();
        }
        $this->Container->removeChildBy($removeBy, $toRemove);
    }
    public function renderPage(){
        return $this->Container->toHTML();
    }
}

?>