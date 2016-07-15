<?php 
	$usrInputErr = $emailInputErr = $passwordInputErr = $password_againInputErr = "";
	$usrInput = $emailInput = $passwordInput = $password_againInput = "";

	if ($_SERVER["REQUEST_METHOD"] == "POST") {
	  	if (empty($_POST["usrInput"])) {
	    	$nameErr = "Username is required";
		} else {
		    $usrInput = test_input($_POST["usrInput"]);
		    // check if usrInput only contains letters and whitespace
		    if (!preg_match("/^[a-zA-Z ]*$/",$usrInput)) {
		      $nameErr = "Only letters and white space allowed";
		    }
		}
		  
		if (empty($_POST["emailInput"])) {
		   	$emailInputErr = "EmailInput is required";
	  	} else {
		    $emailInput = test_input($_POST["emailInput"]);
		    // check if e-mail address is well-formed
		    if (!filter_var($emailInput, FILTER_VALIDATE_EMAIL)) {
		      $emailInputErr = "Invalid emailInput format";
		    }
		}

		if (empty($_POST["passwordInput"])) {
		   	$passwordInputErr = "Password is required";
	  	} else {
	  		//success !
		    $passwordInput = test_input($_POST["passwordInput"]);
		    
			if (empty($_POST["password_againInput"])) {
			   	$password_againInputErr = "Password repeat is required";
		  	} else {
		  		//success !
			    $password_againInput = test_input($_POST["password_againInput"]);

			    //Testing password conditions
			    if ($_POST["passwordInput"] != $_POST["password_againInput"]) {
				   	$passwordInputErr = "Passwords are not the same";
				   	$password_againInputErr = "Passwords are not the same";
				}
				else {
				   	// success!

					//The password must be at least 8 character long
			    	if(strlen($_POST["passwordInput"])<8) {
			    		$passwordInputErr = "Password must be at least 8 character long"
			    	} 
			    	else {

			    		//success !

						//The password must not contain the username
						if(strpos($_POST["passwordInput"], $_POST["usrInput"])) {
							$passwordInputErr = "Passwords must not contain the username";
						}
						else {
							//success !

							//The password must contain one number
							if(strspn($_POST["passwordInput"], "0123456789")) {
								$passwordInputErr = "Passwords must not contain at least one numerical value";
							}
							else {
								//success !

								//The password must contain one lower case character
								if(strspn($_POST["passwordInput"], "abcdefghijklmnopqrstuvwxyz")>0) {
									$passwordInputErr = "Passwords must not contain at least one lower case character";
								}
								else {
									//success !

									//The password must contain one upper case character
									if(strspn($_POST["passwordInput"], "ABCDEFGHIJKLMNOPQRSTUVWXYZ")>0) {
										$passwordInputErr = "Passwords must not contain at least one upper case character";
									}
									else {
										//success !
									}
								}
							}
						}
			    	}
				}
			}
		}
	}

	function test_input($data) {
	  $data = trim($data);
	  $data = stripslashes($data);
	  $data = htmlspecialchars($data);
	  return $data;
	}
?>
