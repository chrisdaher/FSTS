    var calenderBox = '#div_CalenderBox';
    var filesFoundDiv = '#FilesFoundDiv';
    var fileBlock = '.div_FileBlock';
    var appointmentDivs = '.div_AppointmentBox';
    var currentPage=1;
    var totalPages=0;
    var prev_xmlhttp;
    var inDialog=false;
   $(init, UpdateAppointmentInfo() );
   
   jQuery.expr[':'].focus = function( elem ) {
		return elem === document.activeElement && ( elem.type || elem.href );
	};
   
   $(document).keyup(function (event) {
		if(!inDialog){
    		var theNb = event.keyCode % 49;
    		if (theNb < 0 || theNb > 8) return;
    		if ($("#input_Search").is(":focus")) return;
    		var selectedAppointment = $(".div_AppointmentBox");
    				
    		var theFile = $(".selectedFile");
    		if (theFile.length > 0){
    			to =$(selectedAppointment[theNb]);
    			for (var i =0;i<theFile.length;i++){
    				from=$(theFile[i]).draggable();
    				drag(from, to);
    			}		
    		}
        }
	});
   
   $(function(){
    $( '#dialog_AppInfo' ).dialog({
			autoOpen: false,
			height: 640,
			width: 520,
			modal: true,
			buttons: {
				"Print": function() {
                    var id = $("#dialog_AppInfo").attr("eid");
                    var isEvent = $("#dialog_AppInfo").attr("isevent");
                    var toPrint = $("#dialog_AppInfo").html();
                    printTable(id, isEvent, toPrint);
				},
				Cancel: function() {

					$( this ).dialog( "close" ); 
					
				}
			},
			close: function() {
				inDialog=false;
			}
		});
    $("#input_Search").keyup(searchKeyDown);
	
	$("#div_Data").attr("method", "POST");
	$("#div_Data").attr("action", "php/services/Event/createEvent.php");

   });
   function init(){
        initFilesFound();
        initCalenderBox();
        setInitialFocus();
		setMainFile();
   }
   
   function setMainFile(){
		var id = Get("fileId");		
		if (id != ""){
			$("#input_Search").val(id);
			ajaxSearch(id);
			setTimeout("clickFile("+id+")", 500);
		}
		else{
			$("#input_Search").focus();
		}	
   }	
   
   function clickFile(id){
		$('.div_FileBlock[fileid="'+id+'"]').click();
		$('.div_FileBlock[fileid="'+id+'"]').focus();
		$("#input_Search").blur();
   }
   
   //Calender Initializations
    function initCalenderBox(){
        $(appointmentDivs).droppable( {
          accept: fileBlock,
          hoverClass: 'hovered',
          drop: handleFileDrop
        } );
        $(appointmentDivs).click(function(){
             var allFiles = $(".selectedFile");
            if(allFiles.length>0){
                var from;
                var to;
                for(var i=0; i<allFiles.length;i++){
           	        from=$(allFiles[i]).draggable();
                    to =$(this);
    	           drag(from, to);
               }
            }else{
                previousSelection=$(".selectedAppointment");
                if(previousSelection.attr('appointmentID')!=$(this).attr('appointmentID')){
                    previousSelection.removeClass("selectedAppointment");
                }
                $(this).toggleClass("selectedAppointment");
            }
        });
        $(".div_AppointmentBoxEdit").click(function(){
			var type = ($(this).get(0).tagName);
			if (type == "FORM") return;
			
			ToggleEditAppointment(Get("EventID"), $("#div_Calender"), $(this).attr("appointmentid"));
        });
        $('.btn_AddAppointment').button({
            icons:{
                primary: "ui-icon-plus"
            },
            height:15,
            width:15
        });
        $('.btn_AddAppointment').click(function(){
            ToggleEditAppointment(Get("EventID"), $("#div_Calender"), -2);
        });
        $('.btn_AppDelete').button({
            icons:{
                primary: "ui-icon-trash"
            },
            height:15,
            width:15
        });
        $(".btn_AppDelete").click("click", function(){
            //	($(this).attr("appointmentid"));
			var id = $(this).attr("appid");
			DeleteAppointment(id);
        });
        $('.btn_AppInfo').button({
            icons:{
                primary: "ui-icon-info"
            },
            height:15,
            width:15
        });
        $('.btn_AppInfo').click(function(){
                var tempID = $(this).attr('AppID');
                getAppointmentInfo(tempID);
        });
    }
	
	
	function DeleteAppointment(appId){
		var xmlhttp;
        if (window.XMLHttpRequest)
          {// code for IE7+, Firefox, Chrome, Opera, Safari
          xmlhttp=new XMLHttpRequest();
          }
        else
          {// code for IE6, IE5
          xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
          }
        xmlhttp.onreadystatechange=function()
          {
          if (xmlhttp.readyState==4 && xmlhttp.status==200)
            {
                var txt = xmlhttp.responseText;
				if (txt[0] != 'S'){
					alert("Error occured deleting appointment....");
				}
				else{
					//alert("DELETED!");
				}
				ToggleEditAppointment(Get("EventID"), $("#div_Calender"));
            }
          }
        xmlhttp.open("GET","php/services/Event/DeleteAppointment.php?id="+appId,true);
        xmlhttp.send();
	}
	
	function SaveAppointment(appId){
		if (appId == ""){
			appId = -1;
		}
		
		var start_date =  $(".lbl_StartDateEdit").val();
		var start_time = $('input[name="start_time"]').val();
		var end_date = $(".lbl_EndDateEdit").val();
		var end_time = $('input[name="end_time"]').val();
		var cap = $(".lbl_AppCap").val();
		var evId = Get("EventID");
		start_date = start_date + " " + start_time;
		end_date = end_date + " " + end_time;
		
		var xmlhttp;
        if (window.XMLHttpRequest)
          {// code for IE7+, Firefox, Chrome, Opera, Safari
          xmlhttp=new XMLHttpRequest();
          }
        else
          {// code for IE6, IE5
          xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
          }
        xmlhttp.onreadystatechange=function()
          {
          if (xmlhttp.readyState==4 && xmlhttp.status==200)
            {
                var txt = xmlhttp.responseText;
				var appId = parseInt(txt);
				ToggleEditAppointment(Get("EventID"), $("#div_Calender"));
            }
          }
        xmlhttp.open("GET","php/services/Event/AddAppointment.php?startDate="+start_date + "&endDate="+end_date+
			"&cap="+cap+"&evId="+evId+"&appId="+appId,true);
        xmlhttp.send();
	}
	
    function initEditApp(){
        $(".btn_AppCurrentDelete").button({
            icons:{
                primary: "ui-icon-trash"
            },
            height:15,
            width:15
        });
        $(".btn_AppCurrentDelete").click("click", function(){
            //DeleteAppointment($(this).attr("appointmentid"));
			var id = $(this).attr("appid");
			DeleteAppointment(id);
        });
        $('.btn_AppCurrentDone').button({
            icons:{
                primary: "ui-icon-check"
            },
            height:15,
            width:15
        });
        $(".btn_AppCurrentDone").click("click", function(){
            //DeleteAppointment($(this).attr("appointmentid"));
			var id = $(this).attr("appid");
			SaveAppointment(id);
        });
        $('.btn_AppCurrentCancel').button({
            icons:{
                primary: "ui-icon-close"
            },
            height:20,
            width:20
        });
        $('.btn_AppCurrentCancel').click(function(){
                ToggleEditAppointment(Get("EventID"), $("#div_Calender"));
        });
    }
   //Files Found Initializations
   function initFilesFound() {
        FilesFoundRefresh();
        DropRefresh();
        prevLimit=$("#btn_prevFileSet").attr('limit');
        nextLimit=$("#btn_nextFileSet").attr('limit');
        totalPages=nextLimit;
        $("#btn_prevFileSet").button();
        $("#btn_prevFileSet").click(function(){
            if(currentPage>prevLimit){
                showPage(currentPage, --currentPage);
                }
            });
        
        $("#btn_nextFileSet").button();
        $("#btn_nextFileSet").click(function(){
            if(currentPage<nextLimit){
                showPage(currentPage, ++currentPage);
                }
            });
        showPage(1,1);
            
   }
   
   //Show the right page in files found
    function showPage(oldPage, newPage){ 
        $('.GalleryContainer[page="'+oldPage+'"]').addClass("HiddenGallery");
        $('.GalleryContainer[page="'+newPage+'"]').removeClass("HiddenGallery");
        $('#lbl_page').html("page: "+newPage+" of "+totalPages);
    }
    
    //set the initial focus	
    function setInitialFocus(){
        $("#input_Search").focus();
    }

    //Better String replace
 	function strReplace(str, toRep, val){
		var newString = "";
		var temp;
		for (var i=0;i<str.length;i++){
			temp = str[i];
			 if (temp == toRep){
				 temp = val;				 
			 }
			 newString+=temp;
	    }
		return newString;
	}	
	function getAppointmentInfo(appID){
        var xmlhttp;
        if (window.XMLHttpRequest)
          {// code for IE7+, Firefox, Chrome, Opera, Safari
          xmlhttp=new XMLHttpRequest();
          }
        else
          {// code for IE6, IE5
          xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
          }
        xmlhttp.onreadystatechange=function()
          {
          if (xmlhttp.readyState==4 && xmlhttp.status==200)
            {
                OpenAppointmentInfo(xmlhttp.responseText,appID);
                initAppInfo();
				
            }
          }
        xmlhttp.open("GET","php/controller/Submit/GetAppointmentInfo.php?appID="+appID,true);
        xmlhttp.send();
	}
	function getEventAttendance(eventID, searchString){
        if (undefined != prev_xmlhttp){
			prev_xmlhttp.abort();
		}
        if (window.XMLHttpRequest)
          {// code for IE7+, Firefox, Chrome, Opera, Safari
          xmlhttp=new XMLHttpRequest();
          }
        else
          {// code for IE6, IE5
          xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
          }
        xmlhttp.onreadystatechange=function()
          {
          if (xmlhttp.readyState==4 && xmlhttp.status==200)
            {
                UpdateAttendance(xmlhttp.responseText, "Event Attendance");
                initAppData();
            }
          }
        xmlhttp.open("GET","php/controller/Submit/GetEventAttendance.php?eventID="+eventID+"&searchString="+searchString,true);
        xmlhttp.send();
        prev_xmlhttp=xmlhttp;
	}
	function printTable(id, isEvent, toPrint){
	   $.post("php/services/printing/PrintAttendance.php",
          { id: id, isEvent: isEvent, toPrint: toPrint },
          function(data){
            window.location=data;
          });
	}
	function getEventInfo(eventID){
        var xmlhttp;
        if (window.XMLHttpRequest)
          {// code for IE7+, Firefox, Chrome, Opera, Safari
          xmlhttp=new XMLHttpRequest();
          }
        else
          {// code for IE6, IE5
          xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
          }
        xmlhttp.onreadystatechange=function()
          {
          if (xmlhttp.readyState==4 && xmlhttp.status==200)
            {
                OpenAppointmentInfo(xmlhttp.responseText, eventID, "Event Attendance");
                initAppInfo();
				
            }
          }
        xmlhttp.open("GET","php/controller/Submit/GetEventInfo.php?eventID="+eventID,true);
        xmlhttp.send();
	}
	function ToggleEditAppointment(eventID, toChange, appID){
        var xmlhttp;
        if(appID == undefined){
            appID=-1;
        }
        if (window.XMLHttpRequest)
          {// code for IE7+, Firefox, Chrome, Opera, Safari
          xmlhttp=new XMLHttpRequest();
          }
        else
          {// code for IE6, IE5
          xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
          }
        xmlhttp.onreadystatechange=function()
          {
          if (xmlhttp.readyState==4 && xmlhttp.status==200)
            {
                toChange.parent().html(xmlhttp.responseText);
                initCalenderBox();
                initEditApp();
				
            }
          }
        xmlhttp.open("GET","php/controller/AjaxDisplay/ToggleEditAppointment.php?appID="+appID+"&eventID="+eventID,true);
        xmlhttp.send();
	}
    function OpenAppointmentInfo(appInfo, id, title){
        inDialog=true;
        var isEvent = true;
        if(title==undefined){
            isEvent=false;            
            title="Appointment Info";
        }
        if(id==undefined){
            id = -1;
        }
        $("#dialog_AppInfo").html(appInfo);
        $("#dialog_AppInfo").dialog( "option", "title", title );
        $("#dialog_AppInfo").dialog( "open" );
        $("#dialog_AppInfo").attr("EID" , id );
        $("#dialog_AppInfo").attr("isevent" , isEvent );
    }
    function UpdateAttendance(Attendance){
        $("#appointmentFilesInfo").html(Attendance);
    }
    function UpdateAppointmentInfo(){
        setInterval("setNewCapacity()", 1500);
    }
    function setNewCapacity(){
        var AppDivs = $(".div_AppOptions");
        var currentSize, currentCap;
        for(var i=0; i<AppDivs.length; i++){
            var lbl_Current=$($(AppDivs[i]).find('.lbl_AppCurrent')[0]), lbl_Cap=AppDivs[i].childNodes[3];
            var tempArr = getAppCap(AppDivs[i].getAttribute('appID'),lbl_Current, lbl_Cap);
        }
    }
    function getAppCap(appID, sizeToUpdate, capToUpdate){
		
        var xmlhttp;
        if (window.XMLHttpRequest)
          {// code for IE7+, Firefox, Chrome, Opera, Safari
          xmlhttp=new XMLHttpRequest();
          }
        else
          {// code for IE6, IE5
          xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
          }
        xmlhttp.onreadystatechange=function()
          {
          if (xmlhttp.readyState==4 && xmlhttp.status==200)
            {
				var ret = xmlhttp.responseText;
				//alert(ret);
				var data = ret.split(':');
				
                var Size=data[0];
                var Capacity=data[1];
                var currentSize=parseInt($(sizeToUpdate).html());
                var currentCap=parseInt($(capToUpdate).html());
                if(currentSize != Size){
                    $(sizeToUpdate).fadeOut(600, 'swing', function(){
                        $(sizeToUpdate).html(Size);
                        $(sizeToUpdate).fadeIn(600, 'swing' ,function(){});
                    });
                    $(sizeToUpdate).css("display", "block");
                    
                }
                if(currentCap!=Capacity){
                    $(capToUpdate).fadeOut(600, 'swing', function(){
                        $(capToUpdate).html(Capacity);
                        $(capToUpdate).fadeIn(600, 'swing' ,function(){});
                    });
                    $(capToUpdate).css("display", "block");
                }
            }
          }
        xmlhttp.open("GET","php/controller/Submit/getAppSize.php?appID="+appID,true);
        xmlhttp.send();
    }
    function initAppInfo(){
        initAppData();
        $('#input_SearchAttendance').keyup(function(e){
            if(e.keyCode!=16){
                getEventAttendance(Get("EventID"), $(this).val());
            }
        });
    }
    function initAppData(){
        $('.btn_removeFile').button({
            height:15,
            width:15,
            icons:{
                primary:"ui-icon-trash"
            }
        });
        $('.btn_editFile').button({
            height:15,
            width:15,
            icons:{
                primary:"ui-icon-pencil"
            }
        });
        $('.btn_attendance').button({
            icons:{
                primary:"ui-icon-check"
            }
        });
		
		$('.btn_attendance').click(function(){
			var isChecked = ($(this).is(':checked'));			
			var fileId = $(this).attr("fileid");
			var evId = Get("EventID");
			doAttendance(isChecked, fileId, evId);

        });
        $('.btn_removeFile').click(function(){
            var fileID=$(this).attr('fileID'), appID= $(this).attr('appID'), toRemove=$(".div_appInfo_file[fileID='"+fileID+"']");
            removeFileFromApp(fileID,appID ,toRemove );
			$('.btn_removeFile').attr("disabled", "disabled");
        });
        $('.btn_editFile').click(function(){
            window.location = "File_Page.php?id="+$(this).attr('fileID')+"edit=1";
        });
        $("#appointmentFilesInfo").addClass("tablesorter");
        $(".tablesorter").tablesorter({
            handle: 'td:att_FileID'
        }).disableSelection();
    }
	
	function doAttendance(ischkd, fid, eid){
		if (ischkd){
			ischkd = 1;
		}
		else{
			ischkd = 0;
		}
		var xmlhttp;
        if (window.XMLHttpRequest)
          {// code for IE7+, Firefox, Chrome, Opera, Safari
          xmlhttp=new XMLHttpRequest();
          }
        else
          {// code for IE6, IE5
          xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
          }
        xmlhttp.onreadystatechange=function()
          {
          if (xmlhttp.readyState==4 && xmlhttp.status==200)
            {
                var text = xmlhttp.responseText;
				
				if (text[0] != 'S'){
					alert("ERROR!");
				}
            }
          }
        xmlhttp.open("GET","php/services/Event/Attendance.php?evId="+eid+"&fId="+fid+"&att="+ischkd,true);
        xmlhttp.send();
	}
	
    function removeFileFromApp(fileID, appID, toRemove){
        		
        var xmlhttp;
        if (window.XMLHttpRequest)
          {// code for IE7+, Firefox, Chrome, Opera, Safari
          xmlhttp=new XMLHttpRequest();
          }
        else
          {// code for IE6, IE5
          xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
          }
        xmlhttp.onreadystatechange=function()
          {
          if (xmlhttp.readyState==4 && xmlhttp.status==200)
            {
                var status = xmlhttp.responseText;
                if(status != 'E'){
                    toRemove.remove();
					//var toEnable = $(".div_FileBlock[fileID='"+fileID+"']");
					
					searchSubmit(true);
					
					var cap = document.getElementById('app_info_size');
					var newSize = xmlhttp.responseText;
					cap.innerHTML = newSize;
                }
				else{
					alert("You're not supposed to see this...");
					alert(status);
				}
				$('.btn_removeFile').removeAttr("disabled");
            }
          }
        xmlhttp.open("GET","php/controller/Submit/removeFileFromApp.php?appID="+appID+"&fileID="+fileID,true);
        xmlhttp.send();
        //toRemove.css("display","none");

    }
    