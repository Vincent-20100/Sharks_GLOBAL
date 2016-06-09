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
				minlength: 6,
			}
		},
		messages: {
			username: {
				required: "Enter a username",
				usrcheck: "Username must contain only letters and digits"
			},
			password: {
				required: "Enter a password",
				minlength: "Password must be at least {0} character long",
			}
		},
		submitHandler: function(form) {
        	form.submit();
   		}
	});

	$.vadator.addMethod("usrcheck", function(value, element) {
		return /^[A-Za-z0-9]*$/.test(value); // consist of only these
	});


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
				number: true,
				pwcheck: true
			},
			password_again: {
				required: true,
				minlength: 6,
				number: true,
				pwcheck: true,
				egalTo: '#password-register'
			}

		},
		messages: {
			username: {
				required: "Enter a username",
				usrcheck: "Username must contain only letters and digits"
			},
			email: {
				required: "Enter an email adress",
				email: "Email must be valid"
			},
			password: {
				required: "Enter a password",
				minlength: "Password must be at least {0} character long",
				number: "Password must contain at least one number",
				pwcheck: "Your password must contain at least one uppercase letter, one lower case letter and one digit"
			},
			password_again: {
				required: "Enter the password again",
				minlength: "Password must be at least {0} character long",
				number: "Password must contain at least one number",
				pwcheck: "Your password must contain at least one uppercase letter, one lower case letter and one digit",

			}
		},
		submitHandler: function(form) {
        	form.submit();
   		}
	});

	$.vadator.addMethod("usrcheck", function(value, element) {
		return /^[A-Za-z0-9]*$/.test(value); // consist of only these
	});

	$.vadator.addMethod("pwcheck", function(value, element) {
			return /^[A-Za-z0-9=!\-@._*$]*$/.test(value) // consist of only these
				&& /[A-Z]/.test(value) // has a upper case letter
				&& /[a-z]/.test(value) // has a lower case letter
				&& /\d/.test(value); // has a digit
	});


});