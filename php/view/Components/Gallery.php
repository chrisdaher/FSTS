<?php

class Gallery{
    const FILES_FOUND_GALLERY_CONTAINER = "GalleryContainer";
    const FILES_FOUND_GALLERY_PAGE = "GalleryPage";
    const FILES_FOUND_GALLERY_PAGE_HIDE = "HiddenGallery";
    const FILES_FOUND_GALLERY_NAVIGATOR_ID = "div_btnContainer";
    const FILES_FOUND_GALLERY_NAGIGATOR_CLASS = "GalleryNavigator";
    
    const MAX_PAGE_SIZE = 200;
    protected $NumberOfPages;
    protected $SearchString;
     
    protected $pages;
    protected $FileFoundIDs;
    
    protected $Container;
    protected $FilesFoundBuilder;
    
    protected $Navigator;
    
    public function __construct($builder = null, $FileFoundIDs=null, $SearchString=null){
        $this->SearchString=$SearchString;
        $this->Container = new html("div", self::FILES_FOUND_GALLERY_CONTAINER);
        if($FileFoundIDs!=null){
            $this->NumberOfPages=ceil(sizeof($FileFoundIDs)/self::MAX_PAGE_SIZE);
            $this->FileFoundIDs=$FileFoundIDs;
        }
        $this->attachBuilder($builder);
        if($this->NumberOfPages>1){
            $this->buildNavigator();   
        }
    
    }
    
    public function attachBuilder($builder){
        $this->FilesFoundBuilder = $builder;
    }
    protected function buildPages(){
        $lastFileDone=0;
        $filesLeft=sizeof($this->FileFoundIDs);
        $NumOfPages=$this->NumberOfPages;
        $MaxNumberOfFiles=self::MAX_PAGE_SIZE;
        $FileIDs=$this->FileFoundIDs;
        
        for($i=0;$i<$NumOfPages;$i++){
            $tempPage = new html("div", self::FILES_FOUND_GALLERY_PAGE);
            $tempPage->addAttribute("page", $i+1);
            $tempPage->addClass(self::FILES_FOUND_GALLERY_PAGE_HIDE);
            for($j=$lastFileDone;$j<(($i+1)*$MaxNumberOfFiles);$j++){
                $lastFileDone++;
                if($filesLeft>0){
                    $filesLeft--;
                    $tempFile = $this->FilesFoundBuilder->doSearch($FileIDs[$j], $this->SearchString);
                    $tempPage->addChild($tempFile);
                }else{
                    break;
                }
            }
            $this->pages[sizeof($this->pages)] = $tempPage;
        }
    }
    protected function buildNavigator(){
        $this->Navigator = new html("div", self::FILES_FOUND_GALLERY_NAGIGATOR_CLASS, self::FILES_FOUND_GALLERY_NAVIGATOR_ID);
        
        $prevBtnAttr = array("id"=>"btn_prevFileSet", "value"=>"Previous", "limit"=>"1");
        $pageLblAttr = array("id"=>"lbl_page");
        $nextBtnAttr = array("id"=>"btn_nextFileSet", "value"=>"Next", "limit"=>$this->NumberOfPages);
        
        $prevBtn = new html("button", $prevBtnAttr);
        $prevBtn->toJQuery("button");
        $prevBtn->setText("Previous");
        
        $pageLbl = new html("label", $pageLblAttr);
        $pageLbl->setText("page:");
        
        $nextBtn = new html("button", $nextBtnAttr);
        $nextBtn->toJQuery("button");
        $nextBtn->setText("Next");
        
        $this->Navigator->addChild($prevBtn);
        $this->Navigator->addChild($pageLbl);
        $this->Navigator->addChild($nextBtn);
        
        $this->Container->addChild($this->Navigator);
    }
    public function getContainer(){
        return $this->Container;
    }
    public function doSearch($fileIDs, $searchString){
        $this->__construct($this->FilesFoundBuilder, $fileIDs, $searchString);
        $this->buildPages();
        $this->render();
    }
    protected function render(){
        $page = $this->pages[0];
        if($page!=null){
            $page->removeClass(self::FILES_FOUND_GALLERY_PAGE_HIDE);
        }
        $this->Container->addChildren($this->pages);
    }
    public function display(){
        echo ($this->Container->toHTML());
    }
    
}

?>