
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
var isResizing1 = false;
var isResizing2 = false;
var isResizing3 = false;
var isResizing4 = false;
var courant = -1;
var outside1 = false;
var outside2 = false; 
var first = false;
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
	    case 8 : deleteZone();
	        break;
	    case 46 : deleteZone();
	        break;
	    case 27 : resetAllZone();
	        break;
	    case 107 : plus();
	        break;
	    case 109 : less();
	        break;
	    case 37 : leftd();
	        break;
	    case 38 : up();
	        break;  
	    case 39 : rightd();
	        break;
	    case 40 : down();
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
	if(isDragging != true && isResizing1 != true && isResizing2 != true && isResizing3 != true && isResizing4 != true){
	
	initPos[0] = posym.x; // x
	initPos[1] = posym.y; // y
	
	isMousePressed = true;
	
	}
	
}



/* draw the selected area */

function setZone() {
   if (isMousePressed){
        if(setOK===true){
		    $("#container").append("<div id='selectedZone"+rank+"' value= '"+rank+"' class = 'selectedZone' name='touch' onmousedown = 'initDrag("+rank+")'  onmousemove='dragZone()' onmouseup ='endDrag()'></div>");
		    $("#container").append("<div id='point1"+rank+"' value= '"+rank+"' class='point' name='pointodd' onmousedown = 'initResize1("+rank+")' onmousemove ='resizePoint1()'></div>");
		    $("#container").append("<div id='point2"+rank+"' value= '"+rank+"' class='point' name='pointeven' onmousedown = 'initResize2("+rank+")' onmousemove ='resizePoint2()'></div>");
		    $("#container").append("<div id='point3"+rank+"' value= '"+rank+"' class='point' name='pointodd'onmousedown = 'initResize3("+rank+")' onmousemove ='resizePoint3()'></div>");
		    $("#container").append("<div id='point4"+rank+"' value= '"+rank+"' class='point' name='pointeven' onmousedown = 'initResize4("+rank+")' onmousemove ='resizePoint4()'></div>");
		    first = true;   
		    var elem = $("#selectedZone"+courant);
            elem.removeClass("selected");
		    courant = rank;
		    elem = $("#selectedZone"+courant);
            elem.addClass("selected");  
		 
		    setOK = false;
	    //div id="container" onmousedown="initZone()" onmousemove="selectZone()" onmouseup="endSelectZone()">
	
	    }
	    isSetting = true;
	    var div = $("#container").offset();
	    var elem = $("#selectedZone"+courant);
	    var point1 = $("#point1"+courant);
	    var point2 = $("#point2"+courant);
	    var point3 = $("#point3"+courant);
	    var point4 = $("#point4"+courant);
	    var img = $('#imageContainer');
	   

	
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
        
        if(elem.offset().left < img.offset().left){
            outside1 = true;
        }
        else{
            outside1 = false;
        }
        if(elem.offset().left + elem.width() > img.offset().left + img.width()){
            outside2 = true;
        }
        else{
            outside2 = false;
        }			    
    }
    else if(isDragging === true){
	    dragZone();
	}
	else if(isResizing1 === true){
	    resizePoint1();
	}
	else if(isResizing2 === true){
	    resizePoint2();
	}else if(isResizing3 === true){
	    resizePoint3();
	}
	else if(isResizing4 === true){
	    resizePoint4();
	}
}


function endSelectZone() {
    console.log("Sort");
	isMousePressed = false;
	isDragging = false;
	isResizing1 = false;
    isResizing2 = false;
    isResizing3 = false;
    isResizing4 = false;
	    var elem = $("#selectedZone"+courant);
	    var point1 = $("#point1"+courant);
	    var point2 = $("#point2"+courant);
	    var point3 = $("#point3"+courant);
	    var point4 = $("#point4"+courant);
	    point1.removeClass("dontShow");
		point2.removeClass("dontShow");
        point3.removeClass("dontShow");
        point4.removeClass("dontShow");

       var img = $('#imageContainer');
		
	if(outside1 === true){
	    elem.width(elem.width() - (img.offset().left - elem.offset().left));
	    elem.offset({left : img.offset().left});    
        outside1 = false;
	    
    }
    else if(outside2 === true){
        elem.width(elem.width() - (elem.offset().left + elem.width() - (img.offset().left + img.width())));
        elem.offset({left : img.offset().left + img.width() - elem.width()});
        outside2 = false;
    }   
	if (first === true){ 
	    point1.offset({left : elem.offset().left - point1.width()/2, top : elem.offset().top - point1.height()/2});   
	    point2.offset({left : elem.offset().left + elem.width() - point2.width()/2, top: elem.offset().top - point2.height()/2});
	    point3.offset({left : elem.offset().left + elem.width() - point3.width()/2, top: elem.offset().top + elem.height() - point3.height()/2});
		point4.offset({left : elem.offset().left - point4.width()/2, top : elem.offset().top + elem.height() - point4.height()/2});
	 }
	if (isSetting === true){
	    rank = rank+1;
	    isSetting = false;
	    setOK = true;
	}	
	
}


