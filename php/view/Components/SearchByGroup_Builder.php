<?php

class SearchByGroup_Builder{
    const CONTAINER_ID ="div_SearchByGroup";
    const RADIO_BUTTON_ID = "radio";
    const RADIO_LABEL_ID = "label_radio";
    
    private $container;
    
    public function __construct(){
        $this->container = new html("div",null, self::CONTAINER_ID);
        
        $this->buildRadioButtons();
    }
    
    private function buildRadioButtons(){
        $radioButtonTextArray = array("File", "Event");
        
        for($i=1;$i<=sizeof($radioButtonTextArray);$i++){
            $buttonAttributes = array ("type" => "radio", "id" => self::RADIO_BUTTON_ID.$i , "name"=>"radio" );
            $labelAttributes = array("id"=>self::RADIO_LABEL_ID.$i, "for"=>self::RADIO_BUTTON_ID.$i);
            $tempRadioButton = new html("input", $buttonAttributes);
            $tempRadioLabel = new html("label", $labelAttributes);
            $tempRadioLabel->addClass("SearchByButton");
            $tempRadioLabel->addAttribute("searchBy", $radioButtonTextArray[$i-1]);
            $tempRadioLabel->setText($radioButtonTextArray[$i-1]);
            
            $this->container->addChild($tempRadioButton);
            $this->container->addChild($tempRadioLabel);   
        }    
    }
    
    public function getContainer(){
        return $this->container;
    }
    
    public function display(){
        print($this->getContainer()->toHTML());
    }
}

?>