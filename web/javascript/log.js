

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
		loginError( get_notConnected() );
	}
	
	// encrypt the password with i's salt
	var shaObj = new jsSHA("SHA-512", "TEXT");
	shaObj.update( $("#password").val() + salt );
	var hashedPasswd = shaObj.getHash("HEX");
	
	//some logs
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
	console.log(data);
	
	if(data == 'Success'){
		loginError("alert-success", get_connected() );
	}
	else{ // data == "Failed"
		loginError("alert-danger", get_notConnected() );
		return false;
	}
}

function loginError(type, msg) {
	$("#login-error").removeClass("hide alert-danger alert-warning alert-info alert-success");
	$("#login-error").addClass(type);
	$("#login-error").html(msg);
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

