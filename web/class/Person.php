<?php
"use strict";

class Person {
	private $id;
	private $username;
	private $email;
	private $password;
	private $salt;

	public function id() {
		return this->id;
	}
	public function username() {
		return this->username;
	}
	public function email() {
		return this->email;
	}
	public function password() {
		return this->password;
	}
	public function salt() {
		return this->salt;
	}

	public function setId($id) {
		this->id = $id;
	}
	public function setUsername($username) {
		this->username = $username;
	}
	public function setEmail($email) {
		this->email = $email;
	}
	public function setPassword($password) {
		this->password = $password;
	}
	public function setSalt($salt) {
		this->salt = $salt;
	}

	/* This function take an array as parmeter.
	 * It affect values to variables.
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
	private $activationCode;

	public function score() {
		return this->score;
	}
	public function tutorialFinished() {
		return this->tutorialFinished;
	}
	public function activationCode() {
		return this->activationCode;
	}

	public function setscore($score) {
		this->score = $score;
	}
	public function setTutorialFinished($tutorialFinished) {
		this->tutorialFinished = $tutorialFinished;
	}
	public function setActivationCode($activationCode) {
		this->activationCode = $activationCode;
	}

	/* This function take an array as parmeter.
	 * It affect values to variables.
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

    function __construct(array $personData, array $playerData){
   		super($data1);
   		$this->hydrate($data2);
	}
}

class Administrator extends Person { //faire heriter de Person
	function __construct (array $data) {
		super($data);
	}
}

// see the right way http://www.phpied.com/3-ways-to-define-a-javascript-class/
// http://www.2ality.com/2012/01/js-inheritance-by-example.html
function extend(target, source) {
		Object.getOwnPropertyNames(source)
		.forEach(function(propName) {
			Object.defineProperty(target, propName,
			Object.getOwnPropertyDescriptor(source, propName));
		});
		return target;
	}
?>