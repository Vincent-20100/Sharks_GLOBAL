<?php
	/* Vincent Bessouet, DCU School of Computing, 2016 */
	
	session_start();
	
	$_SESSION['session'] = 'h2k22c0k8qucnab9islmkvhbq4';
	
	if(!isset($_SESSION['id'])){
		$_SESSION['id'] = session_id();
	}
	else {
		// session already started previouly
	}
	
	print $_SESSION['id'];
	
	
	if($_SERVER['PHP_SELF'] != '/SharksTag/login.php' &&
		$_SERVER['PHP_SELF'] != '/SharksTag/logout.php') {
	
		include '/home/socguest/Desktop/Sharks_GLOBAL/web/class/PersonManager.php';
	
		$db = new PDO('mysql:host=localhost;dbname=sharksTaggingGame', 'root', '');
		$persM = new PersonManager($db);
	
	
	
		$isConnected = false;
		if(	$pers = $persM->getBySession($_SESSION['session']) ){
			if( $pers != NULL) {
				echo $pers->username() . " is connected";
				$isConnected = true;
			}
		}
	
		if (!$isConnected){
			// move the user to the log in page
			header("Location: /SharksTag/login.php?n=" . $_SERVER['REQUEST_URI']);
			exit();
		}
	
	}
	
	/***************************************************************************
	****************************************************************************
	
	// if the user is active, continue
	// else redirect to the login page
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
