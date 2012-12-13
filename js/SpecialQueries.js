$(initMain)
var isHelp = false;
function initMain(){
	$('.accordion').hide();
	$('.accordion').accordion({
        fillSpace:true
    });
	
	$('.accordion .head').click(function() {
		$(this).next().toggle();
		return false;
	}).next().hide();
	
	$('.btn_execute').button();
	$('.btn_help').button();
	
	$('.btn_help').click(function(){
		if (isHelp){
			$('.accordion').hide();
		}
		else{
			$('.accordion').show();
		}
		isHelp = !isHelp;
	});
	
	$('.btn_clear').button().click(function(){
		$('#sQuery').val("");
		$('#sQuery').focus();
		$('.qResults').html("");
	});
	$('.btn_execute').click(function(){
		$.post('php/services/Queries/SpecialQuery.php', {query : $('.input_sQuery').val()}, function(data){
			$('.qResults').html(data);
			initTable();
		});
	});
	
	$('.report_param_container').buttonset();
	
	$('.accordion_lbl').click(function(){
			tagClick($(this));	
	});
	
	
}


function tagClick(curr){
	var siz = $('.accordion_lbl')
	var id = $(curr).attr("id");
	var lbl = $('label[for="'+id+'"]');
	var reset = false;
			/*
	if ($(lbl).hasClass("ui-state-active")){
		reset = true;
	}
	for (var i=0;i<siz.length;i++){
		$(siz[i]).removeClass("ui-state-active");
	}
	
	if (!reset || true){
		$(lbl).addClass("ui-state-active");
	}
	*/
	var data = id.toString().split("_");
	var newData = "";
	for (var i=1;i<data.length;i++){
		newData += data[i];
		if ((i+1)!= data.length){
			newData+="_";
		}
	}
	data = newData;
	data = data.toUpperCase();
	
	if ($(lbl).hasClass("specButton")){
		data = $(lbl).attr("specval");
	}
	

	var currVal =$('#sQuery').val();
	$('#sQuery').val(currVal + data + " ");
	$('#sQuery').focus();
	
		var par = $(curr).parent();
		if ($(par).hasClass("tableDiv")){
			var tabId = $(curr).attr("tableId");
			
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
					var txt = xmlhttp.responseText;
					$('.columnDiv').html(txt);
					$('.h1ColumnDiv').effect("highlight", {}, 2500);
					$('.report_param_container').buttonset();
					$(".accordion_lbl").unbind("click");
					$('.accordion_lbl').click(function(){
						tagClick($(this));	
					});	
				}
			}
			xmlhttp.open("GET","php/services/Queries/BuildColumnAcc.php?id="+tabId,true);
			xmlhttp.send();
		}
		
		if ($(lbl).hasClass("specColumn")){
			var tabId = $(lbl).attr("tableId");
			
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
					var txt = xmlhttp.responseText;
					$('.specDiv').html(txt);
					$('.h1SpecDiv').effect("highlight", {}, 2500);
					$('.report_param_container').buttonset();
					$(".accordion_lbl").unbind("click");
					$('.accordion_lbl').click(function(){
						tagClick($(this));	
					});	
				}
			}
			xmlhttp.open("GET","php/services/Queries/BuildSpecAcc.php?id="+tabId+"&name="+data,true);
			xmlhttp.send();
		}
}

function initTable(){
	$('.qResults').addClass("tablesorter");
	$('.tablesorter').tablesorter();
}