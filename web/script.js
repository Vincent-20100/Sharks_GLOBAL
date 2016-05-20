/*
function hello(){
	document.getElementById("helloWorld_span").innerHTML = "Hello JavaScript";
}

var cpt = 0;

function incrementeCompteur(){
	cpt++;
	document.getElementById("cpt_span").innerHTML = cpt;
	
	console.log("incrementeCompteur()");
}
*/

/* start of mouse click */
/* document.getElementById("container").onmousedown = initZone; */
/* when mouse moves */
/* document.getElementById("container").onmousemove = selectZone; */
/* end of mouse click */
/* document.getElementById("container").onmouseup = endSelectZone; */
/*
document.onkeydown = function(evt) {
	evt = evt || window.event;
}

document.onkeyup = function(evt) {
	evt = evt || window.event;
}
*/
document.onkeydown = function(e) {
    e = e || window.event;
    
    // detect shortcut key press
    switch(e.keyCode) {
    	case 82 : // 'R'
    	case 114 : // 'r'
    		if (event.altKey) {
    			resetZone();
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

function initZone() {
	var elem = document.getElementById("selectedZone");
	var e = window.event;
	
	initPos[0] = e.clientX; // x
	initPos[1] = e.clientY; // y
	
	mousePos[0] = initPos[0]; // x1
	mousePos[1] = initPos[1]; // y1
	mousePos[2] = initPos[0]; // x2
	mousePos[3] = initPos[1]; // y2
	
	isMousePressed = true;
	
	/* remove the class dontShow which contains the css 'display: none' */
	elem.className = elem.className.replace(/dontShow/,"");
	/* hide the border frame */
	document.getElementById("maskNorth").className =
		document.getElementById("maskNorth").className.replace(/ dontShow/,"") + " dontShow";
	document.getElementById("maskSouth").className =
		document.getElementById("maskSouth").className.replace(/ dontShow/,"") + " dontShow";
	document.getElementById("maskEast").className =
		document.getElementById("maskEast").className.replace(/ dontShow/,"") + " dontShow";
	document.getElementById("maskWest").className =
		document.getElementById("maskWest").className.replace(/ dontShow/,"") + " dontShow";
}

/* function which draw the selected area */
function selectZone() {
	if (isMousePressed) {
		var div = document.getElementById("container");
		var elem = document.getElementById("selectedZone");
		var e = window.event;
	
		/* get the new position of the mouse */
		var x = e.clientX;
		var y = e.clientY;
	
		/* sort the coordonates */
		if (x < initPos[0]) {
			mousePos[0] = x;
			mousePos[2]= initPos[0];
		} else {
			mousePos[0] = initPos[0];
			mousePos[2] = x;
		}
		if (y < initPos[1]) {
			mousePos[1] = y;
			mousePos[3]= initPos[1];
		} else {
			mousePos[1] = initPos[1];
			mousePos[3] = y;
		}
	
		/* set the frame coordonates */
		elem.style.left = (mousePos[0] - div.getBoundingClientRect().left) + "px";
		elem.style.top = (mousePos[1] - div.getBoundingClientRect().top) + "px";
		elem.style.width = (mousePos[2] - mousePos[0]) + "px";
		elem.style.height = (mousePos[3] - mousePos[1]) + "px";
	}
}

function endSelectZone() {
	var divBound = document.getElementById("container").getBoundingClientRect();
	var elemBound = document.getElementById("selectedZone").getBoundingClientRect();
	isMousePressed = false;
	
	
	document.getElementById("maskNorth").style.left = 0;
	document.getElementById("maskNorth").style.top = 0;
	document.getElementById("maskNorth").style.width = divBound.width + "px";
	document.getElementById("maskNorth").style.height = (elemBound.top - divBound.top) + "px";
	
	document.getElementById("maskSouth").style.left = 0;
	document.getElementById("maskSouth").style.top =
		(elemBound.height + elemBound.top - divBound.top) + "px";
	document.getElementById("maskSouth").style.width = divBound.width + "px";
	document.getElementById("maskSouth").style.height =
		(divBound.top + divBound.height - (elemBound.top + elemBound.height)) + "px";
	
	document.getElementById("maskEast").style.left =
		(elemBound.width + elemBound.left - divBound.left) + "px";
	document.getElementById("maskEast").style.top =
		(elemBound.top - divBound.top)+ "px";
	document.getElementById("maskEast").style.width =
		(divBound.width - (elemBound.left + elemBound.width) + divBound.left) + "px";
	document.getElementById("maskEast").style.height = elemBound.height + "px";
	
	document.getElementById("maskWest").style.left = 0;
	document.getElementById("maskWest").style.top = (elemBound.top - divBound.top) + "px";
	document.getElementById("maskWest").style.width = (elemBound.left - divBound.left) + "px";
	document.getElementById("maskWest").style.height = elemBound.height + "px";
	
	
	/* show the border frame */
	document.getElementById("maskNorth").className =
		document.getElementById("maskNorth").className.replace(/ dontShow/,"");
	document.getElementById("maskSouth").className =
		document.getElementById("maskSouth").className.replace(/ dontShow/,"");
	document.getElementById("maskEast").className =
		document.getElementById("maskEast").className.replace(/ dontShow/,"");
	document.getElementById("maskWest").className =
		document.getElementById("maskWest").className.replace(/ dontShow/,"");
}

function resetZone() {
	var elem = document.getElementById("selectedZone");
		
	isMousePressed = false;
	
	initPos = [0, 0];
	mousePos = [0,0,0,0];
	/* set the frame coordonates */
	elem.style.left = 0;
	elem.style.top = 0;
	elem.style.width = 0;
	elem.style.height = 0;
	
	
	/* class dontShow which contains the css 'display: none' */
	elem.className = elem.className.replace(/ dontShow/,"") + " dontShow";
	
	/* hide the border frame */
	document.getElementById("maskNorth").className =
		document.getElementById("maskNorth").className.replace(/ dontShow/,"") + " dontShow";
	document.getElementById("maskSouth").className =
		document.getElementById("maskSouth").className.replace(/ dontShow/,"") + " dontShow";
	document.getElementById("maskEast").className =
		document.getElementById("maskEast").className.replace(/ dontShow/,"") + " dontShow";
	document.getElementById("maskWest").className =
		document.getElementById("maskWest").className.replace(/ dontShow/,"") + " dontShow";
}
