var currX;
var currY;
var prev_id;
var tempo_id;
var curr_id;
var spec_id;
var isApp;
var eventDp;
var appDp;
var defaultLightBox;
var date_given;
$(function() {
    $("#draggable").draggable(),
    $(".dhx_scale_holder").droppable() 
});

function eventAdded(evId, evObj){
	alert(scheduler.toJSON());
	alert(scheduler.render_table());
}

jQuery(document).ready(function(){
   $("#thescheduler").mousemove(function(e){
		currX = e.pageX;
		currY = e.pageY;
   }); 
})

function mine(sid, action){
// if (tempo_id == sid || action == 'updated') return;

// var ev = scheduler.getEvent(sid);
// var currTxt = scheduler.getEventText(sid);
// var temp = currTxt.split(' - ');
// currTxt = temp[0];
// scheduler.setEventText(sid, currTxt + " - ID #" + sid);
// scheduler.updateEvent(sid);
// eventDp.setUpdated(sid, true);
// tempo_id = sid;

}


function initDefault(){
		var theSch = document.getElementById("thescheduler");
		theSch.style.width =(screen.width-5) +"px";
		theSch.style.height = (screen.height-200) +"px";
		scheduler.config.full_day = true;
		scheduler.config.auto_end_date
		scheduler.locale.labels.workweek_tab = "W-Week";
		scheduler.locale.labels.section_Capacity = "Capacity";
		scheduler.locale.labels.section_eventInfo = "Event ID";
		scheduler.date.workweek_start = scheduler.date.week_start;
    	scheduler.config.details_on_create=true;
		scheduler.config.details_on_dblclick=true;
		scheduler.config.show_loading =true;
		scheduler.config.multi_day = true;        
		scheduler.config.mark_now = true;
		scheduler.config.hour_date = "";
        scheduler.config.xml_date="%Y-%m-%d %H:%i";
		scheduler.init("thescheduler",date_given,"month");	
		scheduler.load("bin\\DHXScheduler\\serverHandler\\events_rec.php?uid="+scheduler.uid());
				
		eventDp = new dataProcessor("bin\\DHXScheduler\\serverHandler\\events_rec.php");
		eventDp.init(scheduler);
		eventDp.setOnAfterUpdate(mine);
		
		
		
		scheduler.date.get_workweek_end=function(date){ 
            return scheduler.date.add(date,5,"day"); 
		}
		
		 scheduler.date.add_workweek=function(date,inc){ 
            return scheduler.date.add(date,inc*7,"day");
		}
		
		scheduler.templates.workweek_date = scheduler.templates.week_date;
		scheduler.templates.workweek_scale_date = scheduler.templates.week_scale_date;
		
		defaultLightBox = scheduler.config.lightbox.sections;
		
		getEventType(scheduler);
				
		 //scheduler.attachEvent("onClick", eventClickHandler);
		 scheduler.attachEvent("onmousemove", function (event_id, native_event_object){
			spec_id = -1;
			
			 if (event_id!=null){
				 curr_id = event_id;
				 spec_id = curr_id;
			 }
		 });					 
		 
		 
		var theDiv = document.getElementById("back_event");
		theDiv.style.display = "none";
		var theDiv = document.getElementById("info_event");
		theDiv.style.display = "none";
				
		scheduler.setCurrentView(null,"month");	
		

		var theDiv = document.getElementById("day_tab");
		theDiv.style.display = "none";
		var theDiv = document.getElementById("week_tab");
		theDiv.style.display = "none";
		var theDiv = document.getElementById("workweek_tab");
		theDiv.style.display = "none";
		
		
		 scheduler.attachEvent("onEventIdChange", function(old_event_id,new_event_id){
			//alert("OLD: " + old_event_id + "\nNEW: " + new_event_id);
			var send = false;   			
			if (old_event_id.indexOf('#') != -1){
				send = true;
			}

			if (send == true && send == false){
						
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
								//alert(xmlhttp.responseText);
							}
						  }
						var theData = old_event_id.split('#');
						xmlhttp.open("GET","php/services/setRecIdEvent.php?oldId=" + theData[0] + "&newId="+theData[1],true);
						xmlhttp.send();
					}
					else if (send == false){
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
								//alert(xmlhttp.responseText);
							}
						  }
						var ev = scheduler.getEvent(new_event_id);
						var theData = old_event_id.split('#');
						xmlhttp.open("GET","php/services/resetAppId.php?recId=" + ev.event_length + "&newId="+new_event_id,true);
						xmlhttp.send();
					}
			});
			
