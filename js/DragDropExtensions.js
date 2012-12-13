        
    
    var drag = function(from, to) {
        var offsetBefore, offsetTo, offsetAfter, dragged;
    	//var element = handle.data("draggable").element;
    	offsetBefore = from.offset();
        offsetTo = to.offset();
        var dx=0;
        var dy=0;
        if(offsetBefore!=null){
            dx= offsetTo.left-offsetBefore.left;
            dy= offsetTo.top-offsetBefore.top;
        }
    	$(from).simulate("drag", {
    		dx: dx || 0,
    		dy: dy || 0
    	});
    	dragged = { dx: dx, dy: dy };
    }

    //Remove a previously dropped file
    function removeDropped(id){
		var ajax = true;
		var toRemove = $(".droppedContainer[DroppedID='"+id+"'] .div_DroppedStatus");
		var toEnable = $(".div_FileBlock[fileID='"+id+"']");
		try{
			var listOfClasses = toRemove.attr("class").split(/s+/);
			$.each( listOfClasses, function(index, item){
				
				if (item.toString().indexOf('bar_Failed') != -1) {
					var toRemove = $(".droppedContainer[DroppedID='"+id+"']");
					enable(toEnable);
					toRemove.remove();
					FilesFoundRefresh();
					ajax = false;
					searchSubmit(true);
				}
			});
		}
		catch(err)
		{
		
		}
		
		if (ajax){
		
			var xmlhttp;
			var evId = Get("EventID");
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
					var isGood = true;
					if (xmlhttp.responseText != ""){
						isGood = false;
					}
					if (isGood){
						var toRemove = $(".droppedContainer[DroppedID='"+id+"']");
						var toEnable = $(".div_FileBlock[fileID='"+id+"']");
						enable(toEnable);
						toRemove.remove();
						FilesFoundRefresh();
					}
				}
			  }
			xmlhttp.open("GET","php/controller/Submit/RemoveFileFromEvent.php?fileID="+id+"&eventId="+evId,true);
			xmlhttp.send();
						//DELETE THIS FILE FROM THE APPOINTMENT in DB and on success do the rest
		}
    }
    
    //Enable\Disable the File found
    function disable(element){
        element.addClass( 'added' );
        element.removeClass('ui-draggable-disabled ');
        element.removeClass('ui-state-disabled');
        element.draggable('disable');

    }
    function enable(element){
        element.removeClass('added');
        /*element.removeClass('ui-draggable-disabled ');
        element.removeClass('ui-state-disabled');
        element.draggable('enable'); // no need for these because we call DropRefresh which refreshes all the draggables*/
    }
    
    // highlight/unhighlight droppable appointments
    function highlightDroppable(){
        $(appointmentDivs).addClass("highlightDroppable");
    }
    function unhighlightDroppable(){
        $(appointmentDivs).removeClass("highlightDroppable");
    }
    
    //refresh all the components
    function FilesFoundRefresh(){
        $(".div_FileBlock").draggable({
            helper:'clone',
            opacity:0.7,
            revert: "invalid",
            cursor: "move",
            disabled:false,
            start: highlightDroppable,
            stop: unhighlightDroppable
        });
        $(".div_FileBlock").click(function(event){
            if(!event.isPropagationStopped()){
                event.stopPropagation();
                var selectedAppointment = $(".selectedAppointment");
                if(selectedAppointment.length==0){
        			$( this ).toggleClass("selectedFile");
                    if($(".selectedFile").length>0){
                        highlightDroppable();
						$("#input_Search").blur();
                    }else{
                        unhighlightDroppable();
                    }
                }else{
       	                from=$(this).draggable();
                        to =$(selectedAppointment[0]);
        	           drag(from, to);
                }
            }
		});
    }
    function DropRefresh(){

/*        .drag("init",function(){
			if ( $( this ).is('.selectedFile') )
				return $('.selectedFile');
		})
		.drag(function( ev, dd ){
			$( this ).drag({
				top: dd.offsetY,
				left: dd.offsetX
			});
		});*/
        $(".added").draggable('disable');
        $('.div_DroppedBlock').click(function(event){
            event.stopPropagation();
        });
        $('.btn_DroppedRemove').button({
            icons: {
                primary: "ui-icon-close"
            },
            text: false
        });
        $('.div_DroppedStatus').progressbar({
            value:0
        });
        $('.btn_DroppedRemove').click(function(event){
            event.stopPropagation();
            var DroppedID= $(this).attr('fileID');
            removeDropped(DroppedID);
        });
    }
    
    //Handle what happens when an event is dropped to a droppable appointment
    function handleFileDrop(event, ui){ 
       var appointmentID = this.getAttribute( 'appointmentID' );
       var fileID = ui.draggable.attr( 'fileID' );
       /*
       //Get the data from the div that was dropped to the appointment
       var FirstName=ui.draggable.attr('FirstName');
       var LastName= ui.draggable.attr('LastName');
       
       var StreetNumber=ui.draggable.attr('StreetNumber');
       var StreetName=ui.draggable.attr('StreetName');
       var City=ui.draggable.attr('City');
       var Province=ui.draggable.attr('Province');
       var PostalCode=ui.draggable.attr('PostalCode');
       */
       var getString="FileID="+fileID;//+"&FirstName="+FirstName+"&LastName="+LastName+"&StreetNumber="+StreetNumber+"&StreetName="+StreetName+"&City="+City+"&Province="+Province+"&PostalCode="+PostalCode; 
	   	   
	   
	   getString = strReplace(getString, ' ', "\\s");
       disable(ui.draggable);
        
       $(this).append($("<div class='droppedContainer' DroppedID='"+fileID+"'>").load("php/view/AppointmentAssignment/FilesFoundDiv/DroppedFile.php?"+getString, function(){
            DropRefresh();
            submitFile(fileID, appointmentID);
            //setInitialFocus();            
        }));
       
        
    }
    function runEffect(element) {
			// get effect type from 
			var selectedEffect = "fade";
			// run the effect
            $(element).fadeOut(1600, 'swing', pushFileToDB(element));
		};
    function pushFileToDB(element) {
		setTimeout(function() {
			$( element ).hide();
		}, 1000 );
    };
    function submitFile(fileID, appID){
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
				var res = xmlhttp.responseText;
				var data = res.split(':');
				var worked = true;
				var errMsg = "";
				
				if (data[1] == 'E'){ //error
					worked = false;
					errMsg = data[2];
				}		
                				
                toUpdate.removeClass('bar_inProgress');
                toUpdate.removeClass('bar_Failed');
                toUpdate.removeClass('bar_Success');
                if(worked){
                    toUpdate.addClass('bar_Success');
                    setTimeout("runEffect(\".droppedContainer[DroppedID='"+fileID+"']\")", 2500);
                }else{
                    toUpdate.addClass('bar_Failed');
                    toShowError.removeClass('hiddenError');
                    toShowError.attr('title', errMsg);
					
                }
				searchSubmit(true);
            }
          }
          var toUpdate=$(".droppedContainer[DroppedID='"+fileID+"'] .div_DroppedStatus");
          var toShowError=$(".droppedContainer[DroppedID='"+fileID+"'] img");
        toUpdate.addClass('bar_inProgress');
		var evid = Get("EventID");
        xmlhttp.open("GET","php/controller/Submit/AddFileToAppointment.php?fileID="+fileID+"&appID="+appID+"&eventID="+evid,true);
        xmlhttp.send();
    }


