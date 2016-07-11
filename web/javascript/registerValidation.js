
$( function () {
	
	// add in head of the html file the file needed to encrypt
	$("head").append("<script type='text/javascript' src='javascript/sha512.js'></script>");
	
	
	$("#register-form").submit (function (evt) {
		if(evt.preventDefault) {
			evt.preventDefault();
		}
		else {
			//internet explorer
			evt.returnValue = false;
		}
		
		var generatedSalt = makeSalt(10);
		// encrypt the password
		var shaObj = new jsSHA("SHA-512", "TEXT");
		shaObj.update( $("#password-register").val() + generatedSalt );
		var passwordHashed = shaObj.getHash("HEX");
		
		$.ajax({
			async: true,
			// destination page
			url: 'http://136.206.48.174/SharksTag/php_script/dbCreateAccount.php',
			// use POST method 
			type: 'POST',
			// POST's arguments
			data: {
				username : $("#username-register").val(),
				session : $("#session_id").val(),
				email : $("#email-register").val(),
				password : passwordHashed,
				salt : generatedSalt
			},
			// get the result
			success: checkCreated
		});
	
	});
	
	
	$("#email-register").blur (function () {
		
		$.ajax({
			async: true,
			// destination page
			url: 'http://136.206.48.174/SharksTag/php_script/dbCheckEmailExists.php',
			// use POST method
			type: 'POST',
			// POST's arguments
			data: {
				email : $("#email-register").val()
			},
			// get the result
			success: checkEmailExists
		});
	});
	
	
	$("#username-register").blur (function () {
		
		$.ajax({
			async: true,
			// destination page
			url: 'http://136.206.48.174/SharksTag/php_script/dbCheckUsernameExists.php',
			// use POST method
			type: 'POST',
			// POST's arguments
			data: {
				username : $("#username-register").val()
			},
			// get the result
			success: checkUsernameExists
		});
	});
	
	$("#password-register").keyup (checkPasswordAreEquals);
	$("#confirm-password-register").keyup (checkPasswordAreEquals);
	
});



function makeSalt( length ) {
	var text = "";
    var array = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";
	
    for( var i=0; i < length; i++ )
        text += array.charAt(Math.floor(Math.random() * array.length));

    return text;
}

function checkCreated(data) {
	console.log(data);
	if(data.endsWith('Success')){
		dispMsg("alert-success", "ok-sign", "Account regestered. You are now connected.");
		
		window.location.href = ($("#register-form").attr("next-page") +
			"?username=" + $("#username-register").val());
	}
	else{ // data == "Failed"
		dispMsg("alert-danger", "remove-sign", data);
	}
}

function checkEmailExists(data) {
	elemValidation( "email", !data.endsWith("Success"));
	if (data.endsWith("Success")) {
		// 'success' means that the e-mail has been found,
		// so this new account can't be created, print an error
		dispMsg("alert-danger", "remove-sign", "This e-mail is already used by an other account.");
	}
}

function checkUsernameExists(data) {
	elemValidation( "username", !data.endsWith("Success"));
	if (data.endsWith("Success")) {
		// 'success' means that the username has been found,
		// so this new account can't be created, print an error
		dispMsg("alert-danger", "remove-sign", "This username already exists.");
	}
}

function checkPasswordAreEquals() {
	if($("#confirm-password-register").val() == $("#password-register").val()) {
		elemValidationReset("confirm-password");
	}
	else {
		elemValidation("confirm-password", false);
	}
}

function elemValidation(elementName, isValid) {
	var elem = $("#" + elementName + "-validation");
	var elemInput = $("#" + elementName + "-register");
	elem.removeClass("color-danger color-warning color-info color-success");
	elemInput.removeClass("border-danger border-warning border-info border-success");
	
	if(isValid) {
		elem.addClass("color-success");
		elem.html("<span class='glyphicon glyphicon-ok-sign'></span>");
		
		elemInput.addClass("border-success");
	}
	else {
		elem.addClass("color-danger");
		elem.html("<span class='glyphicon glyphicon-remove-sign'></span>");
		
		elemInput.addClass("border-danger");
	}
}

function elemValidationReset(elementName) {
	var elem = $("#" + elementName + "-validation");
	var elemInput = $("#" + elementName + "-register");
	elem.removeClass("color-danger color-warning color-info color-success");
	elem.html("");
	elemInput.removeClass("border-danger border-warning border-info border-success");
}