//			setInterval("updateCalendar()", 2000);
			
	}
	
function updateCalendar(){
	
	scheduler.load("bin\\DHXScheduler\\serverHandler\\events_rec.php?uid="+scheduler.uid());
}
function backToEvent(){
	setDefaultView();
}

function initAppointmentView(eventObj, date){

	var toSend = curr_id.replace('#', '-');
	var str = date.getFullYear()+"-"+(date.getMonth()+1)+"-"+date.getDate();
	window.location.href = 'appView.php?id='+toSend+"&date="+str;
	
	// //scheduler.xy.nav_height = 0;
	// var theDiv = document.getElementById("prev_button");
	// theDiv.style.display = "none";
	// var theDiv = document.getElementById("next_button");
	// theDiv.style.display = "none";
	// var theDiv = document.getElementById("today_button");
	// theDiv.style.display = "none";
	// var theDiv = document.getElementById("day_tab");
	// theDiv.style.display = "none";
	// var theDiv = document.getElementById("week_tab");
	// theDiv.style.display = "none";
	// var theDiv = document.getElementById("month_tab");
	// theDiv.style.display = "none";
	// var theDiv = document.getElementById("workweek_tab");
	// theDiv.style.display = "none";
	
	// var theDiv = document.getElementById("back_event");
	// theDiv.style.display = "";
	// var theDiv = document.getElementById("info_event");
	// theDiv.style.display = "";
	
	// var appView = document.getElementById("info_span");
	// appView.innerHTML = "Event: " + eventObj.text;
	
	// // var appView = document.getElementById("info_event");
	// // appView.onmouseover = tooltip.show('Testing 123');
	// // //appView.hover  = tooltip.show('Testing 123');
	// // //onmouseover="tooltip.show('Testing 123 <strong>Testing 123</strong>');"
	
	// scheduler.setCurrentView(eventObj.start_date, "day");
	// scheduler.clearAll();
	
	
	// scheduler.load("DHXScheduler\\serverHandler\\app_rec.php?uid="+scheduler.uid()); 
		
	  // scheduler.attachEvent("onLightbox", function(id) {
		 // if (isApp){
			  // var ev = scheduler.getEvent(id);
			  // scheduler.formSection('eventInfo').setValue(curr_id); // note that here i am using name of the section instead of map_to property
		 // }
	 // });
		

	// var appDetails = {name:"Capacity", height:21, type:"select", map_to:"capacity", options:[
		// {key:"5", label:"5"},
		// {key:"10", label:"10"},
		// {key:"15", label:"15"},
		// {key:"20", label:"20"},
		// {key:"25", label:"25"},
		// {key:"30", label:"30"},
		// {key:"35", label:"35"}
	// ]};
	
	// var eventInfo = {name:"eventInfo", height:21, type:"textarea", map_to:"event_id"};
	
	// var appInfo = {name:"description", height:21, type:"textarea", map_to:"text"};
	
	 // scheduler.form_blocks.textarea.set_value=function(node,value,ev){
         // node.firstChild.value=value||"";
         // node.firstChild.disabled = true; // or just = true; to disable for all events
     // }
	
	 // scheduler.resetLightbox();
	 // scheduler.config.lightbox.sections = [appInfo,appDetails,eventInfo,{ name:"time", height:72, type:"time", map_to:"auto"}];	
	 // scheduler.resetLightbox();
	 
	// detachDp(eventDp);
	// appDp.init(scheduler);		
}

