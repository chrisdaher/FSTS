<?php

$subFolder="";
include_once($subFolder."AppointmentBoxForm.php");
$subFolder="";
include_once($subFolder."AppointmentBoxEdit.php");
$root = $_SERVER['DOCUMENT_ROOT']."fsts";
$subFolder=$root."/php/model/";
include_once($subFolder."Event.php");

class EventInfoForm{
    const APP_INFO_CLASS = "div_Calender";
    const EVENT_DATA_CLASS = "div_Data";
    
    private $AppointmentInfo;
    private $EventData;

    private $Event;
    
    public function __construct($EventID, $appToEdit=-1){
		
        $this->Event = new Event($EventID, true);
        
        $this->buildAppInfo($appToEdit);
        if($appToEdit==-1){
            $this->buildEventData();
        }
    }
    
    private function buildAppInfo($appToEdit=-1){
		global $arr;
		
        $this->AppointmentInfo = new html("div",null,self::APP_INFO_CLASS);
        
        $tempComponent = new html("div",null, "lbl_AppointmentDay" );
        $tempSub = new html("button", "btn_AddAppointment");
        $tempComponent->addChild($tempSub);
        $tempComponent->setText($this->getAppointmentDate());
        $this->AppointmentInfo->addChild($tempComponent);
        
        $tempComponent = new html("div", null, "div_CalenderBox");
        $ContainerHeight = (sizeof($this->Event->appointments)*72)."px";
        $tempComponent->addAttribute("style", "height:".$ContainerHeight);
		
        $arr = $this->Event->appointments;
		if (sizeof($arr) > 0){
			$this->quicksort($arr, 0, sizeof($arr) - 1);
			$this->Event->appointments = $arr;		
		}
		
        for($i=0; $i<sizeof($this->Event->appointments);$i++){
            if($this->Event->appointments[$i]->id==$appToEdit){
                $tempSub = new AppointmentBoxEdit($this->Event->appointments[$i]);
            }else{
                $tempSub = new AppointmentBoxForm($this->Event->appointments[$i]);
            }

            $tempSub = $tempSub->getContainer();
            $tempComponent->addChild($tempSub);
        }
        if($appToEdit==-2){
                $tempSub = new AppointmentBoxEdit();
                $tempSub = $tempSub->getContainer();
                $tempComponent->addChild($tempSub);
        }
        $this->AppointmentInfo->addChild($tempComponent);
    }
    
    private function buildEventData(){
		$isOpen="checked";
		if($this->Event->isOpen){
			$isOpen="unchecked";
		}
        $EventLabelContainerClass = "div_DataBox";
        $EventLabelClass="lbl_eventlabel";
        $EventInfoClass="lbl_eventInfo";
        $EventLabelID = array('input_EventName','input_EventType','input_EventStartDate','input_EventEndDate','input_EventRecurring', 'input_EventOpen');
        $EventInputName = array('text','event_type','start_date','end_date','recurring', 'isOpen');
        $EventDivType = array('input', 'select', 'input', 'input', 'input', 'input');
        $EventValueType = array("value", "toSelect", "value", "value", "value", $isOpen);
        $EventInputType = array('text','text','text','text','checkbox', 'checkbox');
        $EventLabel = array('Name','Type','Start Date','End Date','Recurring', 'Status');
        $EventArray = array($this->Event->text, $this->Event->getEventTypeString(), $this->Event->getStartDate(), $this->Event->getEndDate(), $this->Event->getRecursionString(), $this->Event->isOpen);
     
        $EventLine="";
        
        $this->EventData = new html("form", null, self::EVENT_DATA_CLASS);

                for($i=0;$i<sizeof($EventArray);$i++){
                    $tempContainer= new html("div", $EventLabelContainerClass);
                    $tempTable = new html("table");
                    
                    $tempLabel = new html("td", $EventLabelClass);
                    $tempLabel->setText($EventLabel[$i].': ');
                    $tempTable->addChild($tempLabel);
                    
                    $tempLabel = new html("td", $EventInfoClass, $EventLabelID[$i]);
                    $tempInput = new html($EventDivType[$i], array("type"=>$EventInputType[$i], "name"=>$EventInputName[$i]));
                    $tempInput->addAttribute($EventValueType[$i], $EventArray[$i]);
                    $tempLabel->addChild($tempInput);
                    $tempTable->addChild($tempLabel);
                    
                    $tempContainer->addChild($tempTable);
                    $this->EventData->addChild($tempContainer);
                   }
    }
    
    private function getAppointmentDate(){
        $AppointmentDay = "No appointments";
        $cntr=($this->Event->appointments);
        $Appointments=$this->Event->appointments;
        if ($cntr >0){
        	$theDate = preg_split('/ /', $Appointments[0]->start_date);
        	$dateInfo = getDate(strtotime($theDate[0]));
        	//the day
        	$day = $dateInfo['mday'];
        	$temp = strval($day);
        	if(strlen ($temp) < 2){
        		$temp = '0'.$temp;
        	}
        
        	if ($temp[1] == 1 && $temp[0]!=1){
        		$day .= 'st';
        	}
        	elseif ($temp[1] == 2 && $temp[0]!=1){
        		$day .= 'nd';
        	}
        	elseif ($temp[1] == 3 && $temp[0]!=1){
        		$day .= 'rd';
        	}
        	else{
        		$day .=  'th';
        	}
        
        	$AppointmentDay=$dateInfo['weekday'] . " " . $dateInfo['month'] . " " . $day . " " . $dateInfo['year']; //$theDate[0];
            return $AppointmentDay; 
        }
    }
        
    private function partition($arr, $left, $right){
    	global $arr;
	
    	$i = $left;
    	$j = $right;	
    	$pivot = $arr[($left+$right)/2];
    	
    	$d1;
    	$d2;
    	$dpiv = date($pivot->start_date);
    	$temp;
    	while ($i <= $j){
			$a1 = $arr[$i];
    		$d1 = date($a1->start_date);
    		
    		while ($d1 < $dpiv){
    			$i++;
    			$a1 = $arr[$i];
				$d1 = date($a1->start_date);
    		}
    		
			$a2 = $arr[$j];
    		$d2 = date($a2->start_date);
    		
    		while ($d2 > $dpiv){
    			$j--;
    			$a2 = $arr[$j];
				$d2 = date($a2->start_date);
    		}
    
    		if ($i <= $j){
    			$temp = $arr[$i];
    			$arr[$i] = $arr[$j];
    			$arr[$j] = $temp;
    			
    			//logger("SWAPPED: " . $arr[$j][$part] . " WITH: " . $arr[$i][$part]);
    			$i++;
    			$j--;

    		}
    	}
    	return $i;
     }
     
     private function quicksort($arr, $left, $right){
    	global $arr;
		
    	$index = $this->partition($arr, $left, $right);
    	
    	if ($left < ($index-1)){
    		$this->quicksort($arr, $left, $index -1);
    	}
    	if ($index < $right){
    		$this->quicksort($arr, $index, $right);
    	}

     }
     
    public function getAppInfo(){
        return $this->AppointmentInfo;
    }
    public function getEventData(){
        return $this->EventData;
    }
}

?>