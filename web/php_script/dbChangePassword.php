<?php
	
include 'dbManager.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
	if(isset($_POST['newpassword']) && isset($_POST['session']) && isset($_POST['oldpassword'])) {
		$newpassword = $oldpassword = "";	
		
		if (empty($_POST["newpassword"])) {
		   	echo "NewPassword is required\n";
		if (empty($_POST["oldpassword"])) {
			echo "OldPassword is required\n";
	  	} else {
	  		//success !
			$oldpassword = test_input($_POST["oldpassword"]);
			$newpassword = test_input($_POST["newpassword"]);
			$session = test_input($_POST['session']);
			$db = db_open();
			$personManager = PersonManager($db);
			if($person = $personManager->getBySession($session)){
				if(strcmp($oldpassword, $person->password()) == 0)
					$person->setPassword($newpassword);
					$personManager->update($person);
					echo "Success";
				} else {
					echo "old password not matching the actual password";			
				}
			} else {
				echo "Session issue.\n"
			}
			db_close($db);
		}
	}
	else {
		echo "Password was not set\n";
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
