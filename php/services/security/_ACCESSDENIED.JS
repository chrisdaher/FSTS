function timeMsg()
{
	var t=setTimeout("redirect()",800);
}
function redirect()
{
	document.location.href = '../LoginPage.php';
}
    function checkLogin()
    {
    	document.location.href = 'Security/LoginRedirect.php';
    }
    
    function closeDialog(){
		document.location.href = 'LoginPage.php?Access=tryAgain';
	}
	function checkAccess(){
		alert("BALLS");
		if(Get("Access")=="denied"){
			setTimeout("closeDialog()", 2500);
		}
	}
    
	$(function() {
		// // a workaround for a flaw in the demo system (http://dev.jqueryui.com/ticket/4375), ignore!
		// $( "#dialog_denied" ).dialog({
			// height: 180,
			// width:300,
			// modal: true
		// });
	});