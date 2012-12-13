$(function() {
    var pageLink="AssigningAppointments.php";
    var id = Get('EventID');
    var isEdit = Get('edit');
    var date = Get('date');
    //make all the buttons in the option bar jQuery buttons...
    $( ".JQuery_button" ).button();
    
    // set the event handler for each button
	$("#btn_Return").click(function(){		
		window.location="appView.php?id="+id+"&date="+date;
	});
	
    $( "#btn_Edit"  ).click(function() { 
        window.location=pageLink+"?EventID="+id+"&date="+date+"&edit=1";
    });
    $( "#btn_Delete"  ).click(function() { 
        //var id = Get('id');
        window.location="php/Submit/deleteEvent.php";
    });
    $( "#btn_Done"  ).click(function() { 
        $("#div_Data").submit();
    });
    $( "#btn_Cancel"  ).click(function() { 
		if (id == "new"){
			window.location="Homepage.php";
		}
		else{
			if(id==""){
				window.location=pageLink+"?EventID=new&date="+date;                    
			}else{
				window.location=pageLink+"?EventID="+id+"&date="+date;
			}
		}
    });
    $( "#btn_New"  ).click(function() { window.location=pageLink+"?id=new&edit=2"; });
    $('#btn_Attendance').click(function(){
         var tempID = Get("EventID");
         getEventInfo(tempID);
    });
});