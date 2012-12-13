<?php


include_once("html.php");
include_once("Bar.php");
include_once("GeneralBar.php");

abstract class OptionBar_AbstractFactory{
    const OPTION_BAR_BUTTON_CLASS = "OptionMenuBtn";
    
    protected $fileID_attributes;
    protected $flag_attributes;
        
    protected $new_attributes;
    protected $delete_attributes;
    protected $registerToEvent_attributes;
    protected $search_attributes;
    
    protected $edit_attributes;
    protected $done_attributes;
    protected $execute_attributes;
    protected $cancel_attributes;
    protected $return_attributes;
    protected $attendance_attributes;
    
    protected $divID;
    protected $divClass;
    
    protected $bar;
    
    protected abstract function buildLeft();
    protected abstract function buildCenter();
    protected abstract function buildRight();
    
    protected function __construct(){
        
        $this->divID = "div_optionBar";
        $this->divClass = "OptionBarContainer"; 
                
        $this->fileID_attributes = array("id"=>"div_FileIdNumber");
        $this->flag_attributes = array("id"=>"image_flag");
        
        $this->new_attributes = array("id"=>"btn_New");
        $this->delete_attributes = array("id"=>"btn_Delete");
        $this->registerToEvent_attributes = array("id"=>"btn_Register");
        $this->search_attributes = array("id"=>"AA_div_search");
        
        $this->edit_attributes = array("id"=>"btn_Edit");
        $this->done_attributes = array("id"=>"btn_Done");
        $this->execute_attributes = array("id"=>"btn_Execute");
        $this->cancel_attributes = array("id"=>"btn_Cancel");
        $this->return_attributes = array("id"=>"btn_Return");
        $this->attendance_attributes = array("id"=>"btn_Attendance");   
    }
    
    protected function buildBar(){

        $attributes = array(
            "id"=>$this->divID,
            "class"=>$this->divClass
        );
        $this->bar = new GeneralBar("OptionBar", $attributes);
        
        $this->buildLeft();
        $this->buildCenter();
        $this->buildRight();
        
    }

    public function getContainer(){
        return $this->bar->getContainer();    
    }
    
    public function display(){
        print($this->getContainer()->toHTML());
    }
}


?>