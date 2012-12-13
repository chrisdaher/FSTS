var searchBar = ".input_Search";
var currSection;
$(initMain);
$(initOptionBar);

function initOptionBar(){
	$(".link_adminLink").click(function(){
        section = $(this).attr("href");
        section = section.replace("#", "");
		currSection = section;
        getPageSection(section, $(this).html(), $("#Admin_page_MainDisplay"));
    });
}

function initMain(){
   $(".JQuery_button").button();
    
	var theLoc = window.location;
	theLoc = theLoc.toString();
	theLoc = theLoc.split("#");
	theLoc = theLoc[1];
	theLoc = "#"+theLoc;
	
	var theLink =$('[href="'+theLoc+'"]');

	

   $('.btn_add').button({
       icons:{
           primary: "ui-icon-plusthick"
       }
   });
   $('.btn_add').click(function(){
        addNewEntry($(this).attr("Section"), $('.div_results_table'));
   });
   $('.SearchButton').click(function(){

        if (!$("#input_Search").hasClass("defaultTextEmpty")){
            $("#input_Search").keyup();
        }
   });
   $('input[class=" div_preview_pcode"]').keyup(function(e){
        var pcode= $(this).val();
        
        labels = $('label[class=" div_preview_pcode"]');
        var toChange = new Array();
        toChange[0] = $(labels[0]);
        toChange[1] = $(labels[1]);
        toChange[0].html("");
        toChange[1].html("");
        
        if(pcode.match(/^[a-zA-Z][0-9][a-zA-Z]$/)){
            getPCodePrev(pcode, toChange);
        }
   });
   $(searchBar).focus(function(srcc)
    {
        if ($(this).hasClass("defaultTextEmpty"))
        {
            $(this).removeClass("defaultTextEmpty");
            $(this).val("");
        }
    });
    
    $(searchBar).blur(function()
    {
        if ($(this).val() == "")
        {
            $(this).addClass("defaultTextEmpty");
            $(this).val($(this)[0].title);
        }
    });
    
    $(searchBar).blur();
    $(searchBar).keyup(function(){
        $toSearch = $(this).val();
        if($(this).hasClass("defaultTextEmpty")){
            $toSearch = "";
        }
        getData($toSearch, $(this).attr("searchFrom"), $(".div_results_table"));
        
    });
    setFocus(".input_Search", true);
    pageLoadInit();
	
	if (("#"+currSection) != theLoc){
		//theLink.click();
	}
}
function pageLoadInit(){
    getData("", $(".input_Search").attr("searchFrom"),$(".div_results_table"));
}
function getData(str, from, toChange)
{
    if (window.XMLHttpRequest)
      {// code for IE7+, Firefox, Chrome, Opera, Safari
      var xmlhttp=new XMLHttpRequest();
      }
    else
      {// code for IE6, IE5
      var xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
      }
    xmlhttp.onreadystatechange=function()
      {
      if (xmlhttp.readyState==4 && xmlhttp.status==200)
        {
            var searchResults = xmlhttp.responseText;
            toChange.html(searchResults);
            initResults();
            setTimeout("refreshPreview()",200);
        }
      }
	
    xmlhttp.open("GET","./php/controller/AjaxDisplay/getAdminSearchResults.php?Search="+str+"&From="+from,true);
    xmlhttp.send();
}
function getPCodePrev(pcode, toChange)
{
    if (window.XMLHttpRequest)
      {// code for IE7+, Firefox, Chrome, Opera, Safari
      var xmlhttp=new XMLHttpRequest();
      }
    else
      {// code for IE6, IE5
      var xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
      }
    xmlhttp.onreadystatechange=function()
      {
      if (xmlhttp.readyState==4 && xmlhttp.status==200)
        {
            var searchResults = xmlhttp.responseText.split("::");
            var City = searchResults[0];
            var Province = searchResults[1];
            toChange[0].html(City);
            toChange[1].html(Province);
            
            initResults();
            
        }
      }
	
    xmlhttp.open("GET","./php/services/getCityFromPcode.php?pcode="+pcode,true);
    xmlhttp.send();
}
function addNewEntry(section, toChange)
{
    if (window.XMLHttpRequest)
      {// code for IE7+, Firefox, Chrome, Opera, Safari
      var xmlhttp=new XMLHttpRequest();
      }
    else
      {// code for IE6, IE5
      var xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
      }
    xmlhttp.onreadystatechange=function()
      {
      if (xmlhttp.readyState==4 && xmlhttp.status==200)
        {
            var searchResults = xmlhttp.responseText;
            toChange.append(searchResults);
            initResults();
            setFocus(-1);
        }
      }
    xmlhttp.open("GET","./php/controller/AjaxDisplay/getNewEntry.php?Section="+section,true);
    xmlhttp.send();
}
function getPageSection(Section, Text, toChange)
{	
    if (window.XMLHttpRequest)
      {// code for IE7+, Firefox, Chrome, Opera, Safari
      var xmlhttp=new XMLHttpRequest();
      }
    else
      {// code for IE6, IE5
      var xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
      }
    xmlhttp.onreadystatechange=function()
      {
      if (xmlhttp.readyState==4 && xmlhttp.status==200)
        {
            var MainDiv = xmlhttp.responseText;
            toChange.html(MainDiv);
            initMain();
        }
      }
    xmlhttp.open("GET","./php/controller/AjaxDisplay/getAdminSection.php?Section="+Section+"&Text="+Text,true);
    xmlhttp.send();
}

