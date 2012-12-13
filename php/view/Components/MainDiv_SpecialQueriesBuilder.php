<?php

$subFolder="";
include_once($subFolder."MainDiv_AbstractFactory.php");

$subFolder="";
include_once($subFolder."html.php");
class MainDiv_SpecialQueriesBuilder extends MainDiv_AbstractFactory{
    private $SpecialQueryContainer;
    private $QueryResultsContainer;
	private $rows;
    public function __construct(){
		 parent::__construct(3);
		 
		$this->rows[0] = new html("tr", "row1");
        $this->rows[1] = new html("tr", "row2");
		
        $this->Container = new html("div");
        $this->Wrapper = new html("div","Wrapper");
        $this->Wrapper->addClass(self::MAIN_DIV_CLASS);
		$this->SpecialQueryContainer = new html("div", "div_sQuery");
		$this->QueryResultsContainer = new html("div", "div_qResult");
        $NumOfCols = 3;
       
        $this->Columns[0]->addClass("div_rParams");
		
        $this->buildMain();
        $this->render();
    }
  
    protected function buildMain(){
        $this->buildSpecialQueries();
    }
    protected function buildSpecialQueries(){
        $tempTable = new html("table", "table_sQuery");
        
        $tempRow = new html("tr", "table_row1");
        $tempColumn = new html("td", "table_column1");
                
        $Accordion = new html("div", "accordion");
		$AccordionSectionsTitles = array("Sql Keywords", "Table", "Columns", "Spec");
		include_once("/../../services/Queries/dbHelper.php");
		
		$AccordionSections = array(array("Select", "Insert", "Delete", "Update", "Where", "Like", "=", ">", "<", "%", "*", "From"), 
									array_values($models), array(), array());
        for($i=0;$i<sizeof($AccordionSections);$i++){
            $SectionH = new html("h1");
			
            $Section = new html("a","report_section" ,"section_".$AccordionSectionsTitles[$i]);
            $Section->addAttribute("href", "#");
            $Section->setText($AccordionSectionsTitles[$i]);
            $SectionContainer = new html("div", "report_param_container");
			if ($i == 2){
				$SectionContainer->addAttribute("class", "columnDiv");
				$SectionH->addAttribute("class", "h1ColumnDiv");
			}
			else if ($i == 1){
				$SectionContainer->addAttribute("class", "tableDiv");
				$SectionH->addAttribute("class", "h1TableDiv");
			}
			else if ($i==3){
				$SectionContainer->addAttribute("class", "specDiv");
				$SectionH->addAttribute("class", "h1SpecDiv");
			}
            for($j=0;$j<sizeof($AccordionSections[$i]);$j++){
                $currentID= "param_".$AccordionSections[$i][$j];
                $param = new html("button","accordion_lbl" ,$currentID);
                //$param->addAttribute("type", "checkbox");    
				$param->setText($AccordionSections[$i][$j]);
                $SectionContainer->addChild($param);
				if ($i==1){
					$param->addAttribute("tableId", $modelsHelper[($AccordionSections[$i][$j])]);
				}
				/*
                $label = new html("label", "accordion_lbl");
				if ($i==1){
					$label->addAttribute("tableId", $modelsHelper[($AccordionSections[$i][$j])]);
				}
                $label->addAttribute("for", $currentID);
                $label->setText($AccordionSections[$i][$j]);
                $SectionContainer->addChild($label);
				*/
            }
            $SectionH->addChild($Section);
            $Accordion->addChild($SectionH);
            $Accordion->addChild($SectionContainer);
        }
		
		$tempColumn->addChild($Accordion);
        $tempRow->addChild($tempColumn);
        
        $tempColumn = new html("td", "table_column2");
        $InputQuery = new html("textarea", "input_sQuery");
		$InputQuery->addAttribute("name", "sQuery");
		$InputQuery->addAttribute("id", "sQuery");
		$tempColumn->addChild($InputQuery);
		$tempRow->addChild($tempColumn);
        
        $tempTable->addChild($tempRow);
        $tempRow = new html("tr", "table_row2");
        $tempColumn = new html("td", "table_column1");
        $tempRow->addChild($tempColumn);
        
        $tempColumn = new html("td", "table_column2");
		$InputQuery = new html("button", "btn_execute");
		$InputQuery->setText("Execute");
        $tempColumn->addChild($InputQuery);
		
		$InputQuery = new html("button", "btn_clear");
		$InputQuery->setText("Clear");
        $tempColumn->addChild($InputQuery);
		
		$InputQuery = new html("button", "btn_help");
		$InputQuery->setText("?");
        $tempColumn->addChild($InputQuery);
        $tempRow->addChild($tempColumn);
        $tempTable->addChild($tempRow);
        $this->SpecialQueryContainer->addChild($tempTable);
        
		$LabelResults = new html("table", "qResults");
		$this->QueryResultsContainer->addChild($LabelResults);
    }
    protected function render(){
        $this->Container->removeChildren();
        $this->Container->addChild($this->SpecialQueryContainer);
        $this->Container->addChild($this->QueryResultsContainer);
    }
}

?>