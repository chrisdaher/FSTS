<?php
$subFolder="/../../model/";
include_once($subFolder."User.php");
$subFolder="";
include_once($subFolder."FileBlock_AbstractFactory.php");

class MiniFileFoundBuilder extends FileBlock_AbstractFactory{
    private $rows;
    
    private $User;
    private $EventID;
    
    public function __construct($UserID=null, $toMatch=null, $EventID=null){
        $this->User =  new User($UserID, false); 
        $FileID = $this->User->family_id;
        if($EventID != null){
            $this->EventID = $EventID;
        }
        parent::__construct($FileID, $toMatch);
        
        if($this->File!=null){
            $this->File->loadEvents(false);
        
            $this->buildAttributeArray();
            $this->buildFile($this->EventID);
        }
    }
    
    protected function buildAttributeArray(){
        $this->AttributeArray = array(
                                    "class"=>self::MINI_FILE_FOUND_CLASS,
                                    "fileID"=>$this->File->id,
                                    "FirstName"=>$this->User->first_name,
                                    "LastName"=>$this->User->last_name,
                                    "StreetNumber"=>$this->File->file_info->addr_nb,
                                    "StreetName"=>$this->File->file_info->addr_street,
                                    "City"=>$this->File->file_info->addr_city,
                                    "Province"=>$this->File->file_info->addr_prov,
                                    "PostalCode"=>$this->File->file_info->addr_pcode
                                );
    }
    protected function buildFile($EventID=null){
        $match=0;
        $this->Container = new html("div", $this->AttributeArray);
        $this->rows=null;
        
        $EventArray = $this->File->events;
        for($i=0; $i<sizeof($EventArray);$i++){
            if($EventID==$EventArray[$i]->event_id){
                $this->Container->addClass(self::MINI_FILE_FOUND_DISABLED);
            }
        }
        
        
        $match += $this->buildID();
        $match += $this->buildName();
        $match += $this->buildInfoFound();
        
        $this->matches=$match;
    }
    
    private function buildID(){
        $match=0;
        $FileID=$this->File->id;
        
        $div_container= new html ("div", "filefound_div_id");
        
        $lbl_info = new html("label", "filefound_lbl");
        $lbl_info->setText("File ID : ");
        $div_container->addChild($lbl_info);
        
        $lbl_data = new html("label", "filefound_value", "filefound_id");
        $lbl_data->setText("$FileID");
        if($this->isMatch($FileID)){
            $match++;
            $lbl_data->addClass("match");
        }
        $div_container->addChild($lbl_data);
        $this->rows[sizeof($this->rows)]=$div_container;
        return $match;
    }
    private function buildName(){
        $match=0;
        $User=$this->User;
        $FirstName=$User->first_name;
        $LastName = $User->last_name;
        
        $div_container= new html ("div", "filefound_div_name");
        
        $lbl_info = new html("label", "filefound_lbl");
        $lbl_info->setText("Name: ");
        $div_container->addChild($lbl_info);
        
        $lbl_data = new html("label", "filefound_value", "filefound_first");
        $lbl_data->setText("$FirstName ");
        if($this->isMatch($FirstName)){
            $match++;
            $lbl_data->addClass("match");
        }
        $div_container->addChild($lbl_data);
        
        $lbl_data = new html("label", "filefound_value", "filefound_last");
        $lbl_data->setText("$LastName ");
        if($this->isMatch($LastName)){
            $match++;
            $lbl_data->addClass("match");
        }
        $div_container->addChild($lbl_data);
        $this->rows[sizeof($this->rows)]=$div_container;
        return $match;
    }
    
    private function buildInfoFound(){
        $match=0;
        $StreetNumber=$this->File->file_info->addr_nb;
        $StreetName=$this->File->file_info->addr_street;
        $City=$this->File->file_info->addr_city;
        $Province=$this->File->file_info->addr_prov;
        $PostalCode=$this->File->file_info->addr_pcode;

        $div_container= new html ("div", "filefound_div_info");
        
        $lbl_info = new html("label", "filefound_lbl");
        $lbl_info->setText("Address: ");
        $div_container->addChild($lbl_info);
        
        $lbl_data = new html("label", "filefound_value", "filefound_number");
        $lbl_data->setText("$StreetNumber ");
        if($this->isMatch($StreetNumber)){
            $match++;
            $lbl_data->addClass("match");
        }
        $div_container->addChild($lbl_data);
        
        $lbl_data = new html("label", "filefound_value", "filefound_name");
        $lbl_data->setText("$StreetName ");
        if($this->isMatch($StreetName)){
            $match++;
            $lbl_data->addClass("match");
        }
        $div_container->addChild($lbl_data);
        
        $lbl_data = new html("label", "filefound_value", "filefound_postal");
        $lbl_data->setText("$PostalCode ");
        if($this->isMatch($PostalCode)){
            $match++;
            $lbl_data->addClass("match");
        }
        $div_container->addChild($lbl_data);
        
        $lbl_data = new html("label", "filefound_value", "filefound_city");
        $lbl_data->setText("$City ");
        if($this->isMatch($City)){
            $match++;
            $lbl_data->addClass("match");
        }
        $div_container->addChild($lbl_data);
        
        $lbl_data = new html("label", "filefound_value", "filefound_province");
        $lbl_data->setText("$Province ");
        if($this->isMatch($Province)){
            $match++;
            $lbl_data->addClass("match");
        }
        $div_container->addChild($lbl_data);
        $this->rows[sizeof($this->rows)]=$div_container;
        return $match;
    }
    protected function render(){
        $this->Container->addChildren($this->rows);
    }
    
}

?>