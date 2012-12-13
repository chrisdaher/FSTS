$(document).ready(function() {
  
  $("#btn_submit").click(btnClick);
  $("#btn_remove").click(btnClickRemove);

  getLanguages();
});

function btnClickRemove(){
	var elSel = document.getElementById('ui_select');
	var id = elSel.options[elSel.selectedIndex].value;
	
	
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
				getLanguages();
			}
		}
	
	xmlhttp.open("GET","php/services/admin/adminServices.php?data=language&op=remove&id=" + id,true);
	xmlhttp.send();
}

function change(){

}

function getLanguages(){
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
				var elSel = document.getElementById('ui_select');
				elSel.options.length = 0;
				var OptNew;
				for (var i=0;i<theObj.length;i++){
					 OptNew = document.createElement('option');
					 OptNew.text = theObj[i].name;
					 OptNew.value = theObj[i].id;
					 try{
						elSel.add(OptNew, null);
					}catch(ex){
						elSel.add(OptNew);
					}
				}
			}
		}
	
	xmlhttp.open("GET","php/services/admin/adminServices.php?data=language&op=get",true);
	xmlhttp.send();
}

function btnClick(){
	var theTxt = ($("#txt_lang").val());
	
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
				
				if (xmlhttp.responseText == "D"){
					alert("DENIED!");
				}
				else{
					getLanguages();
					($("#txt_lang").val(""));
				}
			}
		}
	
	xmlhttp.open("GET","php/services/admin/adminServices.php?data=language&op=add&name="+theTxt,true);
	xmlhttp.send();
}