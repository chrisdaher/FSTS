<?php
$subFolder="/../../model/";
include_once($subFolder."User.php");
$subFolder="";
include_once($subFolder."FileBlock_AbstractFactory.php");

class FileBlock_MainFileBuilder extends FileBlock_AbstractFactory{
    private $rows;
   
    private $flagDiv;
    private $FoundID;
    
    public function __construct($FoundID=null, $toMatch=null){
        parent::__construct($FoundID, $toMatch);
        if($this->File!=null){
            $this->File->loadIndependent(false);
            $this->File->loadDependents(false);
            $this->buildAttributeArray();
            $this->buildFile();
        }
    }
    
    protected function buildAttributeArray(){
        $this->AttributeArray = array(
                                    "class"=>self::MAIN_FILE_FOUND_CLASS,
                                    "hover"=>"enabled",
                                    "fileID"=>$this->File->id,
                                    "FirstName"=>$this->File->independent->first_name,
                                    "LastName"=>$this->File->independent->last_name,
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
        $this->rows[0]=new html("tr", "mainResult_row1");
        $this->rows[0]=new html("tr", "mainResult_row1");
		$this->rows[0]=new html("td", "mainResult_td1");
        $this->flagDiv = new html("button", "filefound_flag");
        
        $match += $this->buildID();
        $match += $this->buildName();
        $match += $this->buildInfoFound();
        $tempMatch = $match;
        //if($match<1){
            $match += $this->buildDependents();
        //}

        if($tempMatch>0 && $match>$tempMatch){
            $this->flagDiv->addClass("InBoth");
            $this->flagDiv->addAttribute("title", "Found in Both");
        }elseif($tempMatch>0 && $match==$tempMatch){
            $this->flagDiv->addClass("OnlyInMain");
            $this->flagDiv->addAttribute("title", "Found in Main");
        }else{
            $this->flagDiv->addClass("OnlyInHover");
            $this->flagDiv->addAttribute("title", "Found in Hover");
        }
        $this->buildFlag();
        $this->matches=$match;
    }
    
    private function buildID(){
        $match=0;
        $FileID=$this->File->id;
        
        $div_container= new html ("td", "filefound_id_container");
        
        $lbl_info = new html("label", "filefound_lbl");
        $lbl_info->setText("");
        $div_container->addChild($lbl_info);
        
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
        $User=$this->File->independent;
        $FirstName=$User->first_name;
        $LastName = $User->last_name;
        if(strlen($FirstName)>18){
			$FirstName = substr($FirstName, 0, 15)."...";
		}
		if(strlen($LastName)>18){
			$LastName = substr($LastName, 0, 15)."...";
		}
        $div_container= new html ("td", "filefound_fname_container");
        
        $lbl_data = new html("label", "filefound_value", "filefound_first");
        $lbl_data->setText("$FirstName");
        if($this->isMatch($FirstName)){
            $match++;
            $lbl_data->addClass("match");
        }
        $div_container->addChild($lbl_data);
        $this->rows[0]->addChild($div_container);
        
        $div_container= new html ("td", "filefound_lname_container");
        $lbl_data = new html("label", "filefound_value", "filefound_last");
        $lbl_data->setText("$LastName");
        if($this->isMatch($LastName)){
            $match++;
            $lbl_data->addClass("match");
        }
        $div_container->addChild($lbl_data);
        $this->rows[0]->addChild($div_container);
        return $match;
    }
    
    private function buildInfoFound(){
        $match=0;
        $StreetNumber=$this->File->file_info->addr_nb;
        $StreetName=$this->File->file_info->addr_street;
        $City=$this->File->file_info->addr_city;
        $Province=$this->File->file_info->addr_prov;
        $PostalCode=$this->File->file_info->addr_pcode;

        $div_container= new html ("td", "filefound_addr_num_container");
        
        $lbl_data = new html("label", "filefound_value", "filefound_number");
        $lbl_data->setText("$StreetNumber");
        if($this->isMatch($StreetNumber)){
            $match++;
            $lbl_data->addClass("match");
        }
        $div_container->addChild($lbl_data);
        $this->rows[0]->addChild($div_container);
        $div_container= new html ("td", "filefound_addr_name_container");
        
        $lbl_data = new html("label", "filefound_value", "filefound_name");
        $lbl_data->setText("$StreetName");
        if($this->isMatch($StreetName)){
            $match++;
            $lbl_data->addClass("match");
        }
        $div_container->addChild($lbl_data);
        $this->rows[0]->addChild($div_container);
        
        $div_container= new html ("td", "filefound_addr_pcode_container");
        $lbl_data = new html("label", "filefound_value", "filefound_postal");
        $lbl_data->setText("$PostalCode");
        if($this->isMatch($PostalCode)){
            $match++;
            $lbl_data->addClass("match");
        }
        $div_container->addChild($lbl_data);
        $this->rows[0]->addChild($div_container);
        
        $div_container= new html ("td", "filefound_city_container");
        $lbl_data = new html("label", "filefound_value", "filefound_city");
        $lbl_data->setText("$City");
        if($this->isMatch($City)){
            $match++;
            $lbl_data->addClass("match");
        }
        $div_container->addChild($lbl_data);
        $this->rows[0]->addChild($div_container);
        
        $div_container= new html ("td", "filefound_addr_province_container");
        $lbl_data = new html("label", "filefound_value", "filefound_province");
        $lbl_data->setText("$Province");
        if($this->isMatch($Province)){
            $match++;
            $lbl_data->addClass("match");
        }
        $div_container->addChild($lbl_data);
        $this->rows[0]->addChild($div_container);
        return $match;
    }
    private function buildDependents(){
        $match=0;
		
        $dependents=$this->File->dependents;
		$lbl_data = new html("label", "filefound_value", "filefound_number");
        for($i=0; $i<sizeof($dependents);$i++){
            $toTest = $dependents[$i]->first_name;
            if($this->isMatch($toTest)){
                $match++;
                $lbl_data->addClass("match");
            }
            
            $toTest = $dependents[$i]->last_name;
            if($this->isMatch($toTest)){
                $match++;
                $lbl_data->addClass("match");
            }
            
            $toTest = $dependents[$i]->id;
            if($this->isMatch($toTest)){
                $match++;
                $lbl_data->addClass("match");
            }
			
			// $toTest = $dependents[$i]->medicard;
            // if($this->isMatch($toTest)){
                // $match++;
                // $lbl_data->addClass("match");
            // }
        }
        return $match;
    }
    private function buildFlag(){
        $div_container= new html ("td", "filefound_flag_container");
        $div_container->addAttribute("rowspan", "2");
        $div_container->addChild($this->flagDiv);
        $this->rows[0]->addChild($div_container);
    }
    protected function render(){
        $table = new html("table", "resultFound_table");
        $table->addChildren($this->rows);
        $this->Container->addChild($table);
    }
    
}

?>