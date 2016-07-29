<?php
	/* Vincent Bessouet, DCU School of Computing, 2016 */
header('Access-Control-Allow-Origin: *');
include 'dbManager.php';
$db = dbOpen();
$personM = new PersonManager($db);


$pers = null;
if(isset($_POST['session'])) {
	$pers = $personM->getBySession( $_POST['session'] );
}
else {
	$pers = $personM->getBySessionName( $_COOKIE['PHPSESSID'] );
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