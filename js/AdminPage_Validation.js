function ValidateEntries(row){
    var InvalidInputBoxIds = new Array();
    for(var i=0; i<row.length; i++){
        if($(row[i]).val()==""){
            InvalidInputBoxIds[i]=$(row[i]);
        }
    }
    return InvalidInputBoxIds;
}
function getErrorString(InvalidInputBoxes, section){
    var TextBoxNames = getTextBoxNames(section);
    var errorString = "";
    var numOfErrors = 0;
    for(var i=0; i<InvalidInputBoxes.length; i++){
        if(InvalidInputBoxes[i]!=undefined){
            if(numOfErrors>0 && i<InvalidInputBoxes.length-1){
                errorString += ", ";
                
            }
            if(numOfErrors==1 && i==InvalidInputBoxes.length-1){
                errorString += " and ";
            }
            if(numOfErrors>1 && i==InvalidInputBoxes.length-1){
                errorString += ",and ";
            }
            errorString += TextBoxNames[i];
            numOfErrors++;
        }
    }
    return errorString;
}
function getTextBoxNames(section){
    var textBoxNames = new Array(section);
    if(section=="PostalCode"){
        textBoxNames[0] = "Postal Code";
        textBoxNames[1] = "City";
        textBoxNames[2] = "Province";
    }
    return textBoxNames;
}