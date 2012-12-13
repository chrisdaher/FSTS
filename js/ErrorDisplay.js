
$(function(){
    var dialogSelector=$("#div_error");
    dialogSelector.dialog({
        modal:true,
        autoOpen:false,
        buttons: {
			"Ignore": function() {
                $(fileForm).submit();
				$( this ).dialog( "close" );
			},
			Cancel: function() {
				$( this ).dialog( "close" );
			}
		},
        close: function(){
            dialogSelector.html('');
        }
    });  
});

function displayError(){
    var dialogSelector=$("#div_error");
    dialogSelector.dialog("open");
}

function addErrors(errors, errorClass){
    var ErrorDiv = document.getElementById('div_error');
    var ErrorMessages = new Array();
    for(var i=0;i<errors.length;i++){
        ErrorMessages[i]=document.createElement('label');
        ErrorMessages[i].setAttribute('class',errorClass);
        ErrorMessages[i].innerHTML=errors[i];
        ErrorDiv.appendChild(ErrorMessages[i]);
    }
}
