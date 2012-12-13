var oldAppointmentDiv;
var appointmentsToPush = new Array();
var cntr = 0;
$(document).ready(function() {
	$('input[name="start_date"]').datepicker({
        showAnim:'fold',
        dateFormat: 'yy-mm-dd',
		onSelect: function(dateText, inst){
			var startDate = $(this).datepicker("getDate");
			var endDate = new Date(dateText);
			startDate = new Date(startDate);
			if (endDate < startDate){ //PROBLEM!!!
				$('input[name="end_date"]').datepicker("setDate", startDate);
			}
		}
	});
	
	$('input[name="end_date"]').datepicker({
        showAnim:'fold',
        dateFormat: 'yy-mm-dd',
		onSelect: function(dateText, inst) {
			$('#end_date').datepicker( "setDate" , dateText )
		}
	});
	getEventType();
});


function formatDate(date1) {
  return date1.getFullYear() + '-' +
    (date1.getMonth() < 9 ? '0' : '') + (date1.getMonth()+1) + '-' +
    (date1.getDate() < 10 ? '0' : '') + date1.getDate();
}

function initAppointmentTimePickers(){
	$(".lbl_StartTimeEdit").timepicker({
		onSelect: function(dateText, inst){
			if(window.console){
				var theTime = dateText;
				theTime = theTime.split(":");
				
				theHour = theTime[0];
				theHour = theHour.toString();
				if (theHour[0] == '0'){
					theHour = theHour[1];
				}
				theTime[0] = theHour;
				
				newTime = (parseInt(theTime[0]) + 1) + ":"+theTime[1];
				$("#appointmentEndTime").val(newTime);
			}
		}
	});
	
	$(".lbl_StartTimeEdit").blur(function(){
		//add an hour to that time
		var theTime = $("#appointmentStartTime").val();
		theTime = theTime.split(":");
		theHour = theTime[0];
		theHour = theHour.toString();
		if (theHour[0] == '0'){
			theHour = theHour[1];
		}
		theTime[0] = theHour;
		newTime = (parseInt(theTime[0]) + 1) + ":"+theTime[1];
		$(".lbl_EndTimeEdit").val(newTime);
	});
	
	$(".lbl_EndTimeEdit").timepickr();
	$("#btnConfirmAddAppointment").click(function(){
		confirmAppointmentAdd();
	});
	
	
}


function getEventType(){
	
		if (window.XMLHttpRequest)
		  {// code for IE7+, Firefox, Chrome, Opera, Safari
		  var xmlhttp=new XMLHttpRequest();
		  }
		else
		  {// code for IE6, IE5
		  var xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
		  }
		xmlhttp.onreadystatechange=function()
		  {
		  if (xmlhttp.readyState==4 && xmlhttp.status==200)
			{
				var theObj = JSON.parse(xmlhttp.responseText);
				var theArr = new Array();
				var newOpt;
                var theDefault = $('select[name="event_type"]').attr("toselect");
                //alert(theDefault);
                $('select[name="event_type"]').attr("id", "typeSelect");
				var sel = document.getElementById("typeSelect");
				for (var i=0;i<theObj.length;i++){
					newOpt = document.createElement('option');
					newOpt.text = theObj[i].name;
                    //alert(theObj[i].name +" "+ theDefault);                    
                    if(theObj[i].name == theDefault){
                        newOpt.selected="selected";
                    }
					newOpt.value = theObj[i].id;
					try{
						sel.add(newOpt, theObj[i].id);
					}catch(ex){
					
					}
				}
			}
		  }
		xmlhttp.open("GET","php/services/getEventType.php",true);
		xmlhttp.send();
}