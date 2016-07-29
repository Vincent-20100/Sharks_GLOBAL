$( function () {
	
	// add in head of the html file the file needed to encrypt
	$("head").append("<script type='text/javascript' src='javascript/sha512.js'></script>");

	//enable the popover button
	$('[data-toggle="popover"]').popover();
	
	
	$("#recoverpassword-form").submit (function (evt) {
		if(evt.preventDefault) {
			evt.preventDefault();
		}
		else {
			//internet explorer
			evt.returnValue = false;
		}

		if ( recoverCanBeSent() == true ) {
			// proceed to the login
			$.ajax({
				async: true,
				// destination page
				url: 'http://www.divelikeastone.com/Sharks/php_script/dbGetSaltByRecoveryCode.php',
				// use POST method
				type: 'POST',
				// POST's arguments
				data: {
					recoveryCode : $("#recoveryCode").val()
				},
				context: this,
				// get the result
				success: changePassword
			});
		}
	});

	$("#newpassword").change (checkPasswordAreEquals);
	$("#confirm-newpassword").change (checkPasswordAreEquals);

});

function changePassword (salt) {
	// encrypt the password

	var shaObj = new jsSHA("SHA-512", "TEXT");

	shaObj.update( $("#newpassword").val() + salt );
	var newpasswordHashed = shaObj.getHash("HEX");

	
	$.ajax({
		async: true,
		// destination page
		url: 'http://www.divelikeastone.com/Sharks/php_script/dbRecoveryChangePassword.php',
		// use POST method 
		type: 'POST',
		// POST's arguments
		data: {
			newpassword : newpasswordHashed,
			recoveryCode : $("#recoveryCode").val()
		},
		// get the result
		success: checkNewpassword
	});

}

function checkNewpassword(data) {

	if(data.endsWith("Success")){
		window.location.href = "/Sharks/login.php?e=PCS";
	}
	else{ // data == "Failed"
		dispMsg("alert-danger", "remove-sign", data );
	}
}

function checkPasswordAreEquals() {
	if($("#confirm-newpassword").val() == $("#newpassword").val()) {
		elemValidationReset("confirm-newpassword");
		elemValidation("newpassword", true);
		elemValidation("confirm-newpassword", true);
	}
	else {
		elemValidationReset("confirm-newpassword");
		elemValidation("confirm-newpassword", false);
	}
}

function elemValidation(elementName, isValid) {
	var elem = $("#" + elementName + "-validation");
	var elemInput = $("#" + elementName);
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
	var elemInput = $("#" + elementName);
	elem.removeClass("color-danger color-warning color-info color-success");
	elem.html("");
	elemInput.removeClass("border-danger border-warning border-info border-success");
}

function recoverCanBeSent () {
	if($("#newpassword").val().length < 6) {
		return false;
	}
	else if(!$("#newpassword").val().match(/[A-Za-z0-9=!?\-@._*$]*/)) {
		return false;
	}
	else if($("#confirm-newpassword").val() != $("#newpassword").val()) {
		return false;
	}
	else {
		return true;
	}
}