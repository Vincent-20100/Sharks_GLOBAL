<?php

$sessionCurrent;
if(isset($_POST['session'])) {
	$sessionCurrent = $_POST['session'];
}
else {
	$sessionCurrent = $_COOKIE['PHPSESSID'];
}


include '/home/socguest/Desktop/Sharks_GLOBAL/web/class/AdministratorManager.php';
include '/home/socguest/Desktop/Sharks_GLOBAL/web/class/PlayerManager.php';
// person manager linked to the database
$db = new PDO('mysql:host=localhost;dbname=sharksTaggingGame', 'root', '');
$adminM = new AdministratorManager($db);
$playerM = new PlayerManager($db);

if(($pers = $adminM->getBySessionName( $sessionCurrent )) == null) {
	$pers = $playerM->getBySessionName( $sessionCurrent );
}

$db = null; // db disconnect
// store the user in the session vars
if($pers && $pers != NULL) {
	$_SESSION['user'] = $pers;
}
else {
	$_SESSION['user'] = null;
}

?>