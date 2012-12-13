<?php
echo ('
	<meta charset="utf-8" />

	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	
	<!-- 1140px Grid styles for IE -->
	<!--[if lte IE 9]><link rel="stylesheet" href="css/Mobile/css/ie.css" type="text/css" media="screen" /><![endif]-->

	<!-- The 1140px Grid - http://cssgrid.net/ -->
	<link rel="stylesheet" href="css/Mobile/css/1140.css" type="text/css" media="screen" />
	
	<!-- Your styles -->
	<link rel="stylesheet" href="css/Mobile/css/styles.css" type="text/css" media="screen" />
	
	<!--css3-mediaqueries-js - http://code.google.com/p/css3-mediaqueries-js/ - Enables media queries in some unsupported browsers-->
	<script type="text/javascript" src="css/Mobile/js/css3-mediaqueries.js"></script>
	
	<!--Delete embedded styles, just for example.-->
	<style type="text/css">
	
	body {
	font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;
	}
	
	.container p {
	color: #fff;
	line-height: 100px;
	background: #000;
	text-align: center;
	margin: 20px 0 0 0;
	}
	
	</style>
');

//------------------------SECURITY-------------------------
   	include('php/services/security/SecurityManager.php');
	verifyLogin();
//----------------------------------------------------------
    include_once("PageHeader.php");
    $subFolder=("php\\view\\Components\\");
    include_once($subFolder."PageBuilder_Attendance.php");
    
    $Name=$_COOKIE['LoginName'];
    $isAdmin = $_SESSION['isAdmin'];
	if(isset($_GET['EventID'])){
		$attendanceID = $_GET['EventID'];
	}else{
		$attendanceID = 0;
	}

    $DocType = "<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\">";
    $htmlOpen = "<html xmlns=\"http://www.w3.org/1999/xhtml\" xml:lang=\"en\" lang=\"en\">";
    $htmlClose = "</html>";
    
    $header=new PageHeader("Attendance");
    $ThemePath = $header->getThemePath();
    $BrowserPath = $header->getBrowserPath();
    
    $JQueryComponents = array(
        $ThemePath."/jquery/js/jquery-1.7.1.min.js",
        //"bin/tooltip/jquery.cluetips.js",
        $ThemePath."/jquery/js/jquery-ui-1.8.17.custom.min.js",
		"tablesorter/jquery.tablesorter.js"
    );
    
    $MainJavascript = array(
        "js/Attendance.js",
        "js/MenuBar.js",
		"js/Get.js",
        "js/OptionBarAttendance.js",
        "js/jScroll/jquery.mousewheel.js",
        "js/jScroll/mwheelIntent.js",
        "js/jScroll/jquery.scrollpane.min.js"
    );

    $header->addComment("CSS LOADING BASED ON IE VERSION");
    $header->addCSS($BrowserPath."/Attendance.css");
    $header->addCSS("css/jScroll/jquery.jscrollpane.css");
    $header->addCSS("css/jScroll/jquery.jscrollpane.lozenge.css");
    $header->addCSS("css/blue/style.css");
	$header->addCSS("css/Mobile/Main.css");
	
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

    $builder = new PageBuilder_Attendance($Name, $attendanceID, $isAdmin);
    $builder->display();
?>