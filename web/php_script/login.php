<?php
	/* Vincent Bessouet, DCU School of Computing, 2016 */

	if ($_SERVER["REQUEST_METHOD"] == "POST") {

		$username = "";
		$passwd_hash = "";

		if( isset($_POST['username']) && isset($_POST['password']) ) {

			//check username
		  	if (empty($_POST["username"])) {
		    	echo "Enter a username.";
			} else {
				//success !
			    $username = test_input($_POST["username"]);

			    // check if username only contains letters and whitespace
			    if (!preg_match("/^[a-zA-Z0-9=!\-@._*$]*$/",$username)) {
			      	echo "Special characters are not allowed.";
			    } 
			    else {
			    	$passwd_hash = test_input($_POST['password']);
			
					return loginAccount($username, $passwd_hash);
				}
			}
		}
		else {
			echo "Uncomplete request :(";
		}
		return false;
	}

function loginAccount($username, $passwd_hash) {
	
	$return = false;
	
	// open connection
	require 'dbConnect.php';

	// connect to the account by checking the hashed passwd
	$query  = "SELECT id FROM Player
				WHERE username = '$username'
				AND password = '$passwd_hash'";
	
	if ($result = $mysqli->query($query)) {
		if ($result->num_rows === 1) {
			// username found

			$row = $result->fetch_row();
			// write the current session in the database
			$query = "UPDATE Player
					SET session = '{$_SESSION['id']}'
					WHERE username = '$username'";
			
			if($mysqli->query($query)) {
				echo "Success";
				$return = true;
			}
			else {
				// wrong password
				echo "Please check your username or password.";
			}
		}
		else {
			// username not found, can't return the hashed password
			echo "Please check your username or password.";
		}
		$result->close();
	}
	
	// close connection
	include 'dbDisconnect.php';
	
	return $return;
}
	
	
//modify any special character like <p> </p>
function test_input($data) {
	$data = trim($data);
	$data = stripslashes($data);
	$data = htmlspecialchars($data);
	return $data;
}

	
	
?>
