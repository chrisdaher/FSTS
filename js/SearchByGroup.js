	$(function() {
		$( "#div_SearchByGroup" ).buttonset(),
        $("#div_SearchByGroup").click(function(){setInitialFocus();}),
        $('label[for="radio1"]').click(function(e){changeTag(1);}),
        $('label[for="radio2"]').click(function(e){changeTag(2);})

	});
    function changeTag(i){
	
        if(i==2){
            document.getElementById("label_SearchTag2").style.visibility="visible";
            document.getElementById("label_SearchTag1").style.visibility="hidden";
			document.getElementById("label_SearchTag3").style.visibility="hidden";
			
        }
        else if (i==1){
			
            document.getElementById("label_SearchTag1").style.visibility="visible";
            document.getElementById("label_SearchTag2").style.visibility="hidden";
			document.getElementById("label_SearchTag3").style.visibility="hidden";
			
        }
		else{
			document.getElementById("label_SearchTag1").style.visibility="hidden";
            document.getElementById("label_SearchTag2").style.visibility="hidden";
			document.getElementById("label_SearchTag3").style.visibility="visible";		
			
		}
        //document.getElementById("label_FSTS").innerHTML="FSTS";
        //document.getElementById("label_Name").innerHTML="Ryan";
    }