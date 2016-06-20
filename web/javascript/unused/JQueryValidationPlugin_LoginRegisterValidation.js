/****************************************************/
/*													*/
/*			   JQuery Validation Plugin				*/
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