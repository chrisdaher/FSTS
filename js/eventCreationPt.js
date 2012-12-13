var oldAppointmentDiv;
var appointmentsToPush = new Array();
var cntr = 0;
$(document).ready(function() {
	$('#end_date').datepicker({
		onSelect: function(dateText, inst){
			var startDate = $('#start_date').datepicker("getDate");
			var endDate = new Date(dateText);
			startDate = new Date(startDate);
			if (endDate < startDate){ //PROBLEM!!!
				$('#end_date').datepicker("setDate", startDate);
			}
		}
	});
	
	$('#start_date').datepicker({
		onSelect: function(dateText, inst) {
			$('#end_date').datepicker( "setDate" , dateText )
		}
	});
	
	$("#btn_addAppointment").click(function(){
		addAppointment();
	});
	
	var sel = document.getElementById("typeSelect");
	sel.onchange = function(){
		var sel = document.getElementById("typeSelect");
		//sel.value;
	}
	
	$("#btnCreateEvent").click(function(){
		createEvent();
	});
	
	getEventType();
});

function createEvent(){
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
				alert(xmlhttp.responseText);
			}
		  }
	var eventText = $("#txt_eventName").val();
	var sd = $("#start_date").datepicker("getDate");
	var ed = $("#end_date").datepicker("getDate");
	
	sd = formatDate(sd);
	ed = formatDate(ed);
	
	var sel = document.getElementById("typeSelect");
	var evType = sel.value;
	
	xmlhttp.open("GET","php/services/Event/createEvent.php?text="+eventText+"&start_date="+sd+"&end_date="+ed+"&event_type="+evType,true);
	xmlhttp.send();
}

function formatDate(date1) {
  return date1.getFullYear() + '-' +
    (date1.getMonth() < 9 ? '0' : '') + (date1.getMonth()+1) + '-' +
    (date1.getDate() < 10 ? '0' : '') + date1.getDate();
}

function addAppointment(){
	var mainDiv = document.getElementById("appointmentDivMain");
	if (oldAppointmentDiv !== undefined){
		mainDiv.removeChild(oldAppointmentDiv);
	}
	
	var bodyDiv = document.createElement('div');
	bodyDiv.setAttribute('id', 'bodyDiv');
	bodyDiv.setAttribute('class', 'addAppointmentDiv');
	
	var inputBox = document.createElement('input');
	inputBox.setAttribute('id', 'appointmentStartTime');
	bodyDiv.appendChild(inputBox);
	
	var inputBox = document.createElement('input');
	inputBox.setAttribute('id', 'appointmentEndTime');
	bodyDiv.appendChild(inputBox);
	
	var inputBox = document.createElement('input');
	inputBox.setAttribute('id', 'appointmentAddCapacity');
	bodyDiv.appendChild(inputBox);
	
	var inputBox = document.createElement('button');
	inputBox.setAttribute('id', 'btnConfirmAddAppointment');
	inputBox.innerHTML = "ADD";
	bodyDiv.appendChild(inputBox);
	
	var inputBox = document.createElement('button');
	inputBox.setAttribute('id', 'btnRemoveAppointmentAdding');
	inputBox.innerHTML = "X";
	bodyDiv.appendChild(inputBox);
	
	document.getElementById("appointmentDivMain").appendChild(bodyDiv);
	
	$("#appointmentStartTime").timepicker({
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
	
	$("#appointmentStartTime").blur(function(){
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
		$("#appointmentEndTime").val(newTime);
	});
	
	$("#appointmentEndTime").timepickr();
	$("#btnConfirmAddAppointment").click(function(){
		confirmAppointmentAdd();
	});
	
	$("#btnRemoveAppointmentAdding").click(function(){
		removeAppointmentAdding();
	});
	
	oldAppointmentDiv = bodyDiv;
	
}

function removeAppointmentAdding(){
	var mainDiv = document.getElementById("appointmentDivMain");
	if (oldAppointmentDiv !== undefined){
		mainDiv.removeChild(oldAppointmentDiv);
		oldAppointmentDiv = undefined;
	}
}

function confirmAppointmentAdd(){
	var sd = $("#appointmentStartTime").val();
	var ed = $("#appointmentEndTime").val();
	var cap = $("#appointmentAddCapacity").val();
	var thePushString = sd + "," + ed + "," + cap;
	appointmentsToPush[cntr] = thePushString;
	cntr++;
	
	var mainDiv = document.getElementById("appointmentDivMain");
	if (oldAppointmentDiv !== undefined){
		mainDiv.removeChild(oldAppointmentDiv);
		oldAppointmentDiv = undefined;
	}
	
	var bodyDiv = document.createElement('div');
	bodyDiv.setAttribute('id', 'bodyDiv');
	bodyDiv.setAttribute('class', 'confirmedAppointment');
	
	var inputBox = document.createElement('label');
	inputBox.setAttribute('id', 'confirmedAppointmentStartTime');
	inputBox.setAttribute('class', 'confirmedAppointmentLabel');
	inputBox.innerHTML = sd;
	bodyDiv.appendChild(inputBox);
	
	var inputBox = document.createElement('label');
	inputBox.setAttribute('id', 'confirmedAppointmentEndTime');
	inputBox.setAttribute('class', 'confirmedAppointmentLabel');
	inputBox.innerHTML = ed;
	bodyDiv.appendChild(inputBox);
	
	var inputBox = document.createElement('label');
	inputBox.setAttribute('id', 'confirmedAppointmentCapacity');
	inputBox.setAttribute('class', 'confirmedAppointmentLabel');
	inputBox.innerHTML = cap;
	bodyDiv.appendChild(inputBox);
	
	mainDiv.appendChild(bodyDiv);
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
				var sel = document.getElementById("typeSelect");
				for (var i=0;i<theObj.length;i++){
					newOpt = document.createElement('option');
					newOpt.text = theObj[i].name;
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