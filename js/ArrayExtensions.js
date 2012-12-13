function removeElementFromArray (from, element){
    var temp=new Array();
    var tempPopped="";
    var size = from.length;
    for(var i =0; i<size; i++){
        tempPopped = from.pop();
        if(tempPopped==element){
            break;
        }else{
            temp.push(tempPopped);
        }
    }
    returnElements(temp,from);
}

function returnElements(from, to){
    var size = from.length;
    for(var i = 0; i<size;i++){
        to.push(from.pop());
    }
}