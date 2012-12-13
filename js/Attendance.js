    var calenderBox = '#div_CalenderBox';
    var filesFoundDiv = '#FilesFoundDiv';
    var fileBlock = '.div_FileBlock';
    var appointmentDivs = '.div_AppointmentBox';
    var currentPage=1;
    var totalPages=0;
    var prev_xmlhttp;
    var inDialog=false;
   $(init );
      
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
   

   function init(){
	$('#input_Search').keyup(function(e){
		if(e.keyCode!=16){
			getEventAttendance(Get("EventID"), $(this).val());
		}
	});
	$('#input_Search').keyup();
	$('#div_FileIdNumber').keypress(function(e){
		if(e.which==13){
			window.location = "Attendance.php?EventID="+$(this).val();
		}
	});
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
                initAttendance();
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
	function UpdateAttendance(Attendance){
        $(".Attendance_SearchResults").html(Attendance);
    }

	function initAttendance(){
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
        $(".Attendance_SearchResults").addClass("tablesorter");
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
	