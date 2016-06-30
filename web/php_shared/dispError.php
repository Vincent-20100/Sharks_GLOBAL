<div class="container">
	<div class="row">
		<div id="disp-error" class="col-sm-6 col-sm-offset-3">
			<div id='disp-error-msg' <?php
			if ( ! isset($_GET['e'])) {
				echo "class='col-xs-12 text-center alert alert-success hide'>";
			}
			else {
				// in case of the user arrived on this page after a redirection
				
				echo "class='col-xs-12 text-center alert alert-success alert-info'>";
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
	</div>
</div>
