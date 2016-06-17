<?php
class Player { //faire heriter de Person
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

    function __construct(array $data){
   		$this->hydrate($data);
	}
}
?>