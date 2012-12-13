<?php
$subFolder="/../../model/";
include_once($subFolder."File.php");
$subFolder="";
include_once($subFolder."html.php");
abstract class FileBlock_AbstractFactory{
    const MINI_FILE_FOUND_CLASS = "div_FileBlock";
    const MAIN_FILE_FOUND_CLASS = "div_FileBlock";
    const MINI_FILE_FOUND_DISABLED = "added";
    const MINI_FILE_DROPPED_CLASS = "div_DroppedBlock";
    protected $File;
    protected $AttributeArray;
    protected $Container;
    protected $toMatch;
    
    public $matches;
    
    protected function __construct($FileID=null, $toMatch=null){
        if($FileID!=null){
            $this->File = new File($FileID, false);
            $this->File->loadFileInfo();
        }
        $this->toMatch = $toMatch;
    }
    protected function isMatch($toCheck){
        $toCheck = strtoupper($toCheck);
        $toMatch = strtoupper($this->toMatch);
		$position=false;
		if($toMatch!=""){
			$position= strpos($toCheck, $toMatch);
		}
        $toRet =false;
		
		
		
        if($position!==false){
            $toRet= true;
        }
		if ($toCheck != ''){
			$position= strpos($toMatch, $toCheck);
			if($position!==false){
				$toRet= true;
			}
		}
		
        return $toRet;
    }
    public function getContainer(){
        if($this->Container!=null){
            $this->Container->removeChildren();
        }
        $this->render();
        return $this->Container;
    }
    public function display(){
        echo ($this->Container->toHTML());
    }
    public function doSearch($FileID, $toMatch){
        $this->__construct($FileID, $toMatch);

        //$this->buildAttributeArray();
        //$this->buildFile();
        
        return $this->getContainer();
    }
    protected abstract function render();  
    protected abstract function buildFile();
    protected abstract function buildAttributeArray();
}

?>