<?php
	/* Vincent Bessouet, DCU School of Computing, 2016 */
class DataBase {
	
	protected $mysqli;
	
	function __construct() {
		$this->$mysqli = new mysqli("localhost", "root", "", "sharksTaggingGame");
		
		if ($this->$mysqli->connect_errno) {
			//echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
		}
	}
	
	function __destruct() {
		$this->$mysqli->close();
	}
	
	public function db() {
		return $this->$mysqli;
	}
	
}
	
?>
