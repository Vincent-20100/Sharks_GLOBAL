

$( function () {
	// add in head of the html file the file needed to encrypt
	$("head").append("<script type='text/javascript' src='javascript/sha512.js'></script>");
	
	
	$("#login-submit").click (function () {
		
		$.post(
			// destination page
			'php_script/getSalt.php',
			// POST's arguments
			{
				username : $("#username").val()
			},
			// get the result
			checkAccount,
			// data type
			'text'
		);
	
	});
		
});


// parameter is the salt if the correct account has been found
// else it is "Failed"
function checkAccount(salt) {
	if (salt == "Failed") {
		dispMsg("alert-danger", "ok-sign", get_notConnected() );
	}
	
	
	// encrypt the password
	var shaObj = new jsSHA("SHA-512", "TEXT");
	shaObj.update( $("#password").val() + salt );
	var hashedPasswd = shaObj.getHash("HEX");
	
	console.log( $("#password").val() + salt );
	console.log(hashedPasswd);

	$.post(
		// destination page
		'php_script/login.php',
		// POST's arguments
		{
			username : $("#username").val(),
			password : hashedPasswd
		},
		// get the result
		checkConnection,
		// data type
		'text'
	);
	
	return true;
};

function checkConnection(data) {
	if(data == 'Success'){
		dispMsg("alert-success", "ok-sign", get_connected() );
	}
	else{ // data == "Failed"
		dispMsg("alert-danger", "remove-sign", data );
		return false;
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

