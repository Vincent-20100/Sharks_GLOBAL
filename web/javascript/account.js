$( function () {
	
	// add in head of the html file the file needed to encrypt
	$("head").append("<script type='text/javascript' src='javascript/sha512.js'></script>");
	
	
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
				username : $_SESSION['user']->username()
			},
			context: this,
			// get the result
			success: changePassword
		});

		
	
	});


	function changePassword (salt){
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
				session : $_SESSION['user']->session()
			},
			// get the result
			success: checkNewpassword
		});

	}
}

function checkNewpassword(data) {
	console.log(data);

	if(data.endsWith("Success")){
		dispMsg("alert-success", "ok-sign", "Password changed" );
	}
	else{ // data == "Failed"
		dispMsg("alert-danger", "remove-sign", data );
	}
}


function dispMsg(type, glyphicon, msg) {
	$("#disp-error-msg").removeClass("hide alert-danger alert-warning alert-info alert-success");
	$("#disp-error-msg").addClass(type);
	
	var txt;
	if (glyphicon === null) {
		txt = msg;
	}
	else {
		txt = "<span class='glyphicon glyphicon-" + glyphicon + "'></span> " + msg;
	}
	$("#disp-error-msg").html(txt);
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
