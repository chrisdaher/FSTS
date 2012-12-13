<?php
    include_once("PageHeader.php");
    $subFolder=("php\\view\\Components\\");
    include_once($subFolder."PageBuilder_Admin.php");

    //-----------------Security---------------------------------------
   	include_once('php/services/security/SecurityManager.php');
	if (!verifyLoginAdmin()){
		denied();
	}
	//session_start();
    //----------------------------------------------------------------
    $Name=$_COOKIE['LoginName'];
    $isAdmin = $_SESSION['isAdmin'];
    
    $DocType = "<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\">";
    $htmlOpen = "<html xmlns=\"http://www.w3.org/1999/xhtml\" xml:lang=\"en\" lang=\"en\">";
    $htmlClose = "</html>";
    
    $header=new PageHeader("Admin");
    $ThemePath = $header->getThemePath();
    $BrowserPath = $header->getBrowserPath();
    
    $JQueryComponents = array(
        $ThemePath."/jquery/js/jquery-1.7.1.min.js",
        //"bin/tooltip/jquery.cluetips.js",
        $ThemePath."/jquery/js/jquery-ui-1.8.17.custom.min.js",
        "js/jquery.combobox.js",
        "js/jquery.simulate.js",
        "js/jquery.event.drag-2.0.min.js",
        "js/jquery.event.drop-2.0.min.js"
    );
    
    $MainJavascript = array(
        "js/Admin.js",
        "js/AdminPage_Validation.js",
        //"js/DragDropExtensions.js",
        "js/ComboBox.js",
        "js/SearchGroup.js",
        "js/MenuBar.js",
        "js/OptionBarAdmin.js",
        "js/Get.js",
        "js/ajax.js",
        "js/SearchBar.js"
    );

    $header->addComment("CSS LOADING BASED ON IE VERSION");
    $header->addCSS($BrowserPath."/Admin.css");
    
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
    
    if($isAdmin){
        $AppAssignmentPage= new PageBuilder_Admin($Name, $isAdmin);
        $AppAssignmentPage->display();
    }
    
?>