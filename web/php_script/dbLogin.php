<?php
	/* Vincent Bessouet, DCU School of Computing, 2016 */

//if ($_SERVER["REQUEST_METHOD"] == "POST") {

	$username = "";
	$passwd_hash = "";

	if( isset($_POST['username']) && isset($_POST['password']) && isset($_POST['userSession'])) {
		//check username
	  	if (empty($_POST["username"])) {
	    	echo "Enter a username.";
		} elseif (empty($_POST["password"])) {
			echo "Enter a password.";
		} else {
			$username = test_input($_POST['username']);
			$userSession = test_input($_POST['userSession']);
			
			
		    // check if username only contains letters and whitespace
		    if (!preg_match("/^[a-zA-Z0-9=!\-@._*$]*$/",$username)) {
		      	echo "Special characters are not allowed.";
		    }
		    else {
		    	$passwd_hash = test_input($_POST['password']);
		
				return loginAccount($username, $passwd_hash, $userSession);
			}
		}
	}
	else {
		echo "Uncomplete request :(";
	}
	return false;
//}

function loginAccount($username, $passwd_hash, $userSession) {
	
	// open connection
	require 'dbConnect.php';
	
	$return = false;

	// connect to the account by checking the hashed passwd
	// Even if the password is correct, success only if the activation code
	// has been used
	$query  = "	SELECT id FROM Person
				WHERE username = '$username'
				AND password = '$passwd_hash'";
	
	if ($result = $mysqli->query($query)) {
		
		if ($result->num_rows === 1) {
			// username found and correct password
			$row = $result->fetch_row();
			$userId = $row[0];
			
			$queryAccountActive = "	SELECT id FROM Person
									WHERE id = '$userId'
									AND activationCode IS NULL";
			// check if the account has been activated
			if ($resultAA = $mysqli->query($queryAccountActive)) {
				if ($resultAA->num_rows === 1) {
					// YES it is active
					// history the session statistics
					$sessionIds = setNewSession($mysqli, $userSession, $userId);
					
					$userSessionId = $sessionIds->fetch_assoc()['id'];
					// store the current player session
					if(setPlayerSession($mysqli, $username, $userSessionId, $userId)){
						echo "Success";
						$return = true;
					}
					else {
						echo "Session unreachable.";
					}
				}
				// NO this account is not active
				else {
					echo "This account has not been activated yet.<br />Check your e-mails to get your activation code.";
				}
			}
			else {
				echo "Wrong request";
			}
		}
		else {
			// wrong user name or password
			echo "Please, check your username or password.";
		}
		$result->close();
	}
	else {
		echo "Wrong request";
	}
	
	// close connection
	include 'dbDisconnect.php';
	
}
	
	
function setPlayerSession($mysqli, $username, $userSessionId, $userId) {
	// write the current session in the database
	$query = "UPDATE Person
			SET id_sessionCurrent = $userSessionId
			WHERE username = '$username'";
	return $mysqli->query($query);
}

function setNewSession($mysqli, $userSession, $userId) {
	require 'Browser.php-master/lib/Browser.php';
	$browser = new Browser();
	$device = $browser->getPlatform();
	$os = $browser->getPlatform();
	$browserVersion = $browser->getBrowser();
	
	$queryStart = "START TRANSACTION;";

	$query1 = 	"INSERT INTO Session (name, id_person, ipv4, os, device, browser)
				VALUES('$userSession',
						$userId,
						'" . ip2long($_SERVER['REMOTE_ADDR']) . "',
						'$os',
						'$device',
						'$browserVersion'
						);";
	
	$query2 = 	"SELECT id
				FROM Session
				WHERE name = '$userSession'
				ORDER BY date DESC;";

	$queryEnd = "COMMIT";
	
			$mysqli->query($queryStart);
			$mysqli->query($query1);
	$data = $mysqli->query($query2);
			$mysqli->query($queryEnd);

	return $data;
}

//modify any special character like <p> </p>
function test_input($data) {
	$data = trim($data);
	$data = stripslashes($data);
	$data = htmlspecialchars($data);
	return $data;
}
	
?>
