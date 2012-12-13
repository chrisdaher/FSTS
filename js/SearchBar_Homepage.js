var mainSelected;
var secSelected;
var gotMainResult;
var gotSecondaryResult;
var mainSel;
var innerSel;
var isAdvanced;
var prevAdv_xmlhttp;
var prev_xmlhttp;

function removeLabel(event){
	var theKeyCode = event.keyCode;
	
	var TABKEY = 9;
	var keyDown=40;
	if (innerSel || !isAdvanced){
		 if(theKeyCode == TABKEY) {
				if(event.preventDefault) {
					event.preventDefault();
				}
				var theFor = $(".ui-state-active").attr("for");
				if (theFor == 'radio1'){
					$('[for="radio2"]').click();
				}
				else{
					$('[for="radio1"]').click();
				}
				
				if (isAdvanced){
					resetAdvancedSearch();
				}
				
				//$("#input_Search").val("");
				return false;
		 }
		 else if(theKeyCode == 40){
			$('[tabindex="0"]').focus();
		 }
	}
	
	var theTxt = document.getElementById('input_Search');
	var theVal = theTxt.value;
	
	if (theKeyCode==8 && theVal==""){
		$("#label_SearchTag3").click();
	}
}

function searchKeyDown(e){
	var theKeyCode = e.keyCode;
	
	
	var theTxt = document.getElementById('input_Search');
	var theVal = theTxt.value;
	
	if (theVal == "" && theKeyCode == 13 && !isAdvanced){
		var st1 = $("#label_SearchTag1").css("visibility");
		if (st1 == 'visible'){
			window.location = "File_Page.php";
		}
		else{
			var st1 = $("#label_SearchTag2").css("visibility");
			if (st1 == 'visible'){
					window.location = "AssigningAppointments.php?EventID=";
			}
		}
	}
	
	
	if (theVal != '.'){	
			
		if (theVal.length<3 && theKeyCode!=13){
			$('#div_Column2').html("");
			$('#div_Column3').html("");
			return;
		}
		
		if (mainSelected && secSelected && theVal!=""){
			doSearch(theVal);
			return;
		}
		
		if (theKeyCode == 13 && !isAdvanced){
			searchSubmit(true);
		}
		else if (!isAdvanced){	
			searchSubmit(false);
		}
	}
	else{
		searchAdvance(theKeyCode, theVal);
	}
}

function resetSecondary(){
	gotSecondaryResult = false;
	secSelected	= false;
	
	var temp = mainSel.replace(".", "");
	$("#label_SearchTag3").html(temp);	
	$("#input_Search").val("");
	setInitialFocus();
}

function searchAdvance(kc, val){

	if (!mainSelected && !gotMainResult){
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
				var searchResults = xmlhttp.responseText;
				
				var theObj = JSON.parse(searchResults);
				
				var toAc = new Array();
				for (var i=0;i<theObj.length;i++){
					var temp = theObj[i];
					var istr = (i+1).toString();
					toAc[i] = "."+temp[istr];
				}
				setAutocomplete(toAc);
				$( "#ui_txt" ).autocomplete( "enable" );
				isAdvanced = true;
				gotMainResult= true;
			}
		  }
		 $( "#input_Search" ).autocomplete({ autoFocus: true });
		$( "#input_Search" ).autocomplete({ delay: 0 });
		changeTag(3);
		$("#label_SearchTag3").html("Advanced");
		xmlhttp.open("GET","./php/services/Search/getMainSearchTags.php",true);
		xmlhttp.send();
	}
	else if (mainSelected && !gotSecondaryResult){
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
				var searchResults = xmlhttp.responseText;
				
				var theObj = JSON.parse(searchResults);
				
				var toAc = new Array();

				var i = 0;
				try{
					while (true){
						toAc[i] = "."+theObj[i].name;
						i++;
					}
				}catch(err){}
				
				setAutocomplete(toAc);
				
				gotSecondaryResult = true;
			}
		  }
		 $( "#input_Search" ).autocomplete({ autoFocus: true });
		$( "#input_Search" ).autocomplete({ delay: 0 });
		
		xmlhttp.open("GET","./php/services/Search/getSearchTagsForModel.php?id="+mainSel,true);
		xmlhttp.send();
	}

}

function doSearch(val){
	if (undefined != prevAdv_xmlhttp){
			prevAdv_xmlhttp.abort();
	}
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
				$('#div_Column2').html("");
				$('#div_Column3').html("");
				
				var searchResults = xmlhttp.responseText;
				var divToDisplay = $('#div_Column2');
				divToDisplay.html(xmlhttp.responseText);
                initResults();
			
				//var theObj = JSON.parse(searchResults);
				//console.log(theObj);
			}
		  }
		  
		xmlhttp.open("GET","./php/services/Search/doSearchKeySearch.php?main="+mainSel+"&in="+innerSel+"&data="+val,true);
		xmlhttp.send();
		prevAdv_xmlhttp = xmlhttp;
	}
	
function resetAdvancedSearch(){
	mainSelected = false;
	gotSecondaryResult = false;
	gotMainResult = false;
	secSelected = false;
	isAdvanced = false;
	
	$('.ui-state-active').click();
	
	$( "#input_Search" ).autocomplete( "destroy" );
	setInitialFocus();

}

function setAutocomplete(arr){
	$( "#input_Search" ).autocomplete({
		source: arr
	});
					
	$("#input_Search").autocomplete( "search" , "." );
}

function dataSelected(data){	
	if (!mainSelected){
		var temp = data.replace(".", "");
		$("#label_SearchTag3").html(temp);				
		mainSelected = true;
		mainSel = data;
	}
	else{
		var temp = data.replace(".","");
		temp = temp.replace("_", " ");
		$("#label_SearchTag3").html(temp);				
		secSelected = true;
		innerSel = data;
	}
}

function searchSubmit(force){
	var theTxt = $('#input_Search');
	var theVal = theTxt.val();
    theTxt.attr("searchString", theVal);
	var divToDisplay = $('#div_Column2');
    var searchBy = $('.SearchByButton[aria-pressed="true"]').attr("searchBy");
	if (!force){
		if (theVal.length >2){
			ajaxSearch(theVal, divToDisplay, searchBy);
		}
		else{
            
		}
	}
	else{
		ajaxSearch(theVal, divToDisplay, searchBy);
	}
	
}

function ajaxSearch(val, divToDisplay, searchBy){
		if (undefined != prev_xmlhttp){
			prev_xmlhttp.abort();
		}
		//ajax 
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
				$('#div_Column2').html("");
				$('#div_Column3').html("");
				
                 divToDisplay.html(xmlhttp.responseText);
                 initResults();
			}
		  }
		xmlhttp.open("GET","php/controller/SearchResults/SearchMainFiles.php?key=" + val +"&SearchBy=" +searchBy ,true);
		xmlhttp.send();
		prev_xmlhttp = xmlhttp;
}