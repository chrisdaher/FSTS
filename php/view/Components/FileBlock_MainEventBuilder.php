<?php
$subFolder="/../../model/";
include_once($subFolder."Event.php");
$subFolder="";
include_once($subFolder."FileBlock_AbstractFactory.php");

class FileBlock_MainEventBuilder extends FileBlock_AbstractFactory{
    private $rows;
   
    private $FoundID;
    
    public function __construct($FoundID=null, $toMatch=null){
        $this->toMatch = $toMatch;
        if($FoundID!=null){
            $this->File = new Event($FoundID, false);
            $this->buildAttributeArray();
            $this->buildFile();
        }
    }
    
    protected function buildAttributeArray(){
        $this->AttributeArray = array(
                                    "class"=>self::MAIN_FILE_FOUND_CLASS,
                                    "hover"=>"enabled",
                                    "eventID"=>$this->File->event_id,
                                    "EventStartDate"=>$this->File->start_date,
                                    "EventEndDate"=>$this->File->end_date,
                                    "EventType"=>$this->File->event_type_id,
                                    "EventRecursive"=>$this->File->rec_type,
                                    "text"=>$this->File->text,
                                );
    }
    protected function buildFile(){
        $match=0;
        $this->Container = new html("div", $this->AttributeArray);
        $this->rows[0]=new html("tr", "mainResult_row1");
        $this->flagDiv = new html("button", "filefound_flag");
        
        $match += $this->buildID();
        $match += $this->buildName();
		$match += $this->buildInfoFound();
        $tempMatch = $match;
        
        $this->buildFlag();
        $this->matches=$match;
    }
    
    private function buildID(){
        $match=0;
        $FileID=$this->File->event_id;
        
        $div_container= new html ("td", "filefound_eid_container");
        
        $lbl_data = new html("label", "filefound_value", "filefound_id");
        $lbl_data->setText("$FileID");
        if($this->isMatch($FileID)){
            $match++;
            $lbl_data->addClass("match");
        }
        $div_container->addChild($lbl_data);
        $this->rows[0]->addChild($div_container);
        return $match;
    }
    private function buildName(){
        $match=0;
        $EventName=$this->File->event_name;
        $EventName = preg_split("/-/",$EventName);
		$EventName = $EventName[0];
		if(strlen($EventName)>18){
			$EventName = substr($EventName, 0, 15)."...";
		}
        $div_container= new html ("td", "filefound_name_container");
        
        $lbl_data = new html("label", "filefound_value", "filefound_first");
        $lbl_data->setText("$EventName");
        if($this->isMatch($EventName)){
            $match++;
            $lbl_data->addClass("match");
        }
        $div_container->addChild($lbl_data);
        
        $this->rows[0]->addChild($div_container);
        return $match;
    }
    
    private function buildInfoFound(){
        $match=0;
        $Day="Monday";
        $Month="February";
        $Date="2nd";
        $Year="2011";
        $EventType = $this->File->getEventTypeString();
		
		
        
        $div_container= new html ("td", "filefound_start_date_container");
        $lbl_data = new html("label", "filefound_value", "filefound_start");

		$lbl_data->setText($this->File->getStartDate());
		if ($this->isMatch($this->File->getStartDate())){
			$match++;
			$lbl_data->addClass("match");
		}
		
        $div_container->addChild($lbl_data);
        $this->rows[0]->addChild($div_container);
        
        $div_container= new html ("td", "filefound_end_date_container");
        $lbl_data = new html("label", "filefound_value", "filefound_end");
		$lbl_data->setText($this->File->getEndDate());
		if ($this->isMatch($this->File->getEndDate())){
			$match++;
			$lbl_data->addClass("match");
		}
		
        $div_container->addChild($lbl_data);
        $this->rows[0]->addChild($div_container);
        // $lbl_data->setText("$Year");
        // if($this->isMatch($Year)){
            // $match++;
            // $lbl_data->addClass("match");
        // }
		
        
        
        $div_container= new html ("td", "filefound_type_container");
        $lbl_data = new html("label", "filefound_value", "filefound_type");
        $lbl_data->setText("$EventType");
		
        if($this->isMatch($EventType)){
            $match++;
            $lbl_data->addClass("match");
        }
        $div_container->addChild($lbl_data);
        $this->rows[0]->addChild($div_container);
        return $match;
    }
    private function buildFlag(){
        $div_container= new html ("td", "filefound_flag_container");
        //$div_container->addAttribute("rowspan", "2");
        //$div_container->addChild($this->flagDiv);
        $this->rows[0]->addChild($div_container);
    }
    protected function render(){
        $table = new html("table", "resultFound_table");
        $table->addChildren($this->rows);
        $this->Container->addChild($table);
    }
    
}

?>