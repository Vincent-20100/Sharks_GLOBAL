
var posym ={
	x:0,
	y:0
}

var taillemin = false;
var rank = 0;
var setOK= true;
var topp = false;
var left = false;
var right = false;
var bot = false;
var isSetting = false;
var isDragging = false;
var isResizing = false;
var courant = -1;

$(function (){
	
	$("#container").mousemove(function(e) {
		posym.x = e.pageX;
		posym.y = e.pageY;
	});
	
});


document.onkeydown = function(e) {
	e = e || window.event;
	
	// detect shortcut key press
	switch(e.keyCode) {
		case 78 : // 'N'
		case 110 : // 'n'
			if (event.altKey) {
				newImage();
			} else {
				console.log(e.keyCode);
			}
			break;
		case 82 : // 'R'
		case 114 : // 'r'
			if (event.altKey) {
				resetZone();
			} else {
				console.log(e.keyCode);
			}
			break;
		case 84 : // 'T'
		case 116 : // 't'
			if (event.altKey) {
				showHideTips();
			} else {
				console.log(e.keyCode);
			}
			break;
		default :
			console.log(e.keyCode);
	}
};

var isMousePressed = false;
var initPos = [0, 0];
var mousePos = [0,0,0,0];

var mouseAction = setZone;

function initZone() {
	if(isDragging != true && isResizing != true){

	
	
	/*var elem = $("#selectedZone"+rank);
	var point1 = $("#point1"+rank);
	var point2 = $("#point2"+rank);
	var point3 = $("#point3"+rank);
	var point4 = $("#point4"+rank);
	*/
	
	
	initPos[0] = posym.x; // x
	initPos[1] = posym.y; // y
	
	/*mousePos[0] = initPos[0]; // x1
	mousePos[1] = initPos[1]; // y1
	mousePos[2] = initPos[0]; // x2
	mousePos[3] = initPos[1]; // y2*/
	
	isMousePressed = true;
	
	/* drag the zone */


	
	/*if (((Math.pow(initPos[0]-(point1.offset().left + point1.width()/2),2) + Math.pow(initPos[1]-(point1.offset().top + point1.height()/2),2)) <=  Math.pow(point1.width()/2,2)) ||
		((Math.pow(initPos[0]-(point2.offset().left + point2.width()/2),2) + Math.pow(initPos[1]-(point2.offset().top + point2.width()/2),2)) <=  Math.pow(point2.width()/2,2)) ||
		((Math.pow(initPos[0]-(point3.offset().left + point3.width()/2),2) + Math.pow(initPos[1]-(point3.offset().top + point3.width()/2),2)) <=  Math.pow(point3.width()/2,2)) ||
		((Math.pow(initPos[0]-(point4.offset().left + point4.width()/2),2) + Math.pow(initPos[1]-(point4.offset().top + point4.width()/2),2)) <=  Math.pow(point4.width()/2,2))){
			
			mouseAction = resizeZone;
			
	}
	
	else if ((elem.offset().left < initPos[0]) &&
		(initPos[0] < (elem.offset().left + elem.width())) && 
		(elem.offset().top < initPos[1]) &&
		(initPos[1] < (elem.offset().top + elem.height()))) {
		// The mouse point is inside the rectangle
		elem.attr("name","grab");
		mouseAction = dragZone;
	} else {
		// The mouse point is not inside the rectangle
		/* select a new zone */
   
	
	/*}*/
	}
	
}



/* draw the selected area */

