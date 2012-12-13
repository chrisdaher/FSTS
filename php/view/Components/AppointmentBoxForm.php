<?php
$subFolder="";
include_once($subFolder."html.php");
$root = $_SERVER['DOCUMENT_ROOT']."fsts";
$subFolder=$root."/php/model/";
include_once($subFolder."Appointment.php");
class AppointmentBoxForm{
    const APPOINTMENT_CONTAINER= "div_AppointmentContainer";
    
    var $Appointment;
    var $Container;
    
    public function __construct($Appointment=null){
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

    }
    
    private function buildAppBox(){
        $tempContainer=new html("div", "div_AppointmentBoxEdit");
        $tempContainer->addAttribute("appointmentID", $this->Appointment->id);
        
        $tempComponent = new html("label", "lbl_StartTimeEdit");
		$tempComponent->setText($this->Appointment->getStartTime());
        $tempContainer->addChild($tempComponent);
        
        $tempComponent = new html("label", "lbl_EndTimeEdit");
        $tempComponent->setText($this->Appointment->getEndTime());
        $tempContainer->addChild($tempComponent); 
        
        $tempComponent = new html("div", "div_Capacity");
        $tempSub = new html("label", "lbl_AppCurrent");
        $tempSub->setText($this->Appointment->size);
        $tempComponent->addChild($tempSub);
        
        $tempSub = new html("label", "lbl_AppSep");
        $tempSub->setText("of");
        $tempComponent->addChild($tempSub);
        
        $tempSub = new html("label", "lbl_AppCapacity");
        $tempSub->setText($this->Appointment->capacity);
        $tempComponent->addChild($tempSub);
        $tempContainer->addChild($tempComponent);
        
        $this->Container->addChild($tempContainer);
    }
    
    private function buildOptions(){
        $tempComponent = new html("div", "div_AppOptionsEdit");
        $tempComponent->addAttribute("appID", $this->Appointment->id);
        
        $tempSub = new html("button", "btn_AppDelete");
        $tempSub->addAttribute("appID", $this->Appointment->id);
        $tempSub->toJQuery("button");
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