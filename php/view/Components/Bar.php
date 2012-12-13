<?php
include_once("html.php");
abstract class Bar{
    const WIDGET_CLASS = "WIDGET_CLASS";
    protected $Name;
    protected $Container;
    protected $Widgets;
       
    abstract public function toHTML();   
       
    public function __construct($name, $attributes=null, $type="div"){
        $this->Name=$name;
        $this->Container= new html($type);
        $this->Container->addMultipleAttributes($attributes);
    }  
    
    public function getWidgets(){
        return $this->Widgets;
    }
    public function getWidgetBy($attr, $value){
        $tempArr = $this->getWidgets();
        $toRet=null;
        if(sizeof($tempArr)>0){
            for($i=0;$i<sizeof($tempArr);$i++){
                $toCheck=$tempArr[$i]->getAttribute($attr);
                if($attr==$value){
                    $toRet=$tempArr[$i];
                }
            }
        }
        return $toRet;
    }
    public function getWidgetIndexBy($attr, $value){
        $tempArr = $this->getWidgets();
        $toRet=null;
        if(sizeof($tempArr)>0){
            for($i=0;$i<sizeof($tempArr);$i++){
                $toCheck=$tempArr[$i]->getAttribute($attr);
                if($attr==$value){
                    $toRet=$i;
                }
            }
        }
        return $toRet;
    }
    
    public function getContainer(){
        return $this->Container;
    }
    
    public function setContainer($type, $class=null, $id=null){
        $this->Container=new html($type, $class, $id);
    }
    
    protected function addToWidget($toAdd){
        $currentSize=sizeof($this->getWidgets());
        if(is_array($toAdd)){
            for($i=0;$i<sizeof($toAdd);$i++){
                $toAdd[$i]->addClass(self::WIDGET_CLASS);
                $toAdd[$i].toJQuery();
                $this->Widgets[$currentSize]=$toAdd[$i];
            }
        }else{
            $toAdd->addClass(self::WIDGET_CLASS);
            $this->Widgets[$currentSize]=$toAdd;
        }
        return $toAdd;
    }
    protected function removeFromWidgetBy($attr, $value){
        $toRemove=$this->getWidgetIndexBy($attr, $value);
        if($toRemove!=null){
            unset($Widgets[$toRemove]);
            $Widgets=array_values($Widgets);
        }
    }

     

}

?>
