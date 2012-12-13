function doAddCombo(e,theElement){
    if(e.keyCode==13){
        addCombo(theElement.value, "input_Language");
    }
}

function doSetDefault(e, theElement){
    if(e.keyCode==13){
        setDefault(theElement.value, "input_Language");
    }
}

function addCombo(entry, value, comboBox) {
    var option = entry;
    var combo= comboBox;
    if(option!=""){
        comboBox.append($('<option></option>').val(value).html(option));
    }
}
function setIndex(val, comboBoxName){
    var combo = document.getElementById(comboBoxName);
    combo.selectedIndex = val;
}


function setDefault(val, comboBoxName){
    var combo = document.getElementById(comboBoxName);
    for (var i=0 ; i < combo.length; i++){
        if (combo[i].value==val){
            combo.selectedIndex = i;
        }
    }
}

function clearComboBox(comboBox){
    comboBox.empty();
}