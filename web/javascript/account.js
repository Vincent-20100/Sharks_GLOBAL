$( function () {
	
	// add in head of the html file the file needed to encrypt
	$("head").append("<script type='text/javascript' src='javascript/sha512.js'></script>");

	//enable the popover button
	$('[data-toggle="popover"]').popover();
	
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
			url: 'http://136.206.48.174/SharksTag/php_script/dbGetSalt.php',
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
		url: 'http://136.206.48.174/SharksTag/php_script/dbChangePassword.php',
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
		window.location.href = "/SharksTag/menu.php?e=PCS";
	}
	else{ // data == "Failed"
		dispMsg("alert-danger", "remove-sign", data );
	}
}


function elemValidation(elementName, isValid) {
	var elem = $("#" + elementName + "-validation");
	var elemInput = $("#" + elementName + "-changepassword");
	if(isValid) {
		elem.removeClass("icon-danger icon-warning icon-info icon-success");
		elem.addClass("icon-success");
		elem.html("<span class='glyphicon glyphicon-ok-sign'></span>");

		elemInput.removeClass("border-danger border-warning border-info border-success");
		elemInput.addClass("border-success");
	}
	else {
		elem.removeClass("icon-danger icon-warning icon-info icon-success");
		elem.addClass("icon-danger");
		elem.html("<span class='glyphicon glyphicon-remove-sign'></span>");

		elemInput.removeClass("border-danger border-warning border-info border-success");
		elemInput.addClass("border-danger");
	}
}
