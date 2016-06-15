<?php
// be able to use the session
session_start();

// generate a new session id leads to fail connection with the previous session id
// it keeps the session vars and global vars
session_regenerate_id();

header("Location: login.php");
exit();
?>
