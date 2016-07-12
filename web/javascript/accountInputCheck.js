/****************************************************/
/*													*/
/*			   JQuery and API HTML5					*/
/*													*/
/****************************************************/
$( function() {

	var oldpassword = $("#oldpassword")[0];

	$("#oldpassword").keyup( function (event) {
	  	if(oldpassword.validity.patternMismatch){
	  		oldpassword.setCustomValidity("You entered an unautaurized character");
	  	} else if (oldpassword.validity.tooLong) {
	  		oldpassword.setCustomValidity("You entered too much characters");
	  	} else {
	  		oldpassword.setCustomValidity("");
	  	}
	});




	var newpassword = $("#newpassword")[0];

	$("#newpassword").keyup( function (event) {
		if(newpassword.value.length < 6) {
			newpassword.setCustomValidity("Password must be at least 6 character long");
	  	} else if(newpassword.validity.patternMismatch){
	  		newpassword.setCustomValidity("You entered an unautaurized character");
	  	} else if(!newpassword.value.match(/\d/)){
	  		newpassword.setCustomValidity("Password must contain at least one digit");
	  	} else if(!newpassword.value.match(/[A-Z]/)) {
	  		newpassword.setCustomValidity("Password must contain at least one uppercase character");
	  	} else if(!newpassword.value.match(/[a-z]/)) {
	  		newpassword.setCustomValidity("Password must contain at least one lowercase character");
	  	} else if (newpassword.validity.tooLong) {
	  		newpassword.setCustomValidity("You entered too much characters");
	  	} else {
	  		newpassword.setCustomValidity("");
	  	}
	});

	var confirm_newpassword = $("#confirm-newpassword")[0];

	$("#confirm-newpassword").keyup( function (event) {
		if($("#newpassword").val() != $("#confirm-newpassword").val()){
			confirm_newpassword.setCustomValidity("You must enter the same password as before");
	  	} else {
	  		confirm_newpassword.setCustomValidity("");
	  	}
	});



});
