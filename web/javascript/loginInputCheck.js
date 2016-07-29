/****************************************************/
/*													*/
/*			   JQuery and API HTML5					*/
/*													*/
/****************************************************/
$( function() {

	var username_login = $("#username-login")[0];

	$("#username-login").change( function (event) {
		// input check
	  	if(username_login.validity.patternMismatch) {
			username_login.setCustomValidity("You entered an unautaurized character");
	  	} else if(username_login.validity.tooLong) {
			username_login.setCustomValidity("You entered too much characters");
		} else {
			username_login.setCustomValidity("");
		}
		
		// save username if remember is asked
		if($("#remember").is(":checked")) {
			setCookie("username", $("#username-login").val());
		}
	});

	var password_login = $("#password-login")[0];

	$("#password-login").change( function (event) {
	  	if(password_login.validity.patternMismatch){
	  		password_login.setCustomValidity("You entered an unautaurized character");
	  	} else if (password_login.validity.tooLong) {
	  		password_login.setCustomValidity("You entered too much characters");
	  	} else {
	  		password_login.setCustomValidity("");
	  	}
	});
	
	// save username if remember is asked
	$("#remember").click(function() {
		var $this = $(this);

		if($this.is(':checked')){
			setCookie("remember", "true");
			setCookie("username", $("#username-login").val());
		} else {
			setCookie("remember", "false");
		}
	});
	
	//set username if remember is active
	if(getCookie("remember") == "true") {
		$("#remember").attr("checked", "");
		$("#username-login").val(getCookie("username"));
	}
});

function setCookie(key, value) {
	var expires = new Date();
	expires.setTime(expires.getTime() + (365 * 24 * 60 * 60 * 1000));
	document.cookie = key + '=' + value + ';expires=' + expires.toUTCString();
}

function getCookie(key) {
	var keyValue = document.cookie.match('(^|;) ?' + key + '=([^;]*)(;|$)');
	return keyValue ? keyValue[2] : null;
}
