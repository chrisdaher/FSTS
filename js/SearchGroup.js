	$(function() {
		var availableTags = [
			"ActionScript",
			"AppleScript",
			"Asp",
			"BASIC",
			"C",
			"C++",
			"Clojure",
			"COBOL",
			"ColdFusion",
			"Erlang",
			"Fortran",
			"Groovy",
			"Haskell",
			"Java",
			"JavaScript",
			"Lisp",
			"Perl",
			"PHP",
			"Python",
			"Ruby",
			"Scala",
			"Scheme"
		];
		// $( "#input_Search" ).autocomplete({
			// source: availableTags
		// });
	});

	$(function() {
        
        $( "#btn_Search" ).button({
            icons: {
                primary: "ui-icon-search"
                }, 
            text: false 
        }),
		$( "#btn_Search" ).click(function() { searchSubmit(true); })
    	// BUTTON


	});
