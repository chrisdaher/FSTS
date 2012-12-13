<?php
//-----------------Security---------------------------------------
   	include_once('php/services/security/SecurityManager.php');
	if (!verifyLoginAdmin()){
		denied();
	}
//----------------------------------------------------------
    include_once("PageHeader.php");
    $subFolder=("php\\view\\Components\\");
    include_once($subFolder."PageBuilder_Reporting.php");
	
    $Name=$_COOKIE['LoginName'];
    $isAdmin = $_SESSION['isAdmin'];

    $DocType = "<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\">";
    $htmlOpen = "<html xmlns=\"http://www.w3.org/1999/xhtml\" xml:lang=\"en\" lang=\"en\">";
    $htmlClose = "</html>";
    
    $header=new PageHeader("Reporting");
    $ThemePath = $header->getThemePath();
    $BrowserPath = $header->getBrowserPath();
    
    $JQueryComponents = array(
        $ThemePath."/jquery/js/jquery-1.7.1.min.js",
        //"bin/tooltip/jquery.cluetips.js",
        $ThemePath."/jquery/js/jquery-ui-1.8.17.custom.min.js"
    );
    
    $MainJavascript = array(
        "js/MenuBar.js",
		"js/Reporting.js",
        "js/Get.js",
        "js/ajax.js",
        "js/jScroll/jquery.mousewheel.js",
        "js/jScroll/mwheelIntent.js",
        "js/jScroll/jquery.scrollpane.min.js",
        "jqPlot/excanvas.js",
        "jqPlot/jquery.jqplot.min.js",
        "jqPlot/plugins/jqplot.barRenderer.min.js",
        "jqPlot/plugins/jqplot.pointLabels.min.js",
        "jqPlot/plugins/jqplot.categoryAxisRenderer.min.js",
		"tablesorter/jquery.tablesorter.js"
    );

    $header->addComment("CSS LOADING BASED ON IE VERSION");
    $header->addCSS($BrowserPath."/Reporting.css");
    $header->addCSS("css/jScroll/jquery.jscrollpane.css");
    $header->addCSS("css/jScroll/jquery.jscrollpane.lozenge.css");
    
    $header->addComment("JQuery Components");
    $header->addCSS($ThemePath."/jquery/css/custom-theme/jquery-ui-1.8.17.custom.css");
	$header->addCSS("css/blue/style.css");
    $header->addCSS("jqPlot/jquery.jqplot.css");
    for($i=0;$i<sizeof($JQueryComponents);$i++){
        $header->addJS($JQueryComponents[$i]);
    }
    
    $header->addComment("MAIN JAVASCRIPT");
    for($i=0;$i<sizeof($MainJavascript);$i++){
        $header->addJS($MainJavascript[$i]);
    }
       
    print("$DocType $htmlOpen");
    print($header->getHeader());
    print("$htmlClose");

    $builder = new PageBuilder_Reporting($Name, $isAdmin);
    $builder->display();
?>