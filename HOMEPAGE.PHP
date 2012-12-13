<?php
//------------------------SECURITY-------------------------
   	include('php/services/security/SecurityManager.php');
	verifyLogin();
//----------------------------------------------------------
    include_once("PageHeader.php");
    $subFolder=("php\\view\\Components\\");
    include_once($subFolder."PageBuilder_Homepage.php");
    
    $Name=$_COOKIE['LoginName'];
    $isAdmin = $_SESSION['isAdmin'];

    $DocType = "<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\">";
    $htmlOpen = "<html xmlns=\"http://www.w3.org/1999/xhtml\" xml:lang=\"en\" lang=\"en\">";
    $htmlClose = "</html>";
    
    $header=new PageHeader("Homepage");
    $ThemePath = $header->getThemePath();
    $BrowserPath = $header->getBrowserPath();
    
    $JQueryComponents = array(
        $ThemePath."/jquery/js/jquery-1.7.1.min.js",
        //"bin/tooltip/jquery.cluetips.js",
        $ThemePath."/jquery/js/jquery-ui-1.8.17.custom.min.js",
    );
    
    $MainJavascript = array(
        "js/Homepage.js",
        "js/SearchGroup.js",
        "js/SearchByGroup.js",
        "js/MenuBar.js",
        "js/OptionBarAssigningAppointments.js",
        "js/Get.js",
        "js/ajax.js",
        "js/SearchBar_Homepage.js",
        "js/jScroll/jquery.mousewheel.js",
        "js/jScroll/mwheelIntent.js",
        "js/jScroll/jquery.scrollpane.min.js"
    );

    $header->addComment("CSS LOADING BASED ON IE VERSION");
    $header->addCSS($BrowserPath."/Homepage.css");
    $header->addCSS("css/jScroll/jquery.jscrollpane.css");
    $header->addCSS("css/jScroll/jquery.jscrollpane.lozenge.css");
    
    $header->addComment("JQuery Components");
    $header->addCSS($ThemePath."/jquery/css/custom-theme/jquery-ui-1.8.17.custom.css");
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

    $builder = new PageBuilder_Homepage($Name, $isAdmin);
    $builder->display();
?>