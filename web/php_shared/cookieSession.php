
<!-- write the session id in the html page in a hidden input -->
<input
	id="session_id"
	type="hidden"
	session-name="<?php echo $_COOKIE['PHPSESSID']; ?>" 
	<?php if(isset($_COOKIE['SESSID'])) { echo "value='{$_COOKIE['SESSID']}'"; } ?>
	session-username="<?php if(isset($_SESSION['user'])) { echo $_SESSION['user']->username(); } ?>"
/>

