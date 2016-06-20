<?php
	/* Vincent Bessouet, DCU School of Computing, 2016 */
	
	$cmd = "ifconfig | grep 'inet ' | grep -v '127.0.0.1' | cut -d: -f2 | cut -d' ' -f1";
	return shell_exec($cmd);
?>
