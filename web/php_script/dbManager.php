<?php

	$prev =  '/usr/local/pem/vhosts/161494/webspace/httpdocs/divelikeastone.com/Sharks/';
	// includes PHP classes

	include_once $prev . "class/ImageManager.php";
	include_once $prev . "class/TaggedImageManager.php";
	include_once $prev . "class/SpeciesManager.php";
	include_once $prev . "class/TagManager.php";
	include_once $prev . "class/Barycenter.php";
	include_once $prev . "class/AdministratorManager.php";
	include_once $prev . "class/PlayerManager.php";
	include_once $prev . "class/PersonManager.php";
	// connect and disconnect to database by PDO
	include_once $prev . "php_script/anonymousPDO.php";
?>
