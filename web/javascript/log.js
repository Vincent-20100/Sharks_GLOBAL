

$( function () {
	
	// add in head of the html file the file needed to encrypt
	$("head").append("<script type='text/javascript' src='javascript/sha512.js'></script>");
	
	
	$("#login-form").submit (function ( evt ) {
		if(evt.preventDefault) {
			evt.preventDefault();
		}
		else {
			//internet explorer
			evt.returnValue = false;
		}
		
		$.ajax({
			async: true,
			// destination page
			url: 'php_script/getSalt.php',
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
		dispMsg("alert-danger", "ok-sign", get_notConnected() );
	}
	else {
		// encrypt the password
		var shaObj = new jsSHA("SHA-512", "TEXT");
		shaObj.update( $("#password-login").val() + salt );
		var hashedPasswd = shaObj.getHash("HEX");
	
		console.log( $("#password-login").val() + salt );
		console.log(hashedPasswd);

		$.ajax({
			async: true,
			// destination page
			url: 'php_script/login.php',
			// use POST method
			type: 'POST',
			// POST's arguments
			data: {
				username : $("#username-login").val(),
				password : hashedPasswd
			},
			context: this,
			// get the result
			success: checkConnection
		});
	}
};

function checkConnection(data) {
	if(data == 'Success'){
		dispMsg("alert-success", "ok-sign", get_connected() );
		window.location.href = $("#login-form").attr("next-page");
	}
	else{ // data == "Failed"
		dispMsg("alert-danger", "remove-sign", data );
	}
}

function dispMsg(type, glyphicon, msg) {
	$("#disp-error-msg").removeClass("hide alert-danger alert-warning alert-info alert-success");
	$("#disp-error-msg").addClass(type);
	
	var txt;
	if (glyphicon === null) {
		txt = msg;
	}
	else {
		txt = "<span class='glyphicon glyphicon-" + glyphicon + "'></span> " + msg;
	}
	$("#disp-error-msg").html(txt);
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

