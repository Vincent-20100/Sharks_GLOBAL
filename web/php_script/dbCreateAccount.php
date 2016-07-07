<?php
	/* Vincent Bessouet, DCU School of Computing, 2016 */
	
	include 'dbManager.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
	if( isset($_POST['email']) && isset($_POST['username']) &&
		isset($_POST['password']) && isset($_POST['salt']) && isset($_POST['session'])) {
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
		
		if (empty($_POST["password"])) {
		   	echo "Password is required\n";
	  	} else {
	  		//success !
		    $password = test_input($_POST["password"]);
			$session = test_input($_POST['session']);
		    
		    /************************************************************************************/
		    /*    For now the password is hashed at this point, so we can't check it with php   */
		    /*		and this is not important because a hashed password is not easy to find     */
			/************************************************************************************/
			
		    // find potential accounts already using this username or email
		    // check if this email is already used
		    // check if this username is already used
		    $r1 = require 'dbCheckEmailExists.php';
		    $r2 = require 'dbCheckUsernameExists.php';
		    if ($r1 || $r2) {
		    	echo "Your Email or Username already exist in the database\n";
		    }
		    else {
		    	createAccount($username, $email, $password, $salt);
		    	//uncomment later
		    	//sendEMailNewAccount($email, $username);
		    }


		    // uncomment it if you make the password transit in clear text throuth a https protocol
		    /* it will check the password conformity in the server side 
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
									sendEMailNewAccount($email);
								}
							}
						}
					}
		    	}
		    }*/
		}
	}
	else {
		echo "User name, email or password were not set\n";
	}
}

function createAccount($username, $email, $passwd_hash, $salt) {

	// open connection
	$db = dbOpen();
	
	if (setNewAccount($db, $username, $email, $passwd_hash, $salt)) {
		echo "Success";
	}
	else {
		echo "An error occured. Your account was not created\n";
	}
	
	// close connection
	dbClose($db);
}

function setNewAccount($db, $username, $email, $passwd_hash, $salt) {
	$activationCode = bin2hex(random_bytes(5));
	
	require 'Browser.php-master/lib/Browser.php';
	$browser = new Browser();
	$device = $browser->getPlatform();
	$os = $browser->getPlatform();
	$browserVersion = $browser->getBrowser();
	
	$db->beginTransaction();
	$res = $db->query("	INSERT INTO Person(username, email, password, salt, activationCode)
						VALUES('$username', '$email', '$passwd_hash', '$salt', '$activationCode');
						
						INSERT INTO Player(id_person)
						VALUES ( ( SELECT id FROM Person WHERE username = '$username') );";
	$db->commit();

	return $res;
}

function sendEMailNewAccount($email, $username) {
	
	// open connection
	$db = dbOpen();
	
	$activationCode = "";

	
	if ($result = getActivationCode($db, $email)){
		if($row = $result->fetch(PDO::FETCH_ASSOC)) {
			$activationCode = $row['activationCode'];

			// close connection
			dbClose($db);

			// Send an automatic e-mail to give the activation code
			
			// Subject
			$subject = "[SharksTag] Your account activation code";

			// message
			$message = "
			<html>
			<head>
				<title>[SharksTag] Your account activation code</title>
			</head>
			<body>
				<p>Hi $username!</p>
				<p>Here is your activation code. Use the link below to activate your account.</p>
				<p><a href='http://136.206.48.174/SharksTag/activation.php?user=$username&code=$activationCode' alt='Your activation link'>http://136.206.48.174/SharksTag/activation.php?user=$username&code=$activationCode</a>
				<p>Have a good play!</a>
			</body>
			</html>";

			// e-mail header
			$headers  = "MIME-Version: 1.0" . "\r\n";
			$headers .= "Content-type: text/html; charset=iso-8859-1" . "\r\n";

			// En-têtes additionnels
			$headers .= "To: $email" . "\r\n";
			$headers .= "From: SharksTag<bessouet.vincent@gmail.com>" . "\r\n";

			$status = mail($email, $subject, $message, $headers);

			// Envoi
			if($status) {
                echo "Your message has been sent !";
            }
            else {
                echo "An error occurred while trying to send the mail.";
            }
			return $status;
		}
	}
	// close connection
	dbClose($db);

	return false;
}

function getActivationCode($db, $email) {
	// get activation code
	return $db->query("	SELECT Pl.activationCode
						FROM Player Pl, Person Pe
						WHERE Pl.id_person = Pe.id
						AND Pe.email = '$email'");
}

//modify any special character like <p> </p>
function test_input($data) {
	$data = trim($data);
	$data = stripslashes($data);
	$data = htmlspecialchars($data);
	return $data;
}

?>
