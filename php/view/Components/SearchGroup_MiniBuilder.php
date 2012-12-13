<?php
include_once("SearchGroup_AbstractFactory.php");
class SearchGroup_MiniBuilder extends SearchGroup_AbstractFactory{
    
    private $SearchBtn;
    
    private $text;
    private $includeButton;
    private $searchFrom;
    
    public function __construct($text="Search Here", $searchFrom= "language",$includeButton=true){
        parent::__construct();
        $this->text = $text;
        $this->searchFrom = $searchFrom;
        $this->includeButton= $includeButton;
        $this->buildSearchGroup();

    }       
    
    protected function buildSearchGroup(){
        $this->SearchContainer;
        $this->SearchBox;
                
        $SearchInput = new html("input", array("type"=>"text", "title"=>$this->text), self::SEARCH_INPUT_ID.$this->searchFrom);
        $SearchInput->addClass(self::SEARCH_INPUT_ID);
        $SearchInput->addClass(self::INPUT_MINI_CLASS);
        $SearchInput->addAttribute("searchFrom", $this->searchFrom);
        $this->SearchContainer->addChild($this->SearchBox);
        
        $this->SearchBox->addChild($SearchInput);
        if($this->includeButton){
            $this->SearchBtn=new html("button", self::SEARCH_BUTTON_CLASS, self::SEARCH_BUTTON_ID);
            $this->SearchBtn->addClass(self::BUTTON_MINI_CLASS);
            $this->SearchContainer->addChild($this->SearchBtn);
        }

    }
    
}

?>