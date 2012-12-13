<?php

class Accordion{
    private $Accordion;
    
    public function __construct($elementType="div", $class="accordion"){
        $this->Accordion = new html($elementType, $class);
        $Section = array();
    }
    
    public function addSection($SectionTitle, $ElementArray){
        $SectionH = new html("h1");
        $Section = new html("a","report_section" ,"section_".$SectionTitle);
        $Section->setText($SectionTitle);
        $SectionContainer = new html("div", "report_param_container");
        
        for($i=0;$i<sizeof($ElementArray);$i++){
            $SectionContainer->addChild($ElementArray[$i]);
        }
        
        $SectionH->addChild($Section);
        $this->Accordion->addChild($SectionH);
        $this->Accordion->addChild($SectionContainer);
    }
    
    public function getContainer(){
        return $this->Accordion;
    }
}


?>