function setZone() {
   if (isMousePressed){
        if(setOK===true){
		    $("#container").append("<div id='selectedZone"+rank+"' value= '"+rank+"' name='touch' onmousedown = 'initDrag("+rank+")'  onmousemove='dragZone()' onmouseup ='endDrag()'></div>");
		    $("#container").append("<div id='point1"+rank+"' value= '"+rank+"' class='point' name='pointodd' onmousedown = 'initResize("+rank+")' onmousemove ='resizePoint1()'></div>");
		    $("#container").append("<div id='point2"+rank+"' value= '"+rank+"' class='point' name='pointeven' ></div>");
		    $("#container").append("<div id='point3"+rank+"' value= '"+rank+"' class='point' name='pointodd'></div>");
		    $("#container").append("<div id='point4"+rank+"' value= '"+rank+"' class='point' name='pointeven' ></div>");
		    setOK = false;
	    //div id="container" onmousedown="initZone()" onmousemove="selectZone()" onmouseup="endSelectZone()">
	
	    }
	    isSetting = true;
	    console.log("setZone()");
	    var div = $("#container").offset();
	    var elem = $("#selectedZone"+rank);
	    var point1 = $("#point1"+rank);
	    var point2 = $("#point2"+rank);
	    var point3 = $("#point3"+rank);
	    var point4 = $("#point4"+rank);
	

	
	    var pointRef ={
		    x:0,		
		    y:0
	    }
	    /* sort the coordonates */
	    if (posym.x < initPos[0]) {
		    pointRef.x = posym.x;
	    }
	    else{
		    pointRef.x = initPos[0];
	    } 
	    if (posym.y < initPos[1]) {
		    pointRef.y = posym.y;	
	    }
	    else{
		    pointRef.y = initPos[1];
	    }
	

	    /* set the frame coordonates */
	
	    elem.offset({left: pointRef.x, top: pointRef.y});
	    elem.width(Math.abs(initPos[0]- posym.x));
	    elem.height(Math.abs(initPos[1]- posym.y));
	

	
	    point1.offset({left: pointRef.x - point1.width()/2, 
					    top: pointRef.y - point1.height()/2});
	    point2.offset({left: pointRef.x + elem.width() - point2.width()/2, 
					    top: pointRef.y - point2.height()/2});
	    point3.offset({left: pointRef.x + elem.width() - point3.width()/2, 
					    top: pointRef.y + elem.height() - point3.height()/2});
	    point4.offset({left: pointRef.x - point4.width()/2, 
					    top: pointRef.y + elem.height() - point4.height()/2});
    }
    else if(isDragging === true){
	    dragZone();
	}
	else if(isResizing === true){
	    resizePoint1();
	}	    
}


function endSelectZone() {
	isMousePressed = false;
	isDragging = false;
	isResizing = false;
	var elem = $("#selectedZone"+rank);
	elem.attr("name","touch");
	var point1 = $("#point1"+rank);
	var point3 = $("#point3"+rank);
	var point2 = $("#point2"+rank);
	var point4 = $("#point4"+rank);
	var img = $('#imageContainer');
	
	if (isSetting === true){
	    rank = rank+1;
	    isSetting = false;
	    setOK = true;
	}	
}

function set(){
	
	
	for (var i=0; i<=rank ;i++){
	    var elem = $("#selectedZone"+i);
	    var point1 = $("#point1"+i);
	    var point2 = $("#point2"+i);
	    var point3 = $("#point3"+i);
	    var point4 = $("#point4"+i);
	
	    if (elem.length != 0 ){ 
		    elem.attr("name","selectedZoneSet");
		    point1.attr("name","pointSet");
		    point2.attr("name","pointSet");
		    point3.attr("name","pointSet");
		    point4.attr("name","pointSet");

		    
	    }
	}
	setOK = true;
}





function initResize(rank){
    console.log("initResize");
    isResizing = true;
    initPos[0]= posym.x
	initPos[1] = posym.y
    var point = $("#point1"+rank);
    var val = point.attr("value");
    console.log("value :"+val);
    courant = val;

}

function resizePoint1() {
	console.log("DANS LA FONCTION");
	if (isResizing === true){
	    console.log("resizeZone");
	    var elem = $("#selectedZone"+courant);
	    var point1 = $("#point1"+courant);
	    var point2 = $("#point2"+courant);
	    var point3 = $("#point3"+courant);
	    var point4 = $("#point4"+courant);
	
	    if (((point2.offset().left - point1.offset().left)*(point3.offset().top-point2.offset().top))>10000){
		   
			    point2.offset({top :point2.offset().top + posym.y - initPos[1]});
			    point4.offset({left :point4.offset().left + posym.x - initPos[0]});
			    elem.width(elem.width() - (posym.x - initPos[0]));
			    elem.height(elem.height() - (posym.y - initPos[1]));
			    elem.offset({left : elem.offset().left + posym.x - initPos[0], top :elem.offset().top + posym.y - initPos[1]});
			    point1.offset({left : elem.offset().left - point1.width()/2, top: elem.offset().top - point1.height()/2});    	
	    }
	    initPos[0]= posym.x;
	    initPos[1] = posym.y;
	}
}










 /*   else if((Math.pow(initPos[0]-(point2.offset().left + point2.width()/2),2) + Math.pow(initPos[1]-(point2.offset().top + point2.width()/2),2)) <=  Math.pow(point2.width()/2,2)){
			    point2.offset({left :point2.offset().left + posym.x - initPos[0], top :point2.offset().top + posym.y - initPos[1]});
			    point3.offset({left :point3.offset().left + posym.x - initPos[0]})
			    elem.width(elem.width() + posym.x - initPos[0]);
			    elem.height(elem.height() - (posym.y - initPos[1]));
			    elem.offset({top :elem.offset().top + posym.y - initPos[1]});
			    point1.offset({ left : elem.offset().left - point1.width()/2, top: elem.offset().top - point1.height()/2});

		    }
		    else if((Math.pow(initPos[0]-(point3.offset().left + point3.width()/2),2) + Math.pow(initPos[1]-(point3.offset().top + point3.width()/2),2)) <=  Math.pow(point3.width()/2,2)){
			    point3.offset({left :point3.offset().left + posym.x - initPos[0], top :point3.offset().top + posym.y - initPos[1]});
			    point2.offset({left :point2.offset().left + posym.x - initPos[0]});
			    point4.offset({top :point4.offset().top + posym.y - initPos[1]});
			    elem.width(elem.width() + posym.x - initPos[0]);
			    elem.height(elem.height() + posym.y - initPos[1]);

		    }
		    else{

			    point4.offset({left :point4.offset().left + posym.x - initPos[0], top :point4.offset().top + posym.y - initPos[1]});
			    point3.offset({top :point3.offset().top + posym.y - initPos[1]});
			    elem.width(elem.width() - (posym.x - initPos[0]));
			    elem.height(elem.height() + posym.y - initPos[1]);
			    elem.offset({left : elem.offset().left + posym.x - initPos[0]});
			    point1.offset({left : elem.offset().left - point1.width()/2, top : elem.offset().top - point1.height()/2});

		    }
	    }
	    else{
		    taillemin = true;
	    }

	    initPos[0]= posym.x;
	    initPos[1] = posym.y;


*/









