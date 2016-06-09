
$( function () {
	
	// add in head of the html file the file needed to encrypt
	$("head").append("<script type='text/javascript' src='javascript/sha512.js'></script>");
	
	
	$("#register-submit").click (function () {
		var generatedSalt = makeSalt(10);
		// encrypt the password
		var shaObj = new jsSHA("SHA-512", "TEXT");
		shaObj.update( $("#password-register").val() + generatedSalt );
		var passwordHashed = shaObj.getHash("HEX");
		
		$.post(
			// destination page
			'php_script/createAccount.php',
			// POST's arguments
			{
				email : $("#email-register").val(),
				username : $("#username-register").val(),
				password : passwordHashed,
				salt : generatedSalt
			},
			// get the result
			checkCreated,
			// data type
			'text'
		);
	
	});
	
	
	$("#email-register").blur (function () {
		
		$.post(
			// destination page
			'php_script/checkEmailExists.php',
			// POST's arguments
			{
				email : $("#email-register").val()
			},
			// get the result
			checkEmailExists,
			// data type
			'text'
		);
	});
	
	
	$("#username-register").blur (function () {
		
		$.post(
			// destination page
			'php_script/checkUsernameExists.php',
			// POST's arguments
			{
				username : $("#username-register").val()
			},
			// get the result
			checkUsernameExists,
			// data type
			'text'
		);
	});
	
});



function makeSalt( length ) {
	var text = "";
    var array = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";
	
    for( var i=0; i < length; i++ )
        text += array.charAt(Math.floor(Math.random() * array.length));

    return text;
}


function registerError(type, msg) {
	$("#register-error").removeClass("hide alert-danger alert-warning alert-info alert-success");
	$("#register-error").addClass(type);
	$("#register-error").html(msg);
}


function checkCreated(data) {
	console.log(data);
	if(data.endsWith('Success')){
		registerError("alert-success", "Account regestered. You are now connected. ");
	}
	else{ // data == "Failed"
		registerError("alert-danger", "An error occured. Your account is not created.");
		return false;
	}
}

function checkEmailExists(data) {
	elemValidation( $("#email-validation"), data=="Failed");
	if (data=='Success') {
		// 'success' means that the e-mail has been found,
		// so this new account can't be created, print an error
		registerError("alert-danger", "This e-mail is already used by an other account.");
	}
	else {
		$("#register-error").addClass("hide");
	}
}

function checkUsernameExists(data) {
	elemValidation( $("#username-validation"), data=="Failed");
	if (data=='Success') {
		// 'success' means that the username has been found,
		// so this new account can't be created, print an error
		registerError("alert-danger", "This username already exists.");
	}
	else {
		$("#register-error").addClass("hide");
	}
}

function elemValidation(elem, isValid) {
	if(isValid) {
		elem.removeClass("icon-danger icon-warning icon-info icon-success");
		elem.addClass("icon-success");
		elem.html("<span class='glyphicon glyphicon-ok-sign'></span>");
	}
	else {
		elem.removeClass("icon-danger icon-warning icon-info icon-success");
		elem.addClass("icon-danger");
		elem.html("<span class='glyphicon glyphicon-remove-sign'></span>");
	}
}
