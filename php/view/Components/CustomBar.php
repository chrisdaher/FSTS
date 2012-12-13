<?php

include_once("Bar.php");
class CustomBar extends Bar{
    const WIDGET_CONTAINER_CLASS= "widget_container";
    
    private $WidgetContainerID;
    
    private $WidgetContainer;

    public function __construct($name, $attributes=null, $type="div"){
        parent::__construct($name, $attributes, $type);
        
        $this->WidgetContainerID=$name."_".self::WIDGET_CONTAINER_CLASS;
        
        $this->WidgetContainer=new html("div", self::WIDGET_CONTAINER_CLASS, $this->WidgetContainerID);
    }
    
    public function removeWidgetBy($attr, $value){
        $this->WidgetContainer->removeChildBy($attr,$value);
        $this->removeFromWidgetBy($attr, $value);
    }
    public function addWidget($toAdd){
        $toAdd=$this->addToWidget($toAdd);
        $this->WidgetContainer->addChild($toAdd);
    }
}

?>