function initResults(){
    $(".input_ResultData").keypress(function(e){
        if(e.which == 13){
            e.preventDefault();
            var id = $(this).attr("ResultID");
            $('.btn_ResultAdd[ResultID="'+id+'"]').click();
        }
    });
    $(".btn_ResultEdit").button({
        icons:{
           primary: "ui-icon-pencil"
        },
    });
    $(".btn_ResultEdit").click(function(){
        var id = $(this).attr("ResultID");
        editResult(id, $('tr[ResultID="'+id+'"]'));
    });
    $(".btn_ResultRemove").button({
        icons:{
           primary: "ui-icon-closethick"
        },
    });
    $(".btn_ResultRemove").click(function(){
        removeResult($(this).attr("Section"), $(this).attr("ResultID"));
    });
    
    $(".btn_ResultAdd").button({
        icons:{
           primary: "ui-icon-check"
        },
    });
    $(".btn_ResultAdd").click(function(){
        var id = $(this).attr("ResultID");
        addResult(id, $('tr[ResultID="'+id+'"]'));
    });
}
function ToggleEdit(id,section ,toChange, GET_Array){
	if (window.XMLHttpRequest)
      {// code for IE7+, Firefox, Chrome, Opera, Safari
      var xmlhttp=new XMLHttpRequest();
      }
    else
      {// code for IE6, IE5
      var xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
      }
    xmlhttp.onreadystatechange=function()
      {
      if (xmlhttp.readyState==4 && xmlhttp.status==200)
        {
            var element = xmlhttp.responseText;
            toChange.html(element);
            initResults();
            setTimeout("refreshPreview()",200);
            setFocus(id);
        }
      }
	  
    xmlhttp.open("GET","./php/controller/AjaxDisplay/ToggleEntry.php?Section="+section+"&id="+id+"&"+GET_Array,true);
    xmlhttp.send();
}
function changeEntry(id,section ,toChange, GET_Array){
	if (window.XMLHttpRequest)
      {// code for IE7+, Firefox, Chrome, Opera, Safari
      var xmlhttp=new XMLHttpRequest();
      }
    else
      {// code for IE6, IE5
      var xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
      }
    xmlhttp.onreadystatechange=function()
      {
      if (xmlhttp.readyState==4 && xmlhttp.status==200)
        {
            var element = xmlhttp.responseText;
            var id = element.split("::")[0];
            var element = element.split("::")[1];

            toChange.attr("ResultID", id);
            toChange.html(element);
            initResults();
            setTimeout("refreshPreview()",200);
        }
      }
	  
    xmlhttp.open("GET","./php/controller/AjaxDisplay/ChangeEntry.php?Section="+section+"&id="+id+"&"+GET_Array,true);
    xmlhttp.send();
}


