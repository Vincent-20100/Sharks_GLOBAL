/****************************************************/
/*													*/
/*			   JQuery and API HTML5					*/
/*													*/
/****************************************************/
$( function() {

	var username_login = $("#username-login")[0];

	$("#username-login").keyup( function (event) {
	  	if(username_login.validity.patternMismatch) {
			username_login.setCustomValidity("You entered an unautaurized character");
	  	} else if(username_login.validity.tooLong) {
			username_login.setCustomValidity("You entered too much characters");
		} else {
			username_login.setCustomValidity("");
		}
	});

	var password_login = $("#password-login")[0];

	$("#password-login").keyup( function (event) {
	  	if(password_login.validity.patternMismatch){
	  		password_login.setCustomValidity("You entered an unautaurized character");
	  	} else if (password_login.validity.tooLong) {
	  		password_login.setCustomValidity("You entered too much characters");
	  	} else {
	  		password_login.setCustomValidity("");
	  	}
	});
	
	$("#remember").click(function() {
		var $this = $(this);

		if($this.is(':checked')){
			$_SESSION["remember"] = true;
			$_SESSION["username"] = $("#username-login").val();
		} else {
			$_SESSION["remember"] = false;
		}
	});
});
