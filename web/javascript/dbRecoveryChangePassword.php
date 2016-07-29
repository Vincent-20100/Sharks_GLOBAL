<?php
header('Access-Control-Allow-Origin: *');
include 'dbManager.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
	if(isset($_POST['newpassword']) && isset($_POST['recoveryCode'])) {
		$newpassword = "";	
		
		if (empty($_POST["newpassword"])) {
		   	echo "NewPassword is required";
	  	} else if (empty($_POST["recoveryCode"]))
	  		echo "RecoveryCode is required";
	  	else{
	  		//success !
			$newpassword = test_input($_POST["newpassword"]);
			$recoveryCode = test_input($_POST['recoveryCode']);

			$db = dbOpen();
			$personManager = new PersonManager($db);
			$person = $personManager->getByRecoveryCode($recoveryCode);
			if($person != null) {
				$person->setPassword($newpassword);
				$person->setRecoveryCode(null);
				$personManager->update($person);

				echo "Success";
			} else {
				echo "This is not a correct activation code.";
			}
			dbClose($db);
		}
	}
	else {
		echo "Password was not set";
	}
}


//modify any special character like <p> </p>
function test_input($data) {
	$data = trim($data);
	$data = stripslashes($data);
	$data = htmlspecialchars($data);
	return $data;
}

?>
