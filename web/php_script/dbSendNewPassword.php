<?php 
header('Access-Control-Allow-Origin: *');
include 'dbManager.php';

function sendRecoveryCode($usernameOrEmail) {
	
	$recoveryCode = "";
	
	if ($recoveryCode = getRecoveryCode($usernameOrEmail)){
		if($recoveryCode != "") {

			$db = dbOpen();
			$personManager = new PersonManager($db);
			$person = $personManager->getByUserNameOrEmail($usernameOrEmail);

			$username = $person->username();

			dbClose($db);

			// Send an automatic e-mail to give the recovery code
			
			// Subject
			$subject = "[SharksTag] Your password recovery code";

			// message
			$message = "
			<html>
			<head>
				<title>[SharksTag] Your password recovery code</title>
			</head>
			<body>
				<p>Hi $username!</p>
				<p>Here is your recovery code. Use the link below to change your password.</p>
				<p><a href='http://www.divelikeastone.com/Sharks/recoveryCode.php?user=$username&code=$recoveryCode' alt='Your activation link'>http://www.divelikeastone.com/Sharks/activation.php?user=$username&code=$recoveryCode</a>
				<p>Have a good play!</p>
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

	return false;
}

function getRecoveryCode($usernameOrEmail) {

	// create a recovery code
	$recoveryCode = bin2hex(random_bytes(5));

	//store it in the database
	$db = dbOpen();
	$personManager = new PersonManager($db);
	$person = $personManager->getByUserNameOrEmail($usernameOrEmail);
	if($person != null) {
		$person->setRecoveryCode($recoveryCode);
		$personManager->update($person);
	} else {
		return "";
	}

	dbClose($db);

	return $person;
}

//modify any special character like <p> </p>
function test_input($data) {
	$data = trim($data);
	$data = stripslashes($data);
	$data = htmlspecialchars($data);
	return $data;
}

?>