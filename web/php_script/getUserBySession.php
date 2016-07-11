<?php
	/* Vincent Bessouet, DCU School of Computing, 2016 */

include 'dbManager.php';
$db = dbOpen();
$adminM = new AdministratorManager($db);
$playerM = new PlayerManager($db);


$pers = null;
if(isset($_POST['session'])) {
	if(($pers = $adminM->getBySession( $_POST['session'] )) == null) {
		$pers = $playerM->getBySession( $_POST['session'] );
	}
}
else {
	if(($pers = $adminM->getBySessionName( $_COOKIE['PHPSESSID'] )) == null) {
		$pers = $playerM->getBySessionName( $_COOKIE['PHPSESSID'] );
	}
}


dbClose($db); // db disconnect
// store the user in the session vars
if($pers && $pers != NULL) {
	$_SESSION['user'] = $pers;
	$_COOKIE['SESSID'] = $pers->id_sessionCurrent();
}
else {
	$_SESSION['user'] = null;
}

?>