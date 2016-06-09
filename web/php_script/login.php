<?php
	/* Vincent Bessouet, DCU School of Computing, 2016 */
	
	$usernameErr = $emailErr = $passwordErr = $password_againErr = "";
	$username = $email = $password = $password_again = "";
	$remember = "";

	if ($_SERVER["REQUEST_METHOD"] == "POST") {
		$remember = $_POST["remember"];

		if( isset($_POST['username']) && isset($_POST['password']) ) {
			//success !

			//check username
		  	if (empty($_POST["username"])) {
		    	$nameErr = "Username is required";
			} else {
				//success !
			    $username = test_input($_POST["username"]);

			    // check if username only contains letters and whitespace
			    if (!preg_match("/^[a-zA-Z0-9 ]*$/",$username)) {
			      $nameErr = "Only letters, numbers and white space allowed";
			    }
			}

			//check password conformity
			if (empty($_POST["password"])) {
			   	$passwordErr = "Password is required";
		  	} else {
		  		//success !
			    $password = test_input($_POST["password"]);

				//The password must be at least 6 character long
		    	if(strlen($_POST["password"])<6) {
		    		$passwordErr = "Password must be at least 6 character long";
		    	} 
		    	else {
		    		//success !

					//The password must not contain the username
					if(strpos($_POST["password"], $_POST["username"])) {
						$passwordErr = "Passwords must contain the username";
					}
					else {
						//success !

						//The password must contain one number
						if(strspn($_POST["password"], "0123456789")) {
							$passwordErr = "Passwords must contain at least one numerical value";
						}
						else {
							//success !

							//The password must contain one lower case character
							if(strspn($_POST["password"], "abcdefghijklmnopqrstuvwxyz")>0) {
								$passwordErr = "Passwords must not contain at least one lower case character";
							}
							else {
								//success !

								//The password must contain one upper case character
								if(strspn($_POST["password"], "ABCDEFGHIJKLMNOPQRSTUVWXYZ")>0) {
									$passwordErr = "Passwords must contain at least one upper case character";
								}
								else {
									//success !
									loginAccount();
								}
							}
						}
					}
				}
			}
		}
		else {
			echo "Failed";
		}
	}

function loginAccount() {
	// open connection
	require 'dbConnect.php';
	
	$username = $_POST['username'];
	$passwd_hash = $_POST['password'];
	
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
	
	
	//modify any special character like <p> </p>
	function test_input($data) {
	  $data = trim($data);
	  $data = stripslashes($data);
	  $data = htmlspecialchars($data);
	  return $data;
	}

	
	
?>
