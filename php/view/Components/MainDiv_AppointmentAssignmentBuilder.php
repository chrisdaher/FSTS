<?php

$subFolder="";
include_once($subFolder."EventInfo.php");
$subFolder="";
include_once($subFolder."EventInfoForm.php");
$subFolder="";
include_once($subFolder."MainDiv_AbstractFactory.php");
$subFolder="";
include_once($subFolder."Gallery.php");
$subFolder="";
include_once($subFolder."MiniFileFoundBuilder.php");
class MainDiv_AppointmentAssignmentBuilder extends MainDiv_AbstractFactory{

    protected $SearchString;
    protected $EventID;
    protected $FileIDs;
    protected $isEdit;
    public function __construct($EventID = null,  $isEdit=false, $FileIDs = null, $searchString = null){

        parent::__construct(2);
        
        $this->EventID = $EventID;
        $this->FileIDs = $EventID;
        $this->isEdit = $isEdit;
        $this->SearchString= $searchString;
        
        $this->buildMain();
        $this->render();
    }
  
    protected function buildMain(){
        $this->buildEventInfo();
    }
    
    protected function buildEventInfo(){
        if($this->isEdit){
            $builder = new EventInfoForm($this->EventID);
            $this->Columns[0]->addChild($builder->getAppInfo());
            $this->Columns[1]->addChild($builder->getEventData());
        }else{
            $builder = new EventInfo($this->EventID);
            $this->Columns[0]->addChild($builder->getAppInfo());
            $this->Columns[1]->addChild($builder->getEventData());
         }
    }
    protected function getSearchResults(){
        $toRet = null;
        if($this->FileIDs[0]!=null){
            $this->Columns[1]->removeChildBy("class", Gallery::FILES_FOUND_GALLERY_CONTAINER);
            
            $builder = new MiniFileFoundBuilder();
            $Gallery = new Gallery(null, null, $builder);

            $Gallery->doSearch($this->FileIDs, $this->SearchString);
            $toRet = $Gallery->getContainer();
        }
        return $toRet;
    }
    
    public function Search($fileIDs, $searchString){
        $this->FileIDs = $fileIDs;
        $this->SearchString = $searchString;
        return $this->getSearchResults();
    }
}

?>