<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

<head>

	 <!-- JQuery -->
    <link type="text/css" href="theme/dark/jquery/css/custom-theme/jquery-ui-1.8.17.custom.css" rel="stylesheet" />	
	<script type="text/javascript" src="theme/dark/jquery/js/jquery-1.7.1.min.js"></script>
	<script type="text/javascript" src="theme/dark/jquery/js/jquery-ui-1.8.17.custom.min.js"></script>

    <script src="bin/DHXScheduler/codebase/dhtmlxscheduler.js" type="text/javascript" charset="utf-8"></script>
	<link rel="stylesheet" href="bin/DHXScheduler/codebase/dhtmlxscheduler.css" type="text/css" charset="utf-8"/>
    <script src="bin/DHXScheduler/codebase/ext/dhtmlxscheduler_recurring.js" type="text/javascript" charset="utf-8"></script>
    <link title="no title" href="bin/DHXScheduler/codebase/dhtmlxscheduler_recurring.css" rel="stylesheet" type="text/css" charset="utf-8"/>
	<script src='bin/DHXScheduler/codebase/ext/dhtmlxscheduler_timeline.js' type="text/javascript" charset="utf-8"></script>
	<script src="bin/DHXScheduler/codebase/ext/dhtmlxscheduler_editors.js"></script>
	<script src="bin/DHXScheduler/sources/dhtmlxcommon.js"></script>
	<script src="bin/tooltip/script.js"></script>
	<link rel="stylesheet" href="bin/tooltip/style.css" type="text/css" charset="utf-8"/>
	<script src="bin/dhtmlxCombo/codebase/dhtmlxcombo.js"></script>
	
    <?php
        require_once('php/services/BrowserDetection/Browser.php');
        $browser = new Browser();

        //if( $browser->getBrowser() == Browser::BROWSER_IE){
        //    print("<link type=\"text/css\" href=\"css/IE".ceil($browser->getVersion())."/EventView.css\" rel=\"stylesheet\" />");
       // }
        //else{
            print("<link type=\"text/css\" href=\"css/IE9/EventView.css\" rel=\"stylesheet\" />");
        //}
    ?>
	
    <!-- UI Imports -->
    <script type="text/javascript" src="js/MenuBar.js"></script>
    <script>
        var theTop=40;
    </script>
		
	<link rel="stylesheet" href="bin/dhtmlxCombo/codebase/dhtmlxcombo.css" type="text/css" charset="utf-8"/>
    
        <!-- JQuery -->
    <link type="text/css" href="theme/dark/jquery/css/custom-theme/jquery-ui-1.8.17.custom.css" rel="stylesheet" />	
	<script type="text/javascript" src="theme/dark/jquery/js/jquery-1.7.1.min.js"></script>
	<script type="text/javascript" src="theme/dark/jquery/js/jquery-ui-1.8.17.custom.min.js"></script>
    
    <!-- Main-->
    <script src="js/Scheduler.js" type="text/javascript" charset="utf-8"></script>
	<script src="js/Get.js" type="text/javascript" charset="utf-8"></script>

	<title>DHX Scheduler</title>

</head>

<body>
	<?php
		include('php/services/security/SecurityManager.php');
		verifyLogin();
	?>
	<?php include('php/view/FileView/Bars/MenuBar.php'); ?>
	<div oncontextmenu="rightClick();return false;" id="thescheduler" class="dhx_cal_container" >
		<div class="dhx_cal_navline" id="navline">
			<div class="dhx_cal_prev_button" id="prev_button">&nbsp;</div>
			<div class="dhx_cal_next_button" id="next_button">&nbsp;</div>
			<div class="dhx_cal_today_button" id="today_button"></div>
			<div class="dhx_cal_date" id="lbl_date"></div>
			<div class="dhx_cal_tab" id="day_tab" name="day_tab" style="right:204px;"></div>
			<div class="dhx_cal_tab" id="week_tab" name="week_tab" style="right:140px;"></div>
			<div class="dhx_cal_tab" id="month_tab" name="month_tab" style="right:76px;"></div>
			<div class="dhx_cal_tab" id="workweek_tab" name="workweek_tab" style="right:280px;"></div>
			
			
			<div id="back_event" style="right: 96px;">
				<span onclick="backToEvent();" id="back_span"  class="hotspot">Back</span>
			</div>
			
			<div id="info_event" style="right: 140px;">
				<span onclick="goToEvent();" id="info_span" class="hotspot"></span>
			</div>
			
		</div>
		<div class="dhx_cal_header">
		</div>
		<div class="dhx_cal_data">
		</div>		

	</div>
    <script>
		setupScheduler(true);
    </script>

</body>
</html>