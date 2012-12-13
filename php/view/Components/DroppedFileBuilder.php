<?php
$subFolder="";
include_once($subFolder."FileBlock_AbstractFactory.php");

class DroppedFileBuilder extends FileBlock_AbstractFactory{
    const DROPPED_BAR = "div_DroppedBar";
    const DROPPED_INFO = "div_DroppedInfo";
    
    const I_IMAGE_PATH = "Images/i.png";
    const DROPPED_STATUS = "div_DroppedStatus";
    const DROPPED_REMOVE = "btn_DroppedRemove";
    const DROPPED_ERROR_BTN = "div_DroppedError";
    const DROPPED_ERROR_IMG = "img_DroppedError";
    const DROPPED_HIDDEN_ERROR = "hiddenError";
    const DROPPED_ID = "div_DroppedID";
    
    private $div_bar;
    private $div_info;
    
    public function __construct($FileID=null){
        parent::__construct($FileID);
        $this->buildAttributeArray();
        $this->buildFile();
    }
    
    protected function buildAttributeArray(){
        $this->AttributeArray = array(
                                    "class"=>self::MINI_FILE_DROPPED_CLASS,
                                    "fileID"=>$this->File->id,
                                    "StreetNumber"=>$this->File->file_info->addr_nb,
                                    "StreetName"=>$this->File->file_info->addr_street,
                                    "City"=>$this->File->file_info->addr_city,
                                    "Province"=>$this->File->file_info->addr_prov,
                                    "PostalCode"=>$this->File->file_info->addr_pcode
                                );
    }
    protected function buildFile(){
        $match=0;
        $this->Container = new html("div", $this->AttributeArray);
        $this->div_bar=new html("div", self::DROPPED_BAR);
        $this->div_info=new html("div", self::DROPPED_INFO);
        
        $this->buildBar();
        $this->buildInfo();
        
        $this->matches=$match;
    }
    
    private function buildBar(){
        $FileID=$this->File->id;
        $tempContent=new html("div", self::DROPPED_STATUS);
        $this->div_bar->addChild($tempContent);
        
        $tempContent=new html("button", self::DROPPED_REMOVE);
        $tempContent->addAttribute("fileID", $FileID);
        $tempContent->toJQuery("button");
        $this->div_bar->addChild($tempContent);
        
        $tempContent=new html("div", self::DROPPED_ERROR_BTN);
        $tempContent->addAttribute("fileID", $FileID);
        $tempImage = new html("img", self::DROPPED_ERROR_IMG);
        $tempImage->addAttribute("src", self::I_IMAGE_PATH);
        $tempImage->addClass(self::DROPPED_HIDDEN_ERROR);
        $tempContent->addChild($tempImage);
        $this->div_bar->addChild($tempContent);
        
    }
    private function buildInfo(){
        $FileID=$this->File->id;
        
        $tempContent=new html("div", self::DROPPED_ID);
        $tempContent->setText($FileID);
        $this->div_info->addChild($tempContent);
    }
    
    protected function render(){
        $this->Container->addChild($this->div_bar);
        $this->Container->addChild($this->div_info);
    }
   
}

?>