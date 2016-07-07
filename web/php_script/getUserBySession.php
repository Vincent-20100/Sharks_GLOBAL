<?php
	/* Vincent Bessouet, DCU School of Computing, 2016 */

$sessionCurrent;
if(isset($_POST['session'])) {
	$sessionCurrent = $_POST['session'];
}
else {
	$sessionCurrent = $_COOKIE['PHPSESSID'];
}

include 'dbManager.php';
$db = dbOpen();
$adminM = new AdministratorManager($db);
$playerM = new PlayerManager($db);

if(($pers = $adminM->getBySessionName( $sessionCurrent )) == null) {
	$pers = $playerM->getBySessionName( $sessionCurrent );
}

dbClose($db); // db disconnect
// store the user in the session vars
if($pers && $pers != NULL) {
	$_SESSION['user'] = $pers;
}
else {
	$_SESSION['user'] = null;
}

?>