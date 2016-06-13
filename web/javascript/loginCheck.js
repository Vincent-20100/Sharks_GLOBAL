/****************************************************/
/*													*/
/*			Try with jQuery Validation Plugin		*/
/*													*/
/****************************************************/

/*
// Validation of the inputs to login
$(document).ready(function () {
	$('#login-form').validate({
		rules: {
			username: {
				required: true,
				usrcheck: true
			},
			password: {
				required: true,
				minlength: 6
			}
		},
		messages: {
			username: {
				required: "Enter a username"
			},
			password: {
				required: "Enter a password",
				minlength: "Password must be at least {0} character long"
			}
		},
		submitHandler: function(form) {
        	form.submit();
   		}
	});

	$.validator.addMethod("usrcheck",
		function(value, element) {
			return /^[A-Za-z0-9]*$/.test(value); // consist of only these
		},
		"Username must contain only letters and digits"
	);
});

// Validation of the inputs to register
$(document).ready(function () {
	$('#register-form').validate({
		rules: {
			username: {
				required: true,
				usrcheck: true
			},
			email: {
				required: true,
				email: true
			},
			password: {
				required: true,
				minlength: 6,
				pwcheck: true
			},
			'confirm-password': {
				required: true,
				minlength: 6,
				egalTo: '#password-register',
				pwcheck: true
			}
		},
		messages: {
			username: {
				required: "Enter a username"
			},
			email: {
				required: "Enter an email adress",
				email: "Email must be valid"
			},
			password: {
				required: "Enter a password",
				minlength: "Password must be at least {0} character long"
			},
			'confirm-password': {
				required: "Enter the password again",
				minlength: "Password must be at least {0} character long",
				egalTo: "The two passwords must be the same"
			}
		},
		submitHandler: function(form) {
        	form.submit();
   		}
	});

	$.validator.addMethod("usrcheck", 
		function(value, element) {
			return /^[A-Za-z0-9]*$/.test(value); // consist of only these
		},
		"Username must contain only letters and digits"
	);

	$.validator.addMethod("pwcheck", 
		function(value, element) {
			return /^[A-Za-z0-9=!\-@._*$]*$/.test(value) // consist of only these
				&& /[A-Z]/.test(value) // has a upper case letter
				&& /[a-z]/.test(value) // has a lower case letter
				&& /\d/.test(value); // has a digit},
			"Your password must contain at least one uppercase letter, one lower case letter and one digit"
	);


});
*/

/****************************************************/
/*													*/
/*			Try with jQuery and API HTML5			*/
/*													*/
/****************************************************/

// login part
var username_login = $("#username-login");

username_login.keyup( function (event) {
  	if(username_login.validity.patternMismatch) {
    	username_login.setCustomValidity("You entered an unautaurized character");
  	} else {
		if(username_login.validity.tooLong) {
	    	username_login.setCustomValidity("You entered too much characters");
		} else {
			username_login.setCustomValidity("");
		}
	}
});

var password_login = $("#password-login");

password_login.keyup( function (event) {
    if(password_login.validity.tooShort) {
    	password_login.setCustomValidity("You didn't entered enough characters");
	} else {
		if(password_login.validity.tooLong) {
			password_login.setCustomValidity("You entered too much characters");
		} else {
			password_login.setCustomValidity("");
		}
	}
	
});

//register part

var username_register = $("#username-register");

username_register.keyup( function (event) {
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

var email_register = $("#email-register");

email_register.keyup( function (event) {
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

var password_register = $("#password-register");

password_register.keyup( function (event) {
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

var confirm_password_register = $("#confirm-password-register");

confirm_password_register.keyup( function (event) {
	if($("#password-register").value != $("#confirm-password-register").value){
		confirm_password_register.setCustomValidity("You must enter the same password as before");
  	} else {
  		if(confirm_password_register.validity.patternMismatch) {
    		confirm_password_register.setCustomValidity("You entered an unautaurized character");
		} else {
			if(confirm_password_register.validity.tooLong) {
				confirm_password_register.setCustomValidity("You entered too much characters");
			} else {
				confirm_password_register.setCustomValidity("");	
			}
			
		}
	}
});
