	function getUserInfo(str)
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
				var fname=theObj.first_name;
				var lname=theObj.last_name;
				var medicard=theObj.medicard;
				var age=theObj.age;
				var gender=theObj.gender;
                var contact = theObj.contact -1;
				
				$("#dep_fname").val(fname);
				$("#dep_lname").val(lname);
				$("#dep_medicard").val(medicard);
				$("#dep_age").val(age);
		
				setDefault(gender,"dep_gender");
				setIndex(contact, "dep_contact");
				NewDepForm("Edit");      
			}
		  }
		xmlhttp.open("GET","php/services/getUserInfo.php?id="+str,true);
		xmlhttp.send();
		}
        
 	function getIncInfo(str)
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
				var person=theObj.person;
				var type=theObj.type;
				var mode=theObj.mode;
				var sDate=theObj.sDate;
				var eDate=theObj.eDate;
				var incVal=theObj.incVal;
				
				$("#Person").val(person);
				$("#Type").val(type);
				$("#Mode").val(mode);
				$("#sDate").val(sDate);
                $("#eDate").val(eDate);
				$("#incVal").val(incVal);
                setDefault(person,"Person");
				setDefault(type, "Type");
                setDefault(mode, "Mode");
        
				NewIncForm("Edit");      
			}
		  }
		xmlhttp.open("GET","php/services/getIncInfo.php?id="+str,true);
		xmlhttp.send();
	}

$(function() {
        //INCOME
		$( ".inc_btn_edit" ).button({
            icons: {
                primary: "ui-icon-pencil"
            },
            text: false
        }),
		$( ".inc_btn_remove" ).button({
            icons: {
                primary: "ui-icon-trash"
            },
            text: false
        });
        $(".inc_btn_edit").click(function() { 
            var tempID=$(this).attr('incID');
            //get the values of the following from db based on the dependent ID which is in this case tempID,
            // which is the same you provided to the depID in the DependentDiv:
			getIncInfo(tempID);

        });
        $(".inc_btn_remove").click(function() { 
            //provide the current fileID so after you delete the dependent you can redirect back to this page?
             var tempID=$(this).attr('incID');
             var famID=$(this).attr('fileID');
             window.location="./php/controller/Submit/DeleteIncome.php?inc_id="+tempID+"&file_id="+famID;       
			
		});
        
        //DEPENDENTS
		$( ".dep_btn_edit" ).button({
            icons: {
                primary: "ui-icon-pencil"
            },
            text: false
        }),
		$( ".dep_btn_remove" ).button({
            icons: {
                primary: "ui-icon-trash"
            },
            text: false
        });
        $(".dep_btn_edit").click(function() { 
            var tempID=$(this).attr('depID');
            //get the values of the following from db based on the dependent ID which is in this case tempID,
            // which is the same you provided to the depID in the DependentDiv:
			getUserInfo(tempID);

        });
        $(".dep_btn_remove").click(function() { 
            //provide the current fileID so after you delete the dependent you can redirect back to this page?
             var tempID=$(this).attr('depID');
             var famID=$(this).attr('fileID');
             window.location="./php/controller/Submit/DeleteDependent.php?dep_id="+tempID+"&file_id="+famID;       
			
		});
  });