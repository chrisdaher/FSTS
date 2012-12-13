function checkSubmit(e)
{
   if(e && e.keyCode == 13)
   {
        e.preventDefault();
      document.forms[0].submit();
   }
}

function checkLogin(){
	var id = Get('Access');
	if (id == 'tryAgain'){
		var txt = document.getElementById("label_error");
		txt.innerHTML = "Invalid username/password.";
	}
	else if (id == 'denied'){
		var txt = document.getElementById("label_error");
		txt.innerHTML = "Access denied.";
	}
	else{
		var txt = document.getElementById("label_hi");
		var txtErr = document.getElementById("label_error");
		txt.innerHTML = "Welcome, please log in.";
		txtErr.innerHTML = "";
	}
	var txt = document.getElementById("input_username");
	txt.focus();
}

function setInitialFocus(){
    $("#input_username").focus();
}