/*

    W8
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


*/


function initResize1(rank){

    isResizing1 = true;
    initPos[0]= posym.x
	initPos[1] = posym.y
    var point = $("#point1"+rank);
    var val = point.attr("value");
    var elem = $("#selectedZone"+courant);
    elem.removeClass("selected");
    courant = val;
    elem = $("#selectedZone"+courant);
    elem.addClass("selected");

}
function initResize2(rank){

    isResizing2 = true;
    initPos[0]= posym.x
	initPos[1] = posym.y
    var point = $("#point2"+rank);
    var val = point.attr("value");
    var elem = $("#selectedZone"+courant);
    elem.removeClass("selected");
    courant = val;
    elem = $("#selectedZone"+courant);
    elem.addClass("selected");

}
function initResize3(rank){
    isResizing3 = true;
    initPos[0]= posym.x
	initPos[1] = posym.y
    var point = $("#point3"+rank);
    var val = point.attr("value");
     var elem = $("#selectedZone"+courant);
    elem.removeClass("selected");
    courant = val;
    elem = $("#selectedZone"+courant);
    elem.addClass("selected");

}
function initResize4(rank){
    isResizing4 = true;
    initPos[0]= posym.x
	initPos[1] = posym.y
    var point = $("#point4"+rank);
    var val = point.attr("value");
    var elem = $("#selectedZone"+courant);
    elem.removeClass("selected");
    courant = val;
    elem = $("#selectedZone"+courant);
    elem.addClass("selected");

}

function resizePoint1() {
	if (isResizing1 === true){
	    var elem = $("#selectedZone"+courant);
	    var point1 = $("#point1"+courant);
	    var point2 = $("#point2"+courant);
	    var point3 = $("#point3"+courant);
	    var point4 = $("#point4"+courant);
	    var img = $('#imageContainer');
	
	   var pointRef ={
		    x:0,		
		    y:0
	    }
	    initPos[0] = point3.offset().left + point3.width()/2;
	    initPos[1] = point3.offset().top + point3.height()/2;
	   
	    
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
		   
			    elem.offset({left : pointRef.x , top :pointRef.y});
			    elem.width(Math.abs(initPos[0] - posym.x));
	            elem.height(Math.abs(initPos[1] - posym.y));
			    point1.addClass("dontShow");
			    point2.addClass("dontShow");
			    point4.addClass("dontShow");
	    if(elem.offset().left < img.offset().left){
            outside1 = true;
        }
        else{
            outside1 = false;
        }
        if(elem.offset().left + elem.width() > img.offset().left + img.width()){
            outside2 = true;
        }
        else{
            outside2 = false;
        }	
	    
	
	}
	
}

function resizePoint2(){
	if (isResizing2 === true){
	    var elem = $("#selectedZone"+courant);
	    var point1 = $("#point1"+courant);
	    var point2 = $("#point2"+courant);
	    var point3 = $("#point3"+courant);
	    var point4 = $("#point4"+courant);
	    var img = $('#imageContainer');
	
	   
	   var pointRef ={
		    x:0,		
		    y:0
	    }
	    initPos[0] = point4.offset().left + point4.width()/2;
	    initPos[1] = point4.offset().top + point4.height()/2;
	    
	    
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
		   
			    elem.offset({left : pointRef.x , top :pointRef.y});
			    elem.width(Math.abs(initPos[0] - posym.x));
	            elem.height(Math.abs(initPos[1] - posym.y));
			    point1.addClass("dontShow");
			    point2.addClass("dontShow");
			    point3.addClass("dontShow");
			
	     if(elem.offset().left < img.offset().left){
            outside1 = true;
        }
        else{
            outside1 = false;
        }
        if(elem.offset().left + elem.width() > img.offset().left + img.width()){
            outside2 = true;
        }
        else{
            outside2 = false;
        }	
	
	
	}

}