function initDrag(rank){
    isDragging = true;
    initPos[0]= posym.x
	initPos[1] = posym.y
    var elem = $("#selectedZone"+rank);
    var val = elem.attr("value");
    console.log("value :");
    courant = val;
    
}



function dragZone() {
	
	    if(isDragging === true){
	    console.log("dragZone");
	
	    var elem = $('#selectedZone'+courant).offset();
	    var point1 = $("#point1"+courant).offset();
	    var point2 = $("#point2"+courant).offset();
	    var point3 = $("#point3"+courant).offset();
	    var point4 = $("#point4"+courant).offset();
	    var img = $('#imageContainer');
	
	
	    if (elem.left < img.offset().left){
		    left = true;
	    }
	    else left = false;
	
	    if(elem.top < img.offset().top){
		    topp = true;
	    }
	    else topp = false;
	
	    if(elem.left + $('#selectedZone'+courant).width() > img.offset().left + img.width()){
		    right = true;
	    }
	    else right = false;
	
	    if(elem.top + $('#selectedZone'+courant).height() > img.offset().top + img.height()){
		    bot = true;
	    }
	    else bot = false;
	
	    point1.left = point1.left + posym.x - initPos[0];
	    point1.top = point1.top + posym.y - initPos[1];
	    point2.left = point2.left + posym.x - initPos[0];
	    point2.top = point2.top + posym.y - initPos[1];
	    point3.left = point3.left + posym.x - initPos[0];
	    point3.top = point3.top + posym.y - initPos[1];	
	    point4.left = point4.left + posym.x - initPos[0];
	    point4.top = point4.top + posym.y - initPos[1];
	    elem.left = elem.left + posym.x - initPos[0];
	    elem.top = elem.top + posym.y - initPos[1];


	    $('#selectedZone'+courant).offset(elem);
	    $("#point1"+courant).offset(point1);
	    $("#point2"+courant).offset(point2);
	    $("#point3"+courant).offset(point3);
	    $("#point4"+courant).offset(point4);
	
	    initPos[0]= posym.x
	    initPos[1] = posym.y
	
	
	
	
	    //(elem.offset().left + elem.width()) < img.width() && (elem.offset().top + elem.height() < img.height()
	
	}else if(isResizing === true){
	    resizePoint1();
	}	   
	
}

