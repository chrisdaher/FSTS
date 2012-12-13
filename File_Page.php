<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />

		<title>File View</title>

    <!--WINDOW RESIZING-->
    <script type="text/javascript" src="js/WindowSizeHandler.js"></script>
    <script type="text/javascript" src="js/MainDivResize.js"></script>
    
    <?php
        require_once('php/services/BrowserDetection/Browser.php');
        $browser = new Browser();

        //if( $browser->getBrowser() == Browser::BROWSER_IE){
        //    print("<link type=\"text/css\" href=\"css/IE".ceil($browser->getVersion())."/File.css\" rel=\"stylesheet\" />");
        //}
        //else{
            print("<link type=\"text/css\" href=\"css/IE9/File.css\" rel=\"stylesheet\" />");
        //}
    ?>
    <!-- JQuery -->
    <link type="text/css" href="theme/dark/jquery/css/custom-theme/jquery-ui-1.8.17.custom.css" rel="stylesheet" />	
	<script type="text/javascript" src="theme/dark/jquery/js/jquery-1.7.1.min.js"></script>
	<script type="text/javascript" src="theme/dark/jquery/js/jquery-ui-1.8.17.custom.min.js"></script>
    <script type="text/javascript" src="theme/dark/jquery/js/jquery.combobox.js"></script>
    
    <!-- MAIN JAVASCRIPT-->
    <LINK REL=StyleSheet HREF="" TYPE="text/css">
    <script type="text/javascript" src="js/File.js"></script>
    <script type="text/javascript" src="js/MenuBar.js"></script>
    <script type="text/javascript" src="js/OptionBarFileView.js"></script>
    
    <script type="text/javascript" src="js/ComboBox.js"></script>
    <script type="text/javascript" src="js/Get.js"></script>
    <script type="text/javascript" src="js/DependentBtns.js"></script>
	<script type="text/javascript" src="js/ajax.js"></script>
	<script type="text/javascript" src="js/FileView_FormActions.js"></script>
    <!-- Error Display Script-->
    <script type="text/javascript" src="js/ErrorDisplay.js"></script>
    <LINK REL=StyleSheet HREF="css/Components/DialogBoxClass.css" TYPE="text/css">
	<!--Form Validation Scripts-->
    <script type="text/javascript" src="js/FileFormValidation.js"></script>
    <script type="text/javascript" src="js/NewDependent.js"></script>
    <script type="text/javascript" src="js/ArrayExtensions.js"></script>
    <script type="text/javascript" src="js/Validators.js"></script>
    <script>
        var theTop=100;    
    </script>
</head>

<body  style="background-color: rgb(239, 239, 239);" onload="resizeMainDiv(60);setInitialFocus()">

<?php
	include('php/services/security/SecurityManager.php');
	verifyLogin();
	
	//session_start();
?>

<?php
	$famId = $_GET['id'];
	if (!empty($_GET['edit'])){
		$editMode = $_GET['edit'];
	}
	else{
		$editMode ="";
	}
	
	$famId = intval($famId);
	$editMode = intval($editMode);
	
	if ($famId == 0){
		$famId = 'new';
		if ($editMode == 0){
			header( 'Location: File_Page.php?id=new&edit=2 ') ;
		}
		$editMode = 2;
	}else{
		//check if ID is ACTIVE!
		include("php/services/mysql/phpMySql.php");	
		
		$res = selectWhereQuery("file", "id", $famId);
		$row = mysql_fetch_array($res);
		$isActive = $row['active'];
		if ($isActive == 0){
			$famId = 'new';
			$editMode = 2;
		}
	}
	
	
	$_SESSION['famId']=$famId;
	
?>

    <!-- Menu Bar-->
<?php include('php/view/FileView/Bars/MenuBar.php'); ?>
<?php
    $_GET['pageType']="FileView"; //this is a workaround for passing get parameters in an include
    include('php/view/FileView/Bars/OptionBar.php'); 
    ?>
<div id="div_MainDiv">
            <?php include('php/view/FileView/GetFileInfo.php');?>
            <?php include('php/view/FileView/DependentsDiv/AddDepDialog.php');?>
			<?php include('php/view/FileView/DependentsDiv/AddIncDialog.php');?>
            <?php include('php/view/ErrorDialog.php');?>

</div>


</body>
</html>