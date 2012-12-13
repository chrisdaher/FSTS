            	
    var FirstName= "#input_First";
    var LastName= "#input_Last";
    var StreetNumber= "#input_StreetNumber";
    var StreetName= "#input_Street";
    var PostalCode= "#input_PostalCode";
    var City= "#input_City";
    var Province= "#input_Province";
    var Medicard= "#input_Medicard";
    var DateOfBirth= "#input_DateOfBirth";
    var Age= "#input_Age";
    var FirstVisit= "#input_FirstVisit";
    
    var AllFields = [FirstName, LastName, StreetNumber, StreetName, PostalCode, City, Province, Medicard, DateOfBirth, Age, FirstVisit];
    
    var prev_xmlhttp;
    
   $(function() {
            $( "#input_submit" ).button();
            $("#input_FirstVisit").datepicker({
                showAnim:'fold',
                dateFormat: 'yy-mm-dd'
            });
            $("#input_DateOfBirth").datepicker({
                showAnim:'fold',
                dateFormat: 'yy-mm-dd'
            });
            initUpcomingEvents();
            
            
   });
    function initUpcomingEvents(){
        $(".registerToEvent").button({
            icons:{
                primary:"ui-icon-note"
            }
        });
        $(".registerToEvent").click(function(){
            window.location = "AssigningAppointments.php?EventID="+$(this).attr("EventID")+"&fileId="+Get("id");
        });
    }


$(document).ready(function() {

  $(FirstName).blur(function() {
    ValidateName(FirstName, "First Name", true)
  });
  $(LastName).blur(function() {
    ValidateName(LastName, "Last Name" , true)
  });
  $(StreetNumber).blur(function() {
    ValidateNumber(StreetNumber, "Street Number" , false)
  });
  $(StreetName).blur(function() {
    ValidateName(StreetName, "Street Name", false)
  });
  $(PostalCode).blur(function() {
    ValidatePostalCode(PostalCode, "Postal Code", true)
  });
  $(City).blur(function() {
    ValidateName(City, "City",false)
  });
  $(Province).blur(function() {
    ValidateName(Province, "Province",false)
  });
  $(Medicard).blur(function() {
    ValidateName(Medicard, "Medicard", false)
  });
  $(DateOfBirth).blur(function() {
    ValidateDate(DateOfBirth, "Date of Birth", false)
  });
  $(DateOfBirth).change(function() {
    if(ValidateDate(DateOfBirth, "Date of Birth", false)){
        applyDateOfBirth();
    }
  });
  $(Age).blur(function() {
    ValidateNumber(Age, "Age",false)
  });
  $(FirstVisit).blur(function() {
    ValidateDate(FirstVisit, "First Visit",false)
  });
 $(".form_input").keypress(function(event){
	if(event.keyCode == 13){
		event.preventDefault();
		ValidateFileForm();
	}
 });
 
 $(".OptionMenuBtn").button();
    $("#input_SearchUpcoming").keyup(function(){
        searchEvent($(this).val(), $(".table_Upcoming"));
    });

});

    function setInitialFocus(){
        $("#input_First").focus();
    }
function searchEvent(searchString, toChange){
        if (undefined != prev_xmlhttp){
			prev_xmlhttp.abort();
		}
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
                toChange.html(xmlhttp.responseText);
                initUpcomingEvents();
            }
          }
        xmlhttp.open("GET","php/view/FileView/SearchEvent.php?SearchString="+searchString,true);
        xmlhttp.send();
        prev_xmlhttp=xmlhttp;
}