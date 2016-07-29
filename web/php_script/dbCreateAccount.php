<?php
	/* Vincent Bessouet, DCU School of Computing, 2016 */
	header('Access-Control-Allow-Origin: *');
	include 'dbManager.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
	if( isset($_POST['email']) && isset($_POST['username']) &&
		isset($_POST['password']) && isset($_POST['salt']) && isset($_POST['session'])) {
		$username = $email = $password = $salt = "";
	
		if (empty($_POST["username"])) {
	    	echo "Enter a username.\n";
		} else {
			$username = test_input($_POST['username']);
			if (!preg_match("/^[A-Za-z0-9=!?\-@._*$]*$/",$username)) {
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
		    	echo "The Email or Username you chose already exist in the database\n";
		    }
		    else {
		    	createAccount($username, $email, $password, $salt);
		    	sendEMailNewAccount($email, $username);
		    }


		    /* uncomment it if you make the password transit in clear text throuth a https protocol
		    // it will check the password conformity in the server side 
			//The password must be at least 6 character long
	    	if(strlen($_POST["password"])<6) {
	    		echo "Password must be at least 6 character long\n";
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
									createAccount($username, $email, $password, $salt);
									sendEMailNewAccount($email, $username);
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

	if (setNewAccount($username, $email, $passwd_hash, $salt)) {
		echo "Your acount was created : Success";
	}
	else {
		echo "An error occured. Your account was not created. : Failed\n";
	}
	
	
}

function makeActivationCode( $length ) {
  	$text = "";
   	$values = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";
	$tab = str_split($values);

	if(!shuffle($tab)){echo "Activation have Failed";}

	for ($i=0; $i < $length; $i++) { 
		$text .= $tab[array_rand($tab, 1)];
	}

    return $text;
}

function setNewAccount($username, $email, $passwd_hash, $salt) {
	$activationCode = makeActivationCode(10);

	// open connection
	$db = dbOpen();

	require_once 'Browser.php-master/lib/Browser.php';
	$browser = new Browser();
	$device = $browser->getPlatform();
	$os = $browser->getPlatform();
	$browserVersion = $browser->getBrowser();
	
	$db->beginTransaction();
	$db->query("INSERT INTO Person(username, email, password, salt, activationCode)
				VALUES('$username', '$email', '$passwd_hash', '$salt', '$activationCode')");
	$res = $db->query("	INSERT INTO Player(id_person)
						VALUES ( ( SELECT id FROM Person WHERE username = '$username') )");
	$db->commit();

	// close connection
	dbClose($db);

	return $res;
}

function sendEMailNewAccount($email, $username) {
	
	// open connection
	$db = dbOpen();
	
	$activationCode = "";

	if ($result = getActivationCode($db, $email)){
		if($row = $result->fetch(PDO::FETCH_ASSOC)) {
			$activationCode = $row['activationCode'];
		}
	}
	
	// close connection
	dbClose($db);

	$email_to = "To: $email" . "\r\n";
	$email_from = "SharkTaggingGame@divelikeastone.com";
	$email_headers = "From: SharksTag<noreply@divelikeastone.com>" . "\r\n";
	$email_subject = "[SharksTag] Your account activation code";
	$email_body = "Hi $username!

Here is your activation code. Use the link below to activate your account.
Your activation code : http://www.divelikeastone.com/Sharks/activateAccount.php?code=$activationCode
Have a good play!";

	$mailerResult = @mail($email_to, $email_subject, $email_body, $email_headers, '-f ' . $email_from);

	if ($mailerResult) {
		echo "Mail Sent ! : Success";
	}
	else {
		echo "Error Sending Email! : Failed" . "<br/><br/>";
		print_r(error_get_last());
	}

	return mailerResult;
}

function getActivationCode($db, $email) {
	// get activation code
	return $db->query("	SELECT activationCode
						FROM Person
						WHERE email = '$email'");
}

//modify any special character like <p> </p>
function test_input($data) {
	$data = trim($data);
	$data = stripslashes($data);
	$data = htmlspecialchars($data);
	return $data;
}

?>
