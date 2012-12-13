$(function() {

    //make all the buttons in the option bar jQuery buttons...
    $( ".JQuery_button" ).button();
	$("#btn_Search").button({
		icons: {
			primary: "ui-icon-search"
			}
	});
});