function editResult(id, toChange){
    var label = $('label[ResultID="'+id+'"]');
	
    var section = $(label[0]).attr("Section");
    var GET_Array = rowDataToGetArray(label);
    ToggleEdit(id, section,toChange, GET_Array);
}
function removeResult(section, id){
    if (window.XMLHttpRequest)
      {// code for IE7+, Firefox, Chrome, Opera, Safari
      var xmlhttp=new XMLHttpRequest();
      }
    else
      {// code for IE6, IE5
      var xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
      }
    xmlhttp.onreadystatechange=function()
      {
      if (xmlhttp.readyState==4 && xmlhttp.status==200)
        {
            var success = xmlhttp.responseText;
            
            if(success == "success"){
                $(searchBar).keyup();
            }
            setTimeout("refreshPreview()",200);
        }
      }
    xmlhttp.open("GET","./php/controller/AjaxDisplay/RemoveEntry.php?Section="+section+"&id="+id,true);
    xmlhttp.send();
}
function addResult(id, toChange){
    var input = $('input[ResultID="'+id+'"]');
	
    var section = $(input[0]).attr("Section");
    var InvalidInputBoxes= ValidateEntries(input);
    if(InvalidInputBoxes.length==0){
        var GET_Array = rowDataToGetArray(input, true);
        changeEntry(id, section,toChange,GET_Array);
    }else{
        errorString = getErrorString(InvalidInputBoxes, section);
        alert(errorString + " cant be empty");
        for(var i=0; i<InvalidInputBoxes.length; i++){
            if(InvalidInputBoxes[i]!=undefined){
                setFocus(InvalidInputBoxes[i], false);
                break;
            }
        }
    }
	
}

function rowDataToGetArray(row, isInput){
    if(isInput === undefined){
        isInput = false;
    }
    var theString="";
    for(var i=0; i<row.length; i++){
        if(isInput){
            theString += "text"+i+"="+$(row[i]).val();
        }else{
            theString += "text"+i+"="+$(row[i]).text();
        }
        if(i<(row.length-1)){
            theString += "&";
        }
    }
    return theString;
}

function refreshPreview(){
    var preview = $(".div_preview_combo");
    if(preview!=null){
        updateComboBox(preview);
    }
 }

function updateComboBox(toUpdate){
    if (window.XMLHttpRequest)
      {// code for IE7+, Firefox, Chrome, Opera, Safari
      var xmlhttp=new XMLHttpRequest();
      }
    else
      {// code for IE6, IE5
      var xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
      }
    xmlhttp.onreadystatechange=function()
      {
      if (xmlhttp.readyState==4 && xmlhttp.status==200)
        {
            var response = xmlhttp.responseText;
            var Entries = response.split("::");
            clearComboBox(toUpdate);
            for(var i=0; i<Entries.length;i++){
                var entry = Entries[i].split("=");
                var text = entry[0];
                var value = entry[1];
                addCombo(text, value, toUpdate);
            }
            
        }
      }
    xmlhttp.open("GET","./php/controller/AjaxDisplay/getComboBoxEntries.php?Section="+toUpdate.attr("Section"),true);
    xmlhttp.send();
}
function setFocus(toFocus, isSearchFocus){
    if(isSearchFocus == undefined){
        $($('.input_ResultData[ResultID="'+toFocus+'"]')[0]).focus();
    }else{
        $(toFocus).focus()
    }
}
