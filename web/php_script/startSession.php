<?php
	/* Vincent Bessouet, DCU School of Computing, 2016 */
	
	session_start();
	
	if(!isset($_SESSION['id'])){
		$_SESSION['id'] = session_id();
	}
	else {
		// session already started previouly
	}
	
	
	
	// ==TEST==
	$_SESSION['session'] = 'h2k22c0k8qucnab9islmkvhbq4';
	
	print $_SESSION['id'] . "<br />";
	print $_SERVER['REQUEST_URI'] . "<br />";
	print $_SERVER['PHP_SELF'] . "<br />";
	// ==TEST==
	
	
	$redirect = false;
	if(!isset($_SESSION['session'])) {
		if($_SERVER['PHP_SELF'] != '/SharksTag/login.php') {
			$redirect = true;
		}
	}
	else {
	
		include '/home/socguest/Desktop/Sharks_GLOBAL/web/class/PersonManager.php';
		// person manager linked to the database
		$db = new PDO('mysql:host=localhost;dbname=sharksTaggingGame', 'root', '');
		$persM = new PersonManager($db);
		$pers = $persM->getBySession($_SESSION['session']);
		$db = null; // db disconnect
		
		
		if($_SERVER['PHP_SELF'] == '/SharksTag/login.php') {
			// on the login page :
			// if the user is already connected, redirection to the menu page
			// else continue
			
			if($pers && $pers != NULL) {
				$redirect = true;
			}
		}
		elseif($_SERVER['PHP_SELF'] == '/SharksTag/logout.php') {
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
				echo $pers->username() . " is connected";
			}
			else { $redirect = true; }
		}
	}
	
	// redirect to the login page
	if ($redirect) {
		// move the user to the log in page
		header("Location: /SharksTag/login.php?n=" . $_SERVER['REQUEST_URI']);
		exit();
	}
	
	
	
	/***************************************************************************
	****************************************************************************
	
	
	include 'DataBase.php';
	$db = new DataBase();
	
	$query = "SELECT id
				FROM Pers
				WHERE id_sessionCurrent = '{$_SESSION['user']['session']}'";
	
	$isConnected = false;
	if(	$result = $db->db()->query($query) ){
		if( $result->num_rows == 1){
			$isConnected = true;
		}
	}
	
	if (!isConnected){
		// move the user to the log in page
		header("/SharksTag/login.php?n=" . $_SERVER['REQUEST_URI']);
	}*/
?>
