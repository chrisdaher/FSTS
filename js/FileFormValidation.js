    var cautionedFields= new Array();
    var cautions={};
    
    var tips= new Array();
    var warnings = new Array();
    var fileForm= "#form_file";
//-------------------------VALIDATE THE FORM BEFORE SUBMITTING IT-------------------------------------------
function ValidateFileForm(){
    for (var i = 0; i <AllFields.length; i++){
        $(AllFields[i]).trigger('blur');
    }
    if(cautionedFields.length>0){
        var tipString="tips:\n";
        var warningString="warnings:\n";
        for(var i = 0; i<tips.length;i++){
             tipString+=tips[i] + "\n";
             
        }
        for(var i = 0; i<warnings.length;i++){
            warningString+=warnings[i] +"\n"; 
        }
        addErrors(warnings, "warningTip");
        addErrors(tips, "noticeTip");
        displayError();
    }else{
        $(fileForm).submit();
    }
}


//------------------Generic Validation Functions--------------------------------------
function ValidateName(from, fromText, isWarning){
    $(from).removeClass("warning");
    $(from).removeClass("notice");
    removeCaution(from);
    if(!checkNotEmpty($(from), fromText, isWarning)){
        addCaution(from, fromText, isWarning);
        if(isWarning){
                $(from).addClass("warning");
            }
            else{
                $(from).addClass("notice");
            }
    }


}
function ValidateNumber (from, fromText, isWarning){
    $(from).removeClass("warning");
    $(from).removeClass("notice");
    removeCaution(from);
    if(!checkNotEmpty($(from), fromText, isWarning)){
        addCaution(from, fromText, isWarning);
        if(isWarning){
                $(from).addClass("warning");
            }
            else{
                $(from).addClass("notice");
            }
    }
    else if(!checkRegexp($(from), /^[0-9]+$/, fromText, "digits only.", isWarning)){
            if(isWarning){
                $(from).addClass("warning");
            }
            else{
                $(from).addClass("notice");
            }
    }

    
}
function ValidatePostalCode (from, fromText, isWarning){
    $(from).removeClass("warning");
    $(from).removeClass("notice");
    removeCaution(from);
     if(!checkRegexp($(from), /^\w\d\w\s?\d\w\d$/, fromText, "x0x 0x0 (where x:letter 0:digit)", isWarning)){
        addCaution(from, fromText, isWarning);
            if(isWarning){
                $(from).addClass("warning");
            }
            else{
                $(from).addClass("notice");
            }
    }

}

function ValidateDate(from, fromText, isWarning){
    $(from).removeClass("warning");
    $(from).removeClass("notice");
    removeCaution(from);
    if(!checkRegexp($(from), /^\d\d\d\d\-\d\d\-\d\d$/, fromText, "yyyy-mm-dd", isWarning)){
        addCaution(from, fromText, isWarning)
        if(isWarning){
                $(from).addClass("warning");
                return false;
            }
            else{
                $(from).addClass("notice");
                return false;
            }
    }
    return true;
}

//-------------------------ADDING TIPS AND CAUTIONS-----------------------------------------------------------
function addCaution(from, fromText, isWarning){
    cautionedFields.push(from);
    cautions[from]=fromText + " isNotice";
    if(isWarning){
        cautions[from]=fromText + " isWarning";
    }
}
function removeCaution(element){
    removeElementFromArray(cautionedFields, element);
    
}

function addTip( t, isWarning ) {
    if(isWarning){
      warnings.push(t);
    }else{
        tips.push( t );
    }
    
}
function removeTip(t){
    removeElementFromArray(tips, t);
    removeElementFromArray(warnings, t);
}