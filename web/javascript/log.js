

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
		$("#form-error .alert").addClass("hide");
		$("#form-error .alert-danger").html( get_notConnected() );
		$("#form-error .alert-danger").removeClass("hide");
		return false;
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
		function (data) {
			console.log(data)
			if(data == 'Success'){
				$("#form-error .alert").addClass("hide");
				$("#form-error .alert-success").html( get_connected() );
				$("#form-error .alert-success").removeClass("hide");
			}
			else{ // data == "Failed"
				$("#form-error .alert").addClass("hide");
				$("#form-error .alert-danger").html( get_notConnected() );
				$("#form-error .alert-danger").removeClass("hide");
				return false;
			}
		},
		// data type
		'text'
	);
	
	return true;
};



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

