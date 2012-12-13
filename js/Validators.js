function checkNotEmpty( o, n ,isWarning) {
    var tip = n + " is empty!";
    removeTip(tip);
	if ( o.val().length <= 0) {
		addTip(tip, isWarning);
		return false;
	} else {
		return true;
	}
}

function checkLength( o, n, min, max , isWarning) {
    var tip = "Length of " + n + " is not between " +	min + " and " + max + "!";
    removeTip(tip);
	if ( o.val().length > max || o.val().length < min ) {
		addTip( tip, isWarning );
		return false;
	} else {
		return true;
	}
}
function checkLength( o, n, size , isWarning) {
    var tip = "Length of " + n + " is not " +size + "!";
    removeTip(tip);
	if ( o.val().length != size) {
	//	o.addClass( "ui-state-error" );
		addTip(tip, isWarning);
		return false;
	} else {
		return true;
	}
}

function checkRegexp( o, regexp, n, example, isWarning ) {
	var tip= n +" does not have the right format! Correct format is " + example;
    removeTip(tip);
    if ( !( regexp.test( o.val() ) ) ) {
		//o.addClass( "ui-state-error" );
		addTip( tip, isWarning );
		return false;
	} else {
		return true;
	}
}