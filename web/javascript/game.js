//This is the initialisation of posym (the position x and y of the mouse)
var posym ={
	x:0,
	y:0
}

//Here is the initialisation of some variable that are use in the code bellow
var minimumsize = false;
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
var curent = -1;
var outside1 = false;
var outside2 = false; 
var outside3 = false;
var outside4 = false; 
var first = false;
var isMousePressed = false;
var initPos = [0, 0];
var mousePos = [0,0,0,0];
var mouseAction = setZone;

var UNDEFINED_SPECIES = 'undefined';

function getPos(){
	var pos = $("#mainNav").height();
	$("#navGame").attr("data-offset-top", pos);
}



$(function (){
//This is a Jquery function, it's called all the time
//We get the position of the mouse and we put it in posym
	
	$('#container').bind('touchmove', function(e){
		e.preventDefault(); 
		e.returnValue = false;
	});
	
	$('#imageContainer').bind('touchmove', function(e){
		e.preventDefault(); 
		e.returnValue = false;
	});

	$('#modalTableSpecies').unbind('touchmove');
	$('div.modal-content.container').unbind('touchmove');


	$("#container").on('mousemove ', function(e) {
  		posym.x =  e.pageX
  		posym.y =  e.pageY
	});



	$("#container").on('touchstart touchmove', function(e) {
  		posym.x =  e.originalEvent.touches[0].pageX
  		posym.y =  e.originalEvent.touches[0].pageY
	});

	

		//Each time we have a change in the comboBox, this function is called
	$("#sharkSpecies").keyup( function() {
		//What is choosen in the comboBox
		var speciesSelected = $("#sharkSpecies :selected").attr("value");
		//In which SelectedZone
		var elem = $("#selectedZone"+curent);
		elem.attr("species", speciesSelected);
		if (speciesSelected === UNDEFINED_SPECIES) {
			elem.html("");
		}
		else {
		    //We add this to a span on the actual div in order to print the
		    //Shark spicies on the screen
			elem.html("<span class='species label label-primary'>" + speciesSelected + "</span>");
		}
		
	});
	var bod = $('body');
	var img = $("#container");
	var bodwidth = img.width();
	var bodheight = img.height();
	getPos();
	$(window).resize(function(){
		getPos();
		var pourcentbodwidth = img.width() / bodwidth;
		var pourcentbodheight = img.height() / bodheight;
		var i = 0;
		for(i=0; i<rank; i++){
			var elem = $("#selectedZone"+i);
		    if (elem.length != 0){
				var point1 = $("#point1"+i);
			    var point2 = $("#point2"+i);
			    var point3 = $("#point3"+i);
			    var point4 = $("#point4"+i);
				elem.width(elem.width()*pourcentbodwidth);
				elem.height(elem.height()*pourcentbodheight);
				elem.offset({left: (elem.offset().left)*pourcentbodwidth,  top: (elem.offset().top)*pourcentbodheight});
				point1.offset({left : elem.offset().left - point1.width()/2, top : elem.offset().top - point1.height()/2});
		        point2.offset({left : elem.offset().left + elem.width() - point2.width()/2, top: elem.offset().top - point2.height()/2});
		        point3.offset({left : elem.offset().left + elem.width() - point3.width()/2, top: elem.offset().top + elem.height() - point3.height()/2});
			    point4.offset({left : elem.offset().left - point4.width()/2, top : elem.offset().top + elem.height() - point4.height()/2});
		    }
		}
		bodwidth = img.width();
		bodheight = img.height();
	});
});




document.onkeydown = function(e) {
//This fonction allows users to use the keyboard
	e = e || window.event;
	// detect shortcut key press
	switch(e.keyCode) {
		case 13 : // 'Enter'
			if(!window.location.href.endsWith('tutorial.php')){
				newImage();
			}
			break;
		case 84 : // 'T'
			showHideTips();
			break;
	    case 46 : // 'delete'
	    	deleteZone();
	        break;
	    case 27 : //'Esc'
	    	resetAllZone();
	        break;
	    case 107 : // '+'
	    	plus();
	        break;
	    case 109 : // '-'
	    	less();
	        break;
	    case 37 : // left arrow
	    	leftd();
	        break;
	    case 38 : // up arrow
	    	up();
	        break;  
	    case 39 : // right arrow
	    	rightd();
	        break;
	    case 40 : // down arrow
	    	down();
	        break;
	}
};