function resizePoint3(){
	if (isResizing3 === true){
	    var elem = $("#selectedZone"+courant);
	    var point1 = $("#point1"+courant);
	    var point2 = $("#point2"+courant);
	    var point3 = $("#point3"+courant);
	    var point4 = $("#point4"+courant);
        var img = $('#imageContainer');
	
	  
	   var pointRef ={
		    x:0,		
		    y:0
	    }
	    initPos[0] = point1.offset().left + point1.width()/2;
	    initPos[1] = point1.offset().top + point1.height()/2;
	   
	    
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
		   
			    elem.offset({left : pointRef.x , top :pointRef.y});
			    elem.width(Math.abs(initPos[0] - posym.x));
	            elem.height(Math.abs(initPos[1] - posym.y));
			    point2.addClass("dontShow");
			    point3.addClass("dontShow");
			    point4.addClass("dontShow");
	    
	    if(elem.offset().left < img.offset().left){
            outside1 = true;
        }
        else{
            outside1 = false;
        }
        if(elem.offset().left + elem.width() > img.offset().left + img.width()){
            outside2 = true;
        }
        else{
            outside2 = false;
        }	
	  
	}

}

function resizePoint4(){
	if (isResizing4 === true){
	    var elem = $("#selectedZone"+courant);
	    var point1 = $("#point1"+courant);
	    var point2 = $("#point2"+courant);
	    var point3 = $("#point3"+courant);
	    var point4 = $("#point4"+courant);
        var img = $('#imageContainer');
	
	   
	   var pointRef ={
		    x:0,		
		    y:0
	    }
	    initPos[0] = point2.offset().left + point2.width()/2;
	    initPos[1] = point2.offset().top + point2.height()/2;
	    
	    
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
		   
			    elem.offset({left : pointRef.x , top :pointRef.y});
			    elem.width(Math.abs(initPos[0] - posym.x));
	            elem.height(Math.abs(initPos[1] - posym.y));
			    point1.addClass("dontShow");
			    point3.addClass("dontShow");
			    point4.addClass("dontShow");
			    
			    
	    if(elem.offset().left < img.offset().left){
            outside1 = true;
        }
        else{
            outside1 = false;
        }
        if(elem.offset().left + elem.width() > img.offset().left + img.width()){
            outside2 = true;
        }
        else{
            outside2 = false;
        }	
	
	}

}




function initDrag(rank){
    isDragging = true;
    initPos[0]= posym.x
	initPos[1] = posym.y
    var elem = $("#selectedZone"+rank);
    var val = elem.attr("value");
    elem = $("#selectedZone"+courant);
    elem.removeClass("selected");
    courant = val;
    elem = $("#selectedZone"+courant);
    elem.addClass("selected");
    elem.attr("name","grab");
    
}



function dragZone() {
	
	    if(isDragging === true){
	
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
	
	
	
	
	    
	
	}else if(isResizing1 === true){
	    resizePoint1();
	}else if(isResizing2 === true){
	    resizePoint2();
	}else if(isResizing3 === true){
	    resizePoint3();
	}else if(isResizing4 === true){
	    resizePoint4();
	}	   
	
}

