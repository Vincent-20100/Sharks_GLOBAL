<?php
	/* Vincent Bessouet, DCU School of Computing, 2016 */

// Start the session
session_start();
$loginOK = false;

if ($_SERVER["REQUEST_METHOD"] == "POST") {

	$username = "";
	$passwd_hash = "";

	if( isset($_POST['username']) && isset($_POST['password']) ) {
		//check username
	  	if (empty($_POST["username"])) {
	    	echo "Enter a username.";
		} else {
			$username = test_input($_POST['username']);
		
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
			$_SESSION['id_player']=$row[0];
			$_SESSION['user']=$username;

			// store the current player session
			if(setPlayerSession($mysqli, $username)){
				// history the session statistics
				if(setNewSession($mysqli)) {
					$loginOK = true;
					echo "Success";
					$return = true;
				}
				else {
					echo "Session unreachable.";
				}
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
	
	
  	
}
	
	
function setPlayerSession($mysqli, $username) {
	// write the current session in the database
	$query = "UPDATE Player
			SET id_session = '{$_SESSION['id']}'
			WHERE username = '$username'";
	
	return $mysqli->query($query);
}

function setNewSession($mysqli) {
	$query = "INSERT INTO Session(`id`, `ip`,`id_player`)
			VALUES('{$_SESSION['id']}', '{$_SERVER['REMOTE_ADDR']}', {$_SESSION['id_player']})";
							
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
