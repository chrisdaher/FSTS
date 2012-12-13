function applyMedicard(event){
	
	var theTxt = document.getElementById("input_Medicard");
	var medicard = theTxt.value;
	medicard = removeSpaces(medicard);
	medicard = medicard.toUpperCase();
	if (medicard.length != 12){
		var theGender = document.getElementById("input_Gender");
		theGender.selectedIndex = 0;
		
		//var theAge = document.getElementById("input_Age");
		//theAge.value = "";
	}
	else{	
		var yearOfBirth = parseInt(medicard.substring(4,6)) + 1900;
		var monthOfBirth = medicard.substring(6,8);
		var dayOfBirth = medicard.substring(8,10);
		
		
		
		if (parseInt(monthOfBirth[0]) == 0){
			monthOfBirth = parseInt(monthOfBirth[1]);
		}
		else{
			monthOfBirth = parseInt(monthOfBirth);
		}
		
		if (monthOfBirth > 12){ //female
			monthOfBirth-=50; 
			var theGender = document.getElementById("input_Gender");
			theGender.selectedIndex = 1;
		}
		else{
			var theGender = document.getElementById("input_Gender");
			theGender.selectedIndex = 0;
		}
        var d = new Date();
		
		var currYear = (d).getFullYear();
		var currMonth = (d).getMonth() + 1;
		var age = currYear - yearOfBirth;
		if (age>100) age-=100;
		if (currMonth < monthOfBirth){
			age--;
		}
        
		
		
		medicard = fixMedicardStyling(medicard);
		theTxt.value = medicard;
		
		
		
		var theAge = document.getElementById("input_Age");
		theAge.value = age;
		
		if (monthOfBirth < 10){
			monthOfBirth = "0" + monthOfBirth;
		}
		
		var dateOfBirth = yearOfBirth + "-" + monthOfBirth + "-" + dayOfBirth;
		
		//date of birth
		var firstVis = document.getElementById("input_DateOfBirth");
		firstVis.value = dateOfBirth;
	}
}

function ajaxPcode(pcode){
			//ajax 
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
				var data = xmlhttp.responseText;
				if (data != ""){
					var city = data.split('::')[0];
					var province = data.split('::')[1];
					
					var cityIn = document.getElementById('input_City');
					 
					cityIn.value = city;
					 
					var provIn = document.getElementById('input_Province');
					provIn.value = province;
					
					//document.getElementById('input_PostalCode').value = pcode.toUpperCase();
				}
			}
		  }
		xmlhttp.open("GET","php/services/getCityFromPcode.php?pcode=" + pcode,true);
		xmlhttp.send();
}
function applyDateOfBirth(){
	var DOB = (document.getElementById('input_DateOfBirth').value);
	var age = document.getElementById('input_Age');
	age.value = getAge(DOB);
}

function applyPostalCode(){
	
    var pcode = (document.getElementById('input_PostalCode').value);
	if (pcode.length >= 3){
		var thePcode = pcode.substring(0,3);
		ajaxPcode(thePcode);
	}
	else{
		var city = document.getElementById('input_City');
		city.value = "";
		
		var provIn = document.getElementById('input_Province');
		provIn.value = "";
	}
}
function fixMedicardStyling(str){
	var first = str.substring(0,4);
	var second = str.substring(4,8);
	var third = str.substring(8,12);
	return (first + " " + second + " " + third);
}

function removeSpaces(str){
	return str.split(' ').join("");
}
function getAge(dateString) {
    var today = new Date();
    var birthDate = new Date(dateString);
    var age = today.getFullYear() - birthDate.getFullYear();
    var m = today.getMonth() - birthDate.getMonth();
    if (m < 0 || (m === 0 && today.getDate() < birthDate.getDate())) {
        age--;
    }
    return age;
}