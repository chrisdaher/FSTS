var prev_xmlhttp;   
var oldToggle;
var oldId;

function setInitialFocus(){
   $("#input_Search").focus();
}
$(initMain);

function goToFile(id){
	window.location= ("File_Page.php?id="+id);
}

function goToEvent(id){
	window.location= ("AssigningAppointments.php?EventID="+id);
}

 function initMain(){

	
    $("#input_Search").keyup(searchKeyDown);
	$("#input_Search").keydown(removeLabel);
    $('input[id="radio1"]').click();
    $('input[type="radio"]').click(function(){
		if (isAdvanced){
			resetAdvancedSearch();
		}
		
       $("#input_Search").keyup();
    });
    setInitialFocus();
	
	$( "#input_Search" ).bind( "autocompleteselect", function(event, ui) {
		dataSelected(ui.item.value);		
		$( "#input_Search" ).focus();
	});
	
	$( "#input_Search" ).bind( "autocompleteclose", function(event, ui) {
		$( "#input_Search" ).val("");
		$( "#input_Search" ).focus();
		if (secSelected){
			$( "#input_Search" ).autocomplete( "destroy" );
		}
	});	
	
	$("#label_SearchTag3").click(function(){
		if (gotSecondaryResult){
			resetSecondary();
		}
		else{
			resetAdvancedSearch();
		}
	});
	
	
	if (isAdvanced){
		$( "#input_Search" ).autocomplete({ autoFocus: true });
		$( "#input_Search" ).autocomplete({ delay: 0 });
	}
	
	var currText = $("#input_Search").val();
	if (currText.length>0){
		setTimeout("$(\"#input_Search\").keyup()",400);
	}
}

function initResults(){
    $('.div_FileBlock').hover(function(){
            if($(this).attr("hover")=="enabled"){
                hoverOver(this);
            }
        }, function(){
            if($(this).attr("hover")=="enabled"){
                hoverOut(this);
            }
            });
			
		$('.div_FileBlock').focus(function(){
			if($(this).attr("hover")=="enabled"){
                hoverOver(this);
            }
		});
		
		$('.div_FileBlock').blur(function(){
			
		});
		
	    $('.div_FileBlock').keydown(function(e){
				var ec = e.keyCode;
				var tabIndex = 9;
				
				var enter =13;
				var left = 37;
				var right = 39;
				var up=38;
				var down=40;
				//up40 down38
				if (ec==down){
					e.preventDefault();
										
					var index = $(this).attr("tabindex");
					index++;
					$('[tabindex="'+index+'"]').focus();
				}
				else if (ec==up){
					e.preventDefault();
					
					var index = $(this).attr("tabindex");
					index--;
					if (index >= 0){
						$('[tabindex="'+index+'"]').focus();
					}
					else if (index < 0){
						$("#input_Search").focus();	
					}
				}
				else if(ec==right){
					var ti = $(this).attr("tabindex");
					var flagContainer = $($(".filefound_flag_container")[ti]);
					$(flagContainer).click();
				}
				else if(ec==enter){
					$(this).click();
				}
         });
         $('.GalleryContainer').jScrollPane({
                showArrows:true,
                horizontalGutter:10
            });		
			
	var fileBlocks =$('div');
	
	for (var i=0;i<fileBlocks.length;i++){
		$(fileBlocks[i]).attr("tabindex", -1);
	}
	
	var fileBlocks =$('button');
		
	for (var i=0;i<fileBlocks.length;i++){
		$(fileBlocks[i]).attr("tabindex", -1);
	}
			
	var fileBlocks =$('.div_FileBlock');
	
	for (var i=0;i<fileBlocks.length;i++){
		$(fileBlocks[i]).attr("tabindex", i);
	}
	
	
	$(".div_FileBlock").click(function(){
		var id = $(this).attr("fileid");
		if (id !== undefined){
			goToFile(id);
		}
		else{
			id = $(this).attr("eventid");
			goToEvent(id);
		}
		
	});
    $(".filefound_flag_container").click(function(e){
		
        if(!e.isPropagationStopped()){
            e.preventDefault();
            e.stopPropagation();
			var curr = $(this).parentsUntil($(".GalleryPage"));
			
			
            currId = $(curr[curr.length-1]).attr("fileid");
			if (currId === undefined){
				currId = $(curr[curr.length-1]).attr("eventid");
			}
			
			if (oldToggle !== undefined){
				var par = oldToggle.parentsUntil($(".GalleryPage"));
				var oldId = $(par[par.length-1]).attr("fileid");
				
				if (oldId === undefined){
					var oldId = $(par[par.length-1]).attr("eventid");
				}
				
				oldToggle.parentsUntil($(".div_FileBlock")).removeClass("selectedFile");
			}
			
			if (oldId != currId){
				
				var par = $(this).parentsUntil($(".GalleryPage"));
				$(this).parentsUntil($(".div_FileBlock")).toggleClass("selectedFile");
				toggleHover(currId);
				
				oldToggle = $(this);
								
				hoverOver(par[par.length-1]);
			}
			else{
				hoverAll();
				oldToggle = undefined;
				
			}
        }   
    });
	
	$('.OnlyInMain').button({
            icons:{
                primary: "ui-icon-bullet"
            },
            height:15,
            width:15,
			disabled:true
    });
	
	$('.OnlyInHover').button({
            icons:{
                primary: "ui-icon-radio-on"
            },
            height:15,
            width:15,
			disabled:true
    });
	
	$('.InBoth').button({
            icons:{
                primary: "ui-icon-arrowthick-2-e-w"
            },
            height:15,
            width:15,
			disabled:true
    });
		
    hoverOut();
}

function hoverOver(hovered){
    var id = $(hovered).attr("fileid");
	
    var isEvent = false;
    if(id==undefined){
        id = $(hovered).attr("eventid");
        var isEvent = true;
    }
    var toShow = $("#div_Column3");
    getHoverInfo(id, toShow, isEvent);
    toShow.addClass("hovered");
}
function hoverOut(hovered){
    var toHide = $("#div_Column3");
    if(prev_xmlhttp!=undefined){
        prev_xmlhttp.abort();
    }
    toHide.html("");
    toHide.removeClass("hovered");
}

function getHoverInfo(id, toChange, isEvent){
        if (undefined != prev_xmlhttp){
			prev_xmlhttp.abort();
		}
		if (isEvent == undefined){
			isEvent=false;
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
                 toChange.html(xmlhttp.responseText);
			}
		  }
		xmlhttp.open("GET","php/controller/AjaxDisplay/getFullFileInfo.php?id=" + id +"&isEvent=" +isEvent+"&searchString="+$('#input_Search').attr('searchString') ,true);
		xmlhttp.send();
        prev_xmlhttp = xmlhttp;
}
function toggleHover(id){
    toToggle = $(".div_FileBlock");
	disableHoverAll();
	oldId = -1;
    // hover = "enabled";
    // if($(toToggle[0]).attr("hover")=="enabled"){
        // hover = "disabled";
    // }
    // for(var i=0;i<toToggle.length;i++){
        // $(toToggle[i]).attr("hover", hover);
    // }
}
function disableHoverAll(){
	toToggle = $(".div_FileBlock");
	hover = "disabled";
	for(var i=0;i<toToggle.length;i++){
        $(toToggle[i]).attr("hover", hover);
    }
}
function hoverAll(){
	toToggle = $(".div_FileBlock");
	hover = "enabled";
	for(var i=0;i<toToggle.length;i++){
        $(toToggle[i]).attr("hover", hover);
    }
}