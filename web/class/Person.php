<?php

$_PERSON_PHP = true;

class Person {
	private $id;
	private $id_sessionCurrent;
	private $username;
	private $email;
	private $password;
	private $salt;
	private $activationCode;
	private $recoveryCode;

	public function id() {
		return $this->id;
	}
	public function id_sessionCurrent() {
		return $this->id_sessionCurrent;
	}
	public function username() {
		return $this->username;
	}	
	public function email() {
		return $this->email;
	}
	public function password() {
		return $this->password;
	}
	public function salt() {
		return $this->salt;
	}
	public function activationCode() {
		return $this->activationCode;
	}
	public function recoveryCode() {
		return $this->recoveryCode;
	}


	public function setId($id) {
		$this->id = $id;
	}
	public function setId_sessionCurrent($id_sessionCurrent) {
		$this->id_sessionCurrent = $id_sessionCurrent;
	}
	public function setUsername($username) {
		$this->username = $username;
	}
	public function setEmail($email) {
		$this->email = $email;
	}
	public function setPassword($password) {
		$this->password = $password;
	}
	public function setSalt($salt) {
		$this->salt = $salt;
	}
	public function setActivationCode($activationCode) {
		$this->activationCode = $activationCode;
	}
	public function setRecoveryCode($recoveryCode) {
		$this->recoveryCode = $recoveryCode;
	}
	
	public function isAdmin() {
		return false;
	}
	
	/* This function takes an array as parmeter.
	 * It affect values to variables using the setters.
	 *
	*/
	public function hydrate(array $data){
  		foreach ($data as $key => $value){
   			$method = 'set'.ucfirst($key);
   			if (method_exists($this, $method)){
   	  	      	$this->$method($value);
   			}
   		}
   	}

    function __construct(array $data){
   		$this->hydrate($data);
	}
}

class Player extends Person {
	private $score;
	private $tutorialFinished;

	public function score() {
		return $this->score;
	}
	public function tutorialFinished() {
		return $this->tutorialFinished;
	}

	public function setScore($score) {
		$this->score = $score;
	}
	public function setTutorialFinished($tutorialFinished) {
		$this->tutorialFinished = $tutorialFinished;
	}
	
	public function isAdmin() {
		return false;
	}

	/* This function takes an array as parmeter.
	 * It affect values to variables using the setters.
	 *
	*/
	public function hydrate(array $data){
  		foreach ($data as $key => $value){
   			$method = 'set'.ucfirst($key);
   			if (method_exists($this, $method)){
   	  	      	$this->$method($value);
   			}
   		}
   	}

    function __construct(array $data){
    	$personData = array_slice($data, 0, 6);
    	$playerData = array_slice($data, 6);
   		parent::__construct($personData);
   		$this->hydrate($playerData);
	}
}

class Administrator extends Person {
	
	public function isAdmin() {
		return true;
	}
	
	/* This function takes an array as parmeter.
	 * It affect values to variables using the setters.
	 *
	*/
	public function hydrate(array $data){
  		foreach ($data as $key => $value){
   			$method = 'set'.ucfirst($key);
   			if (method_exists($this, $method)){
   	  	      	$this->$method($value);
   			}
   		}
   	}

	function __construct(array $data) {
		parent::__construct($data);
	}
}
?>
