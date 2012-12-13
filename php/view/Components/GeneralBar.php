<?php
include_once("Bar.php");
class GeneralBar extends Bar{
    const LEFT_CONTAINER_CLASS= "widget_container_left";
    const CENTER_CONTAINER_CLASS= "widget_container_center";
    const RIGHT_CONTAINER_CLASS= "widget_container_right";
    
    private $LeftContainerID;
    private $CenterContainerID;
    private $RightContainerID;
    
    private $left;
    private $center;
    private $right;
    
    protected $Wrapper;
       
    public function __construct($name, $attributes=null, $type="table"){
        parent::__construct($name, null, $type);
        
        $this->Wrapper= new html("div", "Wrapper");
        $this->Wrapper->addMultipleAttributes($attributes);
        
        $this->LeftContainerID=$name."_".self::LEFT_CONTAINER_CLASS;
        $this->CenterContainerID=$name."_".self::CENTER_CONTAINER_CLASS;
        $this->RightContainerID=$name."_".self::RIGHT_CONTAINER_CLASS;
        
        $this->left= new html("td",self::LEFT_CONTAINER_CLASS ,$this->LeftContainerID);
        $this->center= new html("td",self::CENTER_CONTAINER_CLASS ,$this->CenterContainerID);
        $this->right= new html("td",self::RIGHT_CONTAINER_CLASS ,$this->RightContainerID);
    }       

    public function getLeft(){
        return $this->left;
    }
    public function getCenter(){
        return $this->center;
    }
    public function getRight(){
        return $this->right;
    }
    public function getWidgetIndexFromLeftBy($attr, $value){
        $toGet = $this->getLeft();
        $toRet=$toGet->getChildIndexBy($attr,$value);
        return $toRet;
    }
    public function getWidgetIndexFromCenterBy($attr, $value){
        $toGet = $this->getCenter();
        $toRet=$toGet->getChildIndexBy($attr,$value);
        return $toRet;
    }
    public function getWidgetIndexFromRightBy($attr, $value){
        $toGet = $this->getRight();
        $toRet=$toGet->getChildIndexBy($attr,$value);
        return $toRet;
    }
    
    public function addLeft($toAdd){
        $toAdd=$this->addToWidget($toAdd);
        if(sizeof($toAdd)>1){
            $this->getLeft()->addChildren($toAdd);
        }else{
            $this->getLeft()->addChild($toAdd);
        }
    }
    public function addCenter($toAdd){
        $toAdd=$this->addToWidget($toAdd);
        if(sizeof($toAdd)>1){
            $this->getCenter()->addChildren($toAdd);
        }else{
            $this->getCenter()->addChild($toAdd);
        }
    }
    public function addRight($toAdd){
        $toAdd=$this->addToWidget($toAdd);

        if(sizeof($toAdd)>1){
            $this->getRight()->addChildren($toAdd);
        }else{
            $this->getRight()->addChild($toAdd);
        }
    }
    
    
    
    public function removeFromLeft($attr, $value){
        $removeFromWidgetBy($attr, $value);
        $this->getLeft()->removeChildBy($attr, $value);
    }
    public function removeFromCenter($attr, $value){
        $removeFromWidgetBy($attr, $value);
        $this->getCenter()->removeChildBy($attr, $value);
    }
    public function removeFromRight($attr, $value){
        $removeFromWidgetBy($attr, $value);
        $this->getRight()->removeChildBy($attr, $value);
    }
    
    public function getContainer(){
        $Container = parent::getContainer();
        
        $Container->addChild($this->getLeft());
        $Container->addChild($this->getCenter());
        $Container->addChild($this->getRight());
        
        $this->Container = $Container;
        
        $this->Wrapper->addChild($Container);
        return $this->Wrapper;
    }
    public function toHTML(){


        $toRet=$this->Container->toHTML();
        return $toRet; 
    }
}

?>