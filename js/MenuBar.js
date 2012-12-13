	$.ctrl = function(key, callback, args) {
		var isCtrl = false;
		$(document).keydown(function(e) {
			if(!args) args=[]; // IE barks when args is null

			if(e.ctrlKey) isCtrl = true;
			if(e.keyCode == key.charCodeAt(0) && isCtrl) {
				callback.apply(this, args);
				return false;
			}
		}).keyup(function(e) {
			if(e.ctrlKey) isCtrl = false;
		});
	};
		
	$.ctrl('1', function(){
		window.location = "Homepage.php";
	});
	
	$.ctrl('2', function(){
		window.location = "DHX.php";
	});
	
	$.ctrl('E', function(){
		var theLoc = window.location;
		theLoc = theLoc.toString();
		if (theLoc.indexOf("File_Page") != -1){
			//in filepage
			var id = Get('id');
			window.location = "File_Page.php?id="+id + "&edit=1";
		}
	});
	
	$.ctrl('S', function(){
		var theLoc = window.location;
		theLoc = theLoc.toString();
		if (theLoc.indexOf("File_Page") != -1){
			//in filepage
			var btnDone = $('#btn_Done');
			if (btnDone.length >0){
				$(btnDone).click();
			}
		}
	});
	
	$.ctrl('R', function(){
		var theLoc = window.location;
		theLoc = theLoc.toString();
		if (theLoc.indexOf("File_Page") != -1){
			$('#btn_Register').click();
		}
	});
	
	$(document).keyup(function (event) {
		
		var theNb = event.keyCode;
		var esc = 27;
		if (theNb == esc){
			var btnCancel = $("#btn_Cancel");
			if (btnCancel.length>0){
				$(btnCancel).click();
			}
		}
	});
   
	
	$(function() {
        $( "#btn_Home" ).button(),
		$( "#btn_Home" ).click(function() { window.location="Homepage.php"; }),
        
        $( "#btn_Calender" ).button(),
		$( "#btn_Calender" ).click(function() { window.location = "dhx.php"; }),
        
        $( "#btn_Reporting" ).button(),
		$( "#btn_Reporting" ).click(function() { window.location = "Reporting.php"; }),
		
		$( "#mbtn_Attendance" ).button(),
		$( "#mbtn_Attendance" ).click(function() { window.location = "Attendance.php"; }),
        
        $( "#btn_Logout" ).button(),
		$( "#btn_Logout" ).click(function() { window.location="php/services/login/Logout.php"; }),  
        
        $( "#btn_Admin" ).button(),
		$( "#btn_Admin" ).click(function() { window.location="Admin.php"; }),   
		
		$( "#btn_spQuery" ).button(),
		$( "#btn_spQuery" ).click(function() { window.location="SpecialQueries.php"; }),   
         
    	// BUTTON
    	$('.fg-button').hover(
    		function(){ $(this).removeClass('ui-state-default').addClass('ui-state-focus'); },
    		function(){ $(this).removeClass('ui-state-focus').addClass('ui-state-default'); }
    	);
    	
    	// MENU	
		$('#flyout').menu({ 
			content: $('#flyout').next().html()
		});
	});