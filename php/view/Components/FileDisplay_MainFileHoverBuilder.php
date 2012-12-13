<?php
$subFolder="";
include_once($subFolder."FileDisplay_AbstractFactory.php");
class FileDisplay_MainFileHoverBuilder extends FileDisplay_AbstractFactory{
    
    
    public function __construct($FileID=null, $searchString=null){
        parent::__construct($FileID, $searchString);
    }
    public function BuildFullDisplay(){
        $this->Container->addChild($this->getMainInfoContainer());
        $this->Container->addChild($this->getDependentInfoContainer());
    }
    public function BuildMainInfo(){
        $div_ids = array(
            self::CONTAINER_MAIN_DATA_CLASS."_id",
            self::CONTAINER_MAIN_DATA_CLASS."_name",
            self::CONTAINER_MAIN_DATA_CLASS."_medicard",
            self::CONTAINER_MAIN_DATA_CLASS."_addr",
            self::CONTAINER_MAIN_DATA_CLASS."_pcode",
            self::CONTAINER_MAIN_DATA_CLASS."_region",
            self::CONTAINER_MAIN_DATA_CLASS."_age",
            self::CONTAINER_MAIN_DATA_CLASS."_marital",
            self::CONTAINER_MAIN_DATA_CLASS."_work"
        );
        $info= array(
                array("ID: ",$this->File->independent->id),
                array($this->File->independent->first_name,$this->File->independent->last_name),
                array($this->File->independent->medicard),
                array($this->File->file_info->addr_nb,$this->File->file_info->addr_street),
                array($this->File->file_info->addr_pcode),
                array($this->File->file_info->addr_city,$this->File->file_info->addr_prov),
                array($this->File->independent->dateBirth),//, "years", "old"),
                array($this->File->independent->getMaritalStatus()),
                array($this->File->independent->getWorkStatus())
        );
        $this->buildInfo($info, self::CONTAINER_MAIN_DATA_CLASS, $div_ids, $this->MainContainer);

    }
    public function BuildDependentInfo(){
        $dependents = $this->File->dependents;
        $div_ids = array(
            self::CONTAINER_DEP_DATA_CLASS."_id",
            self::CONTAINER_DEP_DATA_CLASS."_name",
            self::CONTAINER_DEP_DATA_CLASS."_medicard",
            self::CONTAINER_DEP_DATA_CLASS."_age",
        );
        $tempContainer = new html("div", "div_DependentsCounter");
        $tempLabel = new html("label", "lbl_DependentsCounter");
        $tempLabel->setText("Dependents(".sizeof($dependents).")");
        $tempContainer->addChild($tempLabel);
        $this->DependentContainer->addChild($tempContainer);
        for($i=0;$i<sizeof($dependents);$i++){
            $info= array(
                    array("ID: ".$dependents[$i]->id, $dependents[$i]->first_name,$dependents[$i]->last_name, $dependents[$i]->medicard, $dependents[$i]->age." years old"),
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