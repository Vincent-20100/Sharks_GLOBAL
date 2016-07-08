<?php

include 'getUserBySession.php';

if( ! $_SESSION['user']->isAdmin() ){
	if ( $_SESSION['user'] != null ) {
		echo "<i class='ionicons ion-trophy'></i> " . $_SESSION['user']->score() . " pt" . ($_SESSION['user']->score() > 1 ? 's' : '') ;
	}
	else {
		echo "NULL";
	}
}
else {
	echo "NULL";
}

?>