$( function () {
	
	// add in head of the html file the file needed to encrypt
	$("head").append("<script type='text/javascript' src='javascript/sha512.js'></script>");

	//enable the popover button
	$('[data-toggle="popover"]').popover();
	
	
	$("#changepassword-form").submit (function (evt) {
		if(evt.preventDefault) {
			evt.preventDefault();
		}
		else {
			//internet explorer
			evt.returnValue = false;
		}
		
		// proceed to the login
		$.ajax({
			async: true,
			// destination page
			url: 'http://www.divelikeastone.com/Sharks/php_script/dbGetSalt.php',
			// use POST method
			type: 'POST',
			// POST's arguments
			data: {
				username : $("#session_id").attr("session-username")
			},
			context: this,
			// get the result
			success: changePassword
		});

	});

	$("#newpassword").keyup (checkPasswordAreEquals);
	$("#confirm-newpassword").keyup (checkPasswordAreEquals);

});

function changePassword (salt) {
	// encrypt the password
	var shaObj = new jsSHA("SHA-512", "TEXT");

	shaObj.update( $('#oldpassword').val() + salt );
	var oldpasswordHashed = shaObj.getHash("HEX");

	var shaObj2 = new jsSHA("SHA-512", "TEXT");

	shaObj2.update( $("#newpassword").val() + salt );
	var newpasswordHashed = shaObj2.getHash("HEX");

	
	$.ajax({
		async: true,
		// destination page
		url: 'http://www.divelikeastone.com/Sharks/php_script/dbChangePassword.php',
		// use POST method 
		type: 'POST',
		// POST's arguments
		data: {
			oldpassword : oldpasswordHashed,
			newpassword : newpasswordHashed,
			session : $("#session_id").attr("session-name")
		},
		// get the result
		success: checkNewpassword
	});

}

function checkNewpassword(data) {
	console.log(data);

	if(data.endsWith("Success")){
		window.location.href = "/Sharks/menu.php?e=PCS";
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
		elemValidation("newpassword", false);
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
