<?php
include_once("html.php");
include_once("Bar.php");
include_once("GeneralBar.php");
include_once("OptionBar_AbstractFactory.php");

class OptionBar_FilePage extends OptionBar_AbstractFactory{
    const IMGSOURCE = "Images/FlagAlert.png";
    
    private $fileID;
    private $isEdit;
    private $isFlagged;
    

    
    public function __construct($fileID, $isEdit=false, $isFlagged=false){
        parent::__construct();
        $this->fileID = $fileID;
        $this->isEdit = $isEdit;
        $this->isFlagged = $isFlagged;
        
        $this->buildBar();
    }

    protected function buildLeft(){
	
        $toBeAdded = new html("div", $this->fileID_attributes);
        $toBeAdded->setText($this->fileID);
        $this->bar->addLeft($toBeAdded);
        
        $toBeAdded = new html("div", $this->flag_attributes);   
        if($this->isFlagged){
            $temp = new html("img");
            $temp->addAttribute("src", self::IMGSOURCE);
            $toBeAdded->addChild($temp);
        }
        $this->bar->addLeft($toBeAdded); 
    }
    protected function buildCenter(){
        $toBeAdded = new html("button", $this->new_attributes);
        $toBeAdded->toJQuery("button");
        $toBeAdded->setText("New");
        $this->bar->addCenter($toBeAdded);
        
        $toBeAdded = new html("button", $this->delete_attributes);
        $toBeAdded->toJQuery("button");
        $toBeAdded->setText("Delete");
        $this->bar->addCenter($toBeAdded);
        
        $toBeAdded = new html("button", $this->registerToEvent_attributes);
        $toBeAdded->toJQuery("button");
        $toBeAdded->setText("Register To Event");
        $this->bar->addCenter($toBeAdded);
    }
    protected function buildRight(){
        if(!$this->isEdit){
            $toBeAdded = new html("button", $this->edit_attributes);
            $toBeAdded->toJQuery("button");
            $toBeAdded->setText("Edit");
            $this->bar->addRight($toBeAdded);
        }else{
            $toBeAdded = new html("button", $this->cancel_attributes);
            $toBeAdded->toJQuery("button");
            $toBeAdded->setText("Cancel");
            $this->bar->addRight($toBeAdded);
            
            $toBeAdded = new html("button", $this->done_attributes);
            $toBeAdded->toJQuery("button");
            $toBeAdded->setText("Done");
            $this->bar->addRight($toBeAdded);
        }
    }
    

}
?>