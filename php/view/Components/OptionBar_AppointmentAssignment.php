<?php
include_once("html.php");
include_once("Bar.php");
include_once("GeneralBar.php");
include_once("OptionBar_AbstractFactory.php");
include_once("SearchGroup_MainBuilder.php");


class OptionBar_AppointmentAssignment extends OptionBar_AbstractFactory{
    const IMGSOURCE = "Images/FlagAlert.png";
    
    private $fileID;
    private $isEdit;
    private $isFlagged;
     
    
    public function __construct($fileID, $isEdit=false, $isFlagged=false){
        parent::__construct();
        /*$this->divID="div_optionBar";
        $this->divID="OptionBarContainer";*/
        $this->fileID = $fileID;
        $this->isEdit = $isEdit;
        $this->isFlagged = $isFlagged;
        
        $this->buildBar();
    }

    protected function buildLeft(){
        $tempLink = new html("div", "logoImgAppointment");
		$this->bar->addLeft($tempLink);
		
        $toBeAdded = new html("div", $this->fileID_attributes);
        $toBeAdded->setText($this->fileID);
        $this->bar->addLeft($toBeAdded);
        
    }
    protected function buildCenter(){
        $toBeAdded = new html("center", $this->search_attributes);
        $searchBar = new SearchGroup_MainBuilder(null, false);
        $toBeAdded->addChild($searchBar->getContainer());
        
        $toAdd = new html("button", $this->attendance_attributes);
        $toAdd->addClass(self::OPTION_BAR_BUTTON_CLASS);
        $toAdd->toJQuery("button");
        $toAdd->setText("Attendance");
        $toBeAdded->addChild($toAdd);
        
        $this->bar->addCenter($toBeAdded);
        

    }
    protected function buildRight(){
        if($this->isEdit){
            $toBeAdded = new html("button", $this->cancel_attributes);
            $toBeAdded->addClass(self::OPTION_BAR_BUTTON_CLASS);
            $toBeAdded->toJQuery("button");
            $toBeAdded->setText("Cancel");
            $this->bar->addRight($toBeAdded);
            
            $toBeAdded = new html("button", $this->done_attributes);
            $toBeAdded->addClass(self::OPTION_BAR_BUTTON_CLASS);
            $toBeAdded->toJQuery("button");
            $toBeAdded->setText("Done");
            $this->bar->addRight($toBeAdded);
        }else{
            $toBeAdded = new html("button", $this->return_attributes);
            $toBeAdded->addClass(self::OPTION_BAR_BUTTON_CLASS);
            $toBeAdded->toJQuery("button");
            $toBeAdded->setText("Return");
            $this->bar->addRight($toBeAdded);
            
            $toBeAdded = new html("button", $this->edit_attributes);
            $toBeAdded->addClass(self::OPTION_BAR_BUTTON_CLASS);
            $toBeAdded->toJQuery("button");
            $toBeAdded->setText("Edit");
            $this->bar->addRight($toBeAdded);
        }
    }
    

}
?>