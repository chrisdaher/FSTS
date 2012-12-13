<?php
	include_once("/../../view/Components/html.php");
	include_once("dbHelper.php");
	
	$tabId = $_GET['id'];
	$specName = $_GET['name'];
	$specName = strtolower($specName);
	$model = $modelTags[$tabId];
	
	$specConv = $model->getSpecConverter($specName);
	
	$data = $specConv->getAllData();
	
	
	$AccordionSection = $data;
	// $cntr = 0;
	
	// for ($i=0;$i<sizeof($sections);$i++){
		// $AccordionSection[$cntr] =  $sections[$i];
		// $cntr++;
	// }
	
	$SectionContainer = new html("div", "report_param_container");
	 for($i=0;$i<sizeof($AccordionSection);$i++){
        $currentID= "param_".$AccordionSection[$i]['name'];
        $param = new html("input","accordion_lbl" ,$currentID);
        $param->addAttribute("type", "checkbox");    
        $SectionContainer->addChild($param);
        $label = new html("label", "accordion_lbl");
        $label->addAttribute("for", $currentID);
        $label->setText($AccordionSection[$i]['name']);
		$label->addAttribute("class", "specButton");    
		$label->addAttribute("specVal", $AccordionSection[$i]['id']);
        $SectionContainer->addChild($label);
     }
	 echo $SectionContainer->toHTML();
?>