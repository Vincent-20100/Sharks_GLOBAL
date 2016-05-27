var serverURL = "http://povilas.ovh:8080";
// TODO soon
//var serverURL = "http://136.206.48.60/SharksTag";

function request(url, callback, method, postContent) {
	var xhr = getXMLHttpRequest();
	
	xhr.onreadystatechange = function() {
		if (this.readyState == 4 && (this.status == 200 || this.status == 0)) {
			callback(this.responseText);
		}
	};
	
	xhr.open(method, serverURL + url, true);
	if(method=="POST") {
		// for the POST method
		/*
		xhr.setRequestHeader("Content-Type",
									"application/x-www-form-urlencoded");
		*/
		xhr.setRequestHeader("Content-Type", "application/json");
		console.log(xhr);
		xhr.timeout = 1000;
	}
	xhr.send(postContent);
}


function readData_connectVincent(sData) {
	document.getElementById('resultConnectVincent').innerHTML = sData;
}

function readData_getImage(sData) {
	document.getElementById('resultGetImage').innerHTML = sData;
}

function getXMLHttpRequest() {
	if (window.XMLHttpRequest || window.ActiveXObject) {
		if (window.ActiveXObject) {
			//for old internet explorer
			try {
				return new ActiveXObject("Msxml2.XMLHTTP");
			} catch(e) {
				return new ActiveXObject("Microsoft.XMLHTTP");
			}
		} else {
			//for recent bowsers
			return new XMLHttpRequest(); 
		}
	} else {
		alert("Failed sending the request, your bowser do not use \
			XMLHTTPRequest.");
		return null;
	}
}

