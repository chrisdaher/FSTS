<?php

$subFolder="";
include_once($subFolder."MainDiv_AbstractFactory.php");
include_once($subFolder."SearchGroup_MiniBuilder.php");
class MainDiv_AdminBuilder extends MainDiv_AbstractFactory{
    const COLUMN_EDIT_CLASS = "div_SectionEdit";
    const COLUMN_PREVIEW_CLASS = "div_SectionPreview";
    
    const EDIT_HEADER_CLASS = "div_header";
    const EDIT_LABEL_CLASS = "lbl_section";
    const EDIT_BUTTON_CLASS = "btn_add";
    const EDIT_SEARCH_CLASS = "div_search";
    const EDIT_RESULTS_CLASS = "div_results";
    
    const PREVIEW_LABEL_PREVIEW = "lbl_preview";
    const PREVIEW_LABEL_NOW = "lbl_now";
    const PREVIEW_DIV_PREVIEW = "div_preview";
    const PREVIEW_INPUT_COMBOBOX = "div_preview_combo";
    const PREVIEW_INPUT_PCODE = "div_preview_pcode";
    const PREVIEW_LABEL_CITY = "div_preview_pcode";
    const PREVIEW_LABEL_PROVINCE = "div_preview_pcode";
    const PREVIEW_LABEL_VALUE = "div_preview_value";
    
    const POSTAL_CODE_SECTION = "PostalCode";
    const INCOME_MODE_SECTION = "IncomeLength";
    private $section;
    private $title;
    
    public function __construct($section = "language", $title = "Language"){
        parent::__construct(2);
                
        $this->section = $section;
        $this->title = $title;
        
        $this->buildMain();
        $this->render();
    }
  
    protected function buildMain(){
        $this->buildColumnEdit();
        $this->buildColumnPreview();
    }
    
    protected function buildColumnEdit(){
        $Column = new html("div", self::COLUMN_EDIT_CLASS);
        $Header = new html("div", self::EDIT_HEADER_CLASS);
        
        $tempComponent = new html("label", self::EDIT_LABEL_CLASS);
        $tempComponent->setText($this->title);
        $Header->addChild($tempComponent);
        
        $tempComponent = new html("button", self::EDIT_BUTTON_CLASS);
        $tempComponent->toJQuery("button");
        $tempComponent->addAttribute("section", $this->section);
        $Header->addChild($tempComponent);
        
        $tempComponent = new html("div", self::EDIT_SEARCH_CLASS);
        $tempSub = new SearchGroup_MiniBuilder("Search Here", $this->section, false);
        $tempComponent->addChild($tempSub->getContainer());
        $Header->addChild($tempComponent);
        
        $Column->addChild($Header);
        
        $tempComponent = new html("div", self::EDIT_RESULTS_CLASS);
        $tempTable = new html("table", self::EDIT_RESULTS_CLASS."_table");
        $tempComponent->addChild($tempTable);
        $Column->addChild($tempComponent);
        
        $this->Columns[0]->addChild($Column); 
    }
    
    protected function buildColumnPreview(){
        $Column = new html("div", self::COLUMN_PREVIEW_CLASS);

        $tempComponent = new html("label", self::PREVIEW_LABEL_PREVIEW);
        $tempComponent->setText("PREVIEW");
        $Column->addChild($tempComponent);
        
        $tempComponent = new html("label", self::PREVIEW_LABEL_NOW);
        $tempComponent->setText("This is how it looks like now");
        $Column->addChild($tempComponent);
        
        $tempComponent = new html("div", self::PREVIEW_DIV_PREVIEW);
        
        if($this->section==self::POSTAL_CODE_SECTION){
            $tempSub = new html("input", self::PREVIEW_INPUT_PCODE);
            $tempSub->addAttribute("Section", $this->section);
            $tempComponent->addChild($tempSub);
            
            $tempSub = new html("br");
            $tempSub->addAttribute("Section", $this->section);
            $tempComponent->addChild($tempSub);
            
            $tempSub = new html("label", self::PREVIEW_LABEL_CITY);
            $tempSub->setText("City");
            $tempSub->addAttribute("Section", $this->section);
            $tempComponent->addChild($tempSub);
            
            $tempSub = new html("label", self::PREVIEW_LABEL_PROVINCE);
            $tempSub->setText("Province");
            $tempSub->addAttribute("Section", $this->section);
            $tempComponent->addChild($tempSub);
        }elseif($this->section==self::INCOME_MODE_SECTION){
            $tempSub = new html("select", self::PREVIEW_INPUT_COMBOBOX);
            $tempSub->addAttribute("Section", $this->section);
            $tempComponent->addChild($tempSub);
            
        }else{
            $tempSub = new html("select", self::PREVIEW_INPUT_COMBOBOX);
            $tempSub->addAttribute("type", "select");
            $tempSub->addAttribute("Section", $this->section);
            $tempComponent->addChild($tempSub);
        }
        $Column->addChild($tempComponent);
        
        $this->Columns[1]->addChild($Column); 
    }
    
  
}

?>