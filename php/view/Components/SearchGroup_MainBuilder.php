<?php
include_once("SearchGroup_AbstractFactory.php");
class SearchGroup_MainBuilder extends SearchGroup_AbstractFactory{
    
    private $SearchLabel;
    private $SearchBtn;
    
    private $includeLabel;
    private $text;
    
    public function __construct($text=null, $includeLabel=true){
        parent::__construct();
        $this->includeLabel = $includeLabel;
        $this->text = $text;
        $this->buildSearchGroup();

    }       
    
    protected function buildSearchGroup(){
       
        $this->SearchLabel=null;
        if($this->text!=null){
			$temp = preg_split("/ /", $this->text);
            $this->SearchLabel=new html("label", null, self::SEARCH_LABEL_ID);
            $this->SearchLabel->setText($temp[0]);
            $this->SearchContainer->addChild($this->SearchLabel);
			
			$this->SearchLabel=new html("label", null, self::SEARCH_LABEL_ID."1");
            $this->SearchLabel->setText($temp[1]);
            $this->SearchContainer->addChild($this->SearchLabel);
        }
        
        if($this->includeLabel){
            $SearchTag1 = new html("label", null, self::SEARCH_TAG_ID."1");
            $SearchTag1->setText(self::SEARCH_TAG1);
            $SearchTag2 = new html("label", null, self::SEARCH_TAG_ID."2");
            $SearchTag2->setText(self::SEARCH_TAG2);
			$SearchTag3 = new html("label", null, self::SEARCH_TAG_ID."3");
            $SearchTag3->setText(self::SEARCH_TAG3);
			$SearchTag4 = new html("label", null, self::SEARCH_TAG_ID."4");
            $SearchTag4->setText(self::SEARCH_TAG4);
			
            $this->SearchBox->addChild($SearchTag1);
            $this->SearchBox->addChild($SearchTag2);
			$this->SearchBox->addChild($SearchTag3);
			$this->SearchBox->addChild($SearchTag4);
        }
        
        $SearchInput = new html("input", array("type"=>"text"),  self::SEARCH_INPUT_ID);

        $this->SearchBox->addChild($SearchInput);
        
        $this->SearchBtn=new html("button", self::SEARCH_BUTTON_CLASS, self::SEARCH_BUTTON_ID);
        
        $this->SearchContainer->addChild($this->SearchBox);
        $this->SearchContainer->addChild($this->SearchBtn);
    }
    
}

?>