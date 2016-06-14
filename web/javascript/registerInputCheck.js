$( function() {

	var username_register = $("#username-register")[0];
	$("#username-register").keyup( function (event) {
	  	if(username_register.validity.patternMismatch) {
			username_register.setCustomValidity("You entered an unautaurized character");
	  	} else {
			if(username_register.validity.tooLong) {
				username_register.setCustomValidity("You entered too much characters");
			} else {
				username_register.setCustomValidity("");
			}
		}
	});

	var email_register = $("#email-register")[0];

	$("#email-register").keyup( function (event) {
	  	if(email_register.validity.typeMismatch) {
			email_register.setCustomValidity("Email must be valid");
	  	} else {
	  		if(username_register.validity.tooLong) {
				email_register.setCustomValidity("You entered too much characters");
			} else {
				email_register.setCustomValidity("");
			}
	  	}
	});

	var password_register = $("#password-register")[0];

	$("#password-register").keyup( function (event) {
		if(password_register.validity.patternMismatch) {
			password_register.setCustomValidity("You entered an unautaurized character");
	  	} else {
			if(password_register.validity.tooLong) {
				password_register.setCustomValidity("You entered too much characters");
			} else {
				password_register.setCustomValidity("");
			}
		}
	});

	var confirm_password_register = $("#confirm-password-register")[0];

	$("#confirm-password-register").keyup( function (event) {
		if($("#password-register").val() != $("#confirm-password-register").val()){
			confirm_password_register.setCustomValidity("You must enter the same password as before");
	  	} else {
	  		confirm_password_register.setCustomValidity("");
	  	}
	});

});