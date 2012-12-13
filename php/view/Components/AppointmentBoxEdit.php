<?php
$subFolder="";
include_once($subFolder."html.php");
$root = $_SERVER['DOCUMENT_ROOT']."fsts";
$subFolder=$root."/php/model/";
include_once($subFolder."Appointment.php");
class AppointmentBoxEdit{
    const APPOINTMENT_CONTAINER= "div_AppointmentContainerEdit";
    
    var $Appointment;
    var $Container;
    
    public function __construct($Appointment=null){
		if($Appointment==null){
			$Appointment = new Appointment(-1);
		}
		$this->Appointment = $Appointment;
        $this->Container = new html("div", self::APPOINTMENT_CONTAINER); 
		
        $this->buildAppBox();
        $this->buildOptions();
    }
    
    private function buildLabels(){

    }
    
    private function buildAppBox(){
        $Data = array("", "", "", "", "", "");
        $formName = "div_AppointmentBoxNew";
        if($this->Appointment->id!=null){
            $formName = "div_AppointmentBoxEdit";
            $Data = array(
                $this->Appointment->getStartDate(),
                $this->Appointment->getEndDate(),
                $this->Appointment->getStartTime(),
                $this->Appointment->getEndTime(),
                $this->Appointment->size,
                $this->Appointment->capacity
            );
        }
        $tempContainer=new html("form", $formName);
        $tempContainer->addAttribute("appointmentID", $this->Appointment->id);
        
        $tempDiv = new html("div", "div_date");
        $tempComponent = new html("input", "lbl_StartDateEdit");
        $tempComponent->addAttribute("type", "text");
        $tempComponent->addAttribute("name", "start_date");
		$tempComponent->addAttribute("value", $Data[0]);
        $tempDiv->addChild($tempComponent);
        
        $tempComponent = new html("input", "lbl_EndDateEdit");
        $tempComponent->addAttribute("type", "text");
        $tempComponent->addAttribute("name", "end_date");
        $tempComponent->addAttribute("value", $Data[1]);
        $tempDiv->addChild($tempComponent); 
        $tempContainer->addChild($tempDiv);
        
        
        $tempDiv = new html("div", "div_time");
        $tempComponent = new html("input", "lbl_StartTimeEdit");
        $tempComponent->addAttribute("type", "text");
        $tempComponent->addAttribute("name", "start_time");
		$tempComponent->addAttribute("value", $Data[2]);
        $tempDiv->addChild($tempComponent);
        
        $tempComponent = new html("input", "lbl_EndTimeEdit");
        $tempComponent->addAttribute("type", "text");
        $tempComponent->addAttribute("name", "end_time");
        $tempComponent->addAttribute("value", $Data[3]);
        $tempDiv->addChild($tempComponent);
        $tempContainer->addChild($tempDiv);
        
        
        $tempDiv = new html("div", "div_size");
        $tempComponent = new html("input", "lbl_AppSize");
        $tempComponent->addAttribute("type", "text");
        $tempComponent->addAttribute("name", "app_size");
		$tempComponent->addAttribute("value", $Data[4]);
        $tempDiv->addChild($tempComponent);
        
        $tempComponent = new html("input", "lbl_AppCap");
        $tempComponent->addAttribute("type", "text");
        $tempComponent->addAttribute("name", "app_cap");
        $tempComponent->addAttribute("value", $Data[5]);
        $tempDiv->addChild($tempComponent);
        $tempContainer->addChild($tempDiv);
        
        
        
        $this->Container->addChild($tempContainer);
    }
    
    private function buildOptions(){
        $tempComponent = new html("div", "div_AppOptionsEdit");
        $tempComponent->addAttribute("appID", $this->Appointment->id);
        
        $tempSub = new html("button", "btn_AppCurrentDelete");
        $tempSub->addAttribute("appID", $this->Appointment->id);
        $tempSub->toJQuery("button");
        $tempComponent->addChild($tempSub);
        
        $tempSub = new html("button", "btn_AppCurrentCancel");
        $tempSub->addAttribute("appID", $this->Appointment->id);
        $tempSub->toJQuery("button");
        $tempComponent->addChild($tempSub);
        
        $tempSub = new html("button", "btn_AppCurrentDone");
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