function setDefaultView(){
	isApp = false;
	
	scheduler.xy.nav_height = 0;
	var theDiv = document.getElementById("prev_button");
	theDiv.style.display = "";
	var theDiv = document.getElementById("next_button");
	theDiv.style.display = "";
	var theDiv = document.getElementById("today_button");
	theDiv.style.display = "";
	var theDiv = document.getElementById("day_tab");
	theDiv.style.display = "";
	var theDiv = document.getElementById("week_tab");
	theDiv.style.display = "";
	var theDiv = document.getElementById("month_tab");
	theDiv.style.display = "";
	var theDiv = document.getElementById("workweek_tab");
	theDiv.style.display = "";
	
	var theDiv = document.getElementById("back_event");
	theDiv.style.display = "none";
	var theDiv = document.getElementById("info_event");
	theDiv.style.display = "none";
	
	scheduler.clearAll();
	scheduler.load("bin\\DHXScheduler\\serverHandler\\events_rec.php?uid="+scheduler.uid());
	scheduler.setCurrentView(null, "workweek");
	scheduler.resetLightbox();
	scheduler.config.lightbox.sections = defaultLightBox;
	scheduler.resetLightbox();
	
	scheduler.form_blocks.textarea.set_value=function(node,value,ev){
        node.firstChild.value=value||"";
        node.firstChild.disabled = false; // or just = true; to disable for all events
    }
		  
}

function detachDp(dp){	
	delete dp;
}

function goToEvent(){
	//window.location.href = 'AssigningAppointments.php?id='+curr_id;
}

function setAppView(eventObj, theDate){
	initAppointmentView(eventObj, theDate);
	isApp = true;
}

function intParser(str){
	if (str[0] == '0'){
		str = str.substring(1,str.length);
	}
	return parseInt(str);
}

function setupScheduler(isFull){
	date_given = Get('date');
	// var temp = "";
	// for (var i =0;i<date_given.length;i++){
		// if (date_given[i] == ' ') break;
		// temp += date_given[i];
	// }
	if (date_given == ''){
		date_given = new Date();
	}
	else
	{
		var theDates = date_given.split('-');
		date_given = new Date(theDates[0], intParser(theDates[1])-1, intParser(theDates[2]));
	}
	// if (date_given == 'Invalid Date') 
		// date_given = null;			
	initDefault();
	isApp = false;
	if (!isFull){
		isApp = true;
		initAppointmentView();
	}		 
}

function rightClick(){
	// if (curr_id!=-1){
		// window.location="./php/eventInfo.php?id="+curr_id;
	// }
	// return false;
	//setAppView(curr_id);
	if (!isApp && spec_id!=-1){

		getEventInfoAndShow(curr_id);
	}
}

function eventClickHandler(event_id, native_event_object){
	if (prev_id == event_id){
		scheduler.unselect(event_id);	 				
		prev_id = -1;
	}
	else{
		scheduler.select(event_id);	 
		prev_id = event_id;
	 }
	 
}

function addEventLinkInfo(){

	scheduler.form_blocks["my_eventApp"]={
		render:function(sns){
			return "<div class='dhx_cal_ltext' style='height:25px;'><a href=\"#\">See event info.</a></div>";
		},
		set_value:function(node,value,ev){
			
		},
		get_value:function(node,ev){
			
		},
		focus:function(node){
			
		}
	}
	
	scheduler.config.lightbox.sections.unshift({name:"description", height:11, type:"my_eventApp"});
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
				var theEv  = scheduler.getEvent(id);
				setAppView(theObj, theEv.start_date);
			}
		  }
		xmlhttp.open("GET","php/services/getEventInfo.php?id=" + id,true);
		xmlhttp.send();
}

function getEventType(sch){
	
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
				var theArr = new Array();
				for (var i=0;i<theObj.length;i++){
					theArr.push({key:theObj[i].id, label:theObj[i].name});
				}
				sch.config.lightbox.sections = defaultLightBox;
				sch.config.lightbox.sections.unshift({name:"description", height:21, type:"select", map_to:"event_type_id", options:theArr}); 	
				//sch.config.lightbox.sections.pop();
			}
		  }
		xmlhttp.open("GET","php/services/getEventType.php",true);
		xmlhttp.send();
}
