$(function() {
    //make all the buttons in the option bar jQuery buttons...
    $( ".JQuery_button" ).button();
    
    // set the event handler for each button
    $( "#btn_Edit"  ).click(function() { 
        var id = Get('id');
        if(id==""){
            window.location="File_Page.php?id=new&"+"edit=2";                    
        }else{
            window.location="File_Page.php?id="+id+"&edit=1";
        }
    });
    $( "#btn_Delete"  ).click(function() { 
        //var id = Get('id');
        window.location="php/controller/Submit/deleteFile.php";
    });
    $( "#btn_Done"  ).click(function() { 
        $("#form_file").submit();
    });
    $( "#btn_Cancel"  ).click(function() { 
        var id = Get('id');
		var isEdit = Get('edit');
		if (isEdit == "2"){
			window.location="Homepage.php";
		}
		else{
			if(id==""){
				window.location="File_Page.php?id=new";                    
			}else{
				window.location="File_Page.php?id="+id;
			}
		}
    });
    $( "#btn_New"  ).click(function() { window.location="File_Page.php?id=new&edit=2"; });
	
	$("#btn_Register").click(function() {
		//window.location="DHX.php";
		var id = Get('id');
		window.location="AssigningAppointments.php?EventID=256&date=2012-2-15&fileId="+id;
	});
});