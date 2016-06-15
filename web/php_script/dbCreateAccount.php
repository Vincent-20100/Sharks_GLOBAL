<?php
	/* Vincent Bessouet, DCU School of Computing, 2016 */
	
if ($_SERVER["REQUEST_METHOD"] == "POST") {
	if( isset($_POST['email']) && isset($_POST['username']) &&
		isset($_POST['password']) && isset($_POST['salt']) ) {
		$username = $email = $password = $salt = "";
	
		if (empty($_POST["username"])) {
	    	echo "Enter a username.\n";
		} else {
			$username = test_input($_POST['username']);
			if (!preg_match("/^[a-zA-Z0-9=!\-@._*$]*$/",$username)) {
		      echo "Only letters and white space allowed\n";
		    }
		}		
		
		if (empty($_POST["email"])) {
			echo "Enter an email.\n";
		} else {
			$email = test_input($_POST["email"]);
		    // check if e-mail address is well-formed
		    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
		      	echo "Invalid email format\n";
		    }
		}
		
		if (empty($_POST["salt"])) {
			echo "Salt problem.\n";
		} else {
			$salt = test_input($_POST["salt"]);
		}
		
		//FUCK le password est deja hash
		//FUCK MY LIFE
		if (empty($_POST["password"])) {
		   	echo "Password is required\n";
	  	} else {
	  		//success !
		    $password = test_input($_POST["password"]);
		    

			//The password must be at least 8 character long
	    	if(strlen($_POST["password"])<8) {
	    		echo "Password must be at least 8 character long\n";
	    	}
	    	else {
	    		//success !

				//The password must not contain the username
				if(strpos($_POST["password"], $_POST["username"])) {
					echo "Passwords must not contain the username\n";
				}
				else {
					//success !

					//The password must contain one number
					if(1 != preg_match('~[0-9]~', $_POST["password"])) {
						echo "Passwords must contain at least one numerical value\n";
					}
					else {
						//success !

						//The password must contain one lower case character
						if(strspn($_POST["password"], "abcdefghijklmnopqrstuvwxyz")>0) {
							echo "Passwords must contain at least one lower case character\n";
						}
						else {
							//success !

							//The password must contain one upper case character
							if(strspn($_POST["password"], "ABCDEFGHIJKLMNOPQRSTUVWXYZ")>0) {
								echo "Passwords must contain at least one upper case character\n";
							}
							else {
								//success !

								// find potential accounts already using this username or email
								// check if this email is already used
								// check if this username is already used
								$r1 = require 'dbCheckEmailExists.php';
								$r2 = require 'dbCheckUsernameExists.php';
								if ($r1 || $r2) {
									echo "Your Email or Username already exist in the database\n";
								}
								else {
									createAccount($username, $email, $passwd_hash, $salt);
								}
							}
						}
					}
		    	}
		    }
		}
	}
	else {
		echo "User name, email or password were not set\n";
	}
}

function createAccount($email, $username, $passwd_hash, $salt) {

	// open connection
	require 'dbConnect.php';

	if (setNewAccount($mysqli, $email, $username, $passwd_hash, $salt)) {
		echo "Success";
	}
	else {
		echo "An error occured. Your account was not created\n";
	}
	
	// close connection
	include 'dbDisconnect.php';
}

function setNewAccount($mysqli, $email, $username, $passwd_hash, $salt) {
	$activationCode = bin2hex(random_bytes(5));

	$query = "INSERT INTO Player(`username`, `email`, `password`, `salt`, `session`, `activationCode`)
				VALUES('$username', '$email', '$passwd_hash', '$salt', '{$_SESSION['id']}', '$activationCode')";

	return $mysqli->query($query);
}

//modify any special character like <p> </p>
function test_input($data) {
	$data = trim($data);
	$data = stripslashes($data);
	$data = htmlspecialchars($data);
	return $data;
}

?>
