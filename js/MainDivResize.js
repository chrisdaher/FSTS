
var w=window;
var d=document,e=d.documentElement,g=d.getElementsByTagName('body')[0];
var x=0,y=0;


function resizeMainDiv(){
    x=w.innerWidth||e.clientWidth||g.clientWidth;
    y=w.innerHeight||e.clientHeight||g.clientHeight;
    var toResize=document.getElementById('div_MainDiv');
	if(y>550){
		toResize.style.height= (y-theTop)+"px";
	}
	else{
		toResize.style.height= (550-theTop-5)+"px";
	}
	if(x<840){
			toResize.style.width= (835)+"px";
	}else{
		toResize.style.width= (x-17)+"px";
	}
}

window.onresize = function(event) {
    resizeMainDiv();
}