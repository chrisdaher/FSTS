<?php
$subFolder="/../../model/";
include_once($subFolder."File.php");
$subFolder="";
include_once($subFolder."html.php");
abstract class FileDisplay_AbstractFactory{
    const CONTAINER_CLASS = "FullFile_Container";
    const CONTAINER_MAIN_CLASS = "FullFile_MainContainer";
    const CONTAINER_MAIN_DATA_CLASS = "FullFile_MainData";
    const CONTAINER_DEP_CLASS = "FullFile_DepContainer";
    const CONTAINER_DEP_DATA_CLASS = "FullFile_DepData";
    
    protected $File;
    protected $Container;
    
    protected $toMatch;
    
    protected $MainContainer;
    protected $DependentContainer;
    
    protected function __construct($FileID=null, $searchString=null){
        $this->Container = new html("div", self::CONTAINER_CLASS);
        $this->MainContainer = new html("div", self::CONTAINER_MAIN_CLASS);
        $this->DependentContainer = new html("div", self::CONTAINER_DEP_CLASS);
        
        $this->toMatch = $searchString;
        
        $this->File = new File($FileID, false);
        $this->File->loadFileInfo();
        $this->File->loadIndependent(false);
        $this->File->loadDependents(false);
    }
    protected function isMatch($toCheck){
        $toRet =false;
        if($this->toMatch!=null){
            $toCheck = strtoupper($toCheck);
            $toMatch = strtoupper($this->toMatch);
            $position= strpos($toCheck, $toMatch);
            if($position!==false){
                $toRet= true;
            }
			
			if ($toCheck != ''){
				$position= strpos($toMatch, $toCheck);
				if($position!==false){
					$toRet= true;
				}
			}
        }
        return $toRet;
    }
    public function getContainer(){
        $this->Container->removeChildren();
        $this->BuildFullDisplay();
        return $this->Container;
    }
    public function display(){
        echo ($this->getContainer()->toHTML());
    }
    
    public function getMainInfoContainer(){
        $this->MainContainer->removeChildren();
        $this->BuildMainInfo();
        return $this->MainContainer;
    }
    public function getDependentInfoContainer(){
        $this->DependentContainer->removeChildren();
        $this->BuildDependentInfo();
        return $this->DependentContainer;   
    }
    protected abstract function BuildFullDisplay();
    protected abstract function BuildMainInfo();
    protected abstract function BuildDependentInfo();
}

?>