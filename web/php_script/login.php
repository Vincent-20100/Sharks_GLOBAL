<?php
	/* Vincent Bessouet, DCU School of Computing, 2016 */

	if ($_SERVER["REQUEST_METHOD"] == "POST") {

		$username = "";
		$passwd_hash = "";

		if( isset($_POST['username']) && isset($_POST['password']) ) {

			//check username
		  	if (empty($_POST["username"])) {
		    	echo "Failed";
			} else {
				//success !
			    $username = test_input($_POST["username"]);

			    // check if username only contains letters and whitespace
			    if (!preg_match("/^[a-zA-Z0-9 ]*$/",$username)) {
			      	echo "Failed";
			    } 
			    else {
			    	$passwd_hash = test_input($_POST['password']);
			
					// open connection
					require 'dbConnect.php';

					// connect to the account by checking the hashed passwd
					$query  = "SELECT id FROM Player
								WHERE username = '$username'
								AND password = '$passwd_hash'";
					
					if ($result = $mysqli->query($query)) {
						if ($result->num_rows === 1) {
							$row = $result->fetch_row();
							// write the current session in the database
							
							$query = "UPDATE Player
									SET session = '{$_SESSION['id']}'
									WHERE username = '$username'";
							
							if($mysqli->query($query)) {
								echo "Success";
							}
							else {
								echo "Failed";
							}
						}
						else {
							echo "Failed";
						}
						$result->close();
					}
					
					// close connection
					include 'dbDisconnect.php';
				}
			}
		}
	}

	//modify any special character like <p> </p>
	function test_input($data) {
	  $data = trim($data);
	  $data = stripslashes($data);
	  $data = htmlspecialchars($data);
	  return $data;
	}

	
	
?>
