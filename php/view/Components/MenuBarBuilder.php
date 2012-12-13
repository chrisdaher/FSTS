<?php
include_once("html.php");
include_once("Bar.php");
include_once("GeneralBar.php");

class MenuBarBuilder{
    private $userName; 
    private $isAdmin;
    
    private $home_attributes;
    private $calender_attributes;
    private $reporting_attributes;
	private $attendance_attributes;
    private $admin_attributes;
    private $specialquery_attributes;
    private $name_attributes;
    private $logout_attributes;

    private $divID;
    private $divClass;
    
    private $bar;
    
    
    public function __construct($userName = "NoName", $isAdmin = false){
        $this->userName= $userName;
        $this->isAdmin= $isAdmin;
        $this->divID = "div_MenuBar";
        $this->divClass = "MenuBarContainer";
        
        $this->home_attributes = array("id"=>"btn_Home");
        $this->calender_attributes = array("id"=>"btn_Calender");
        $this->reporting_attributes = array("id"=>"btn_Reporting");
		$this->attendance_attributes = array("id"=>"mbtn_Attendance");
        $this->admin_attributes = array("id"=>"btn_Admin");
        $this->specialquery_attributes = array("id"=>"btn_spQuery");
        $this->name_attributes = array("id"=>"flyout");
        $this->logout_attributes = array("id"=>"btn_Logout");
        
        $this->buildMenuBar();       
    }
    
    private function buildMenuBar(){

        $attributes = array(
            "id"=>$this->divID,
            "class"=>$this->divClass
        );
        $this->bar = new GeneralBar("MenuBar", $attributes);
        
        $this->buildLeft();
        $this->buildRight();
        
    }
    private function buildLeft(){
       
        $tempButton = new html("button", $this->home_attributes);
        $tempButton->setText("Home");
        $this->bar->addLeft($tempButton);
        
        $tempButton = new html("button", $this->calender_attributes);
        $tempButton->setText("Calendar");
        $this->bar->addLeft($tempButton);
        		        
		$tempButton = new html("button", $this->attendance_attributes);
        $tempButton->setText("Attendance");
        $this->bar->addLeft($tempButton);
		
        
        if($this->isAdmin){
			$tempButton = new html("button", $this->reporting_attributes);
			$tempButton->setText("Reporting");
			$this->bar->addLeft($tempButton);
			
			$tempButton = new html("button", $this->specialquery_attributes);
			$tempButton->setText("Special Query");
			$this->bar->addLeft($tempButton);
		
            $tempButton = new html("button", $this->admin_attributes);
            $tempButton->setText("Admin");
            $this->bar->addLeft($tempButton);
			
        }
		        
    }
    private function buildRight(){
        $tempButton = new html("button", $this->logout_attributes);
        $tempButton->setText("Logout");
        $this->bar->addRight($tempButton);
        
        $tempButton = new html("button", $this->name_attributes);
        $tempLabel = new html("label",null, "label_name");
        $tempLabel->setText($this->userName);
        $tempButton->addChild($tempLabel);
        $this->bar->addRight($tempButton);
    }
    
    public function getContainer(){
        return $this->bar->getContainer();
    }
    public function display(){
        print($this->bar->getContainer()->toHTML());
    }
}
?>