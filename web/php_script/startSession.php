<?php
	/* Vincent Bessouet, DCU School of Computing, 2016 */
	header('Access-Control-Allow-Origin: *');
	$_DEBUG = false;
	
	if (!$_DEBUG) {
		initStartSession();
	}
	
	
function initStartSession() {
	session_start();
	
	
	$redirect = false;
	if(startsWith($_SERVER['PHP_SELF'], "/Sharks/php_script/")) {
	}
	else {
		// set the dest and put the next page in the url (GET method)
		$dest = "login.php?n=" . $_SERVER['REQUEST_URI'] . "&e=LIOR";
		// except some pages
		if($_SERVER['PHP_SELF'] == '/Sharks/login.php' ||
			$_SERVER['PHP_SELF'] == '/Sharks/logout.php' ||
			$_SERVER['PHP_SELF'] == '/Sharks/menu.php') {
				$dest = 'login.php'; //redirect without message
		}
	
		// if no session in the history: auto redirect, except on the login page and exceptions
		if(!isset($_COOKIE['PHPSESSID'])) {
			if($_SERVER['PHP_SELF'] != '/Sharks/login.php' &&
				$_SERVER['PHP_SELF'] != '/Sharks/forgotPassword.php' &&
				$_SERVER['PHP_SELF'] != '/Sharks/activateAccount.php'&&
				$_SERVER['PHP_SELF'] != '/Sharks/recoverActivation.php') {
					$redirect = true;
			}
		}
		else {
			// a session has been found
			// check if it is active for a user
	
		
			include 'getUserBySession.php';
			
			if($_SERVER['PHP_SELF'] == '/Sharks/login.php' ||
				$_SERVER['PHP_SELF'] == '/Sharks/forgotPassword.php' ||
				$_SERVER['PHP_SELF'] == '/Sharks/activateAccount.php' ||
				$_SERVER['PHP_SELF'] == '/Sharks/recoverActivation.php') {
				// on the login page / forgotPassword page / activateAccount page :
				// if the user is already connected, redirection to the menu page
				// else continue
				
				if($pers && $pers != NULL && $pers->id_sessionCurrent() != null) {
					$redirect = true;
					$dest = "menu.php?e=ALI";
				}
			}
			elseif($_SERVER['PHP_SELF'] == '/Sharks/logout.php') {
				// on the logout page :
				// TODO if nobody is connected, redirection to the login page
				// else continue
			
				if( ! $pers || $pers == NULL){
					$redirect = true;
				}
			}
			else {
				// on other pages :
				// if nobody is connected, redirection to the login page with a link
				// to the current page
				// else continue
				// get the person in the database thanks to his session id
				
				
				if(	$pers && $pers != NULL) {
					//the user is connected
					//echo $pers->username() . "'s session is open";
					
					// redirect anyway if the session has expired
					if($pers->id_sessionCurrent() == null) {
						//Destroy the expired session
						session_regenerate_id(); // generate a new session id
						$_SESSION = array(); // remove the session vars
						session_destroy();
						unset($_SESSION);
						unset($_COOKIE);
						//redirect to the login page with the appropriate message
						$redirect = true;
						$dest = "login.php?n=" . $_SERVER['REQUEST_URI'] . "&e=SELIA";
					}
					elseif($_SERVER['PHP_SELF'] == '/Sharks/game.php' && !$pers->tutorialFinished()) {
						// if the tutorial has not been played by the player,
						// redirect him to it before starting to play
						$redirect = true;
						$dest = "tutorial.php";
					}
				}
				else {
					$redirect = true;
				}
			}
		}
	
		// redirect to the login page
		if ($redirect) {
			// move the user to the log in page
			header("Location: /Sharks/$dest");
			exit();
		}
	}
}


function startsWith($haystack, $needle) {
	// search backwards starting from haystack length characters from the end
	return $needle === "" || strrpos($haystack, $needle, -strlen($haystack)) !== false;
}

function endsWith($haystack, $needle) {
	// search forward starting from end minus needle length characters
	return $needle === "" || (($temp = strlen($haystack) - strlen($needle)) >= 0 && strpos($haystack, $needle, $temp) !== false);
}

?>