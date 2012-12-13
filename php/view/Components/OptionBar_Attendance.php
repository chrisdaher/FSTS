<?php
include_once("html.php");
include_once("Bar.php");
include_once("GeneralBar.php");
include_once("OptionBar_AbstractFactory.php");
include_once("SearchGroup_MainBuilder.php");


class OptionBar_Attendance extends OptionBar_AbstractFactory{
    const IMGSOURCE = "Images/FlagAlert.png";
    
    private $fileID;
     
    
    public function __construct($EventID){
        parent::__construct();
        /*$this->divID="div_optionBar";
        $this->divID="OptionBarContainer";*/
        $this->fileID = $EventID;
        
        $this->buildBar();
    }

    protected function buildLeft(){
        $tempLink = new html("div", "logoImgAppointment");
		$this->bar->addLeft($tempLink);
		
        $toBeAdded = new html("input", $this->fileID_attributes);
        $toBeAdded->addAttribute("value", $this->fileID);
        $this->bar->addLeft($toBeAdded);
        
    }
    protected function buildCenter(){
        $toBeAdded = new html("center", $this->search_attributes);
        $searchBar = new SearchGroup_MainBuilder(null, false);
        $toBeAdded->addChild($searchBar->getContainer());
        
        $this->bar->addCenter($toBeAdded);
    }
    protected function buildRight(){
    }
    

}
?>