var NewDepDialog="#dialog_AddDep";
var NewIncDialog="#dialog_AddInc";
var incDisabled;
var depDisabled;
function NewDepForm(Mode){
	depDisabled = false
    $(NewDepDialog).dialog( "option", "title", Mode+" Dependent" );
	$(NewDepDialog).dialog( "open" );
	$("#dep_fname").keypress(function(event){
		if(event.keyCode == 13 && !depDisabled){
			depDisabled = true;
			event.preventDefault();
			$(NewDepDialog).dialog("disable");
			$(NewDepDialog).dialog("option","buttons").Done();
		}
	}),
	$("#dep_lname").keypress(function(event){
		if(event.keyCode == 13 && !depDisabled){
			depDisabled = true;
			event.preventDefault();
			$(NewDepDialog).dialog("disable");
			$(NewDepDialog).dialog("option","buttons").Done();
		}
	}),
	$("#dep_medicard").keypress(function(event){
		if(event.keyCode == 13 && !depDisabled){
			depDisabled = true;
			event.preventDefault();
			$(NewDepDialog).dialog("disable");
			$(NewDepDialog).dialog("option","buttons").Done();
		}
	}),
	$("#dep_age").keypress(function(event){
		if(event.keyCode == 13 && !depDisabled){
			depDisabled = true;
			event.preventDefault();
			$(NewDepDialog).dialog("disable");
			$(NewDepDialog).dialog("option","buttons").Done();
		}
	}),
	$("#dep_gender").keypress(function(event){
		if(event.keyCode == 13 && !depDisabled){
			depDisabled = true;
			event.preventDefault();
			$(NewDepDialog).dialog("disable");
			$(NewDepDialog).dialog("option","buttons").Done();
		}
    }),
 	$("#dep_contact").keypress(function(event){
		if(event.keyCode == 13 && !depDisabled){
			depDisabled = true;
			event.preventDefault();
			$(NewDepDialog).dialog("disable");
			$(NewDepDialog).dialog("option","buttons").Done();
		}
	});
}
function NewIncForm(Mode){
	incDisabled = false;
    $(NewIncDialog).dialog( "option", "title", Mode+" Income" );
	$(NewIncDialog).dialog( "open" );
	$(".Person").keypress(function(event){
		if(event.keyCode == 13 && !incDisabled){
			incDisabled = true;
			event.preventDefault();
			$(NewIncDialog).dialog("disable");
			$(NewIncDialog).dialog("option","buttons").Done();
		}
	}),
	$(".Type").keypress(function(event){
		if(event.keyCode == 13 && !incDisabled){
			incDisabled = true;
			event.preventDefault();
			$(NewIncDialog).dialog("disable");
			$(NewIncDialog).dialog("option","buttons").Done();
		}
	}),
	$(".Mode").keypress(function(event){
		if(event.keyCode == 13 && !incDisabled){
			event.preventDefault();
			incDisabled = true;
			$(NewIncDialog).dialog("disable");
			$(NewIncDialog).dialog("option","buttons").Done();
		}
	}),
	$(".sDate").keypress(function(event){
		if(event.keyCode == 13 && !incDisabled){
			event.preventDefault();
			incDisabled = true;
			$(NewIncDialog).dialog("disable");
			$(NewIncDialog).dialog("option","buttons").Done();
		}
	}),
	$(".eDate").keypress(function(event){
		if(event.keyCode == 13 && !incDisabled){
			event.preventDefault();
			incDisabled = true;
			$(NewIncDialog).dialog("disable");
			$(NewIncDialog).dialog("option","buttons").Done();
		}
    }),
	$(".incVal").keypress(function(event){
		if(event.keyCode == 13 && !incDisabled){
			event.preventDefault();
			incDisabled = true;
			$(NewIncDialog).dialog("disable");
			$(NewIncDialog).dialog("option","buttons").Done();
		}
    }),
    $("#sDate").datepicker({
        showAnim:'fold',
        dateFormat: 'yy-mm-dd'
    }),
    $("#eDate").datepicker({
        showAnim:'fold',
        dateFormat: 'yy-mm-dd'
    })
}

$(function() {		
		var fname = $( "#dep_fname" ),
	lname = $( "#dep_lname" ),
	medicard = $( "#dep_medicard" ),
	age = $("#dep_age"),
	gender=$("#dep_gender"),
	allFields = $( [] ).add( fname ).add( lname ).add( medicard ).add(age).add(gender),
	tips = $( ".validateTips" );

		function updateTips( t ) {
			tips
				.text( t )
				.addClass( "ui-state-highlight" );
			setTimeout(function() {
				tips.removeClass( "ui-state-highlight", 1500 );
			}, 500 );
		}
		function checkNotEmpty( o, n ) {
			if ( o.val().length <= 0) {
				o.addClass( "ui-state-error" );
				updateTips( n + " Cannot be empty." );
				return false;
			} else {
				return true;
			}
		}
		
		function checkLength( o, n, min, max ) {
			if ( o.val().length > max || o.val().length < min ) {
				o.addClass( "ui-state-error" );
				updateTips( "Length of " + n + " must be between " +
					min + " and " + max + "." );
				return false;
			} else {
				return true;
			}
		}
		function checkLength( o, n, size ) {
			if ( o.val().length != size) {
				o.addClass( "ui-state-error" );
				updateTips( "Length of " + n + " must be " +
					size + "." );
				return false;
			} else {
				return true;
			}
		}

		function checkRegexp( o, regexp, n ) {
			if ( !( regexp.test( o.val() ) ) ) {
				o.addClass( "ui-state-error" );
				updateTips( n );
				return false;
			} else {
				return true;
			}
		}
		
		$( NewDepDialog ).dialog({
			autoOpen: false,
			height: 640,
			width: 520,
			modal: true,
			buttons: {
				"Done": function() {
					
					var bValid = true;
					allFields.removeClass( "ui-state-error" );
					
					bValid = bValid && checkNotEmpty( fname, "First Name");
					bValid = bValid && checkNotEmpty( lname, "Last Name");
					bValid = bValid && checkLength( medicard, "medicard", 12 );
					bValid = bValid && checkRegexp( medicard, /\D{4}\s?\d{4}\s?\d{4}/, "eg. AAAA 0000 0000 | AAAA00000000" );
					bValid = bValid && checkNotEmpty( age, "Age");
					bValid = bValid && checkNotEmpty( gender, "Gender");
					

					if ( bValid ) {
						$( this ).dialog( "close" );
						document.forms["AddDepForm"].submit();  
					}
				},
				Cancel: function() {
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
						
						
					}
				  }
					  xmlhttp.open("GET","php/services/clearInfo.php",true);
					xmlhttp.send();
					$( this ).dialog( "close" ); 
					
				}
			},
			close: function() {
				allFields.val( "" ).removeClass( "ui-state-error" );
			}
		});
		$( NewIncDialog ).dialog({
			autoOpen: false,
			height: 640,
			width: 520,
			modal: true,
			buttons: {
				"Done": function() {
						$( this ).dialog( "close" );
						$('input[type=submit]', this).attr('disabled', 'disabled');
						document.forms["AddIncForm"].submit();  
				},
				Cancel: function() {
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
						
						
					}
				  }
					  xmlhttp.open("GET","php/services/clearInfo.php",true);
					xmlhttp.send();
					$( this ).dialog( "close" ); 
					
				}
			},
			close: function() {
				allFields.val( "" ).removeClass( "ui-state-error" );
			}
		});


	});