var curr_id;
var appDp;
var prev_id;
var eventObj;
var date;
var passed_id;
var date_given
var toHide;
function init(eventId)
{
	curr_id	 = Get('id');
	passed_id = Get('id');
	getEventInfoAndShow(curr_id);
	
	date_given = Get('date');
	
	if (date_given == ''){
		date_given = new Date();
	}
	else
	{
		var theDates = date_given.split('-');
		date_given = new Date(theDates[0], intParser(theDates[1])-1, intParser(theDates[2]));
	}
	
}

function mine(sid){
if (prev_id == sid) return;
var ev = scheduler.getEvent(sid);
scheduler.setEventText(sid, "Appointment");
scheduler.updateEvent(sid);
appDp.setUpdated(sid, true);
prev_id = sid;
var theRecId = passed_id.split('-')[1];
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

			}
		  }
		xmlhttp.open("GET","php/services/updateAppRecId.php?appId=" + sid + "&recId=" + theRecId,true);
		xmlhttp.send();
}

function intParser(str){
	if (str[0] == '0'){
		str = str.substring(1,str.length);
	}
	return parseInt(str);
}


function setupScheduler(obj){
	var browserName=navigator.appName;
	toHide = new Array();
	scheduler.attachEvent("onViewChange", function (mode , date){
       if (mode == 'week'){
			scheduler.config.readonly = true;
	   }
	   else if(mode == 'day'){
			scheduler.config.readonly = false;
	   }
	});
	var theSch = document.getElementById("thescheduler");
	
	//depends on browser...
	if (browserName=="Microsoft Internet Explorer"){
		theSch.style.width =(screen.width-25) +"px";
		theSch.style.height = (screen.height+40) +"px";
	}
	else{
		theSch.style.width =(screen.width-20) +"px";
		theSch.style.height = (screen.height+30) +"px";
	}
	
	scheduler.config.auto_end_date = true;
	scheduler.config.event_duration = 60;
	eventObj = obj;
	scheduler.locale.labels.section_Capacity = "Capacity";	
	scheduler.locale.labels.section_eventInfo = "Event ID";
    scheduler.config.details_on_create=true;
	scheduler.config.details_on_dblclick=true;
	scheduler.config.show_loading =true;
	scheduler.config.multi_day = true;        
    scheduler.config.xml_date="%Y-%m-%d %H:%i";
	scheduler.config.full_day = true;
	
	var start_h = intParser((obj.start_date.split(' ')[1]).split(':')[0]);
	var start_m = intParser((obj.start_date.split(' ')[1]).split(':')[1])/60;
	var end_h = intParser((obj.end_date.split(' ')[1]).split(':')[0]);
	var end_m = intParser((obj.end_date.split(' ')[1]).split(':')[1]) / 60;
	
	// scheduler.config.first_hour = start_h + start_m;
	// scheduler.config.last_hour = end_h+end_m;
	var theDate = obj.start_date.split(' ');
	var theD = theDate[0].split('-');
	date = new Date(theD[0],intParser(theD[1])-1,intParser(theD[2]));
	
	// scheduler.config.limit_time_select = true;
	// scheduler.config.limit_date_select = true;
		
	scheduler.init("thescheduler",date_given,"day");	
	
	scheduler.load("bin\\DHXScheduler\\serverHandler\\app_rec.php?uid="+scheduler.uid());
	
	appDp = new dataProcessor("bin\\DHXScheduler\\serverHandler\\app_rec.php");	
	appDp.init(scheduler);
	appDp.setOnAfterUpdate(mine);
	
	var appView = document.getElementById("info_span");
	appView.innerHTML = "Event: " + obj.text;
	var opt = new Array();
	
	
	var appDetails = {name:"Capacity", height:21, type:"textarea", map_to:"capacity"};//, options:[
		// {key:"5", label:"5"},
		// {key:"10", label:"10"},
		// {key:"15", label:"15"},
		// {key:"20", label:"20"},
		// {key:"25", label:"25"},
		// {key:"30", label:"30"},
		// {key:"35", label:"35"}
	// ]};
	appDetails.value="ASDASD";
	var eventInfo = {name:"eventInfo", height:21, type:"textarea", map_to:"event_id"};
	
	var appInfo = {name:"description", height:21, type:"textarea", map_to:"text"};
	
	var time ={name:"time", height:72, type:"time", map_to:"auto"};

	 
	 scheduler.config.lightbox.sections = [appDetails,eventInfo];//, time];	
	 
	 scheduler.attachEvent("onXLE", function (){
		
		var theStartDate = ((obj.start_date).split(" "))[0];
		var endDate = theStartDate + " 23:59";
		var startDate = theStartDate + " 00:00";
		
		var sDate = (startDate.split(" "))[0];
		var sTime = (startDate.split(" "))[1];
		
		sDate = sDate.split("-");
		sTime = sTime.split(":");
		
		var eDate = (endDate.split(" "))[0];
		var eTime = (endDate.split(" "))[1];
		eDate = eDate.split("-");
		eTime = eTime.split(":");
		
		var sDate = new Date(sDate[0],sDate[1]-1,sDate[2],sTime[0],sTime[1]);
		var eDate = new Date(eDate[0],eDate[1]-1,eDate[2],eTime[0],eTime[1]);
	
		var events = scheduler.getEvents(sDate, eDate);
        for (var i = 0;i<events.length;i++){
		
			checkEventInAppointment(events[i].id, passed_id);
		}

	});
	
	 // scheduler.form_blocks.textarea.set_value=function(node,value,ev){	
		// for(var propertyName in node.firstChild) {
				// //alert(propertyName);
		// }
		// alert(node.firstChild.nodeName);
		// node.firstChild.value=value||"";
		// node.firstChild.disabled = true; // or just = true; to disable for all events
	// }
	scheduler.attachEvent("onLightbox", function(id) {
			  var ev = scheduler.getEvent(id);
			  scheduler.formSection('eventInfo').setValue(curr_id); // note that here i am using name of the section instead of map_to property
			  

	 });
	 
	 scheduler.filter_day = function(ev_id, event){
		
		if(event.text == 'REMOVE'){
			return false; // event will be filtered (not rendered)
		}
		return true; // event will be rendered
	}
	 
	 //setInterval("updateCalendar()", 2000);
}

