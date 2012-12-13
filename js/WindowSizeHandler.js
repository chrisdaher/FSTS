
var w=window;
var d=document,e=d.documentElement,g=d.getElementsByTagName('body')[0];
var x=0,y=0;

function resizeFileInfo(){
    x=w.innerWidth||e.clientWidth||g.clientWidth;
    y=w.innerHeight||e.clientHeight||g.clientHeight;
    var toResize=document.getElementById('FileInfo');
	if(y>750){
		toResize.style.height= (y-105)+"px";
	}
	else{
		toResize.style.height= 750+"px";
	}
	if(x<1000){
			toResize.style.width= (666)+"px";
	}else{
		toResize.style.width= (x-18)+"px";
	}
}

window.onresize = function(event) {
    resizeFileInfo();
}



