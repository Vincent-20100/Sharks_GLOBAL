<?php
	/* Vincent Bessouet, DCU School of Computing, 2016 */

// Start the session
include 'startSession.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

	$username = "";
	$passwd_hash = "";

	if( isset($_POST['username']) && isset($_POST['password']) ) {
		//check username
	  	if (empty($_POST["username"])) {
	    	echo "Enter a username.";
		} elseif (empty($_POST["password"])) {
			echo "Enter a password.";
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
	
	// open connection
	require 'dbConnect.php';
	
	$return = false;

	// connect to the account by checking the hashed passwd
	$query  = "SELECT id FROM Person
				WHERE username = '$username'
				AND password = '$passwd_hash'";
	
	if ($result = $mysqli->query($query)) {
		if ($result->num_rows === 1) {
			// username found
			$row = $result->fetch_row();
			
			$_SESSION['user'] = array();
				$_SESSION['user']['id']      = $row[0];
				$_SESSION['user']['session'] = $_SESSION['id'];
				$_SESSION['user']['ip']      = $_SERVER['REMOTE_ADDR'];
			
			// history the session statistics
			if(setNewSession($mysqli)) {
				// store the current player session
				if(setPlayerSession($mysqli, $username)){
					echo "Success";
					$return = true;
				}
				else {
					echo "Session unreachable.";
				}
			}
			else {
				// wrong password
				echo "Please check your username or password. 111";
			}
		}
		else {
			// username not found, can't return the hashed password
			echo "Please check your username or password. 222";
		}
		$result->close();
	}
	
	// close connection
	include 'dbDisconnect.php';
	
}
	
	
function setPlayerSession($mysqli, $username) {
	// write the current session in the database
	$query = "UPDATE Person
			SET id_sessionCurrent = '{$_SESSION['id']}'
			WHERE username = '$username'";
	return $mysqli->query($query);
}

function setNewSession($mysqli) {
	require 'Browser.php-master/lib/Browser.php';
	$browser = new Browser();
	$device = $browser->getPlatform();
	$os = $browser->getPlatform();
	$browserVersion = $browser->getBrowser();
	
	$query = "INSERT INTO Session (id, id_person, ipv4, os, device, browser)
				VALUES('{$_SESSION['user']['session']}',
						{$_SESSION['user']['id']},
						'" . ip2long($_SESSION['user']['ip']) . "',
						'$os',
						'$device',
						'$browserVersion'
						)";
	
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
