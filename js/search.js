$(initMain);
var curr;
var mainSel;
var innerSel;
var selected = false;
var gotResult = false;
var gotResultIn = false;
function initMain(){
	
	$( "#ui_txt" ).focus();
	$(ui_txt).keyup(function(event){
        keyupFunc(event);
        
    });

	$("#btn").click(function() {
		selected = false;
		gotResult = false;
		gotResultIn = false;
	});
	
	$( "#ui_txt" ).bind( "autocompleteselect", function(event, ui) {
		dataSelected(ui.item.value);		
		$( "#ui_txt" ).focus();
	});
	
	$( "#ui_txt" ).bind( "autocompleteclose", function(event, ui) {
		$( "#ui_txt" ).val("");
		$( "#ui_txt" ).focus();
		if (gotResultIn){
			$( "#ui_txt" ).autocomplete( "destroy" );
		}
	});	
	
	$( "#ui_txt" ).autocomplete({ autoFocus: true });
	$( "#ui_txt" ).autocomplete({ delay: 0 });
}

function keyupFunc(event){
	var keycode = event.which;
	var val = document.getElementById("ui_txt");
	val = val.value;
	
	if (keycode == 13 && val.length>0){
		doSearch(val);
	}
	
	if (val!='.') return;
	
	if (!selected && !gotResult){
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

				gotResult= true;
			}
		  }
		xmlhttp.open("GET","./php/services/Search/getMainSearchTags.php",true);
		xmlhttp.send();
	}
	else if (selected && !gotResultIn){
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
						toAc[i] = "."+theObj[i+1].name;
						i++;
					}
				}catch(err){}
				
				setAutocomplete(toAc);
				
				gotResultIn = true;
			}
		  }
		xmlhttp.open("GET","./php/services/Search/getSearchTagsForModel.php?id="+curr,true);
		xmlhttp.send();
	}
	
}

function doSearch(val){

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
				console.log(theObj);
			}
		  }
		xmlhttp.open("GET","./php/services/Search/doSearchKeySearch.php?main="+mainSel+"&in="+innerSel+"&data="+val,true);
		xmlhttp.send();
	}
	

function setAutocomplete(arr){
	$( "#ui_txt" ).autocomplete({
		source: arr
	});
				
	$("#ui_txt").autocomplete( "search" , "." );
}

function dataSelected(data){	
	curr = data;
	
	if (!selected){
		mainSel = data;
	}
	else{
		innerSel = data;
	}
	
	var spanTag = document.createElement("span"); 
  
	selected=  true;

	spanTag.id = "span1"; 
  
	spanTag.className ="dynamicSpan"; 
 
	spanTag.innerHTML = data; 
  
	document.body.appendChild(spanTag); 
	
	$( "#ui_txt" ).focus();
}