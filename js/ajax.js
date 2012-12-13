	function getUserInfoTest(str, obj)
		{
		if (str=="")
		  {
		  document.getElementById("txtHint").innerHTML="";
		  return;
		  } 
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
				return theObj;
			}
		  }
		xmlhttp.open("GET","php/getUserInfo.php?id="+str,true);
		xmlhttp.send();
		}