function endDrag(){
    var elem = $('#selectedZone'+courant);
    var point1 = $("#point1"+courant);
    var point2 = $("#point2"+courant);
	var point3 = $("#point3"+courant);
	var point4 = $("#point4"+courant);
	var img = $('#imageContainer');
	elem.attr("name","touch");
	
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


function deleteZone(){
		var elem = $("#selectedZone"+courant);
		var point1 = $("#point1"+courant);
		var point2 = $("#point2"+courant);
		var point3 = $("#point3"+courant);
		var point4 = $("#point4"+courant);
		
		
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


function plus(){
        var elem = $("#selectedZone"+courant);
	    var point1 = $("#point1"+courant);
	    var point2 = $("#point2"+courant);
	    var point3 = $("#point3"+courant);
	    var point4 = $("#point4"+courant);
	    var img = $('#imageContainer');
	        if((elem.offset().left + elem.width() + 25 < img.offset().left + img.width()) && (elem.offset().top + elem.height() + 25 < img.offset().top + img.height())){
	        elem.width(elem.width()+25);
	        elem.height(elem.height()+25);
	         point1.offset({left : elem.offset().left - point1.width()/2, top : elem.offset().top - point1.height()/2});   
	        point2.offset({left : elem.offset().left + elem.width() - point2.width()/2, top: elem.offset().top - point2.height()/2});
	        point3.offset({left : elem.offset().left + elem.width() - point3.width()/2, top: elem.offset().top + elem.height() - point3.height()/2});
		    point4.offset({left : elem.offset().left - point4.width()/2, top : elem.offset().top + elem.height() - point4.height()/2});
	        }
}

function less(){
        var elem = $("#selectedZone"+courant);
	    var point1 = $("#point1"+courant);
	    var point2 = $("#point2"+courant);
	    var point3 = $("#point3"+courant);
	    var point4 = $("#point4"+courant);
	    var img = $('#imageContainer');
	    if(elem.width() - 25 > 25 && elem.height() -25 > 25){
	        elem.width(elem.width()-25);
	        elem.height(elem.height()-25);
	        point1.offset({left : elem.offset().left - point1.width()/2, top : elem.offset().top - point1.height()/2});   
	        point2.offset({left : elem.offset().left + elem.width() - point2.width()/2, top: elem.offset().top - point2.height()/2});
	        point3.offset({left : elem.offset().left + elem.width() - point3.width()/2, top: elem.offset().top + elem.height() - point3.height()/2});
		    point4.offset({left : elem.offset().left - point4.width()/2, top : elem.offset().top + elem.height() - point4.height()/2});
	    }
}

function up(){
        var elem = $("#selectedZone"+courant);
	    var point1 = $("#point1"+courant);
	    var point2 = $("#point2"+courant);
	    var point3 = $("#point3"+courant);
	    var point4 = $("#point4"+courant);
	    var img = $('#imageContainer');
	   if(elem.offset().top - 25 > img.offset().top){
	        elem.offset({top : elem.offset().top - 25});
	        point1.offset({left : elem.offset().left - point1.width()/2, top : elem.offset().top - point1.height()/2});   
	        point2.offset({left : elem.offset().left + elem.width() - point2.width()/2, top: elem.offset().top - point2.height()/2});
	        point3.offset({left : elem.offset().left + elem.width() - point3.width()/2, top: elem.offset().top + elem.height() - point3.height()/2});
		    point4.offset({left : elem.offset().left - point4.width()/2, top : elem.offset().top + elem.height() - point4.height()/2});
	    }
}

function down(){
        var elem = $("#selectedZone"+courant);
	    var point1 = $("#point1"+courant);
	    var point2 = $("#point2"+courant);
	    var point3 = $("#point3"+courant);
	    var point4 = $("#point4"+courant);
	    var img = $('#imageContainer');
	    
	     if(elem.offset().top + elem.height() + 25 < img.offset().top + img.height()){
	        elem.offset({top : elem.offset().top + 25});
	        point1.offset({left : elem.offset().left - point1.width()/2, top : elem.offset().top - point1.height()/2});   
	        point2.offset({left : elem.offset().left + elem.width() - point2.width()/2, top: elem.offset().top - point2.height()/2});
	        point3.offset({left : elem.offset().left + elem.width() - point3.width()/2, top: elem.offset().top + elem.height() - point3.height()/2});
		    point4.offset({left : elem.offset().left - point4.width()/2, top : elem.offset().top + elem.height() - point4.height()/2});
	    }
}

function rightd(){
        var elem = $("#selectedZone"+courant);
	    var point1 = $("#point1"+courant);
	    var point2 = $("#point2"+courant);
	    var point3 = $("#point3"+courant);
	    var point4 = $("#point4"+courant);
	    var img = $('#imageContainer');
	    if(elem.offset().left + elem.width() + 25 < img.offset().left + img.width()){
	        elem.offset({left : elem.offset().left + 25});
	        point1.offset({left : elem.offset().left - point1.width()/2, top : elem.offset().top - point1.height()/2});   
	        point2.offset({left : elem.offset().left + elem.width() - point2.width()/2, top: elem.offset().top - point2.height()/2});
	        point3.offset({left : elem.offset().left + elem.width() - point3.width()/2, top: elem.offset().top + elem.height() - point3.height()/2});
		    point4.offset({left : elem.offset().left - point4.width()/2, top : elem.offset().top + elem.height() - point4.height()/2});
	    }
}

function leftd(){
        var elem = $("#selectedZone"+courant);
	    var point1 = $("#point1"+courant);
	    var point2 = $("#point2"+courant);
	    var point3 = $("#point3"+courant);
	    var point4 = $("#point4"+courant);
	    var img = $('#imageContainer');
	    if(elem.offset().left - 25 > img.offset().left){
	        elem.offset({left : elem.offset().left -25});
	        point1.offset({left : elem.offset().left - point1.width()/2, top : elem.offset().top - point1.height()/2});   
	        point2.offset({left : elem.offset().left + elem.width() - point2.width()/2, top: elem.offset().top - point2.height()/2});
	        point3.offset({left : elem.offset().left + elem.width() - point3.width()/2, top: elem.offset().top + elem.height() - point3.height()/2});
		    point4.offset({left : elem.offset().left - point4.width()/2, top : elem.offset().top + elem.height() - point4.height()/2});
	    }
}

function newImage() {
	$("#imageContainer").load('http://136.206.48.60/SharksTag/getAnImage.php');
		/* end by del the selected zone */
		resetAllZone();

}



function showHideTips() {
	document.getElementById("tipsMenu").classList.toggle("dontShow");
}
