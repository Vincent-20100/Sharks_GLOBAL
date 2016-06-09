
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


function checkCreated(data) {
	console.log(data);
	if(data.endsWith('Success')){
		dispMsg("alert-success", "ok-sign", "Account regestered. You are now connected.");
	}
	else{ // data == "Failed"
		dispMsg("alert-danger", "remove-sign", "<span class='glyficon glyficon-remove-sign'></span>An error occured. Your account is not created.");
		return false;
	}
}

function checkEmailExists(data) {
	elemValidation( $("#email-validation"), data=="Failed");
	if (data=='Success') {
		// 'success' means that the e-mail has been found,
		// so this new account can't be created, print an error
		dispMsg("alert-danger", "remove-sign", "This e-mail is already used by an other account.");
	}
	else {
		$("#disp-error-msg").addClass("hide");
	}
}

function checkUsernameExists(data) {
	elemValidation( $("#username-validation"), data=="Failed");
	if (data=='Success') {
		// 'success' means that the username has been found,
		// so this new account can't be created, print an error
		dispMsg("alert-danger", "remove-sign", "This username already exists.");
	}
	else {
		$("#disp-error-msg").addClass("hide");
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
