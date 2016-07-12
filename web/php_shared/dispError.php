<?php
	if ( ! isset($_GET['e'])) {
		echo "<div id='disp-error'>";
		echo "<div id='disp-error-msg' class='text-center'>";
	}
	else {
		// in case of the user arrived on his page after a redirection
		
		switch ( $_GET['e'] ) {
			case 'LIOR' : // Log In Or Register
				$msg = "Please, log in with your account or register to access to the page.";
				break;
			case 'ALI' : // Already Logged In
				$msg = "Log out to access to the page.";
				break;
			case 'SELIA' : //Session Expired Log In Again
				$msg = "Your session expired. Please, log in to resume.";
				break;
			default :
				$msg = "Error code: " . $_GET['e'];
		}

		echo "<div id='disp-error' class='alert-info show'>";
		echo "<div id='disp-error-msg' class='text-center'>";
		// display a message to explain the redirection
		echo "<span class='glyphicon glyphicon-info-sign'></span> $msg";
	}
	?>
	</div>
</div>
