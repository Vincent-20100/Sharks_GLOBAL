<div id="disp-error" <?php
	if ( ! isset($_GET['e'])) {
		echo ">";
		echo "<div id='disp-error-msg' class='text-center'>";
	}
	else {
	
		// in case of the user arrived on this page after a redirection
		
		echo "class='alert-info show'>";
		echo "<div id='disp-error-msg' class='text-center'>";
		// display a message to explain the redirection
		echo "<span class='glyphicon glyphicon-info-sign'></span> ";
		switch ( $_GET['e'] ) {
			case 'LIOR' : // Log In Or Register
				echo "Please, log in with your account or register to access to the page.";
				break;
			case 'ALI' : // Already Logged In
				echo "Log out to access to the page.";
				break;
			default :
				echo "Error code: " . $_GET['e'];
		}
	}
	?>
	</div>
</div>
