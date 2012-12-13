<?php

$subFolder="";
include_once($subFolder."MainDiv_AbstractFactory.php");
$subFolder="";
include_once($subFolder."html.php");
$subFolder="";
include_once($subFolder."Accordion.php");

class MainDiv_ReportingBuilder extends MainDiv_AbstractFactory{
    private $ReportParamArrayTitles;
    private $ReportParamArray;
    private $rows;
    public function __construct(){
        
        parent::__construct(3);
        $this->Container->addClass("MainContent");
        
        $this->rows[0] = new html("tr", "row1");
        $this->rows[1] = new html("tr", "row2");
        $this->Columns[0]->addClass("div_rParams");
        $this->Columns[1]->addClass("div_rResult");
        $this->Columns[1]->addClass("div_rColumn3");
		
		include_once("/../../services/Reporting/ReportingHelper.php");
        $seriesArray = ($reportingModels);
		
        $parameterArray = array("sDate"=>"Start Date", "eDate"=>"End Date", "interval"=>"Interval");
        $this->ReportParamArrayTitles = array("Series", "x-Axis");//, "File", "User");
        $this->ReportParamArray[0] = $seriesArray;
        $this->ReportParamArray[1] = $parameterArray;
        //$this->ReportParamArray[2];
        
        
        $this->buildMain();
        $this->render();
    }
  
    protected function buildMain(){
        $this->buildReportParams();
        $this->buildReportResult();
    }
    protected function buildReportParams(){
        $Accordion = new Accordion();
        
        $elements = self::buildButtonSection($this->ReportParamArray[0]);
        $Accordion->addSection($this->ReportParamArrayTitles[0], $elements);
        
        $elements = self::buildParameterSection($this->ReportParamArray[1]);
        $Accordion->addSection($this->ReportParamArrayTitles[1], $elements);
        
        $this->Columns[0]->addChild($Accordion->getContainer());
    }

    protected function buildButtonSection($ReportArrayIn){
		$toRet = array();
        //$Section->addAttribute("href", "#");
		$ReportArray = array_values($ReportArrayIn);
		$ReportFlip = array_flip($ReportArrayIn);
		

        for($j=0;$j<sizeof($ReportArray);$j++){
			
            $currentID= "param_".$ReportArray[$j];
            $param = new html("button","report_param" ,$currentID);
            $param->addAttribute("param", $ReportFlip[$ReportArray[$j]]);

            //$label = new html("label", "report_param");
            //$label->addAttribute("for", $currentID);
            $param->setText($ReportArray[$j]);
            $toRet[sizeof($toRet)] = $param;
            //$SectionContainer->addChild($label);
        }

        return $toRet;
    }
    protected function buildParameterSection($ReportArr){

        $toRet = array();
        //$Section->addAttribute("href", "#");
		$ReportArray = array_values($ReportArr);
		$ReportFlip = array_values(array_flip($ReportArr));
        
        for($j=0;$j<sizeof($ReportArray)-1;$j++){
            $currentID= "param_".$ReportFlip[$j];
            $param = new html("input","input_param" ,$currentID);
            $param->addAttribute("param", $ReportFlip[$j]);    
            $label = new html("label", "label_param");
            $label->addAttribute("for", $currentID);
            $label->setText($ReportArray[$j]);
            $toRet[sizeof($toRet)] = $label;
            $toRet[sizeof($toRet)] = $param;
            //$SectionContainer->addChild($label);
        }
            $currentID= "param_".$ReportFlip[$j];
            $param = new html("select","input_param" ,$currentID);
            $param->addAttribute("param", $ReportFlip[$j]);
            $label = new html("label", "label_param");
            $label->addAttribute("for", $currentID);
            $label->setText($ReportArray[$j]);
            
            $option = new html("option");
            $option->addAttribute("value", 2);
            $option->setText("Weekly");
            $param->addChild($option);
            
            $option = new html("option");
            $option->addAttribute("value", 1);
            $option->setText("Monthly");
            $param->addChild($option);
            
            $option = new html("option");
            $option->addAttribute("value", 3);
            $option->setText("Yearly");
            $param->addChild($option);
            
            $toRet[sizeof($toRet)] = $label;
            $toRet[sizeof($toRet)] = $param;
        return $toRet;
    }
    
    protected function buildReportResult(){
        $InputQuery = new html("div", "report_chart", "report_chart");
		$this->Columns[1]->addChild($InputQuery);
        $this->Columns[1]->addAttribute("rowspan", "2");
        
		/*
		$InputQuery = new html("button", "btn_execute");
		$InputQuery->setText("Execute");
        $this->SpecialQueryContainer->addChild($InputQuery);
        
		$LabelResults = new html("table", "qResults");
		$this->QueryResultsContainer->addChild($LabelResults);
        */
    }
    protected function render(){
        $this->Container->removeChildren();
        $this->rows[0]->addChild($this->Columns[0]);
        $this->rows[0]->addChild($this->Columns[1]);
        $this->rows[0]->addChild($this->Columns[2]);
        $this->Container->addChild($this->rows[0]);
        $this->rows[1]->addChild(new html("td", "row2_col1"));
        $this->rows[1]->addChild(new html("td", "row2_col2"));
        $this->rows[1]->addChild(new html("td", "row2_col3"));
        $this->Container->addChild($this->rows[1]);
    }
}

?>