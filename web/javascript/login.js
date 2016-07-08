

$( function () {
	//add at the head of the html file the reference to the file needed to encrypt
	$("head").append("<script type='text/javascript' src='javascript/sha512.js'></script>");
	
	//==========================================================================
	
	//enable the popover button
	$('[data-toggle="popover"]').popover();
	
	//==========================================================================
	
	//open the register tab if needed
	if(getUrlParameter('tab') === "register") {
		//set correct links
		$("#login-form-link").removeClass("active");
		$("#register-form-link").addClass("active");
		//set correct tabs
		$("#login-form").css("display", "none");
		$("#register-form").css("display", "block");
	}
	
	//==========================================================================
	
	//set the actions while submiting
	$("#login-form").submit (function ( evt ) {
		// disable the form action
		if(evt.preventDefault) {
			evt.preventDefault();
		}
		else {
			evt.returnValue = false; //internet explorer
		}
		
		
		// proceed to the login
		$.ajax({
			async: true,
			// destination page
			url: 'http://136.206.48.174/SharksTag/php_script/dbGetSalt.php',
			// use POST method
			type: 'POST',
			// POST's arguments
			data: {
				username : $("#username-login").val()
			},
			context: this,
			// get the result
			success: checkAccount
		});
	});
		
});


// parameter is the salt if the correct account has been found
// else it is "Failed"
function checkAccount(salt) {
	
	if (salt == "Failed") {
		dispMsg("alert-danger", "remove-sign", get_notConnected() );
	}
	else {
		
		console.log("salt = "+salt);
		
		// encrypt the password
		var shaObj = new jsSHA("SHA-512", "TEXT");
		shaObj.update( $("#password-login").val() + salt );
		var hashedPasswd = shaObj.getHash("HEX");
	
		console.log( $("#password-login").val() + salt );
		console.log(hashedPasswd);

		$.ajax({
			async: true,
			// destination page
			url: 'http://136.206.48.174/SharksTag/php_script/dbLogin.php',
			// use POST method
			type: 'POST',
			// POST's arguments
			data: {
				username : $("#username-login").val(),
				password : hashedPasswd,
				userSession : $("#session_id").val() //read a cookie
			},
			context: this,
			// get the result
			success: checkConnection
		});
	}
};

function checkConnection(data) {
	console.log(data);
	
	if(data.endsWith("Success")){
		dispMsg("alert-success", "ok-sign", get_connected() );
		window.location.href = $("#login-form").attr("next-page");
	}
	else{ // data == "Failed"
		dispMsg("alert-danger", "remove-sign", data );
	}
}



/* **************************************************************************
   ************************************************************************** */
	
function get_connected() {
	return "Connected.";
}

function get_notConnected() {
	return "Not connected. Please, check your login and password.";
}

function get_disconnected() {
	return "Disconnected.";
}

/* **************************************************************************
	Next function extracted from:
	http://stackoverflow.com/questions/19491336/get-url-parameter-jquery-or-how-to-get-query-string-values-in-js
   ************************************************************************** */

function getUrlParameter(sParam) {
    var sPageURL = decodeURIComponent(window.location.search.substring(1)),
        sURLVariables = sPageURL.split('&'),
        sParameterName,
        i;

    for (i = 0; i < sURLVariables.length; i++) {
        sParameterName = sURLVariables[i].split('=');

        if (sParameterName[0] === sParam) {
            return sParameterName[1] === undefined ? true : sParameterName[1];
        }
    }
    return false;
};