function updateCalendar(){
	scheduler.load("bin\\DHXScheduler\\serverHandler\\app_rec.php?uid="+scheduler.uid());
}

function checkEventInAppointment(appId, evId){
	
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
				
				var str = xmlhttp.responseText;
				var data = str.split(':');
				if (data[1] == 'F'){
					var ev = scheduler.getEvent(data[0]);
					ev.text = "REMOVE";
					toHide[data[0]] = 1;
					scheduler.updateEvent(data[0]); 
					
					scheduler.render_view_data();
					
				}
			}
		  }
		xmlhttp.open("GET","php/services/isAppointmentForEvent.php?appId=" + appId + "&evId=" + evId,true);
		xmlhttp.send();
}

function goToEvent(){
	var str = date.getFullYear()+"-"+(date.getMonth()+1)+"-"+date.getDate();
	window.location.href = 'AssigningAppointments.php?EventID='+curr_id+'&date='+str;
}

function backToEvent(){
	var str = date.getFullYear()+"-"+(date.getMonth()+1)+"-"+date.getDate();
	window.location.href = 'DHX.php?date='+ str;
}

function getEventInfoAndShow(id){
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
				var theObj = JSON.parse(xmlhttp.responseText);
				if (!theObj){ //invalid id
					alert("Invalid event id!");
					window.location.href = 'DHX.php'
				}else{
					setupScheduler(theObj);
				}
			}
		  }
		xmlhttp.open("GET","php/services/getEventInfo.php?id=" + id,true);
		xmlhttp.send();
}