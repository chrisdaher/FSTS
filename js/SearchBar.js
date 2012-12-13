
var prev_xmlhttp;
function searchKeyDown(event){
	var theKeyCode = event.keyCode;

	if (theKeyCode == 13){
		searchSubmit(true);
	}
	else{
		var theTxt = document.getElementById('input_Search');
		var theVal = theTxt.value;
		searchSubmit(false);
		/*
		if (theVal == "" || theVal.length<3){
			var oldFilesFound = document.getElementById('FilesFoundDiv');
			if (oldFilesFound!=null){
				var divToDisplay = document.getElementById('div_Column2');
				divToDisplay.removeChild(oldFilesFound);
			}
		}else{
			if (theKeyCode == 8){
				if (theVal.length>3){
					searchSubmit(false);
				}
			}
			else{
				searchSubmit(false);
			}
		}
		*/
	}
}

function searchSubmit(force){
	var theTxt = document.getElementById('input_Search');
	var theVal = theTxt.value;
	if (!force){
		
		if (theVal.length >2){
			ajaxSearch(theVal);
		}
		else{
			
			var oldFilesFound = document.getElementById('FilesFoundDiv');
			if (oldFilesFound!=null){
				var divToDisplay = document.getElementById('div_Column2');
				divToDisplay.removeChild(oldFilesFound);
			}
		}
	}
	else{
		ajaxSearch(theVal);
	}
	
}

function ajaxSearch(val){
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

			     var divIdName="FilesFoundDiv";
			     var oldFilesFound = document.getElementById('FilesFoundDiv');
			     var newFilesFound = document.createElement('div');
                 newFilesFound.setAttribute('id',divIdName);
                 var divToDisplay = document.getElementById('div_Column2');
                 
                 newFilesFound.innerHTML=xmlhttp.responseText;
                 if(oldFilesFound != null){
                 divToDisplay.removeChild(oldFilesFound);
                 }
			     divToDisplay.appendChild(newFilesFound);
				 
				 setTabIndex();
				 setKeyDownEvents();
                 initFilesFound();
			}
		  }
		 var evId = Get("EventID");
		 
		xmlhttp.open("GET","php/controller/SearchResults/SearchMiniFiles.php?key=" + val +"&EventID=" +evId ,true);
		xmlhttp.send();
		prev_xmlhttp = xmlhttp;
}

function setTabIndex(){
	var fileBlocks =$('div');
	
	for (var i=0;i<fileBlocks.length;i++){
		$(fileBlocks[i]).attr("tabindex", -1);
	}
	
	var fileBlocks =$('button');
		
	for (var i=0;i<fileBlocks.length;i++){
		$(fileBlocks[i]).attr("tabindex", -1);
	}


	var theFb = $(".div_FileBlock");
	for (var i=0;i<theFb.length;i++){
		$(theFb[i]).attr('tabIndex', i);
	}
}

function setKeyDownEvents(){
	var theFb = $(".div_FileBlock");
	$('.div_FileBlock').keyup(function(e){
			var ec = e.keyCode;
			var tabIndex = 9;
			var enter =13;
			var left = 37;
			var right = 39;
			var up=38;
			var down=40;
			var del = 46;
			
			if (ec==down){

			}
			else if (ec == del){
				var id = $(this).attr("fileid");
				removeDropped(id);
			}
			else if (ec==up){
				$('#input_Search').focus().select();
			}
			else if(ec==right){
				e.preventDefault();
				
				var index = $(this).attr("tabindex");
				index++;
				if ($('[tabindex="'+index+'"]').length > 0){
					
				}
				else{
					index = 0;
				}
				$('[tabindex="'+index+'"]').focus();
			}
			else if(ec==left){
				e.preventDefault();
				
				var index = $(this).attr("tabindex");
				index--;
				if (index < 0){
					index = 0;
				}
				$('[tabindex="'+index+'"]').focus();
			}
			else if(ec==enter){
				$(this).click();
			}
	});
	
	$("#input_Search").keydown(function(e){
		var ec = e.keyCode;
		var down = 40;
		if (ec == down){
			index = 0;
			$('[tabindex="'+index+'"]').focus();
		}
	});
}