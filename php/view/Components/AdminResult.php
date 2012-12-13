<?php

$subFolder="";
include_once($subFolder."html.php");

class AdminResult{
    const RESULT_CONTAINER_CLASS = "div_ResultContainer";
    const RESULT_DATA_CLASS = "div_ResultDataLine";
    const RESULT_EDIT_CLASS = "btn_ResultEdit";
    const RESULT_REMOVE_CLASS = "btn_ResultRemove";
    const RESULT_ADD_CLASS = "btn_ResultAdd";
    
    const RESULT_DATA_LABEL_CLASS = "lbl_ResultData";
    CONST RESULT_DATA_INPUT_CLASS = "input_ResultData";
    
    protected $Container;
    
    protected $DataContainer;
    protected $EditButton;
    protected $RemoveButton;
    
    protected $isNew;
    protected $ResultID;
    protected $Section;
    public function __construct($Data = array(""), $section= "Langauge", $ResultID=0,$isNew=false){
        $this->ResultID = $ResultID;
        $this->Section= $section;
        $this->Container = new html("tr", self::RESULT_CONTAINER_CLASS);
        $this->Container->addAttribute("ResultID", $this->ResultID);
        $this->isNew=$isNew;
        
        $this->DataContainer = new html("td",self::RESULT_DATA_CLASS."_column" );
        $tempColumn= new html("div", self::RESULT_DATA_CLASS);
        $tempColumn->addAttribute("ResultID", $this->ResultID);
        $tempColumn->addAttribute("Section", $this->Section);
        $this->DataContainer->addChild($tempColumn);
        
        $this->RemoveButton = new html("td",self::RESULT_REMOVE_CLASS."_column" );
        $tempColumn = new html("button", self::RESULT_REMOVE_CLASS);
        $tempColumn->addAttribute("ResultID", $this->ResultID);
        $tempColumn->addAttribute("Section", $this->Section);
        $tempColumn->toJQuery("button");
        $this->RemoveButton->addChild($tempColumn);
        
        $this->EditButton = new html("td",self::RESULT_EDIT_CLASS."_column" );
        if(!$this->isNew){
            $tempColumn = new html("button", self::RESULT_EDIT_CLASS);
        }else{
            $tempColumn = new html("button", self::RESULT_ADD_CLASS);

        }
        $tempColumn->addAttribute("ResultID", $this->ResultID);
        $tempColumn->toJQuery("button");
        $tempColumn->addAttribute("Section", $this->Section);
        $this->EditButton->addChild($tempColumn);
        
        $this->build($Data);
        $this->render();
    }
    
    protected function build($Data){
        $tempTable = new html("table", self::RESULT_DATA_CLASS."_table");
        $tempRow = new html("tr");
        for($i=0; $i<sizeof($Data);$i++){
            if($this->isNew){
                $tempColumn = new html("td", self::RESULT_DATA_INPUT_CLASS."_column");
                $tempData = new html("input", self::RESULT_DATA_INPUT_CLASS);
                $tempData->addAttribute("type", "text");
                $tempData->addAttribute("value",$Data[$i]);

            }else{
                $tempColumn = new html("td", self::RESULT_DATA_INPUT_CLASS."_column");
                $tempData = new html("label", self::RESULT_DATA_LABEL_CLASS);
                $tempData->setText($Data[$i]); 
            }
            $tempData->addAttribute("ResultID", $this->ResultID);
            $tempData->addAttribute("Section", $this->Section);
            $tempColumn->addChild($tempData);
            $tempRow->addChild($tempColumn);
        }
        $tempTable->addChild($tempRow);
        $children = $this->DataContainer->getChildren();
         
        
        $children[0]->addChild($tempTable);
    }
    
    public function getContainer(){
        return $this->Container;
    }
    
    public function display(){
        echo($this->Container->toHTML());
    }
    protected function render(){
        $this->Container->addChild($this->DataContainer);
        $this->Container->addChild($this->EditButton);
        $this->Container->addChild($this->RemoveButton);
    }
}

?>