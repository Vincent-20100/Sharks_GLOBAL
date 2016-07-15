var timeoutHandle;

/* when page is ready */
$( function () {
	// if a message is already displayed at the page loading
	if($("#disp-error.show").length === 1) {
	
		// hide the message 4 seconds after the page is ready
		timeoutHandle = setTimeout(
			function() {
				$("#disp-error").removeClass("show");
			},
			4000
		);
	}
});

function dispMsg(type, glyphicon, msg) {
	$("#disp-error").removeClass("alert-danger alert-warning alert-info alert-success");
	$("#disp-error").addClass(type);
	$("#disp-error").addClass("show");
	
	var txt;
	if (glyphicon === null) {
		txt = msg;
	}
	else {
		txt = "<span class='glyphicon glyphicon-" + glyphicon + "'></span> " + msg;
	}
	$("#disp-error-msg").html(txt);
	
	// hide after 4 seconds
	clearTimeout(timeoutHandle);
	timeoutHandle = setTimeout(
		function() {
			$("#disp-error").removeClass("show");
		},
		4000
	);
}
