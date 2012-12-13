<?php
$subFolder="";
include_once($subFolder."FileDisplay_AbstractFactory.php");
class FileDisplay_MainEventHoverBuilder extends FileDisplay_AbstractFactory{
    
    
    public function __construct($FileID=null, $searchString=null){
        parent::__construct(null, $searchString);
        $this->File = new Event($FileID, true);
    }
    public function BuildFullDisplay(){
        $this->Container->addChild($this->getMainInfoContainer());
        $this->Container->addChild($this->getDependentInfoContainer());
    }
    public function BuildMainInfo(){
        $div_ids = array(
            self::CONTAINER_MAIN_DATA_CLASS."_id",
            self::CONTAINER_MAIN_DATA_CLASS."_name",
            self::CONTAINER_MAIN_DATA_CLASS."_Date",
            self::CONTAINER_MAIN_DATA_CLASS."_EventType",
            self::CONTAINER_MAIN_DATA_CLASS."_Recursive",
        );
		$EventName = $this->File->event_name;
		$EventName = preg_split("/-/", $EventName);
		$EventName = $EventName[0];
        $info= array(
                array("ID: ",$this->File->event_id),
                array($EventName),
                array($this->File->start_date, $this->File->end_date),
                array($this->File->getEventTypeString()),
                array($this->File->getRecursionString())
                );

        $this->buildInfo($info, self::CONTAINER_MAIN_DATA_CLASS, $div_ids, $this->MainContainer);

    }
    public function BuildDependentInfo(){
        $dependents = $this->File->appointments;
        $div_ids = array(
            self::CONTAINER_DEP_DATA_CLASS."_id",
            self::CONTAINER_DEP_DATA_CLASS."_time",
            self::CONTAINER_DEP_DATA_CLASS."_size",
            self::CONTAINER_DEP_DATA_CLASS."_capacity",
        );
        $tempContainer = new html("div", "div_DependentsCounter");
        $tempLabel = new html("label", "lbl_DependentsCounter");
        $tempLabel->setText("Appointments(".sizeof($dependents).")");
        $tempContainer->addChild($tempLabel);
        $this->DependentContainer->addChild($tempContainer);
        for($i=0;$i<sizeof($dependents);$i++){
            $info= array(
                    array("ID: ".$dependents[$i]->id, $dependents[$i]->getStartTime()." to ".$dependents[$i]->getEndTime(),$dependents[$i]->size." of", $dependents[$i]->capacity),
            );

            
            $tempContainer = new html("div", "DependentContainer");
            $this->buildInfo($info, self::CONTAINER_DEP_DATA_CLASS, $div_ids, $tempContainer);
            $this->DependentContainer->addChild($tempContainer);
        }
    }
    private function buildInfo($info, $class, $div_ids, $container){
        for($i=0;$i<sizeof($info);$i++){
            $tempContainer = new html("div", $class, $div_ids[$i]);
            for($j=0;$j<sizeof($info[$i]);$j++){
                $tempData = new html("label", $class."_label");
				
                if($this->isMatch($info[$i][$j])){
                    $tempData->addClass("match");
                }
                $tempData->setText($info[$i][$j]);
                $tempContainer->addChild($tempData);
            }
            $container->addChild($tempContainer);
        }
        
    }
}

?>