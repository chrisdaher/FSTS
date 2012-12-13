<?php
    include_once("PageHeader.php");
    $subFolder=("php\\view\\Components\\");
    include_once($subFolder."PageBuilder_AppointmentAssignment.php");

    //-----------------Security---------------------------------------
   	include_once('php/services/security/SecurityManager.php');
	verifyLogin();
	
	//session_start();
    //----------------------------------------------------------------
    $Name=$_COOKIE['LoginName'];
    $isAdmin = $_SESSION['isAdmin'];
    $famId=$_GET['EventID'];
    $editMode=0;
    if(isset($_GET['edit'])){
        $editMode=$_GET['edit'];
    }
    $isEdit = ($editMode==1);
    
    
    $DocType = "<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\">";
    $htmlOpen = "<html xmlns=\"http://www.w3.org/1999/xhtml\" xml:lang=\"en\" lang=\"en\">";
    $htmlClose = "</html>";
    
    $header=new PageHeader("Appointment Assignment");
    $ThemePath = $header->getThemePath();
    $BrowserPath = $header->getBrowserPath();
    
    $JQueryComponents = array(
        $ThemePath."/jquery/js/jquery-1.7.1.min.js",
        //"bin/tooltip/jquery.cluetips.js",
        $ThemePath."/jquery/js/jquery-ui-1.8.17.custom.min.js",
        "js/jquery.combobox.js",
        "js/jquery.simulate.js",
        "js/jquery.event.drag-2.0.min.js",
        "js/jquery.event.drop-2.0.min.js",
        "tablesorter/jquery.tablesorter.js"
    );
    
    $MainJavascript = array(
        "js/AssigningAppointments.js",
        "js/EventEditing.js",
        "js/DragDropExtensions.js",
        "js/SearchGroup.js",
        "js/MenuBar.js",
        "js/OptionBarAssigningAppointments.js",
        "js/Get.js",
        "js/ajax.js",
        "js/SearchBar.js"
    );

    $header->addComment("CSS LOADING BASED ON IE VERSION");
    $header->addCSS($BrowserPath."/AssigningAppointments.css");
    $header->addCSS("css/blue/style.css");
    
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
    
	
	
    $AppAssignmentPage= new PageBuilder_AppointmentAssignment($Name, $famId, $isAdmin, $editMode);
    $AppAssignmentPage->display();
	
	//make sure event ID is valid
	include_once('php/services/security/validateEventId.php');
	$evId = $_GET['EventID'];
	$_SESSION['evId'] = 'new';
	if ($evId != "new"){
		$isEvent = validateId($_GET['EventID']);
		
		if (!$isEvent){
			header('Location: AssigningAppointments.php?EventID=new&edit=1');
		}
		else{
			$_SESSION['evId'] = $evId;
		}
	}
    
?>