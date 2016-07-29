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
			$email = $person->email();

			dbClose($db);

			$email_to = "To: $email" . "\r\n";
			$email_from = "SharkTaggingGame@divelikeastone.com";
			$email_headers = "From: SharksTag<noreply@divelikeastone.com>" . "\r\n";
			$email_subject = "[SharksTag] Your account recovery code";
			$email_body = "Hi $username!

Here is your recovery code for your password. Use the link below to activate the recovery code and change your password.
Your recovery code : http://www.divelikeastone.com/Sharks/recoverActivation.php?code=$recoveryCode
Have a good play!

Please ignore this message if you didn't request to change your password";

			$mailerResult = @mail($email_to, $email_subject, $email_body, $email_headers, '-f ' . $email_from);

/*
			if ($mailerResult) {
				echo "Mail Sent ! : Success";
			}
			else {
				echo "Error Sending Email! : Failed" . "<br/><br/>";
				print_r(error_get_last());
			}
*/
			return $mailerResult;
		}
	}

	return false;
}

function makeRecoveryCode( $length ) {
  	$text = "";
   	$values = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";
	$tab = str_split($values);

	if(!shuffle($tab)){echo "Recovery have Failed";}

	for ($i=0; $i < $length; $i++) {
		$text .= $tab[array_rand($tab, 1)];
	}

    return $text;
}

function getRecoveryCode($usernameOrEmail) {

	// create a recovery code
	$recoveryCode = makeRecoveryCode(10);

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

	return $person->recoveryCode();
}

?>