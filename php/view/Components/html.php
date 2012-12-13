<?php

class html{
    
    var $elementType;
    var $attributes;
    var $children;
    var $text;
    
    function __construct($tagType="div", $AttributeArray_or_Class=null, $addID=null){
        $this->elementType=$tagType;
        if($AttributeArray_or_Class!=null){
            if(is_array($AttributeArray_or_Class)){
                foreach($AttributeArray_or_Class as $key => $value){
                    $this->addAttribute($key,$value);
                }
            }else{
                $this->addAttribute("class",$AttributeArray_or_Class);
            }
        }
        if($addID!=null){
            $this->addAttribute("id",$addID);
        }
    }
    
    //SETTERS
    public function setID($toSet){
        $this->addAttribute("id",$toSet);;
    }
    public function setClass($toSet){
        $this->addAttribute("class",$toSet);
    }
    public function setType($toSet){
        $this->elementType=$toSet;
    }
    public function setText($toSet){
        $this->text = $toSet;
    }

    
    //GETTERS
    public function getID(){
        return $this->getAttribute("id");
    }
    public function getClass(){
        return $this->getAttribute("class");
    }
    public function getType(){
        return $this->elementType;
    }
    public function getText(){
        return $this->text;
    }
    public function getAttribute($attrName){
        $toRet = null;
        if(isset($this->attributes[$attrName])){
            $toRet = $this->attributes[$attrName];
        }
        return $toRet;
    }
    public function getAttributes(){
        return $this->attributes;
    }
    public function getChildren(){
        return $this->children;
    }
    
    //Adding
    public function addClass($toAdd){
        $this->addAttribute("class",$toAdd);
    }
    public function addAttribute($attrName,$toSet){
        $toAdd = $toSet;
        if($attrName == "class"){
            $current = $this->getAttribute("class");
            $toAdd = $current." ".$toAdd;
            $this->attributes[$attrName]=$toAdd;
        }else{
            $this->attributes[$attrName]=$toAdd;
        }
    }
    public function addMultipleAttributes($attrArray){
        if($attrArray!=null && sizeof($attrArray)>0){
            foreach($attrArray as $key => $value){
                $this->addAttribute($key,$value);
            }
        }
    }
    public function addChildren($elements){
        for($i=0;$i<sizeof($elements); $i++){
            $this->children[sizeof($this->children)] = $elements[$i];
        }
    }
    public function addChild($element){
        $this->children[sizeof($this->children)] = $element;
    }
    //Remove
    public function removeChildBy($attr, $value){
        $toRemove=$this->getChildIndexBy($attr, $value);
        if($toRemove!=null){
            unset($this->children[$toRemove]);
            $this->children=array_values($this->children);
        }
    }
    public function removeChildren(){
        for($i=0; $i<sizeof($this->children);$i++){
            $toRemove=$i;
            unset($this->children[$toRemove]); 
        }
        $this->children=null;
    }
    public function removeChildByIndex($index){
        $toRemove=$index;
        if($toRemove!=null){
            unset($this->children[$toRemove]);
            $this->children=array_values($this->children);
        }
    }
    public function removeAttribute($attrName){
        unset($this->attributes[$attrName]);
    }
    
    public function removeClass($toRemove){
        $this->attributes["class"]=str_replace($toRemove,"" , $this->attributes["class"] );
    }

    //Getting
    public function getChildIndexBy($attr, $value){
        $tempArr = $this->getChildren();
        $toRet=null;
		for($i=0;$i<sizeof($tempArr);$i++){
			$toCheck=$tempArr[$i]->getAttribute($attr);
			if($toCheck==$value){
				$toRet=$i;
			}
		}

        return $toRet;
    }
    public function getSingleLevelChildBy($attribute, $value){
        $tempArray=$this->getChildren();
        $toRet=null;
        if(sizeof($tempArray)>0){
            for($i=0;$i<sizeof($tempArray);$i++){
                $toCheck=$tempArray[$i]->getAttribute($attribute);
                if($toCheck==$value){
                    $toRet= $tempArray[$i];
                }
            }
        }
        return $toRet;
    }
    public function getChildBy($attribute, $value){
        $tempArray=$this->getChildren();
        $toRet=null;
        if(sizeof($tempArray)>0){
            for($i=0;$i<sizeof($tempArray);$i++){
                $toCheck=$tempArray[$i]->getAttribute($attribute);
                if($toCheck==$value){
                    $toRet= $tempArray[$i];
                }
            }
            if($toRet=null){
                for($i=0;$i<sizeof($tempArray);$i++){
                    $toRet=$tempArray->getChildBy($attribute,$value);
                }
            }
        }
        return $toRet;
    }
    
    //Other
    public function AttributesToHTML(){
        $_attributes="";
        $tempArray=$this->getAttributes();
        if(sizeof($tempArray)>0){
            foreach ($tempArray as $key => $value){
                $_attributes=$_attributes.$key."=\"".$value."\" ";     
            }
        }
        return $_attributes;
    }
    public function ChildrenToHTML(){
        $_children="";
        $tempArray=$this->getChildren();
        for($i=0;$i<sizeof($tempArray);$i++){
            if($tempArray[$i]!=null){
                $_children=$_children.$tempArray[$i]->toHTML();
            }
        }
        return $_children;
    }
    public function toHTML(){
        
        $_elementType = $this->getType();
        $_text = $this->text;
        $_children=$this->ChildrenToHTML();
        $_attributes=$this->AttributesToHTML();

        $toRet = "<".$_elementType." ".$_attributes.">".
                    $_text.
                    $_children.
                    "</".$_elementType.">";
        return $toRet;
    }
	public function toText(){
        
        $_elementType = $this->getType();
        $_text = $this->text;
        $_children=$this->ChildrenToText();
        $_attributes=$this->AttributesToHTML();

        $toRet = "< ".$_elementType." ".$_attributes.">".
                    $_text.
                    $_children.
                    "</ ".$_elementType.">";
        return $toRet;
    }
	public function ChildrenToText(){
        $_children="";
        $tempArray=$this->getChildren();
        for($i=0;$i<sizeof($tempArray);$i++){
            if($tempArray[$i]!=null){
                $_children=$_children.$tempArray[$i]->toText();
            }
        }
        return $_children;
    }
    
    public function toJQuery($component){
        $this->addClass("JQuery_".$component);
    }
    
}

?>