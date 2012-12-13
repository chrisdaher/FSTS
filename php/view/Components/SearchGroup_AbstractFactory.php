<?php
include_once("html.php");
abstract class SearchGroup_AbstractFactory{
    const SEARCH_GROUP_ID= "div_SearchGroup";
    const SEARCH_BOX_ID="div_Search";
    const SEARCH_INPUT_ID="input_Search";
    const SEARCH_BUTTON_ID = "btn_Search";
    const SEARCH_BUTTON_CLASS = "SearchButton";
    const SEARCH_LABEL_ID = "label_Search";
    const SEARCH_TAG_ID = "label_SearchTag";
    const SEARCH_TAG1 = "File";
    const SEARCH_TAG2 = "Event";
	const SEARCH_TAG3 = "";
	const SEARCH_TAG4 = "";
    
    const INPUT_MINI_CLASS = "input_mini";
    const BUTTON_MINI_CLASS = "btn_mini";
    
    protected $SearchContainer;
    
    protected $SearchBox;
    
    
    public function __construct(){
        $this->SearchContainer=new html("div",self::SEARCH_GROUP_ID);
        $this->SearchBox=new html("div", null, self::SEARCH_BOX_ID);

    }       
    
    protected abstract function buildSearchGroup();
    
    public function getContainer(){
        return $this->SearchContainer;
    }
    
    public function display(){
        print($this->getContainer()->toHTML());
    }
}

?>