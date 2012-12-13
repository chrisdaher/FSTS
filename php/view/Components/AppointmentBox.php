<?php
$subFolder="";
include_once($subFolder."html.php");
$subFolder="./php/model/";
include_once($subFolder."Appointment.php");
class AppointmentBox{
    const APPOINTMENT_CONTAINER= "div_AppointmentContainer";
    
    var $Appointment;
    var $Container;
    
    public function __construct($Appointment){
		if($Appointment==null){
			$Appointment = new Appointment(-1);
		}
		$this->Appointment = $Appointment;
        $this->Container = new html("div", self::APPOINTMENT_CONTAINER); 
		
        $this->buildLabels();
        $this->buildAppBox();
        $this->buildOptions();
    }
    
    private function buildLabels(){
        $tempComponent = new html("label", "lbl_StartTime");
		$tempComponent->setText($this->Appointment->getStartTime());
        $this->Container->addChild($tempComponent);
        
        $tempComponent = new html("label", "lbl_EndTime");
        $tempComponent->setText($this->Appointment->getEndTime());
        $this->Container->addChild($tempComponent); 
    }
    
    private function buildAppBox(){
        $tempContainer=new html("div", "div_AppointmentBox");
        $tempContainer->addAttribute("appointmentID", $this->Appointment->id);
        $this->Container->addChild($tempContainer);
    }
    
    private function buildOptions(){
        $tempComponent = new html("div", "div_AppOptions");
        $tempComponent->addAttribute("appID", $this->Appointment->id);
        
        $tempSub = new html("button", "btn_AppInfo");
        $tempSub->addAttribute("appID", $this->Appointment->id);
        $tempSub->toJQuery("button");
        $tempComponent->addChild($tempSub);
        
        $tempSub = new html("label", "lbl_AppCurrent");
        $tempSub->setText($this->Appointment->size);
        $tempComponent->addChild($tempSub);
        
        $tempSub = new html("label", "lbl_AppSep");
        $tempSub->setText("of");
        $tempComponent->addChild($tempSub);
        
        $tempSub = new html("label", "lbl_AppCapacity");
        $tempSub->setText($this->Appointment->capacity);
        $tempComponent->addChild($tempSub);
		
        $this->Container->addChild($tempComponent);
    }

    public function getContainer(){
        return $this->Container;
    }
    
    public function display(){
        echo($this->Container->toHTML());
    }
}

?>