function endDrag(){
    var elem = $('#selectedZone'+courant);
    var point1 = $("#point1"+courant);
    var point2 = $("#point2"+courant);
	var point3 = $("#point3"+courant);
	var point4 = $("#point4"+courant);
	var img = $('#imageContainer');
	
    if (taillemin === true){
		point3.offset({left : point3.offset().left + 10, top : point3.offset().top + 10});
		point2.offset({left : point2.offset().left+10});
		point4.offset({top : point4.offset().top+10});
		elem.width(elem.width() + 10);
		elem.height(elem.height() + 10);
		taillemin = false;
	}
	
	if(left === true){
		elem.offset({left: img.offset().left});
		point1.offset({left : elem.offset().left - point1.width()/2 , top: elem.offset().top - point1.height()/2});
		point2.offset({left : elem.offset().left + elem.width() - point2.width()/2 , top: elem.offset().top - point2.height()/2});
		point3.offset({left : elem.offset().left + elem.width() - point3.width()/2 , top: elem.offset().top + elem.height() - point3.height()/2});
		point4.offset({left : elem.offset().left - point4.width()/2 , top: elem.offset().top + elem.height() - point4.height()/2});
	
		left = false;
	}

	if (topp === true){

		elem.offset({top : img.offset().top});
		point1.offset({left : elem.offset().left - point1.width()/2 , top: elem.offset().top - point1.height()/2});
		point2.offset({left : elem.offset().left + elem.width() - point2.width()/2 , top: elem.offset().top - point2.height()/2});
		point3.offset({left : elem.offset().left + elem.width() - point3.width()/2 , top: elem.offset().top + elem.height() - point3.height()/2});
		point4.offset({left : elem.offset().left - point4.width()/2 , top: elem.offset().top + elem.height() - point4.height()/2});
		topp = false;
	}
	
	if(right === true){
		elem.offset({left : img.offset().left + img.width() - elem.width()});
		point1.offset({left : elem.offset().left - point1.width()/2 , top: elem.offset().top - point1.height()/2});
		point2.offset({left : elem.offset().left + elem.width() - point2.width()/2 , top: elem.offset().top - point2.height()/2});
		point3.offset({left : elem.offset().left + elem.width() - point3.width()/2 , top: elem.offset().top + elem.height() - point3.height()/2});
		point4.offset({left : elem.offset().left - point4.width()/2 , top: elem.offset().top + elem.height() - point4.height()/2});
		right = false;
	}
	
	if(bot === true){
		elem.offset({top : img.offset().top + img.height() - elem.height()});
		point1.offset({left : elem.offset().left - point1.width()/2 , top: elem.offset().top - point1.height()/2});
		point2.offset({left : elem.offset().left + elem.width() - point2.width()/2 , top: elem.offset().top - point2.height()/2});
		point3.offset({left : elem.offset().left + elem.width() - point3.width()/2 , top: elem.offset().top + elem.height() - point3.height()/2});
		point4.offset({left : elem.offset().left - point4.width()/2 , top: elem.offset().top + elem.height() - point4.height()/2});
		bot = false;
	}
}


function resetZone() {
	var elem = $("#selectedZone"+rank);
	
	if(elem.length === 0 && rank >0){
		rank = rank-1;
	}
		var elem = $("#selectedZone"+rank);
		var point1 = $("#point1"+rank);
		var point2 = $("#point2"+rank);
		var point3 = $("#point3"+rank);
		var point4 = $("#point4"+rank);
		
		
		elem.remove();
		point1.remove();
		point2.remove();
		point3.remove();
		point4.remove();
		setOK=true;

}

function resetAllZone(){
	while(rank != 0){
		var elem = $("#selectedZone"+rank);
		var point1 = $("#point1"+rank);
		var point2 = $("#point2"+rank);
		var point3 = $("#point3"+rank);
		var point4 = $("#point4"+rank);
		
		elem.remove();
		point1.remove();
		point2.remove();
		point3.remove();
		point4.remove();
		
		rank = rank-1;
	}
	var elem = $("#selectedZone"+rank);
	var point1 = $("#point1"+rank);
	var point2 = $("#point2"+rank);
	var point3 = $("#point3"+rank);
	var point4 = $("#point4"+rank);
	isMousePressed = false;
	elem.remove();
	point1.remove();
	point2.remove();
	point3.remove();
	point4.remove();

	setOK=true;
}


function newImage() {
	$("#imageContainer").load('http://136.206.48.60/SharksTag/getAnImage.php');
		/* end by del the selected zone */
		resetAllZone();

}



function showHideTips() {
	document.getElementById("tipsMenu").classList.toggle("dontShow");
}

/*
var indexImage = -1;
var listImages = [];

function newImage() {
	var elem = document.getElementById("container");
	
	if(listImages.length == 0){
		//no image in the list of images
		//load the list of files available
		
		listImages = (function(dir) {

			var filesystem = require("fs");
			var results = [];

			filesystem.readdirSync(dir).forEach(function(file) {

				file = dir+'/'+file;
				var stat = filesystem.statSync(file);

				if (stat && stat.isDirectory()) {
				    //directory
				} else results.push(file);

			});

			return results;

		})(window.location.pathname+"/");
		console.log(listImages);
	}
	
	if(listImages.length == 0){
		if(elem.getElementById("labelError") == undefined){
			var newDiv = document.createElement("DIV");
			var txt = document.createTextNode("No image found");
			newDiv.appendChild(txt);
			newDiv.style["size"] = "48px";
			newDiv.style["text-align"] = "center";
			newDiv.style["padding"] = "20px";
			newDiv.style["border"] = "solid #f00 2px";
			newDiv.style["margin"] = "auto";
			elem.appendChild(newDiv)
		}
	}
	else{
		if(elem.getElementById("labelError") != undefined){
			elem.removeChild(elem.getElementById("labelError"));
		}
		elem.style.back
	}
	
	/* end by del the selected zone */
/*	resetZone();
}
*/


function showHideTips() {
	document.getElementById("tipsMenu").classList.toggle("dontShow");
}