function initZone() {
//Function called when we click on the div id='container'
	if(isDragging != true && isResizing1 != true && isResizing2 != true && isResizing3 != true && isResizing4 != true){
		
		$("#container").on('mousemove ', function(e) {
  		posym.x =  e.pageX
  		posym.y =  e.pageY
	});

		
		$("#container").on('touchstart', function(e) {
	  		posym.x =  e.originalEvent.touches[0].pageX
	  		posym.y =  e.originalEvent.touches[0].pageY
			initPos[0] = posym.x; // x
			initPos[1] = posym.y; // y
		});
		
		initPos[0] = posym.x; // x
		initPos[1] = posym.y; // y

		isMousePressed = true;   
	}
	
}



function setZone() {
/* draw the selected area */
//Function called when we move on the div id='container'
//If we have clicked on the div id='container', isMousePressed === true
   if (isMousePressed){
   		console.log("set zone");
        if(setOK===true){
        //Creation of a new SelectedZone as well as 4 points

		    $("#container").append("<div id='selectedZone"+rank+"' value= '"+rank+"' species='" + UNDEFINED_SPECIES + "' class = 'selectedZone' name='touch' ontouchstart ='initDrag("+rank+")' ontouchmove ='dragZone()' onmousedown = 'initDrag("+rank+")'  onmousemove='dragZone()' onmouseup='endSelectZone()'></div>");
		    $("#container").append("<div id='point1"+rank+"' value= '"+rank+"' species='' class='point' name='pointodd' ontouchstart ='initResize1("+rank+")' ontouchmove='resizePoint1()' onmousedown = 'initResize1("+rank+")' onmousemove ='resizePoint1()'></div>");
		    $("#container").append("<div id='point2"+rank+"' value= '"+rank+"' species='' class='point' name='pointeven' ontouchstart ='initResize2("+rank+")' ontouchmove='resizePoint2()' onmousedown = 'initResize2("+rank+")' onmousemove ='resizePoint2()'></div>");
		    $("#container").append("<div id='point3"+rank+"' value= '"+rank+"' species='' class='point' name='pointodd' ontouchstart ='initResize3("+rank+")' ontouchmove='resizePoint3()' onmousedown = 'initResize3("+rank+")' onmousemove ='resizePoint3()'></div>");
		    $("#container").append("<div id='point4"+rank+"' value= '"+rank+"' species='' class='point' name='pointeven' ontouchstart ='initResize4("+rank+")' ontouchmove='resizePoint4()' onmousedown = 'initResize4("+rank+")' onmousemove ='resizePoint4()'></div>");

		    first = true;
		    var elem = $("#selectedZone"+curent);
            elem.removeClass("selected");
		    curent = rank;
		    //The courent element is the new element created
		    elem = $("#selectedZone"+curent);
            elem.addClass("selected");  
		 
		    setOK = false;
	
	    }
	    isSetting = true;
	    //recovery of data, the curent element etc...
	    var div = $("#container").offset();
	    var elem = $("#selectedZone"+curent);
	    var point1 = $("#point1"+curent);
	    var point2 = $("#point2"+curent);
	    var point3 = $("#point3"+curent);
	    var point4 = $("#point4"+curent);
	    var img = $('#imageContainer');
	   
		// set the selected option in the combobox to undefined value
		$("#sharkSpecies").val(UNDEFINED_SPECIES);
		
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
	
	    /* set the coordonates of the selectedZone, its width, its height */
	    elem.offset({left: pointRef.x, top: pointRef.y});


	   /* elem.css("left",pointRef.x);
	    elem.css("top",pointRef.y - img.offset().top);
	    elem.css("width", initPos[0]- posym.x);
	    elem.css("height", initPos[1]- posym.y);*/
	    elem.width(Math.abs(initPos[0]- posym.x));
	   elem.height(Math.abs(initPos[1]- posym.y));
	
	    //set the coortonates of the 4 points situated in each corner of the zone
	    point1.offset({left: pointRef.x - point1.width()/2, 
					    top: pointRef.y - point1.height()/2});
	    point2.offset({left: pointRef.x + elem.width() - point2.width()/2, 
					    top: pointRef.y - point2.height()/2});
	    point3.offset({left: pointRef.x + elem.width() - point3.width()/2, 
					    top: pointRef.y + elem.height() - point3.height()/2});
	    point4.offset({left: pointRef.x - point4.width()/2, 
					    top: pointRef.y + elem.height() - point4.height()/2});
        
        //avoid the possibility to create a selectedZone outside the image
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
        
	    if(elem.offset().top < img.offset().top){
		    outside3 = true;
	    }
	    else outside3 = false;


	    if(elem.offset().top + elem.height() > img.offset().top + img.height()){
		    outside4 = true;
	    }
	    else outside4 = false;
    }
    //Even if we are moving the mouse in the container,
    //If we were dragging or resising, it will continute
    //And will not create another new selectedZone  
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

function passDiv(){

 	if(isDragging === true){
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

function initDrag(rank){
//This function is called when you click on a SelectedZone
	console.log("initDRAG");
    isDragging = true;
    initPos[0]= posym.x
	initPos[1] = posym.y
	
    var elem = $("#selectedZone"+rank);
    var val = elem.attr("value");
    
    elem = $("#selectedZone"+curent);
    elem.removeClass("selected");
    curent = val;
    elem = $("#selectedZone"+curent);
    elem.addClass("selected");
    elem.attr("name","grab");
    
    // set the selected option in the combobox to UNDEFINED_SPECIES value
	$("#sharkSpecies").val(elem.attr("species"));
}


function dragZone() {
//This function is called when you move the mouse on a SelectedZone
	
    if(isDragging === true){
   	console.log("Is DRAGGING");
    //recovery of data, the curent element etc...
    var elem = $('#selectedZone'+curent)
    var point1 = $("#point1"+curent)
    var point2 = $("#point2"+curent)
    var point3 = $("#point3"+curent)
    var point4 = $("#point4"+curent)
    var img = $('#imageContainer');

    // we avoid the user to drag a selectedZone outside of the image	    
    if (elem.offset().left < img.offset().left){
	    left = true;
    }
    else left = false;

    if(elem.offset().top < img.offset().top){
	    topp = true;
    }
    else topp = false;

    if(elem.offset().left + $('#selectedZone'+curent).width() > img.offset().left + img.width()){
	    right = true;
    }
    else right = false;

    if(elem.offset().top + $('#selectedZone'+curent).height() > img.offset().top + img.height()){
	    bot = true;
    }
    else bot = false;

    //Change the coordonates of the element and the points   
    elem.offset({left : elem.offset().left + posym.x - initPos[0], top : elem.offset().top + posym.y - initPos[1]}); 
    point1.offset({left : elem.offset().left - point1.width()/2 , top: elem.offset().top - point1.height()/2});
	point2.offset({left : elem.offset().left + elem.width() - point2.width()/2 , top: elem.offset().top - point2.height()/2});
	point3.offset({left : elem.offset().left + elem.width() - point3.width()/2 , top: elem.offset().top + elem.height() - point3.height()/2});
	point4.offset({left : elem.offset().left - point4.width()/2 , top: elem.offset().top + elem.height() - point4.height()/2});

    //the initial position of the mouse is the old next position
    initPos[0]= posym.x
    initPos[1] = posym.y
	   
	//If we were resising, you will not drag but continute to risizes
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



function initResize1(rank){
//This function is called when you click on one point
    isResizing1 = true;
    initPos[0]= posym.x
	initPos[1] = posym.y
    var point = $("#point1"+rank);
    var val = point.attr("value");
    var elem = $("#selectedZone"+curent);
    elem.removeClass("selected");
    curent = val;
    elem = $("#selectedZone"+curent);
    elem.addClass("selected");
}



function initResize2(rank){
//This function is called when you click on one point
    isResizing2 = true;
    initPos[0]= posym.x
	initPos[1] = posym.y
    var point = $("#point2"+rank);
    var val = point.attr("value");
    var elem = $("#selectedZone"+curent);
    elem.removeClass("selected");
    curent = val;
    elem = $("#selectedZone"+curent);
    elem.addClass("selected");
}



function initResize3(rank){
//This function is called when you click on one point
    isResizing3 = true;
    initPos[0]= posym.x
	initPos[1] = posym.y
    var point = $("#point3"+rank);
    var val = point.attr("value");
     var elem = $("#selectedZone"+curent);
    elem.removeClass("selected");
    curent = val;
    elem = $("#selectedZone"+curent);
    elem.addClass("selected");
}



function initResize4(rank){
//This function is called when you click on one point
    isResizing4 = true;
    initPos[0]= posym.x
	initPos[1] = posym.y
    var point = $("#point4"+rank);
    var val = point.attr("value");
    var elem = $("#selectedZone"+curent);
    elem.removeClass("selected");
    curent = val;
    elem = $("#selectedZone"+curent);
    elem.addClass("selected");
}



function resizePoint1() {
//This function is called when you mouve the mouse after click on a green point
	
	if (isResizing1 === true){
	    //recovery of data, the curent element etc...
		var elem = $("#selectedZone"+curent);
	    var point1 = $("#point1"+curent);
	    var point2 = $("#point2"+curent);
	    var point3 = $("#point3"+curent);
	    var point4 = $("#point4"+curent);
	    var img = $('#imageContainer');
	   
	    // dont show the label with the shark name during the resize process
	    $("#selectedZone" + curent + " .species").addClass("dontShow");
	 
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
	    
	    // display this points when we are resising
	    point1.addClass("dontShow");
	    point2.addClass("dontShow");
	    point4.addClass("dontShow");
	   
	    // we avoid the user to resise outside of the image
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
        

	    if(elem.offset().top < img.offset().top){
		    outside3 = true;
	    }
	    else outside3 = false;


	    if(elem.offset().top + elem.height() > img.offset().top + img.height()){
		    outside4 = true;
	    }
	    else outside4 = false;
	}	
}



function resizePoint2(){
//This function is called when you mouve the mouse after click on a green point
	if (isResizing2 === true){
	    //recovery of data, the curent element etc...
	    var elem = $("#selectedZone"+curent);
	    var point1 = $("#point1"+curent);
	    var point2 = $("#point2"+curent);
	    var point3 = $("#point3"+curent);
	    var point4 = $("#point4"+curent);
	    var img = $('#imageContainer');
		
		// dont show the label with the shark name during the resize process
		$("#selectedZone" + curent + " .species").addClass("dontShow");
	   
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
	    
	    // display this points when we are resising
	    point1.addClass("dontShow");
	    point2.addClass("dontShow");
	    point3.addClass("dontShow");
			
	    // we avoid the user to resise outside of the image
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
        

	    if(elem.offset().top < img.offset().top){
		    outside3 = true;
	    }
	    else outside3 = false;


	    if(elem.offset().top + elem.height() > img.offset().top + img.height()){
		    outside4 = true;
	    }
	    else outside4 = false;
	}
}



function resizePoint3(){
//This function is called when you mouve the mouse after click on a green point
	if (isResizing3 === true){
	    //recovery of data, the curent element etc...
	    var elem = $("#selectedZone"+curent);
	    var point1 = $("#point1"+curent);
	    var point2 = $("#point2"+curent);
	    var point3 = $("#point3"+curent);
	    var point4 = $("#point4"+curent);
        var img = $('#imageContainer');
		
		// dont show the label with the shark name during the resize process
		$("#selectedZone" + curent + " .species").addClass("dontShow");
	  
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
        // display this points when we are resising
	    point2.addClass("dontShow");
	    point3.addClass("dontShow");
	    point4.addClass("dontShow");
	    
	    // we avoid the user to resise outside of the image
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
        

	    if(elem.offset().top < img.offset().top){
		    outside3 = true;
	    }
	    else outside3 = false;


	    if(elem.offset().top + elem.height() > img.offset().top + img.height()){
		    outside4 = true;
	    }
	    else outside4 = false;
	}
}



function resizePoint4(){
//This function is called when you mouve the mouse after click on a green point
	if (isResizing4 === true){
	    //recovery of data, the curent element etc...
	    var elem = $("#selectedZone"+curent);
	    var point1 = $("#point1"+curent);
	    var point2 = $("#point2"+curent);
	    var point3 = $("#point3"+curent);
	    var point4 = $("#point4"+curent);
        var img = $('#imageContainer');
		
		// dont show the label with the shark name during the resize process
	    $("#selectedZone" + curent + " .species").addClass("dontShow");
		
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
	    // display this points when we are resising
	    point1.addClass("dontShow");
	    point3.addClass("dontShow");
	    point4.addClass("dontShow");
			    		
	    // we avoid the user to resise outside of the image	    
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
        

	    if(elem.offset().top < img.offset().top){
		    outside3 = true;
	    }
	    else outside3 = false;


	    if(elem.offset().top + elem.height() > img.offset().top + img.height()){
		    outside4 = true;
	    }
	    else outside4 = false;
	}
}


function endSelectZone() {
//This function is called each time the user releases the mouse click
    console.log("End Click");
	//In this case:
	//stop to click
 
    //recovery of data, the curent element etc...
	var elem = $("#selectedZone"+curent);
	var point1 = $("#point1"+curent);
	var point2 = $("#point2"+curent);
	var point3 = $("#point3"+curent);
	var point4 = $("#point4"+curent);
	var img = $('#imageContainer img');	

	if (elem.length == 0) {return;};

	// display the points and the label which indicates the shark species
	point1.removeClass("dontShow");
	point2.removeClass("dontShow");
	point3.removeClass("dontShow");
	point4.removeClass("dontShow");
	$("#selectedZone" + curent + " .species").removeClass("dontShow");
		
	//We are looking if outside1 or outside2 boulean is true
	//If it's true, we have to do some modification of the offset
	if(outside1 === true){
	    elem.width(elem.width() - (img.offset().left - elem.offset().left));
	    elem.offset({left : img.offset().left});    
        outside1 = false;	    
    }
    if(outside2 === true){
        elem.width(elem.width() - (elem.offset().left + elem.width() - (img.offset().left + img.width())));
        elem.offset({left : img.offset().left + img.width() - elem.width()});
        outside2 = false;
    }  
    if(outside3 === true){
    	elem.height(elem.height() - (img.offset().top - elem.offset().top));
    	elem.offset({top : img.offset().top});
    	outside3 = false;
    } 
    if(outside4 === true){
    	elem.height(elem.height() - (elem.offset().top + elem.height() - (img.offset().top + img.height())));
    	elem.offset({top : img.offset.top + img.height()- elem.height()});
    	outside4 = false;
    }
	if (first === true){ 
	    point1.offset({left : elem.offset().left - point1.width()/2, top : elem.offset().top - point1.height()/2});   
	    point2.offset({left : elem.offset().left + elem.width() - point2.width()/2, top: elem.offset().top - point2.height()/2});
	    point3.offset({left : elem.offset().left + elem.width() - point3.width()/2, top: elem.offset().top + elem.height() - point3.height()/2});
		point4.offset({left : elem.offset().left - point4.width()/2, top : elem.offset().top + elem.height() - point4.height()/2});
	 }
	if (isSetting === true){
	    //we made a new selected zone so we are incrementing the variable
	    rank = rank+1;
	    setOK = true;
	}	
	
	//This is just for chqnge the CSS in order to change the cursor
	elem.attr("name","touch");
	
	//Same thing for the drag
	//If one of our boolean are true when the user is Dragging
	//We have to do some modification of the offset
    if (minimumsize === true){
		point3.offset({left : point3.offset().left + 10, top : point3.offset().top + 10});
		point2.offset({left : point2.offset().left+10});
		point4.offset({top : point4.offset().top+10});
		elem.width(elem.width() + 10);
		elem.height(elem.height() + 10);
		minimumsize = false;
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

	//stop to click
	isMousePressed = false;
	//stop to set
	isSetting = false;
	//stop to drag
	isDragging = false;
    //stop to resize	
    isResizing1 = false;
    isResizing2 = false;
    isResizing3 = false;
    isResizing4 = false;
}



function deleteZone(){
//This function is called when you click on the Delete buton or when you press the Delete hotkey
    //recovery of data, the curent element etc...
	var elem = $("#selectedZone"+curent);
	var point1 = $("#point1"+curent);
	var point2 = $("#point2"+curent);
	var point3 = $("#point3"+curent);
	var point4 = $("#point4"+curent);
	
	// set the selected option in the combobox to UNDEFINED_SPECIES value
	$("#sharkSpecies").val(UNDEFINED_SPECIES);	
	elem.remove();
	point1.remove();
	point2.remove();
	point3.remove();
	point4.remove();
	setOK=true;
}



function resetAllZone(){
//This function is called when you click on the ResetAll buton or when you press the Esc hotkey
	while(rank != 0){
	    //recovery of data, the curent element etc...
		var elem = $("#selectedZone"+rank);
		var point1 = $("#point1"+rank);
		var point2 = $("#point2"+rank);
		var point3 = $("#point3"+rank);
		var point4 = $("#point4"+rank);
		
		//we are removing every element
		elem.remove();
		point1.remove();
		point2.remove();
		point3.remove();
		point4.remove();
		rank = rank-1;
	}
	
	//We are doing the same for the last element rank === 0
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
	
	// set the selected option in the combobox to UNDEFINED_SPECIES value
	$("#sharkSpecies").val(UNDEFINED_SPECIES);
	setOK=true;
}



function plus(){
//This function is called when you press the '+' hotkey
    //recovery of data, the curent element etc...
    var elem = $("#selectedZone"+curent);
    var point1 = $("#point1"+curent);
    var point2 = $("#point2"+curent);
    var point3 = $("#point3"+curent);
    var point4 = $("#point4"+curent);
    var img = $('#imageContainer');
    //Avoid the possibility to resize outside the image
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
//This function is called when you press the '-' hotkey
    //recovery of data, the curent element etc...
    var elem = $("#selectedZone"+curent);
    var point1 = $("#point1"+curent);
    var point2 = $("#point2"+curent);
    var point3 = $("#point3"+curent);
    var point4 = $("#point4"+curent);
    var img = $('#imageContainer');
    //we set a minimum size
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
//This function is called when you press the '+' hotkey
    //recovery of data, the curent element etc...
    var elem = $("#selectedZone"+curent);
    var point1 = $("#point1"+curent);
    var point2 = $("#point2"+curent);
    var point3 = $("#point3"+curent);
    var point4 = $("#point4"+curent);
    var img = $('#imageContainer');
    //Avoid the possibility to move the selectedZone outside the image
    if(elem.offset().top - 25 > img.offset().top){
        elem.offset({top : elem.offset().top - 25});
        point1.offset({left : elem.offset().left - point1.width()/2, top : elem.offset().top - point1.height()/2});   
        point2.offset({left : elem.offset().left + elem.width() - point2.width()/2, top: elem.offset().top - point2.height()/2});
        point3.offset({left : elem.offset().left + elem.width() - point3.width()/2, top: elem.offset().top + elem.height() - point3.height()/2});
	    point4.offset({left : elem.offset().left - point4.width()/2, top : elem.offset().top + elem.height() - point4.height()/2});
    }
}



function down(){
//This function is called when you press the down arrow
    //recovery of data, the curent element etc...
    var elem = $("#selectedZone"+curent);
    var point1 = $("#point1"+curent);
    var point2 = $("#point2"+curent);
    var point3 = $("#point3"+curent);
    var point4 = $("#point4"+curent);
    var img = $('#imageContainer');
    //Avoid the possibility to move the selectedZone outside the image
    if(elem.offset().top + elem.height() + 25 < img.offset().top + img.height()){
        elem.offset({top : elem.offset().top + 25});
        point1.offset({left : elem.offset().left - point1.width()/2, top : elem.offset().top - point1.height()/2});   
        point2.offset({left : elem.offset().left + elem.width() - point2.width()/2, top: elem.offset().top - point2.height()/2});
        point3.offset({left : elem.offset().left + elem.width() - point3.width()/2, top: elem.offset().top + elem.height() - point3.height()/2});
	    point4.offset({left : elem.offset().left - point4.width()/2, top : elem.offset().top + elem.height() - point4.height()/2});
    }
}

function rightd(){
//This function is called when you press the right arrow
    //recovery of data, the curent element etc...
    var elem = $("#selectedZone"+curent);
    var point1 = $("#point1"+curent);
    var point2 = $("#point2"+curent);
    var point3 = $("#point3"+curent);
    var point4 = $("#point4"+curent);
    var img = $('#imageContainer');
    //Avoid the possibility to move the selectedZone outside the image
    if(elem.offset().left + elem.width() + 25 < img.offset().left + img.width()){
        elem.offset({left : elem.offset().left + 25});
        point1.offset({left : elem.offset().left - point1.width()/2, top : elem.offset().top - point1.height()/2});   
        point2.offset({left : elem.offset().left + elem.width() - point2.width()/2, top: elem.offset().top - point2.height()/2});
        point3.offset({left : elem.offset().left + elem.width() - point3.width()/2, top: elem.offset().top + elem.height() - point3.height()/2});
	    point4.offset({left : elem.offset().left - point4.width()/2, top : elem.offset().top + elem.height() - point4.height()/2});
    }
}



function leftd(){
//This function is called when you press the left arrow
    //recovery of data, the curent element etc...
    var elem = $("#selectedZone"+curent);
    var point1 = $("#point1"+curent);
    var point2 = $("#point2"+curent);
    var point3 = $("#point3"+curent);
    var point4 = $("#point4"+curent);
    var img = $('#imageContainer');
    //Avoid the possibility to move the selectedZone outside the image
    if(elem.offset().left - 25 > img.offset().left){
        elem.offset({left : elem.offset().left -25});
        point1.offset({left : elem.offset().left - point1.width()/2, top : elem.offset().top - point1.height()/2});   
        point2.offset({left : elem.offset().left + elem.width() - point2.width()/2, top: elem.offset().top - point2.height()/2});
        point3.offset({left : elem.offset().left + elem.width() - point3.width()/2, top: elem.offset().top + elem.height() - point3.height()/2});
	    point4.offset({left : elem.offset().left - point4.width()/2, top : elem.offset().top + elem.height() - point4.height()/2});
    }
}



function newImage() {
	
	sendTags();
	
		
}



function sendTags() {

	var listTags = [];


	
	for(i=0; i<rank; i++){
		var elem = $("#selectedZone"+i);
   	 	var img = $('#imageContainer img');
   	 	var imgContainer = $('#imageContainer');
		var navMain = $("#mainNav");
		var navGame = $("#navGame");
		var container = $('#container');

		if(elem.length != 0){
			listTags[i] = {};

			var x1 = ((elem.offset().left - parseInt(imgContainer.css("margin-left")))/ img.width()) * img.attr("img-width");
			var y1 = ((elem.offset().top - navMain.height() - navGame.height()) / img.height()) * img.attr("img-height");
			var x2 = ((elem.offset().left + elem.width() - parseInt(imgContainer.css("margin-left")) )/ img.width()) * img.attr("img-width");
			var y2 = ((elem.offset().top + elem.height() - navMain.height() - navGame.height()) / img.height()) * img.attr("img-height");
			listTags[i]['sharkName'] = $("#selectedZone" + i).attr("species");
			listTags[i]['x1'] = x1;
			listTags[i]['y1'] = y1;
			listTags[i]['x2'] = x2;
			listTags[i]['y2'] = y2;
		}
		
	}

	// we need to use a JSON to send a tab to the server
	var jsonListTags = JSON.stringify(listTags);
	
		
	// send the tags to the data base
	$.ajax({
		async: true,
		// destination page
		url: 'http://www.divelikeastone.com/Sharks/php_script/tagSent.php',
		// use POST method
		type: 'POST',
		// POST's arguments
		data: {
			imageURL : $("#imageContainer img").attr("src"),
			imageWidth : $("#imageContainer img").attr("img-width"),
			imageHeight : $("#imageContainer img").attr("img-height"),
			id_session : $("#session_id").val(),
			tabTagsPos : jsonListTags
		},
		context: this,
		// get the result
		success: checkTagSent
	});
	
	$("#player_audio").trigger("play");
}

function checkTagSent (data) {

	if(data.endsWith('Success')){
		$.ajax({
			async: true,
			// destination page
			url: 'http://www.divelikeastone.com/Sharks/php_script/getAnImage.php?s=' + $("#session_id").val() ,
			// use POST method
			type: 'GET',
			// POST's arguments
			data: {
			},
			context: this,
			// get the result
			success: checkImageContainer
		});

		/* end by del the selected zone */
		resetAllZone();
	} else {
		// TODO we will see later
		dispMsg("alert-danger", "danger", data);
	}
	
	// ---------------------------------
	// AFTER (avoid the parallelization)
	// ---------------------------------
	// actualize the user's score
	$.ajax({
		async: true,
		// destination page
		url: 'http://www.divelikeastone.com/Sharks/php_script/getScore.php',
		// use POST method
		type: 'POST',
		// POST's arguments
		data: {
			session : $("#session_id").val()
		},
		context: this,
		// get the result
		success: setScore
	});
}

function checkImageContainer(data){

		if($(data).is("img")){
			$("#imageContainer").html(data);
		}
		else {
			$("#imageContainer").html("");
			$("#container").after(data);
		}
}

function setScore (data) {
	if(data !== 'NULL') {
		$("#scoreButton").html(data);
	}
}

function showHideTips() {
	$("#tipsMenu").toggleClass("dontShow");
	$("#player_audio").trigger("play");
}
